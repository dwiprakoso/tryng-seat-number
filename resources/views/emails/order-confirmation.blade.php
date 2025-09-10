<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Pesanan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #28a745;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }

        .success-icon {
            font-size: 48px;
            color: #28a745;
            margin: 20px 0;
        }

        .content {
            line-height: 1.6;
            color: #333333;
        }

        .order-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .order-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .order-row:last-child {
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
            font-weight: bold;
        }

        .customer-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .customer-row {
            margin-bottom: 10px;
        }

        .customer-row:last-child {
            margin-bottom: 0;
        }

        .customer-label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            min-width: 150px;
        }

        .status-pending {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #f39c12;
            color: white;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .payment-instructions {
            background-color: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .payment-instructions h4 {
            color: #1976d2;
            margin: 0 0 15px 0;
            font-size: 16px;
        }

        .payment-instructions p {
            margin: 8px 0;
            font-size: 14px;
            color: #424242;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #218838;
            text-decoration: none;
            color: white;
        }

        .important-note {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #666666;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .order-row {
                flex-direction: column;
                gap: 5px;
            }

            .customer-label {
                min-width: auto;
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">Ticketify ID</div>
            <div class="success-icon">✅</div>
            <h2 style="color: #28a745; margin: 0;">Pesanan Berhasil!</h2>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $buyer->nama_lengkap }}</strong>,</p>

            <p>Terima kasih! Pesanan tiket Anda telah berhasil dibuat. Berikut adalah detail pesanan Anda:</p>

            <div class="order-details">
                <div class="order-row">
                    <span>ID Pesanan:</span>
                    <span><strong>{{ $buyer->external_id }}</strong></span>
                </div>
                <div class="order-row">
                    <span>Tanggal Pesanan:</span>
                    <span>{{ $buyer->created_at->format('d/m/Y H:i') }} WIB</span>
                </div>
                <div class="order-row">
                    <span>Kategori Tiket:</span>
                    <span>{{ $ticket->name }}</span>
                </div>
                <div class="order-row">
                    <span>Jumlah Tiket:</span>
                    <span>{{ $buyer->quantity }} tiket</span>
                </div>
                <div class="order-row">
                    <span>Harga Tiket:</span>
                    <span>Rp {{ number_format($buyer->ticket_price, 0, ',', '.') }}</span>
                </div>
                <div class="order-row">
                    <span>Kode Pembayaran Unik:</span>
                    <span>Rp {{ number_format($buyer->payment_code, 0, ',', '.') }}</span>
                </div>
                <div class="order-row">
                    <span>Total Pembayaran:</span>
                    <span>Rp {{ number_format($buyer->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="customer-details">
                <h4 style="margin-top: 0; color: #333;">Data Pembeli:</h4>
                <div class="customer-row">
                    <span class="customer-label">Nama Lengkap:</span>
                    <span>{{ $buyer->nama_lengkap }}</span>
                </div>
                <div class="customer-row">
                    <span class="customer-label">Email:</span>
                    <span>{{ $buyer->email }}</span>
                </div>
                <div class="customer-row">
                    <span class="customer-label">No. Handphone:</span>
                    <span>{{ $buyer->no_handphone }}</span>
                </div>
                {{-- <div class="customer-row">
                    <span class="customer-label">No. Identitas:</span>
                    <span>{{ $buyer->identitas_number }}</span>
                </div>
                <div class="customer-row">
                    <span class="customer-label">Alamat Lengkap:</span>
                    <span>{{ $buyer->alamat_lengkap }}</span>
                </div>
                <div class="customer-row">
                    <span class="customer-label">Mewakili:</span>
                    <span>{{ $buyer->mewakili }}</span>
                </div> --}}
            </div>

            <div class="status-pending">
                <span class="status-badge">{{ ucfirst($buyer->payment_status) }}</span>
                <p style="margin: 10px 0 0 0; font-size: 14px; color: #856404;">
                    Menunggu konfirmasi pembayaran
                </p>
            </div>

            <div class="payment-instructions">
                <h4>📋 Langkah Selanjutnya</h4>
                <p>1. Lakukan pembayaran sesuai dengan total amount di atas</p>
                <p>2. Simpan nomor pesanan <strong>{{ $buyer->external_id }}</strong> untuk referensi</p>
                <p>3. Upload bukti pembayaran melalui link di bawah ini</p>

                <a href="{{ route('payment.manual', ['external_id' => $buyer->external_id]) }}" class="btn">
                    Upload Bukti Pembayaran
                </a>
            </div>

            <div class="important-note">
                <p style="margin: 0; font-size: 14px; font-weight: bold;">
                    <strong>Penting:</strong> Pastikan nominal transfer sesuai dengan total pembayaran termasuk kode
                    unik
                </p>
            </div>

            <p style="margin-top: 30px;">Silakan simpan email ini sebagai bukti pemesanan tiket Anda.</p>

            <p>Terima kasih telah mempercayai kami untuk kebutuhan tiket event Anda!</p>

            <p>Salam,<br><strong>Ticketify ID</strong></p>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon untuk tidak membalas email ini.</p>
            <p>Hubungi customer service jika memerlukan bantuan</p>
            <p>&copy; {{ date('Y') }} Ticketify ID. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
