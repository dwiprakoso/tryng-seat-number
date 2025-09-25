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
            line-height: 1.3;
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

        .double-line {
            border-top: 2px solid black;
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
            z-index: 1000;
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

        .seats-section {
            margin: 5px 0;
        }

        .seat-item {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
            font-size: 11px;
        }

        .seat-number {
            font-weight: bold;
            color: #333;
        }

        .seat-type {
            font-size: 10px;
            color: #666;
        }

        .total-seats {
            border-top: 1px solid #333;
            padding-top: 3px;
            margin-top: 5px;
            font-weight: bold;
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

        .header-logo {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .event-info {
            font-size: 10px;
            color: #555;
            margin-bottom: 3px;
        }

        .qr-placeholder {
            text-align: center;
            font-size: 10px;
            margin: 10px 0;
            padding: 10px;
            border: 1px dashed #ccc;
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

    <!-- Header -->
    <div class="center">
        <div class="header-logo">UKM-F TEATER BUIH FEB UNDIP</div>
        <div class="bold" style="font-size: 16px; margin: 5px 0;">DHEMIT</div>
        <div class="event-info">Ticketify ID</div>
        <div class="event-info">Jl. Lamper Sari No.32, Semarang</div>
        <div class="event-info">Telp: 0822-2703-1735</div>
    </div>

    <div class="line"></div>

    <!-- Customer Info -->
    <table>
        <tr>
            <td style="width: 25%;">ID</td>
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

    <!-- Ticket Info -->
    <table>
        <tr>
            <td class="bold">{{ $checkin->buyer->ticket->name ?? 'Festival Ticket' }}</td>
            <td class="right bold">{{ $checkin->qty }} pcs</td>
        </tr>
    </table>

    @if ($checkin->buyer->bookingSeats && $checkin->buyer->bookingSeats->count() > 0)
        <div class="line"></div>

        <!-- Seat Information -->
        <div class="seats-section">
            <div class="bold center" style="margin-bottom: 8px;">SEAT ASSIGNMENT</div>

            @php
                $groupedSeats = $checkin->buyer->bookingSeats->groupBy(function ($bookingSeat) {
                    return $bookingSeat->seat->row ?? 'General';
                });
            @endphp

            @foreach ($groupedSeats as $row => $bookingSeats)
                @if ($row !== 'General')
                    <div class="bold" style="font-size: 11px; margin: 5px 0 2px 0;">Row {{ $row }}</div>
                @endif

                @foreach ($bookingSeats as $bookingSeat)
                    @if ($bookingSeat->seat)
                        <div class="seat-item">
                            <span>
                                <span class="seat-number">{{ $bookingSeat->seat->seat_number }}</span>
                                <span>✓</span>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    @endif
    <div class="double-line"></div>

    <div class="thankyou">
        <div class="bold">Selamat menikmati acara!</div>
        <div style="margin: 5px 0;">~ Keep this as proof ~</div>
        <div class="event-info" style="margin-top: 8px;">
            Tanggal: {{ now()->format('d/m/Y') }}<br>
            {{ now()->format('H:i') }} WIB
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            // Small delay to ensure content is fully loaded
            setTimeout(function() {
                window.print();
            }, 500);
        };

        // Optional: Close window after printing
        window.onafterprint = function() {
            // Uncomment if you want to auto-close after print
            // setTimeout(() => window.close(), 1000);
        };

        // Add print button functionality for non-auto scenarios
        function printReceipt() {
            window.print();
        }
    </script>
</body>

</html>
