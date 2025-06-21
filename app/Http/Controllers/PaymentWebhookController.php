<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Services\XenditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentWebhookController extends Controller
{
    public function __construct()
    {
        // Disable CSRF protection untuk webhook
        $this->middleware('throttle:60,1'); // Rate limiting
    }

    /**
     * Handle Xendit Invoice Callback
     */
    public function xenditInvoiceCallback(Request $request)
    {
        try {
            // Log incoming webhook untuk debugging
            Log::info('Xendit Invoice Webhook Received', [
                'headers' => $request->headers->all(),
                'body' => $request->all()
            ]);

            // Verify webhook signature (optional tapi direkomendasikan)
            if (!$this->verifyXenditSignature($request)) {
                Log::warning('Invalid Xendit webhook signature');
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            $webhookData = $request->all();

            // Validasi data yang diperlukan
            if (!isset($webhookData['id']) || !isset($webhookData['status'])) {
                Log::error('Invalid webhook data', $webhookData);
                return response()->json(['error' => 'Invalid webhook data'], 400);
            }

            $invoiceId = $webhookData['id'];
            $status = strtolower($webhookData['status']);
            $externalId = $webhookData['external_id'] ?? null;

            // Cari buyer berdasarkan invoice ID
            $buyer = Buyer::where('xendit_invoice_id', $invoiceId)->first();

            if (!$buyer) {
                Log::warning('Buyer not found for invoice', ['invoice_id' => $invoiceId]);
                return response()->json(['error' => 'Buyer not found'], 404);
            }

            // Update status pembayaran berdasarkan status dari Xendit
            $newPaymentStatus = $this->mapXenditStatus($status);

            DB::beginTransaction();

            try {
                $buyer->update([
                    'payment_status' => $newPaymentStatus,
                    'payment_updated_at' => now()
                ]);

                // Log perubahan status
                Log::info('Payment status updated', [
                    'buyer_id' => $buyer->id,
                    'invoice_id' => $invoiceId,
                    'old_status' => $buyer->payment_status,
                    'new_status' => $newPaymentStatus,
                    'xendit_status' => $status
                ]);

                // Jika pembayaran berhasil, lakukan tindakan tambahan
                if ($newPaymentStatus === 'paid') {
                    $this->handleSuccessfulPayment($buyer, $webhookData);
                }

                // Jika pembayaran expired atau failed
                if (in_array($newPaymentStatus, ['expired', 'failed'])) {
                    $this->handleFailedPayment($buyer, $webhookData);
                }

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Webhook processed successfully'
                ], 200);
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Webhook processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Webhook processing failed'
            ], 500);
        }
    }

    /**
     * Verify Xendit webhook signature
     */
    private function verifyXenditSignature(Request $request): bool
    {
        $callbackToken = config('services.xendit.webhook_token');

        if (!$callbackToken) {
            Log::warning('Xendit webhook token not configured');
            return true; // Skip verification jika token tidak dikonfigurasi
        }

        $signature = $request->header('X-Callback-Token');

        return $signature === $callbackToken;
    }

    /**
     * Map Xendit status to our payment status
     */
    private function mapXenditStatus(string $xenditStatus): string
    {
        switch ($xenditStatus) {
            case 'paid':
            case 'settled':
                return 'paid';
            case 'pending':
                return 'pending';
            case 'expired':
                return 'expired';
            case 'failed':
                return 'failed';
            default:
                return 'pending';
        }
    }

    /**
     * Handle successful payment
     */
    private function handleSuccessfulPayment(Buyer $buyer, array $webhookData)
    {
        try {
            // Update dengan informasi pembayaran
            $buyer->update([
                'paid_at' => now(),
                'payment_method' => $webhookData['payment_method'] ?? null,
                'payment_channel' => $webhookData['payment_channel'] ?? null,
            ]);

            // Kirim email konfirmasi (optional)
            // Mail::to($buyer->email)->send(new PaymentConfirmationMail($buyer));

            // Kirim notifikasi WhatsApp (optional)
            // $this->sendWhatsAppNotification($buyer);

            Log::info('Successful payment processed', [
                'buyer_id' => $buyer->id,
                'amount' => $buyer->total_amount,
                'payment_method' => $webhookData['payment_method'] ?? 'unknown'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to process successful payment', [
                'buyer_id' => $buyer->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle failed/expired payment
     */
    private function handleFailedPayment(Buyer $buyer, array $webhookData)
    {
        try {
            // Log failed payment
            Log::info('Failed/Expired payment processed', [
                'buyer_id' => $buyer->id,
                'reason' => $webhookData['failure_reason'] ?? 'unknown'
            ]);

            // Optional: Kirim notifikasi ke admin atau customer
            // Optional: Auto-delete expired orders setelah waktu tertentu

        } catch (\Exception $e) {
            Log::error('Failed to process failed payment', [
                'buyer_id' => $buyer->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Manual webhook test endpoint (hanya untuk development)
     */
    public function testWebhook(Request $request)
    {
        if (!app()->environment('local')) {
            abort(404);
        }

        // Simulasi webhook data
        $testData = [
            'id' => $request->input('invoice_id'),
            'status' => $request->input('status', 'paid'),
            'external_id' => 'TKT-TEST-000001',
            'payment_method' => 'BANK_TRANSFER',
            'payment_channel' => 'BCA'
        ];

        $testRequest = new Request($testData);

        return $this->xenditInvoiceCallback($testRequest);
    }
}
