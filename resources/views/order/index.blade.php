<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Ticket - Event Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --kt-primary: #009ef7;
            --kt-primary-light: #f1faff;
            --kt-primary-active: #0095e8;
            --kt-secondary: #e4e6ea;
            --kt-success: #50cd89;
            --kt-info: #7239ea;
            --kt-warning: #ffc700;
            --kt-danger: #f1416c;
            --kt-light: #f5f8fa;
            --kt-dark: #181c32;
            --kt-white: #ffffff;
            --kt-gray-100: #f5f8fa;
            --kt-gray-200: #eff2f5;
            --kt-gray-300: #e4e6ea;
            --kt-gray-400: #b5b5c3;
            --kt-gray-500: #a1a5b7;
            --kt-gray-600: #7e8299;
            --kt-gray-700: #5e6278;
            --kt-gray-800: #3f4254;
            --kt-gray-900: #181c32;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--kt-gray-100);
            color: var(--kt-gray-700);
            line-height: 1.6;
            font-size: 13px;
        }

        /* Metronic Navbar */
        .navbar-custom {
            background-color: var(--kt-white);
            border-bottom: 1px solid var(--kt-gray-200);
            box-shadow: 0 0.1rem 1rem 0.25rem rgba(0, 0, 0, 0.05);
            padding: 0;
            min-height: 70px;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--kt-gray-900) !important;
            padding: 1.25rem 0;
        }

        .navbar-brand i {
            color: var(--kt-primary);
        }

        /* Metronic Card */
        .card {
            border: none;
            border-radius: 0.625rem;
            box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075);
            background-color: var(--kt-white);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--kt-gray-200);
            padding: 1.5rem 2rem;
        }

        .card-body {
            padding: 2rem;
        }

        /* Event Poster */
        .poster-wrapper {
            width: 100%;
            height: 350px;
            border-radius: 0.625rem;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--kt-gray-200);
        }

        .poster-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Typography */
        .event-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--kt-gray-900);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .event-meta {
            display: flex;
            align-items: center;
            color: var(--kt-gray-600);
            font-size: 14px;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .event-meta i {
            color: var(--kt-primary);
            width: 20px;
            margin-right: 0.75rem;
            font-size: 16px;
        }

        .event-description {
            color: var(--kt-gray-600);
            font-size: 14px;
            line-height: 1.6;
        }

        /* Section Headers */
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--kt-gray-900);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
        }

        .section-title i {
            color: var(--kt-primary);
            margin-right: 0.75rem;
        }

        /* Ticket Category Cards */
        .ticket-card {
            background-color: var(--kt-white);
            border: 1px solid var(--kt-gray-200);
            border-radius: 0.625rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .ticket-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: var(--kt-primary);
        }

        .ticket-card:hover {
            border-color: var(--kt-primary);
            box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 158, 247, 0.1);
            transform: translateY(-2px);
        }

        .ticket-name {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--kt-gray-900);
            margin-bottom: 0.5rem;
        }

        .ticket-description {
            color: var(--kt-gray-600);
            font-size: 13px;
            margin-bottom: 0.5rem;
        }

        .ticket-qty {
            color: var(--kt-gray-500);
            font-size: 12px;
            font-weight: 500;
        }

        .ticket-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--kt-success);
            margin-bottom: 0.25rem;
        }

        .price-label {
            color: var(--kt-gray-500);
            font-size: 12px;
        }

        /* Metronic Buttons */
        .btn-primary {
            background-color: var(--kt-primary);
            border-color: var(--kt-primary);
            color: var(--kt-white);
            font-weight: 600;
            font-size: 13px;
            padding: 0.75rem 1.5rem;
            border-radius: 0.625rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--kt-primary-active);
            border-color: var(--kt-primary-active);
            color: var(--kt-white);
            transform: translateY(-1px);
        }

        .btn-primary:focus {
            box-shadow: 0 0 0 0.25rem rgba(0, 158, 247, 0.25);
        }

        /* Separator */
        .separator {
            height: 1px;
            background-color: var(--kt-gray-200);
            margin: 2rem 0;
        }

        /* Footer */
        .footer {
            background-color: var(--kt-gray-900);
            color: var(--kt-gray-400);
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .footer h6 {
            color: var(--kt-white);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Container */
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Badge */
        .badge-status {
            background-color: var(--kt-success);
            color: var(--kt-white);
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .poster-wrapper {
                height: 250px;
                margin-bottom: 2rem;
            }

            .event-title {
                font-size: 1.75rem;
            }

            .container-custom {
                padding: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .event-title {
                font-size: 1.5rem;
            }

            .ticket-card {
                padding: 1rem;
            }

            .section-title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-calendar-alt me-2"></i>
                EventHub
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-custom" style="margin-top: 90px;">
        <!-- Event Details Card -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Event Poster -->
                    <div class="col-lg-5">
                        <div class="poster-wrapper">
                            <img src="{{ $product->avatar ? Storage::url($product->avatar) : 'https://via.placeholder.com/400x350?text=No+Image' }}"
                                alt="Event Poster">
                        </div>
                    </div>

                    <!-- Event Information -->
                    <div class="col-lg-7">

                        <h1 class="event-title">{{ $product->product_name }}</h1>

                        <div class="event-meta">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ \Carbon\Carbon::parse($product->event_date)->translatedFormat('d M Y') }}</span>
                        </div>

                        <div class="event-meta">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $product->location }}</span>
                        </div>

                        <div class="separator"></div>

                        <div>
                            <h5 class="fw-bold text-gray-900 mb-3">Deskripsi Event</h5>
                            <p class="event-description">
                                {{ $product->product_description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ticket Categories Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="section-title mb-0">
                    <i class="fas fa-ticket-alt"></i>
                    Kategori Tiket
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($tickets as $ticket)
                        <div class="col-md-6">
                            <div class="ticket-card">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h5 class="ticket-name">{{ $ticket->name }}</h5>
                                        <p class="ticket-description mb-2">Tiket reguler untuk akses umum</p>
                                        <div class="ticket-qty">
                                            <i class="fas fa-users me-1"></i>
                                            {{ $ticket->qty }} tiket tersisa
                                        </div>
                                    </div>
                                    <div class="text-end ms-4">
                                        <div class="ticket-price">Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </div>
                                        <div class="price-label mb-3">per tiket</div>
                                        <a href="{{ route('order.create', ['ticket_id' => $ticket->id]) }}"
                                            class="btn btn-primary">
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            Pesan Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6>EventHub</h6>
                    <p class="mb-0">Platform terpercaya untuk booking tiket event di Indonesia</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; 2025 EventHub. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
