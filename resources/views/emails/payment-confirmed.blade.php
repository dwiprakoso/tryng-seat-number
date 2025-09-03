<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Dikonfirmasi</title>
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

        .qr-section {
            text-align: center;
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            margin: 30px 0;
            border: 2px dashed #28a745;
        }

        .qr-code img {
            max-width: 200px;
            height: auto;
            border: 4px solid #28a745;
            border-radius: 8px;
            padding: 10px;
            background-color: white;
        }

        .qr-instructions {
            margin-top: 15px;
            font-size: 14px;
            color: #666666;
        }

        .seats-section {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }

        .seat-numbers {
            display: inline-flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .seat-badge {
            background-color: #007bff;
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #666666;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }

        .important-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }

        .important-notice h4 {
            color: #856404;
            margin: 0 0 10px 0;
            font-size: 16px;
        }

        .important-notice p {
            color: #856404;
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">Ticketify ID</div>
            <div class="success-icon">✓</div>
            <h2 style="color: #28a745; margin: 0;">Pembayaran Dikonfirmasi!</h2>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $buyer->nama_lengkap }}</strong>,</p>

            <p>Selamat! Pembayaran untuk tiket Anda telah berhasil dikonfirmasi. Berikut adalah detail pesanan Anda:</p>

            <div class="order-details">
                <div class="order-row">
                    <span>ID Pesanan:</span>
                    <span><strong>{{ $buyer->external_id }}</strong></span>
                </div>
                <div class="order-row">
                    <span>Kategori Tiket:</span>
                    <span>{{ $buyer->ticket->name }}</span>
                </div>
                <div class="order-row">
                    <span>Jumlah Tiket:</span>
                    <span>{{ $buyer->quantity }} tiket</span>
                </div>
                <div class="order-row">
                    <span>Harga per Tiket:</span>
                    <span>Rp {{ number_format($buyer->ticket_price / $buyer->quantity, 0, ',', '.') }}</span>
                </div>
                <div class="order-row">
                    <span>Biaya Admin:</span>
                    <span>Rp {{ number_format($buyer->admin_fee, 0, ',', '.') }}</span>
                </div>
                <div class="order-row">
                    <span>Total Pembayaran:</span>
                    <span>Rp {{ number_format($buyer->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Seats Section -->
            @if ($buyer->bookingSeats && $buyer->bookingSeats->count() > 0)
                <div class="seats-section">
                    <h4 style="margin: 0 0 10px 0; color: #007bff;">🪑 Nomor Kursi Anda:</h4>
                    <div class="seat-numbers">
                        @foreach ($buyer->bookingSeats as $bookingSeat)
                            <span class="seat-badge">{{ $bookingSeat->seat->seat_number }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <p><strong>Status Pembayaran:</strong> <span style="color: #28a745;">DIKONFIRMASI</span></p>
            <p><strong>Tanggal Konfirmasi:</strong> {{ $buyer->payment_confirmed_at->format('d/m/Y H:i') }} WIB</p>

            <!-- QR Code Section -->
            @if ($buyer->qr_code)
                <div class="qr-section">
                    <h3 style="color: #28a745; margin: 0 0 20px 0;">🎫 QR Code Tiket Anda</h3>
                    <div class="qr-code">
                        <img src="{{ $buyer->getQrCodeDataUrl() }}" alt="QR Code Tiket {{ $buyer->external_id }}">
                    </div>
                    <div class="qr-instructions">
                        <strong style="color: #28a745;">Cara menggunakan QR Code:</strong><br>
                        • Tunjukkan QR Code ini saat masuk event<br>
                        • Pastikan QR Code terlihat jelas dan tidak rusak<br>
                        • Simpan email ini atau screenshot QR Code<br>
                        • QR Code ini berlaku untuk {{ $buyer->quantity }} orang
                    </div>
                </div>
            @endif

            <p>Tiket Anda telah aktif dan siap digunakan. Silakan simpan email ini sebagai bukti pembelian tiket.</p>

            <p style="margin-top: 30px;">Terima kasih telah mempercayai kami untuk kebutuhan tiket event Anda!</p>

            <p>Salam,<br><strong>Ticketify ID</strong></p>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon untuk tidak membalas email ini.</p>
            <p>Jika ada pertanyaan, silakan hubungi customer service kami.</p>
            <p>&copy; {{ date('Y') }} Ticketify ID. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
