<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Ditolak</title>
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
            border-bottom: 2px solid #dc3545;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #dc3545;
        }

        .error-icon {
            font-size: 48px;
            color: #dc3545;
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

        .reason-box {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
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
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">Ticketify ID</div>
            <div class="error-icon">✗</div>
            <h2 style="color: #dc3545; margin: 0;">Pembayaran Ditolak</h2>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $buyer->nama_lengkap }}</strong>,</p>

            <p>Kami mohon maaf untuk memberitahukan bahwa pembayaran untuk pesanan tiket Anda telah ditolak. Berikut
                adalah detail pesanan Anda:</p>

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
                    <span>Rp {{ number_format($buyer->ticket_price, 0, ',', '.') }}</span>
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

            <div class="reason-box">
                <strong>Alasan Penolakan:</strong><br>
                {{ $reason }}
            </div>

            <p><strong>Status Pembayaran:</strong> <span style="color: #dc3545;">DITOLAK</span></p>

            <p><strong>Langkah Selanjutnya:</strong></p>
            <ul>
                <li>Hubungi customer service jika ada pertanyaan <a href="wa.me/+6282227031735"></a>+62 822-2703-1735
                </li>
            </ul>

            <p>Kami mohon maaf atas ketidaknyamanan ini. Jika Anda memiliki pertanyaan atau memerlukan bantuan lebih
                lanjut, silakan hubungi tim customer service kami.</p>

            <p style="margin-top: 30px;">Terima kasih atas pengertiannya.</p>

            <p>Salam,<br><strong>Ticketify ID</strong></p>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon untuk tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} Ticketify ID. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
