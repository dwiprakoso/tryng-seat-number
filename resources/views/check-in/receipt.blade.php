<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-in Receipt - {{ $checkin->buyer->nama_lengkap }}</title>
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
        <a href="{{ route('checkin.index') }}" class="btn btn-secondary">
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
            <td>: {{ $checkin->buyer->external_id }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $checkin->buyer->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>HP</td>
            <td>: {{ $checkin->buyer->no_handphone }}</td>
        </tr>
        <tr>
            <td>Check-in</td>
            <td>: {{ $checkin->checked_in_at->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td>{{ $checkin->buyer->ticket->name ?? 'Festival Ticket' }}</td>
            <td class="right">{{ $checkin->qty }} pcs</td>
        </tr>
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td class="bold">Status</td>
            <td class="right bold">CHECKED-IN</td>
        </tr>
        <tr>
            <td>Type</td>
            <td class="right">ONLINE BOOKING</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="thankyou">
        <div>Selamat menikmati acara!</div>
        <div>~ Keep this as proof ~</div>
    </div>

    <script>
        // Auto print when page loads
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
