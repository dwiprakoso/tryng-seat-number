<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class XenditService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.xendit.secret_key');
        $this->baseUrl = config('services.xendit.base_url', 'https://api.xendit.co');

        if (!$this->apiKey) {
            throw new Exception('Xendit API key is not configured. Please check your .env file.');
        }
    }

    public function createInvoice($data)
    {
        $curl = curl_init();

        // Generate webhook URL menggunakan route name
        $webhookUrl = route('webhook.xendit.invoice');

        $postData = [
            'external_id' => $data['external_id'],
            'payer_email' => $data['email'] ?? 'customer@example.com',
            'description' => $data['description'],
            'amount' => $data['amount'],
            'invoice_duration' => 86400, // 24 jam
            'success_redirect_url' => $data['success_url'] ?? null,
            'failure_redirect_url' => $data['failure_url'] ?? null,
            'notification_url' => $webhookUrl, // Menggunakan route helper
        ];

        // Optional: tambah customer data
        if (isset($data['customer'])) {
            $postData['customer'] = $data['customer'];
        }

        // Tambah items untuk breakdown biaya (tiket + admin fee)
        if (isset($data['items'])) {
            $postData['items'] = $data['items'];
        }

        // Debug: Log request data dengan webhook URL
        Log::info('Sending request to Xendit', [
            'url' => $this->baseUrl . '/v2/invoices',
            'webhook_url' => $webhookUrl, // Log webhook URL untuk debugging
            'data' => $postData
        ]);

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . '/v2/invoices',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode($this->apiKey . ':'),
                'Content-Type: application/json',
            ],
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);
        curl_close($curl);

        // Debug: Log response
        Log::info('Xendit API Response', [
            'http_code' => $httpCode,
            'response' => $response,
            'curl_error' => $curlError
        ]);

        // Check untuk cURL errors
        if ($curlError) {
            throw new Exception('cURL Error: ' . $curlError);
        }

        // Check HTTP status code
        if ($httpCode !== 200) {
            $errorData = json_decode($response, true);
            $errorMessage = isset($errorData['message']) ? $errorData['message'] : 'Unknown Xendit API error';

            Log::error('Xendit API Error', [
                'http_code' => $httpCode,
                'response' => $response,
                'request_data' => $postData,
                'error_message' => $errorMessage
            ]);

            throw new Exception("Xendit API Error (HTTP {$httpCode}): {$errorMessage}");
        }

        $responseData = json_decode($response, true);

        if (!$responseData) {
            throw new Exception('Invalid JSON response from Xendit API');
        }

        return $responseData;
    }

    public function getInvoice($invoiceId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . '/v2/invoices/' . $invoiceId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode($this->apiKey . ':'),
                'Content-Type: application/json',
            ],
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);
        curl_close($curl);

        if ($curlError) {
            throw new Exception('cURL Error: ' . $curlError);
        }

        if ($httpCode !== 200) {
            $errorData = json_decode($response, true);
            $errorMessage = isset($errorData['message']) ? $errorData['message'] : 'Unknown error';
            throw new Exception("Failed to get invoice (HTTP {$httpCode}): {$errorMessage}");
        }

        return json_decode($response, true);
    }
}
