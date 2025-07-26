<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $otsSale->nama_lengkap }}</title>
    <style>
        body {
            width: 58mm;
            font-family: monospace;
            font-size: 12px;
            margin: 0;
            padding: 10px;
            background: white;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed black;
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 1px 0;
        }

        .right {
            text-align: right;
        }

        .thankyou {
            margin-top: 10px;
            text-align: center;
        }

        .no-print {
            position: fixed;
            top: 10px;
            right: 10px;
            background: white;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .btn {
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 3px;
            font-size: 12px;
            display: inline-block;
            cursor: pointer;
            border: none;
            margin: 2px;
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

        @media print {
            body {
                margin: 0;
                padding: 5mm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="no-print">
        <a href="{{ route('admin.ots-sales.index') }}" class="btn btn-secondary">
            ← Back
        </a>
        <button class="btn btn-primary" onclick="window.print()">
            Print
        </button>
    </div>

    <div class="center bold">Festival Arak Arakan <br> Cheng Ho 2025</div>
    <div class="center">Ticketify ID</div>
    <div class="center">Jl. Lamper Sari No.32, Semarang</div>
    <div class="center">Telp: 0822-2703-1735</div>
    <div class="line"></div>

    <table>
        <tr>
            <td>ID</td>
            <td>: {{ str_pad($otsSale->id, 3, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $otsSale->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>HP</td>
            <td>: {{ $otsSale->no_handphone }}</td>
        </tr>
        <tr>
            <td>Created</td>
            <td>: {{ $otsSale->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td>{{ $otsSale->ticket->name }}</td>
            <td class="right"> {{ $otsSale->quantity }} x Rp. {{ number_format($otsSale->ticket_price, 0, ',', '.') }}
            </td>
        </tr>
        @if ($otsSale->admin_fee > 0)
            <tr>
                <td>Admin Fee</td>
                <td class="right">Rp. {{ number_format($otsSale->admin_fee, 0, ',', '.') }}</td>
            </tr>
        @endif
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td class="bold">Total</td>
            <td class="right bold">Rp {{ number_format($otsSale->total_amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Payment</td>
            <td class="right">{{ strtoupper($otsSale->payment_method) }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="thankyou">
        <div>Terima kasih telah hadir!</div>
        <div>~ Keep this as proof ~</div>
    </div>

    <script>
        // Auto print when page loads(optional)
        window.onload = function() {
            window.print();
        };

        // Close window after printing (optional)
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>

</html>
