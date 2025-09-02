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
            --primary: #D4A574;
            /* Gold color */
            --primary-dark: #B8935F;
            /* Darker gold for hover */
            --success: #D4A574;
            /* Gold for price */
            --dark: #2C2C2C;
            /* Dark gray */
            --white: #ffffff;
            --gray-100: #F5F5F5;
            /* Light gray background */
            --gray-200: #E8E8E8;
            /* Light border */
            --gray-300: #D1D1D1;
            /* Medium border */
            --gray-600: #666666;
            /* Medium gray text */
            --gray-700: #4A4A4A;
            /* Darker gray text */
            --gray-900: #2C2C2C;
            /* Very dark gray */
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
            background: var(--dark);
            border-bottom: 1px solid var(--gray-600);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
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
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
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
            border: 2px solid var(--gray-200);
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

        .event-description h5 {
            color: var(--dark) !important;
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
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .ticket-item:hover {
            border-color: var(--primary);
            box-shadow: 0 6px 20px rgba(212, 165, 116, 0.15);
            transform: translateY(-2px);
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
            color: var(--primary);
        }

        .ticket-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .price-label {
            color: var(--gray-600);
            font-size: 12px;
            margin-bottom: 1rem;
        }

        /* Button */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            color: var(--white);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(212, 165, 116, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #A67C52 100%);
            transform: translateY(-2px);
            color: var(--white);
            box-shadow: 0 6px 20px rgba(212, 165, 116, 0.4);
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
            border-top: 3px solid var(--primary);
        }

        .footer h4 {
            color: var(--primary);
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

        /* Tambahkan di bagian CSS */
        .btn-disabled {
            background: var(--gray-300) !important;
            color: var(--gray-600) !important;
            cursor: not-allowed !important;
            box-shadow: none !important;
            border: 1px solid var(--gray-300) !important;
        }

        .btn-disabled:hover {
            background: var(--gray-300) !important;
            transform: none !important;
            box-shadow: none !important;
        }

        .ticket-item.sold-out {
            opacity: 0.6;
            background: var(--gray-100);
        }

        .sold-out-badge {
            background: #dc3545;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: inline-block;
        }
    </style>
</head>

<body>
    <!-- Alert Messages -->
    {{-- @if (session('error'))
        <div class="container" style="margin-top: 100px;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="container" style="margin-top: 100px;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif --}}
    <!-- Minimal Navbar with Centered Logo -->
    <nav class="navbar">
        <div class="container">
            <a href="#">
                <img src="{{ asset('assets/media/logos/logo.png') }}" alt="Ticketify" class="navbar-brand"
                    height="50">
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container" style="margin-top: 100px; max-width: 1200px;">

        <!-- Event Details -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <img src="{{ $product->avatar ? Storage::url($product->avatar) : 'https://via.placeholder.com/400x300?text=No+Image' }}"
                            alt="Event Poster" class="img-fluid" style="height: 400px; object-fit: contain;">
                    </div>
                    <div class="col-lg-8">
                        <h1 class="event-title">{{ $product->product_name }}</h1>

                        <div class="event-meta">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $product->event_date->translatedFormat('d M Y') }}</span>
                            @if ($product->end_date)
                                <span> &nbsp;-&nbsp;{{ $product->end_date->translatedFormat('d M Y') }}</span>
                            @endif
                        </div>

                        <div class="event-meta">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $product->location }}</span>
                        </div>

                        {{-- <div class="event-description">
                            <h5 style="font-weight: 600; color: var(--dark); margin-bottom: 0.75rem;">Deskripsi Event
                            </h5>
                            <p>{{ $product->product_description }}</p>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Ticket Categories -->
        <div class="card">
            <div class="card-body">
                <h3 class="section-title">
                    {{-- <i class="fas fa-ticket-alt"></i> --}}
                    Kategori Tiket
                </h3>

                <div class="row">
                    @foreach ($tickets as $ticket)
                        <div class="col-md-6">
                            <div class="ticket-item {{ $ticket->qty == 0 ? 'sold-out' : '' }}">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-grow-1">
                                        @if ($ticket->qty == 0)
                                            <span class="sold-out-badge">SOLD OUT</span>
                                        @endif
                                        <h5 class="ticket-name">{{ $ticket->name }}</h5>
                                        <p class="ticket-description">Tiket reguler untuk akses umum</p>
                                        <div class="ticket-qty">
                                            {{-- <i class="fas fa-users"></i> --}}
                                            @if ($ticket->qty == 0)
                                                Tiket habis
                                                {{-- @else
                                                {{ $ticket->qty }} tiket tersisa --}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="ticket-price">Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </div>
                                        <div class="price-label">per tiket</div>
                                        @if ($ticket->qty == 0)
                                            <button class="btn btn-disabled" disabled>
                                                <i class="fas fa-times"></i>
                                                Tiket Habis
                                            </button>
                                        @else
                                            <a href="{{ route('order.create', ['ticket_id' => $ticket->id]) }}"
                                                class="btn btn-primary">
                                                <i class="fas fa-shopping-cart"></i>
                                                Pesan Sekarang
                                            </a>
                                        @endif
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
                    <h4>Ticketify</h4>
                    <p>Platform terpercaya untuk booking tiket event di Indonesia</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; 2025 Tciketify. All rights reserved.</p>
                </div>
            </div>
        </div>
        </div>
        <!-- Modal untuk Seats Full -->
        @if (session('seats_full'))
            <div class="modal fade" id="seatsFullModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title">
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                Kursi Sudah Penuh
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-chair" style="font-size: 3rem; color: var(--gray-400);"></i>
                            </div>
                            <h6 class="mb-3">Maaf, semua kursi untuk event ini sudah dipesan</h6>
                            <p class="text-muted mb-0">
                                Silakan pilih hubungi admin untuk informasi lebih lanjut
                            </p>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>Tutup
                            </button>
                            {{-- <a href="#" class="btn btn-primary">
                                <i class="fas fa-phone me-1"></i>Hubungi Admin
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Modal untuk Error Umum -->
        @if (session('error'))
            <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title text-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>Terjadi Kesalahan
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            {{ session('error') }}
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script>
            @if (session('seats_full'))
                // Auto show modal when page loads
                document.addEventListener('DOMContentLoaded', function() {
                    const modal = new bootstrap.Modal(document.getElementById('seatsFullModal'));
                    modal.show();
                });
            @endif
            @if (session('error'))
                document.addEventListener('DOMContentLoaded', function() {
                    const modal = new bootstrap.Modal(document.getElementById('errorModal'));
                    modal.show();
                });
            @endif
        </script>
</body>

</html>
