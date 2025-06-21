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

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .card-title i {
            color: var(--primary);
            margin-right: 0.75rem;
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 2rem;
            font-size: 14px;
        }

        .breadcrumb-item {
            color: var(--gray-600);
        }

        .breadcrumb-item.active {
            color: var(--gray-700);
            font-weight: 600;
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-dark);
        }

        /* Form Controls */
        .form-label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            font-size: 14px;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: var(--white);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(212, 165, 116, 0.15);
            background-color: var(--white);
        }

        .form-control.is-invalid {
            border-color: #f1416c;
        }

        .text-danger {
            color: #f1416c !important;
            font-size: 12px;
            margin-top: 0.25rem;
        }

        /* Input Groups */
        .input-group-text {
            background-color: var(--gray-200);
            border-color: var(--gray-300);
            color: var(--gray-600);
            font-size: 14px;
        }

        /* Buttons */
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

        .btn-secondary {
            background-color: var(--gray-200);
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background-color: var(--gray-300);
            border-color: var(--gray-700);
            color: var(--gray-700);
        }

        .btn-secondary i {
            margin-right: 0.5rem;
        }

        /* Event Info Card */
        .event-info {
            background-color: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .event-info img {
            border-radius: 8px;
        }

        .event-info h5 {
            color: var(--dark);
            font-weight: 700;
            margin-bottom: 0.75rem;
            font-size: 1.125rem;
        }

        .event-info .text-muted {
            color: var(--gray-600) !important;
            font-size: 14px;
        }

        /* Ticket Selection */
        .ticket-selection {
            background-color: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .ticket-selection h6 {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .price-display {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* Section Headers */
        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--dark);
        }

        .section-header i {
            color: var(--primary);
            margin-right: 0.5rem;
        }

        /* Jersey Size Grid */
        .jersey-size-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(70px, 1fr));
            gap: 0.75rem;
            margin-top: 0.75rem;
        }

        .jersey-size-option {
            position: relative;
            text-align: center;
            padding: 1rem 0.5rem;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: var(--white);
            font-weight: 600;
            font-size: 14px;
        }

        .jersey-size-option:hover {
            border-color: var(--primary);
            background-color: rgba(212, 165, 116, 0.1);
        }

        .jersey-size-option.selected {
            border-color: var(--primary);
            background-color: var(--primary);
            color: var(--white);
        }

        .jersey-size-option input[type="radio"] {
            display: none;
        }

        /* Order Summary */
        .order-summary {
            background-color: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
            position: sticky;
            top: 90px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .order-summary h5 {
            color: var(--dark);
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.125rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-item span:first-child {
            color: var(--gray-600);
            font-size: 14px;
        }

        .summary-item span:last-child {
            font-weight: 600;
            color: var(--dark);
            font-size: 14px;
        }

        .total-section {
            background-color: var(--gray-100);
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .total-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 8px;
            font-size: 12px;
            padding: 1rem;
        }

        .alert-info {
            background-color: rgba(212, 165, 116, 0.1);
            color: var(--primary);
            border: 1px solid rgba(212, 165, 116, 0.2);
        }

        .alert-warning {
            background-color: #fff8dd;
            color: #ffc700;
            border: 1px solid #ffeaa7;
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: var(--gray-600);
            padding: 2rem 0;
            margin-top: 3rem;
            border-top: 3px solid var(--primary);
        }

        .footer h6 {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Container */
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .order-summary {
                position: relative;
                top: auto;
                margin-top: 2rem;
            }

            .container-custom {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            .jersey-size-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .event-info {
                padding: 1rem;
            }

            .order-summary {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="#" class="navbar-brand">
                <img src="{{ asset('assets/media/logos/logo.png') }}" alt="Ticketify" height="50">
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-custom" style="margin-top: 100px;">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('order.index') }}">
                        <i class="fas fa-home me-1"></i>Events
                    </a>
                </li>
                <li class="breadcrumb-item active">Order Form</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Order Form -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            <i class="fas fa-shopping-cart"></i>
                            Form Pemesanan Tiket
                        </h3>

                        <!-- Event Info -->
                        <div class="event-info">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <img src="{{ $product->avatar ? Storage::url($product->avatar) : 'https://via.placeholder.com/150x100?text=No+Image' }}"
                                        alt="Event" class="img-fluid">
                                </div>
                                <div class="col-md-9">
                                    <h5>{{ $product->product_name }}</h5>
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
                                <div class="ticket-selection">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6>{{ $ticket->name }}</h6>
                                            {{-- <small class="text-muted">{{ $ticket->qty }} tiket tersisa</small> --}}
                                        </div>
                                        <div class="price-display">
                                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <div class="section-header">
                                <i class="fas fa-user"></i>
                                Informasi Pemesan
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                        required value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap">
                                    @error('nama_lengkap')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="no_handphone" class="form-label">No. Handphone <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="no_handphone" name="no_handphone"
                                        required value="{{ old('no_handphone') }}" placeholder="08123456789">
                                    @error('no_handphone')
                                        <div class="text-danger">{{ $message }}</div>
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
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kode_pos" class="form-label">Kode Pos <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="kode_pos" name="kode_pos" required
                                        value="{{ old('kode_pos') }}" placeholder="12345">
                                    @error('kode_pos')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="alamat_lengkap" class="form-label">Alamat Lengkap <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3" required
                                    placeholder="Masukkan alamat lengkap untuk pengiriman jersey">{{ old('alamat_lengkap') }}</textarea>
                                @error('alamat_lengkap')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jersey Size Selection -->
                            <div class="mb-4">
                                <label class="form-label">Ukuran Jersey <span class="text-danger">*</span></label>

                                <!-- Size Chart Image -->
                                <div class="mb-3 text-left">
                                    <img src="{{ asset('assets/media/illustrations/size_chart.jpg') }}"
                                        alt="Size Chart" class="img-fluid rounded border" style="max-height: 400px;">
                                    <small class="d-block text-muted mt-1">Panduan Ukuran Jersey</small>
                                </div>

                                <div class="jersey-size-grid">
                                    @php
                                        $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
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
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-3 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-credit-card"></i>
                                    Lanjut ke Pembayaran
                                </button>
                                <a href="{{ route('order.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i>
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
                    <h5>
                        <i class="fas fa-receipt me-2"></i>
                        Ringkasan Pesanan
                    </h5>

                    <div class="summary-item">
                        <span>Kategori Tiket:</span>
                        <span>{{ $ticket->name }}</span>
                    </div>

                    <div class="summary-item">
                        <span>Harga Tiket:</span>
                        <span>Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                    </div>

                    @php
                        $adminFee = $ticket->price * 0.05; // 5% dari harga tiket
                        $totalPrice = $ticket->price + $adminFee;
                    @endphp

                    <div class="summary-item">
                        <span>Biaya Admin (5%):</span>
                        <span>Rp {{ number_format($adminFee, 0, ',', '.') }}</span>
                    </div>

                    <div class="total-section">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total:</span>
                            <span class="total-price">
                                Rp {{ number_format($totalPrice, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Jersey akan dikirim melalui kurir setelah pembayaran dikonfirmasi.
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Penting:</strong> Pastikan alamat dan ukuran jersey sudah benar sebelum melanjutkan
                        pembayaran.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6>Ticketify</h6>
                    <p class="mb-0">Platform terpercaya untuk booking tiket event di Indonesia</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; 2025 Ticketify. All rights reserved.</p>
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
