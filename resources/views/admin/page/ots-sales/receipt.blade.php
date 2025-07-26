<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $otsSale->nama_lengkap }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #fff;
        }

        .receipt {
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10px;
            margin-bottom: 2px;
        }

        .info-section {
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .info-row.bold {
            font-weight: bold;
        }

        .separator {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .items-section {
            margin-bottom: 15px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .item-name {
            flex: 1;
        }

        .item-qty {
            width: 30px;
            text-align: center;
        }

        .item-price {
            width: 80px;
            text-align: right;
        }

        .totals-section {
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-bottom: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .total-row.final {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .footer {
            text-align: center;
            border-top: 1px dashed #000;
            padding-top: 10px;
            font-size: 10px;
        }

        .payment-badge {
            display: inline-block;
            padding: 2px 8px;
            background: {{ $otsSale->payment_method === 'cash' ? '#d4edda' : '#cce5ff' }};
            border: 1px solid {{ $otsSale->payment_method === 'cash' ? '#c3e6cb' : '#99ccff' }};
            border-radius: 3px;
            font-size: 10px;
            text-transform: uppercase;
        }

        @media print {
            body {
                font-size: 11px;
            }

            .receipt {
                width: 100%;
                margin: 0;
                border: none;
                padding: 10px;
            }

            .no-print {
                display: none;
            }
        }

        .btn {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
            cursor: pointer;
            border: none;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #545b62;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="no-print" style="position: fixed; top: 20px; right: 20px; display: flex; gap: 10px;">
        <a href="{{ route('admin.ots-sales.index') }}" class="btn btn-secondary"
            style="background: #6c757d; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-size: 14px; display: inline-block;">
            ← Back to OTS Sales
        </a>
        <button class="btn btn-primary" onclick="window.print()"
            style="background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 14px;">
            Print Receipt
        </button>
    </div>

    <div class="receipt">
        <div class="header">
            <h1>RECEIPT</h1>
            <p>Ticket Sales Receipt</p>
            <p>{{ date('d/m/Y H:i:s') }}</p>
        </div>

        <div class="info-section">
            <div class="info-row">
                <span>Receipt ID:</span>
                <span>#{{ str_pad($otsSale->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <span>Date:</span>
                <span>{{ $otsSale->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span>Customer:</span>
                <span>{{ $otsSale->nama_lengkap }}</span>
            </div>
            <div class="info-row">
                <span>Phone:</span>
                <span>{{ $otsSale->no_handphone }}</span>
            </div>
            <div class="info-row">
                <span>Payment:</span>
                <span class="payment-badge">{{ strtoupper($otsSale->payment_method) }}</span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="items-section">
            <div class="item-row"
                style="font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 8px;">
                <div class="item-name">ITEM</div>
                <div class="item-qty">QTY</div>
                <div class="item-price">AMOUNT</div>
            </div>

            <div class="item-row">
                <div class="item-name">{{ $otsSale->ticket->name }}</div>
                <div class="item-qty">{{ $otsSale->quantity }}</div>
                <div class="item-price">{{ number_format($otsSale->ticket_price * $otsSale->quantity, 0, ',', '.') }}
                </div>
            </div>

            <div style="font-size: 10px; color: #666; margin-top: 3px;">
                @ Rp {{ number_format($otsSale->ticket_price, 0, ',', '.') }} each
            </div>
        </div>

        <div class="totals-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($otsSale->ticket_price * $otsSale->quantity, 0, ',', '.') }}</span>
            </div>

            @if ($otsSale->admin_fee > 0)
                <div class="total-row">
                    <span>Admin Fee (5%):</span>
                    <span>Rp {{ number_format($otsSale->admin_fee, 0, ',', '.') }}</span>
                </div>
            @endif

            <div class="total-row final">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($otsSale->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for your purchase!</p>
            <p>Keep this receipt as proof of purchase</p>
            <br>
            <p style="font-size: 8px;">
                This is a computer generated receipt.<br>
                Generated at {{ now()->format('d/m/Y H:i:s') }}
            </p>
        </div>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() { 
        //     window.print(); 
        // };

        // Close window after printing (optional)
        window.onafterprint = function() {
            // window.close();
        };
    </script>
</body>

</html>
