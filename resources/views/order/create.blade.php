<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form - Event Management</title>

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

        /* Card Styling */
        .card-custom {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--kt-primary) 0%, #7239ea 100%);
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--kt-gray-800);
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--kt-gray-300);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--kt-primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 158, 247, 0.25);
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

        .btn-secondary-custom {
            background: var(--kt-gray-300);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: var(--kt-gray-700);
            transition: all 0.3s ease;
        }

        .btn-secondary-custom:hover {
            background: var(--kt-gray-400);
            transform: translateY(-1px);
        }

        .order-summary {
            background: var(--kt-light);
            border-radius: 0.75rem;
            padding: 1.5rem;
            border-left: 4px solid var(--kt-primary);
        }

        .event-info {
            background: white;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--kt-gray-200);
        }

        .price-display {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--kt-success);
        }

        .total-price {
            font-size: 2rem;
            font-weight: 700;
            color: var(--kt-primary);
        }

        .container-custom {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-custom .breadcrumb-item {
            color: var(--kt-gray-600);
        }

        .breadcrumb-custom .breadcrumb-item.active {
            color: var(--kt-primary);
            font-weight: 600;
        }

        .jersey-size-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .jersey-size-option {
            text-align: center;
            padding: 0.75rem;
            border: 2px solid var(--kt-gray-300);
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .jersey-size-option:hover {
            border-color: var(--kt-primary);
            background: var(--kt-primary-light);
        }

        .jersey-size-option.selected {
            border-color: var(--kt-primary);
            background: var(--kt-primary);
            color: white;
        }

        .jersey-size-option input[type="radio"] {
            display: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container-custom {
                padding: 1rem;
            }

            .jersey-size-grid {
                grid-template-columns: repeat(4, 1fr);
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

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item">
                    <a href="{{ route('order.index') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>Events
                    </a>
                </li>
                <li class="breadcrumb-item active">Order Form</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Order Form -->
            <div class="col-lg-8">
                <div class="card card-custom">
                    <div class="card-header card-header-custom">
                        <h4 class="mb-0">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Form Pemesanan Tiket
                        </h4>
                    </div>
                    <div class="card-body p-4">

                        <!-- Event Info -->
                        <div class="event-info">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <img src="{{ $product->avatar ? Storage::url($product->avatar) : 'https://via.placeholder.com/150x100?text=No+Image' }}"
                                        alt="Event" class="img-fluid rounded">
                                </div>
                                <div class="col-md-9">
                                    <h5 class="mb-2">{{ $product->product_name }}</h5>
                                    <p class="text-muted mb-1">
                                        <i class="fas fa-calendar me-2"></i>
                                        {{ \Carbon\Carbon::parse($product->event_date)->translatedFormat('d M Y') }}
                                    </p>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        {{ $product->location }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('order.store') }}" method="POST" id="orderForm">
                            @csrf
                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                            <!-- Ticket Selection -->
                            <div class="mb-4">
                                <label class="form-label">Kategori Tiket</label>
                                <div class="p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $ticket->name }}</h6>
                                            <small class="text-muted">{{ $ticket->qty }} tiket tersisa</small>
                                        </div>
                                        <div class="price-display">
                                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <h5 class="mb-3">
                                <i class="fas fa-user me-2"></i>
                                Informasi Pemesan
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                        required value="{{ old('nama_lengkap') }}">
                                    @error('nama_lengkap')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="no_handphone" class="form-label">No. Handphone *</label>
                                    <input type="tel" class="form-control" id="no_handphone" name="no_handphone"
                                        required value="{{ old('no_handphone') }}" placeholder="Contoh: 08123456789">
                                    @error('no_handphone')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_instagram" class="form-label">Username Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text">@</span>
                                        <input type="text" class="form-control" id="nama_instagram"
                                            name="nama_instagram" value="{{ old('nama_instagram') }}"
                                            placeholder="username_anda">
                                    </div>
                                    @error('nama_instagram')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kode_pos" class="form-label">Kode Pos *</label>
                                    <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                                        required value="{{ old('kode_pos') }}" placeholder="Contoh: 12345">
                                    @error('kode_pos')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="alamat_lengkap" class="form-label">Alamat Lengkap *</label>
                                <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3" required
                                    placeholder="Masukkan alamat lengkap untuk pengiriman jersey...">{{ old('alamat_lengkap') }}</textarea>
                                @error('alamat_lengkap')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jersey Size Selection -->
                            <div class="mb-4">
                                <label class="form-label">Ukuran Jersey *</label>
                                <div class="jersey-size-grid">
                                    @php
                                        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
                                    @endphp
                                    @foreach ($sizes as $size)
                                        <div class="jersey-size-option" onclick="selectSize('{{ $size }}')">
                                            <input type="radio" name="ukuran_jersey" value="{{ $size }}"
                                                id="size_{{ $size }}"
                                                {{ old('ukuran_jersey') == $size ? 'checked' : '' }}>
                                            <label for="size_{{ $size }}">{{ $size }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('ukuran_jersey')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-credit-card me-2"></i>
                                    Lanjut ke Pembayaran
                                </button>
                                <a href="{{ route('order.index') }}" class="btn btn-secondary-custom">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <h5 class="mb-3">
                        <i class="fas fa-receipt me-2"></i>
                        Ringkasan Pesanan
                    </h5>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Kategori Tiket:</span>
                            <strong>{{ $ticket->name }}</strong>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Harga Tiket:</span>
                            <strong>Rp {{ number_format($ticket->price, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Biaya Admin:</span>
                            <strong>Rp 5.000</strong>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h6">Total:</span>
                            <span class="total-price">
                                Rp {{ number_format($ticket->price + 5000, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>
                            Jersey akan dikirim melalui kurir setelah pembayaran dikonfirmasi.
                        </small>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <small>
                            <strong>Penting:</strong> Pastikan alamat dan ukuran jersey sudah benar sebelum melanjutkan
                            pembayaran.
                        </small>
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

    <script>
        function selectSize(size) {
            // Remove selected class from all options
            document.querySelectorAll('.jersey-size-option').forEach(option => {
                option.classList.remove('selected');
            });

            // Add selected class to clicked option
            event.currentTarget.classList.add('selected');

            // Check the radio input
            document.getElementById('size_' + size).checked = true;
        }

        // Set initial selected state based on old input (for validation errors)
        document.addEventListener('DOMContentLoaded', function() {
            const checkedInput = document.querySelector('input[name="ukuran_jersey"]:checked');
            if (checkedInput) {
                checkedInput.closest('.jersey-size-option').classList.add('selected');
            }
        });

        // Form validation
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            const requiredFields = ['nama_lengkap', 'no_handphone', 'alamat_lengkap', 'kode_pos'];
            let isValid = true;

            // Check text fields
            requiredFields.forEach(function(fieldId) {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            // Check jersey size selection
            const sizeSelected = document.querySelector('input[name="ukuran_jersey"]:checked');
            if (!sizeSelected) {
                isValid = false;
                alert('Mohon pilih ukuran jersey!');
            }

            if (!isValid) {
                e.preventDefault();
                if (!sizeSelected) return; // Alert already shown for size
                alert('Mohon lengkapi semua field yang wajib diisi!');
            }
        });

        // Phone number formatting
        document.getElementById('no_handphone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits

            // Add country code if not present
            if (value.length > 0 && !value.startsWith('62') && !value.startsWith('08')) {
                if (value.startsWith('8')) {
                    value = '0' + value;
                }
            }

            e.target.value = value;
        });

        // Postal code validation (numbers only)
        document.getElementById('kode_pos').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    </script>
</body>

</html>
