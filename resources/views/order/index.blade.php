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
            --primary: #009ef7;
            --success: #50cd89;
            --dark: #181c32;
            --white: #ffffff;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-600: #6c757d;
            --gray-700: #495057;
            --gray-900: #212529;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-100);
            color: var(--gray-700);
            font-size: 14px;
            line-height: 1.5;
        }

        /* Minimal Navbar */
        .navbar {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--dark);
            text-decoration: none;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-brand i {
            color: var(--primary);
            margin-right: 0.5rem;
        }

        .navbar .container {
            display: flex;
            justify-content: center;
        }

        /* Cards */
        .card {
            background: var(--white);
            border: none;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        /* Event Section */
        .event-poster {
            width: 100%;
            height: 300px;
            border-radius: 8px;
            object-fit: cover;
            background: var(--gray-200);
        }

        .event-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .event-meta {
            display: flex;
            align-items: center;
            color: var(--gray-600);
            margin-bottom: 0.75rem;
            font-size: 14px;
        }

        .event-meta i {
            color: var(--primary);
            width: 18px;
            margin-right: 0.75rem;
        }

        .event-description {
            color: var(--gray-600);
            line-height: 1.6;
            margin-top: 1.5rem;
        }

        /* Section Title */
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-title i {
            color: var(--primary);
            margin-right: 0.75rem;
        }

        /* Ticket Cards */
        .ticket-item {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.2s ease;
        }

        .ticket-item:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(0, 158, 247, 0.1);
        }

        .ticket-name {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .ticket-description {
            color: var(--gray-600);
            font-size: 13px;
            margin-bottom: 0.5rem;
        }

        .ticket-qty {
            color: var(--gray-600);
            font-size: 12px;
            display: flex;
            align-items: center;
        }

        .ticket-qty i {
            margin-right: 0.25rem;
        }

        .ticket-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--success);
            margin-bottom: 0.25rem;
        }

        .price-label {
            color: var(--gray-600);
            font-size: 12px;
            margin-bottom: 1rem;
        }

        /* Button */
        .btn-primary {
            background-color: var(--primary);
            border: none;
            color: var(--white);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-primary:hover {
            background-color: #0095e8;
            transform: translateY(-1px);
            color: var(--white);
        }

        .btn-primary i {
            margin-right: 0.5rem;
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: var(--gray-600);
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .footer h6 {
            color: var(--white);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            .event-title {
                font-size: 1.5rem;
            }

            .event-poster {
                height: 200px;
                margin-bottom: 1.5rem;
            }

            .ticket-item {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Minimal Navbar with Centered Logo -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-calendar-alt"></i>
                Ticketify
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container" style="margin-top: 100px; max-width: 1200px;">

        <!-- Event Details -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5">
                        <img src="{{ $product->avatar ? Storage::url($product->avatar) : 'https://via.placeholder.com/400x300?text=No+Image' }}"
                            alt="Event Poster" class="event-poster">
                    </div>
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

                        <div class="event-description">
                            <h5 style="font-weight: 600; color: var(--dark); margin-bottom: 0.75rem;">Deskripsi Event
                            </h5>
                            <p>{{ $product->product_description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ticket Categories -->
        <div class="card">
            <div class="card-body">
                <h3 class="section-title">
                    <i class="fas fa-ticket-alt"></i>
                    Kategori Tiket
                </h3>

                <div class="row">
                    @foreach ($tickets as $ticket)
                        <div class="col-md-6">
                            <div class="ticket-item">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-grow-1">
                                        <h5 class="ticket-name">{{ $ticket->name }}</h5>
                                        <p class="ticket-description">Tiket reguler untuk akses umum</p>
                                        <div class="ticket-qty">
                                            <i class="fas fa-users"></i>
                                            {{ $ticket->qty }} tiket tersisa
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="ticket-price">Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </div>
                                        <div class="price-label">per tiket</div>
                                        <a href="{{ route('order.create', ['ticket_id' => $ticket->id]) }}"
                                            class="btn btn-primary">
                                            <i class="fas fa-shopping-cart"></i>
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
                    <p>Platform terpercaya untuk booking tiket event di Indonesia</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; 2025 EventHub. All rights reserved.</p>
                </div>
            </div>
        </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
