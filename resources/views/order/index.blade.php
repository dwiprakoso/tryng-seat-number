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
            --kt-secondary: #e4e6ea;
            --kt-success: #50cd89;
            --kt-info: #7239ea;
            --kt-warning: #ffc700;
            --kt-danger: #f1416c;
            --kt-light: #f5f8fa;
            --kt-dark: #181c32;
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
        }

        /* Navbar Styling */
        .navbar-custom {
            background: linear-gradient(90deg, var(--kt-primary) 0%, #7239ea 100%);
            box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: white !important;
            transform: translateY(-1px);
        }

        .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            font-weight: 600;
        }

        .btn-outline-light:hover {
            background-color: white;
            color: var(--kt-primary);
            border-color: white;
        }

        /* Card Styling */
        .card-custom {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--kt-primary) 0%, #7239ea 100%);
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .event-poster {
            height: 250px;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .badge-custom {
            background: linear-gradient(135deg, var(--kt-success) 0%, #0dcaf0 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .event-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--kt-gray-900);
            margin-bottom: 1rem;
        }

        .event-meta {
            color: var(--kt-gray-600);
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .event-meta i {
            color: var(--kt-primary);
            width: 20px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--kt-primary) 0%, #7239ea 100%);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 158, 247, 0.25);
        }

        .ticket-category {
            background: var(--kt-light);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--kt-primary);
        }

        .ticket-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--kt-success);
        }

        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .event-title {
                font-size: 1.5rem;
            }

            .container-custom {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-ticket-alt me-2"></i>
                EventHub
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-custom" style="margin-top: 100px;">

        <!-- Event Card -->
        <div class="card card-custom">
            <div class="card-body p-4">
                <div class="row">
                    <!-- Event Poster -->
                    <div class="col-lg-5 mb-4">
                        <img src="https://via.placeholder.com/400x300/009ef7/ffffff?text=Slow+Move+Bazaar+VOL.9"
                            alt="Event Poster" class="img-fluid event-poster w-100">
                    </div>

                    <!-- Event Info -->
                    <div class="col-lg-7">
                        <h1 class="event-title">Slow Move Bazaar VOL.9</h1>

                        <div class="event-meta">
                            <i class="fas fa-calendar"></i>
                            <strong>20 Jun 2025 - 22 Jun 2025</strong>
                        </div>

                        <div class="event-meta">
                            <i class="fas fa-clock"></i>
                            <strong>10:00 - 21:00 WIB</strong>
                        </div>

                        <div class="event-meta mb-3">
                            <i class="fas fa-map-marker-alt"></i>
                            <strong>The Brickhall @ FCC, DKI Jakarta</strong>
                        </div>
                        <div class="mb-4">
                            <h5 class="mb-3">Deskripsi Event</h5>
                            <p class="text-muted">
                                The hottest bazaar in town is back! Join us at Slow Move Bazaar VOL.9 and get ready to
                                dive into a world of Indonesian slow fashion brands, sustainable lifestyle products, and
                                creative communities. More than 100+ Fashion & FnB Tenants will be waiting for you!
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Ticket Categories -->
                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="mb-4">
                            <i class="fas fa-ticket-alt text-primary me-2"></i>
                            Kategori Tiket
                        </h3>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="ticket-category">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">Test Tiket Update</h5>
                                    <p class="text-muted mb-0">Tiket reguler untuk akses umum</p>
                                    <small class="text-muted">Qty: 10 tiket tersisa</small>
                                </div>
                                <div class="text-end">
                                    <div class="ticket-price">Rp 50.000</div>
                                    <small class="text-muted">per tiket</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="ticket-category">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">Tambah Tiket</h5>
                                    <p class="text-muted mb-0">Tiket premium dengan benefit tambahan</p>
                                    <small class="text-muted">Qty: 2310 tiket tersisa</small>
                                </div>
                                <div class="text-end">
                                    <div class="ticket-price">Rp 10.000.000</div>
                                    <small class="text-muted">per tiket</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>EventHub</h5>
                    <p class="text-muted">Platform terpercaya untuk booking tiket event di Indonesia</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted">&copy; 2025 EventHub. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
