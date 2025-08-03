<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Pesanan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.5;
            color: #2c3e50;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .receipt-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }

        .receipt-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 20px;
            background: white;
            border-radius: 50% 50% 0 0;
        }

        .receipt-header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 600;
        }

        .receipt-header p {
            margin: 0;
            font-size: 16px;
            opacity: 0.9;
        }

        .receipt-body {
            padding: 30px;
        }

        .order-id-section {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px dashed #dee2e6;
        }

        .order-id {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin: 0;
        }

        .order-date {
            font-size: 14px;
            color: #6c757d;
            margin: 5px 0 0 0;
        }

        .section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .section h3 {
            color: #495057;
            font-size: 18px;
            margin: 0 0 15px 0;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .ticket-info {
            background: linear-gradient(135deg, #667eea20, #764ba220);
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .ticket-name {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin: 0 0 10px 0;
        }

        .ticket-quantity {
            font-size: 16px;
            color: #6c757d;
            margin: 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 6px;
            border-left: 3px solid #667eea;
        }

        .info-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 5px 0;
            font-weight: 500;
        }

        .info-value {
            font-size: 14px;
            color: #2c3e50;
            margin: 0;
            font-weight: 600;
        }

        .cost-breakdown {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .cost-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px dotted #dee2e6;
        }

        .cost-item:last-child {
            border-bottom: none;
        }

        .cost-label {
            font-size: 14px;
            color: #495057;
        }

        .cost-value {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
        }

        .total-section {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }

        .total-label {
            font-size: 16px;
            margin: 0 0 5px 0;
            opacity: 0.9;
        }

        .total-amount {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }

        .payment-status {
            text-align: center;
            padding: 20px;
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            margin: 20px 0;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #f39c12;
            color: white;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .payment-instructions {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .payment-instructions h4 {
            color: #1976d2;
            margin: 0 0 10px 0;
            font-size: 16px;
        }

        .payment-instructions p {
            margin: 5px 0;
            font-size: 14px;
            color: #424242;
        }

        .payment-link {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 10px;
            transition: transform 0.2s;
        }

        .payment-link:hover {
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
        }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .footer p {
            margin: 5px 0;
            font-size: 13px;
            opacity: 0.8;
        }

        .receipt-line {
            border-top: 2px dashed #dee2e6;
            margin: 20px 0;
            padding-top: 20px;
        }

        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .receipt-body {
                padding: 20px;
            }

            .total-amount {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="receipt-header">
            <h1>✅ Pesanan Berhasil</h1>
            <p>Terima kasih atas kepercayaan Anda!</p>
        </div>

        <div class="receipt-body">
            <!-- Order ID Section -->
            <div class="order-id-section">
                <p class="order-id">{{ $buyer->external_id }}</p>
                <p class="order-date">{{ $buyer->created_at->format('d F Y, H:i') }} WIB</p>
            </div>

            <!-- Ticket Information -->
            <div class="section">
                <h3>🎫 Informasi Tiket</h3>
                <div class="ticket-info">
                    <p class="ticket-name">{{ $ticket->name }}</p>
                    <p class="ticket-quantity">Quantity: {{ $buyer->quantity }} tiket</p>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="section">
                <h3>👤 Data Pembeli</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <p class="info-label">Nama Lengkap</p>
                        <p class="info-value">{{ $buyer->nama_lengkap }}</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">Email</p>
                        <p class="info-value">{{ $buyer->email }}</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">No. Handphone</p>
                        <p class="info-value">{{ $buyer->no_handphone }}</p>
                    </div>
                    <div class="info-item">
                        <p class="info-label">No. Identitas</p>
                        <p class="info-value">{{ $buyer->identitas_number }}</p>
                    </div>
                </div>
                <div class="info-grid" style="margin-top: 15px;">
                    <div class="info-item" style="grid-column: 1 / -1;">
                        <p class="info-label">Alamat Lengkap</p>
                        <p class="info-value">{{ $buyer->alamat_lengkap }}</p>
                    </div>
                    <div class="info-item" style="grid-column: 1 / -1;">
                        <p class="info-label">Mewakili</p>
                        <p class="info-value">{{ $buyer->mewakili }}</p>
                    </div>
                </div>
            </div>

            <!-- Cost Breakdown -->
            <div class="section">
                <h3>💰 Rincian Pembayaran</h3>
                <div class="cost-breakdown">
                    <div class="cost-item">
                        <span class="cost-label">Harga Tiket ({{ $buyer->quantity }}x)</span>
                        <span class="cost-value">Rp {{ number_format($buyer->ticket_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="cost-item">
                        <span class="cost-label">Biaya Admin (5%)</span>
                        <span class="cost-value">Rp {{ number_format($buyer->admin_fee, 0, ',', '.') }}</span>
                    </div>
                    <div class="cost-item">
                        <span class="cost-label">Kode Pembayaran Unik</span>
                        <span class="cost-value">Rp {{ number_format($buyer->payment_code, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Amount -->
            <div class="total-section">
                <p class="total-label">Total Pembayaran</p>
                <p class="total-amount">Rp {{ number_format($buyer->total_amount, 0, ',', '.') }}</p>
            </div>

            <!-- Payment Status -->
            <div class="payment-status">
                <span class="status-badge">{{ ucfirst($buyer->payment_status) }}</span>
                <p style="margin: 10px 0 0 0; font-size: 14px; color: #856404;">
                    Menunggu konfirmasi pembayaran
                </p>
            </div>

            <!-- Payment Instructions -->
            <div class="payment-instructions">
                <h4>📋 Langkah Selanjutnya</h4>
                <p>1. Lakukan pembayaran sesuai dengan total amount di atas</p>
                <p>2. Simpan nomor pesanan <strong>{{ $buyer->external_id }}</strong> untuk referensi</p>
                <p>3. Upload bukti pembayaran melalui link di bawah ini</p>

                <a href="{{ route('payment.manual', ['external_id' => $buyer->external_id]) }}" class="payment-link">
                    Upload Bukti Pembayaran
                </a>
            </div>

            <div class="receipt-line">
                <p style="text-align: center; color: #6c757d; font-size: 14px; margin: 0;">
                    <strong>Penting:</strong> Pastikan nominal transfer sesuai dengan total pembayaran termasuk kode
                    unik
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Email otomatis - Jangan membalas</strong></p>
            <p>Hubungi customer service jika memerlukan bantuan</p>
            <p>© {{ date('Y') }} Event Ticketing System</p>
        </div>
    </div>
</body>

</html>
