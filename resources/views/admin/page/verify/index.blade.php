<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4 class="mb-0">
                            <i class="bi bi-ticket-perforated"></i> Verifikasi Tiket
                        </h4>
                    </div>
                    <div class="card-body text-center">
                        @if ($status === 'valid')
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill fs-1 text-success"></i>
                                <h5 class="mt-3 text-success">{{ $message }}</h5>
                            </div>

                            <div class="ticket-info text-start">
                                <h6 class="fw-bold">Detail Tiket:</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>External ID:</strong></td>
                                        <td>{{ $buyer->external_id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama Lengkap:</strong></td>
                                        <td>{{ $buyer->nama_lengkap }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $buyer->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. Handphone:</strong></td>
                                        <td>{{ $buyer->no_handphone }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jumlah Tiket:</strong></td>
                                        <td>{{ $buyer->quantity }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kursi:</strong></td>
                                        <td>
                                            @foreach ($buyer->bookingSeats as $bookingSeat)
                                                <span
                                                    class="badge bg-primary me-1">{{ $bookingSeat->seat->seat_number }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Event:</strong></td>
                                        <td>{{ $buyer->ticket->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Bayar:</strong></td>
                                        <td class="fw-bold">Rp {{ number_format($buyer->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td><span class="badge bg-success">Sudah Dibayar</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Konfirmasi:</strong></td>
                                        <td>{{ $buyer->payment_confirmed_at ? $buyer->payment_confirmed_at->format('d M Y, H:i') : '-' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        @elseif($status === 'payment_pending')
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle-fill fs-1 text-warning"></i>
                                <h5 class="mt-3 text-warning">{{ $message }}</h5>
                            </div>

                            @if ($buyer)
                                <div class="ticket-info text-start">
                                    <h6 class="fw-bold">Detail Tiket:</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>External ID:</strong></td>
                                            <td>{{ $buyer->external_id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama Lengkap:</strong></td>
                                            <td>{{ $buyer->nama_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span class="badge bg-warning">
                                                    {{ ucfirst(str_replace('_', ' ', $buyer->payment_status)) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-danger">
                                <i class="bi bi-x-circle-fill fs-1 text-danger"></i>
                                <h5 class="mt-3 text-danger">{{ $message }}</h5>
                                <p class="mt-2">Silakan periksa kembali kode QR atau hubungi panitia.</p>
                            </div>
                        @endif

                        <div class="mt-4">
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i>
                                Verifikasi dilakukan pada: {{ now()->format('d M Y, H:i:s') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
