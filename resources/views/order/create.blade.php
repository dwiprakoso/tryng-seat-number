<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order Form - Event Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary: #D4A574;
            --primary-dark: #B8935F;
            --success: #28a745;
            --danger: #dc3545;
            --dark: #2C2C2C;
            --white: #ffffff;
            --gray-50: #FAFAFA;
            --gray-100: #F5F5F5;
            --gray-200: #E8E8E8;
            --gray-300: #D1D1D1;
            --gray-600: #666666;
            --gray-700: #4A4A4A;
            --gray-900: #2C2C2C;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-700);
            font-size: 14px;
            line-height: 1.6;
        }

        /* Improved Navbar */
        .navbar {
            background: linear-gradient(135deg, var(--dark) 0%, #1a1a1a 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.75rem;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--primary-dark);
            transform: scale(1.05);
        }

        .navbar-brand img {
            height: 45px;
            width: auto;
        }

        /* Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 2rem;
            font-size: 14px;
        }

        .breadcrumb-item {
            color: var(--gray-600);
        }

        .breadcrumb-item.active {
            color: var(--gray-900);
            font-weight: 600;
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-dark);
        }

        /* Layout Grid */
        .order-layout {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 2rem;
        }

        @media (max-width: 1200px) {
            .order-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Cards */
        .card {
            background: var(--white);
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .card-body {
            padding: 2.5rem;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            border-bottom: 2px solid var(--gray-100);
            padding-bottom: 1rem;
        }

        .card-title i {
            color: var(--primary);
            margin-right: 1rem;
            font-size: 1.5rem;
        }

        /* Event Info Sidebar */
        .event-sidebar {
            position: sticky;
            top: 120px;
            height: fit-content;
        }

        .event-info {
            background: linear-gradient(135deg, var(--white) 0%, var(--gray-50) 100%);
            border: 1px solid var(--gray-200);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .event-info img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .event-info h5 {
            color: var(--dark);
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .event-detail {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            padding: 0.5rem 0;
            color: var(--gray-600);
        }

        .event-detail i {
            color: var(--primary);
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        /* Order Summary */
        .order-summary {
            background: var(--gray-50);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--gray-200);
        }

        .order-summary h6 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .order-summary h6 i {
            color: var(--primary);
            margin-right: 0.5rem;
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
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--dark);
        }

        /* Step Progress - Improved */
        .step-progress {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
            background: var(--gray-50);
            border-radius: 12px;
            position: relative;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            margin: 0 3rem;
        }

        .step-number {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gray-300);
            color: var(--gray-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            transition: all 0.4s ease;
            border: 4px solid var(--gray-300);
            margin-bottom: 0.75rem;
        }

        .step-item.active .step-number {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            box-shadow: 0 0 0 8px rgba(212, 165, 116, 0.15);
            transform: scale(1.1);
        }

        .step-item.completed .step-number {
            background: var(--success);
            color: var(--white);
            border-color: var(--success);
        }

        .step-text {
            font-weight: 600;
            color: var(--gray-600);
            text-align: center;
            font-size: 14px;
        }

        .step-item.active .step-text {
            color: var(--primary);
            font-weight: 700;
        }

        .step-item.completed .step-text {
            color: var(--success);
        }

        /* Step connector */
        .step-progress::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 25%;
            right: 25%;
            height: 4px;
            background: var(--gray-300);
            transform: translateY(-50%);
            z-index: 1;
            border-radius: 2px;
        }

        .step-progress.step-1-completed::before {
            background: var(--success);
        }

        /* Step Content */
        .step-content {
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.5s ease;
            position: absolute;
            width: 100%;
            visibility: hidden;
        }

        .step-content.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
            visibility: visible;
        }

        /* Form Controls - Enhanced */
        .form-group {
            margin-bottom: 1.75rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.75rem;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .form-label .text-danger {
            margin-left: 0.25rem;
        }

        .form-control {
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-size: 14px;
            transition: all 0.3s ease;
            background: var(--white);
            line-height: 1.5;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(212, 165, 116, 0.15);
            background: var(--white);
        }

        .form-control.is-valid {
            border-color: var(--success);
            background-image: none;
        }

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            display: none;
            color: var(--danger);
            font-size: 12px;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .form-control.is-invalid+.invalid-feedback {
            display: block;
        }

        /* Buttons - Enhanced */
        .btn {
            font-weight: 600;
            padding: 1rem 2rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            border: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            box-shadow: 0 6px 20px rgba(212, 165, 116, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #A67C52 100%);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(212, 165, 116, 0.4);
        }

        .btn-primary:disabled {
            background: var(--gray-300);
            color: var(--gray-600);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-secondary {
            background: var(--gray-200);
            color: var(--gray-700);
            border: 2px solid var(--gray-300);
        }

        .btn-secondary:hover {
            background: var(--gray-300);
            color: var(--gray-900);
            transform: translateY(-2px);
        }

        .btn i {
            margin-right: 0.5rem;
        }

        /* Seat Selection - Redesigned */
        .seat-map {
            background: var(--white);
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--gray-200);
        }

        .seat-map h5 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--dark);
            font-weight: 700;
        }

        .stage-indicator {
            text-align: center;
            margin-bottom: 3rem;
        }

        .stage {
            background: linear-gradient(135deg, var(--gray-300) 0%, var(--gray-200) 100%);
            padding: 1rem 3rem;
            border-radius: 25px;
            display: inline-block;
            font-weight: 600;
            color: var(--gray-700);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .seat-grid {
            display: grid;
            grid-template-columns: repeat(15, 1fr);
            /* Perbanyak jadi 15 kolom */
            gap: 2px;
            /* Gap dalam pixel untuk lebih presisi */
            max-width: 900px;
            /* Perbesar max-width */
            margin: 0 auto 2rem;
            justify-items: center;
        }

        .seat {
            width: 24px;
            /* Lebih kecil lagi dari 32px ke 24px */
            height: 24px;
            /* Lebih kecil lagi dari 32px ke 24px */
            border-radius: 4px;
            /* Border radius minimal */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            /* Font size minimal 8px */
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            /* Border minimal 1px */
            position: relative;
            overflow: hidden;
        }

        .seat-preview {
            margin-bottom: 1.5rem;
            text-align: center;
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .seat-layout-image {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .seat-layout-image:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            .seat-preview {
                margin-bottom: 1rem;
                padding: 0.75rem;
            }
        }

        .seat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.2) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .seat:hover::before {
            transform: translateX(100%);
        }

        .seat.available {
            background: var(--gray-200);
            color: var(--gray-700);
            border-color: var(--gray-300);
        }

        .seat.available:hover {
            background: var(--primary);
            color: var(--white);
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(212, 165, 116, 0.4);
        }

        .seat.selected {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary-dark);
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(212, 165, 116, 0.5);
        }

        .seat.booked {
            background: var(--danger);
            color: var(--white);
            cursor: not-allowed;
            opacity: 0.7;
        }

        .seat-legend {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 13px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            background: var(--gray-50);
            border-radius: 8px;
        }

        .legend-color {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            margin-right: 0.75rem;
            border: 2px solid var(--gray-300);
        }

        /* Selected Seat Info */
        .selected-seat-info {
            background: linear-gradient(135deg, rgba(212, 165, 116, 0.1) 0%, rgba(212, 165, 116, 0.05) 100%);
            border: 2px solid rgba(212, 165, 116, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            margin-top: 2rem;
        }

        .selected-seat-info i {
            color: var(--primary);
            font-size: 1.25rem;
            margin-right: 0.5rem;
        }

        /* Navigation Buttons */
        .step-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid var(--gray-100);
        }

        /* Toast Notifications */
        .custom-toast {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            color: white;
            font-size: 14px;
            font-weight: 600;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.4s ease;
            max-width: 400px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        .custom-toast-success {
            background: linear-gradient(135deg, var(--success) 0%, #1e7e34 100%);
        }

        .custom-toast-error {
            background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--dark) 0%, #1a1a1a 100%);
            color: var(--gray-600);
            padding: 3rem 0;
            margin-top: 4rem;
            border-top: 4px solid var(--primary);
        }

        .footer h6 {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .custom-toast-warning {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #212529;
        }

        /* Update button disabled state */
        .btn:disabled {
            cursor: not-allowed !important;
            transition: all 0.3s ease;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .step-item {
                margin: 0 1rem;
            }

            .step-number {
                width: 50px;
                height: 50px;
                font-size: 1.1rem;
            }

            .seat-grid {
                grid-template-columns: repeat(8, 1fr);
                gap: 0.5rem;
            }

            .seat {
                width: 35px;
                height: 35px;
                font-size: 10px;
            }

            .step-navigation {
                flex-direction: column;
                gap: 1rem;
            }

            .custom-toast {
                left: 20px;
                right: 20px;
                max-width: none;
            }
        }

        @media (max-width: 768px) {
            .seat-grid {
                grid-template-columns: repeat(12, 1fr);
                /* 12 kolom untuk mobile */
                gap: 0.1rem;
                /* Gap minimal untuk mobile */
                max-width: 100%;
            }

            .seat {
                width: 20px;
                height: 20px;
                font-size: 7px;
            }
        }

        /* Untuk tablet */
        @media (max-width: 992px) and (min-width: 769px) {
            .seat-grid {
                grid-template-columns: repeat(13, 1fr);
                /* 13 kolom untuk tablet */
                gap: 0.12rem;
            }

            .seat {
                width: 22px;
                height: 22px;
                font-size: 7px;
            }
        }

        /* Legend items juga diperkecil */
        .legend-color {
            width: 20px;
            /* Kurangi dari 24px */
            height: 20px;
            /* Kurangi dari 24px */
            border-radius: 4px;
            /* Kurangi border radius */
            margin-right: 0.5rem;
            /* Kurangi margin */
            border: 2px solid var(--gray-300);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="#" class="navbar-brand">
                <img src="{{ asset('assets/media/logos/logo.png') }}" alt="Ticketify" />
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container" style="margin-top: 100px;">
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

        <div class="order-layout">
            <!-- Main Form -->
            <div class="order-form">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            <i class="fas fa-shopping-cart"></i>
                            Form Pemesanan Tiket
                        </h3>

                        <form id="orderForm" method="POST" action="{{ route('order.store') }}" novalidate>
                            @csrf
                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}" />
                            <input type="hidden" name="selected_seats" id="selected_seats" />

                            <!-- Step Progress Bar -->
                            <div class="step-progress">
                                <div class="step-item active" id="step1">
                                    <div class="step-number">1</div>
                                    <div class="step-text">Data Diri</div>
                                </div>
                                <div class="step-item" id="step2">
                                    <div class="step-number">2</div>
                                    <div class="step-text">Pilih Kursi</div>
                                </div>
                            </div>

                            <!-- Step Content Wrapper -->
                            <div style="position: relative; min-height: 500px;">
                                <!-- Step 1: Data Diri -->
                                <div class="step-content active" id="step1-content">
                                    <div class="form-group">
                                        <label for="nama_lengkap" class="form-label">
                                            Nama Lengkap <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                            required value="{{ old('nama_lengkap') }}"
                                            placeholder="Masukkan nama lengkap" />
                                        <div class="invalid-feedback">Nama lengkap minimal 3 karakter</div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            Email <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            required value="{{ old('email') }}" placeholder="contoh@email.com" />
                                        <div class="invalid-feedback">Email harus valid</div>
                                    </div>

                                    <div class="form-group">
                                        <label for="no_handphone" class="form-label">
                                            No. WhatsApp <span class="text-danger">*</span>
                                        </label>
                                        <input type="tel" class="form-control" id="no_handphone" name="no_handphone"
                                            required value="{{ old('no_handphone') }}" placeholder="08123456789"
                                            pattern="^08\d{8,12}$" />
                                        <div class="invalid-feedback">Nomor HP harus valid (08xxxxxxxxx)</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity" class="form-label">
                                            Jumlah Tiket <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-outline-secondary" id="decreaseQty">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control text-center" id="quantity"
                                                name="quantity" value="1" min="1" readonly
                                                style="background: white;" />
                                            <button type="button" class="btn btn-outline-secondary"
                                                id="increaseQty">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted">Stok tersedia: <span
                                                id="stockInfo">{{ $availableSeatsCount }}</span> tiket</small>
                                        <div class="invalid-feedback">Jumlah tiket melebihi stok yang tersedia</div>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="alamat_lengkap" class="form-label">
                                            Alamat Domisili <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="alamat_lengkap"
                                            name="alamat_lengkap" required value="{{ old('alamat_lengkap') }}"
                                            placeholder="Masukkan alamat lengkap" />
                                        <div class="invalid-feedback">Alamat minimal 5 karakter</div>
                                    </div> --}}

                                    {{-- <div class="form-group">
                                        <label for="identitas_number" class="form-label">
                                            Nomor Identitas (KTP/NIK/SIM) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="identitas_number"
                                            name="identitas_number" required value="{{ old('identitas_number') }}"
                                            placeholder="0000000000000000" pattern="^\d{12,20}$" />
                                        <div class="invalid-feedback">Nomor identitas harus 12-20 digit angka</div>
                                    </div> --}}

                                    {{-- <div class="form-group">
                                        <label for="mewakili" class="form-label">
                                            Mewakili <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="mewakili" name="mewakili"
                                            required value="{{ old('mewakili') }}"
                                            placeholder="Nama organisasi/perusahaan" />
                                        <div class="invalid-feedback">Mewakili minimal 3 karakter</div>
                                    </div> --}}

                                    <div class="step-navigation">
                                        <div></div>
                                        <button type="button" class="btn btn-primary" id="nextToStep2">
                                            <i class="fas fa-arrow-right"></i> Lanjut ke Pilih Kursi
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 2: Pilih Kursi -->
                                <div class="step-content" id="step2-content">
                                    <div class="seat-map">
                                        <h5>
                                            <i class="fas fa-couch me-2"></i>Pilih Kursi Anda
                                        </h5>

                                        <!-- Preview Image Section -->
                                        <div class="seat-preview">
                                            <img src="{{ asset('assets/img/seat.png') }}" alt="Layout Kursi"
                                                class="seat-layout-image" data-bs-toggle="modal"
                                                data-bs-target="#seatPreviewModal">
                                            <small class="text-muted d-block mt-1">Klik untuk melihat gambar lebih
                                                besar</small>
                                        </div>

                                        <div class="stage-indicator">
                                            <div class="stage">
                                                <i class="fas fa-tv me-2"></i>PANGGUNG
                                            </div>
                                        </div>

                                        <div class="seat-grid" id="seatGrid">
                                            @foreach ($allSeats as $seat)
                                                @if ($seat->is_booked == 0)
                                                    <div class="seat available" data-seat="{{ $seat->seat_number }}">
                                                        {{ $seat->seat_number }}
                                                    </div>
                                                @else
                                                    <div class="seat booked">{{ $seat->seat_number }}</div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="seat-legend">
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: var(--gray-200);">
                                                </div>
                                                <span>Tersedia</span>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: var(--primary);">
                                                </div>
                                                <span>Dipilih</span>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: var(--danger);">
                                                </div>
                                                <span>Sudah Dipesan</span>
                                            </div>
                                        </div>

                                        <div id="selectedSeatInfo" class="selected-seat-info" style="display: none;">
                                            <i class="fas fa-chair"></i>
                                            <div>Kursi yang dipilih (<span id="selectedCount">0</span>/<span
                                                    id="requiredCount">1</span>):</div>
                                            <div id="selectedSeatsList" class="mt-2"></div>
                                        </div>
                                    </div>

                                    <div class="step-navigation">
                                        <button type="button" class="btn btn-secondary" id="backToStep1">
                                            <i class="fas fa-arrow-left"></i> Kembali ke Data Diri
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="submitOrder" disabled>
                                            <i class="fas fa-credit-card"></i> Lanjut ke Pembayaran
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="event-sidebar">
                <!-- Event Info -->
                <div class="event-info">
                    <img src="{{ $product->avatar ? Storage::url($product->avatar) : 'https://via.placeholder.com/400x200?text=No+Image' }}"
                        alt="Event" />
                    <h5>{{ $product->product_name }}</h5>
                    <div class="event-detail">
                        <i class="fas fa-calendar"></i>
                        <span>{{ \Carbon\Carbon::parse($product->event_date)->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="event-detail">
                        <i class="fas fa-clock"></i>
                        <span>{{ \Carbon\Carbon::parse($product->event_time)->format('H:i') }} WIB</span>
                    </div>
                    <div class="event-detail">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $product->location }}</span>
                    </div>
                    <div class="event-detail">
                        <i class="fas fa-ticket-alt"></i>
                        <span>{{ $ticket->name }}</span>
                    </div>
                </div>

                <div class="order-summary">
                    <h6>
                        <i class="fas fa-receipt"></i>
                        Ringkasan Pesanan
                    </h6>
                    <div class="summary-item">
                        <span>Tiket {{ $ticket->name }}</span>
                        <span>Rp {{ number_format($ticket->price, 0, ',', '.') }} x <span
                                id="ticketQtyDisplay">1</span></span>
                    </div>
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span id="subtotalDisplay">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Kode Pembayaran</span>
                        <span id="paymentCodeDisplay">Akan digenerate</span>
                    </div>
                    <div class="summary-item">
                        <span><strong>Total</strong></span>
                        <span><strong id="totalDisplay">Rp
                                {{ number_format($ticket->price, 0, ',', '.') }}</strong></span>
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
    <!-- Modal untuk preview gambar besar -->
    <div class="modal fade" id="seatPreviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Layout Kursi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('assets/img/seat.png') }}" alt="Layout Kursi" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            let selectedSeats = [];
            let requiredQuantity = 1;
            let availableStock = {{ $availableSeatsCount }};
            const ticketPrice = {{ $ticket->price }};

            // Form elements
            const form = document.getElementById('orderForm');
            const nextBtn = document.getElementById('nextToStep2');
            const backBtn = document.getElementById('backToStep1');
            const submitBtn = document.getElementById('submitOrder');
            const quantityInput = document.getElementById('quantity');
            const decreaseBtn = document.getElementById('decreaseQty');
            const increaseBtn = document.getElementById('increaseQty');
            const stockInfo = document.getElementById('stockInfo');

            // Function to check current available stock
            function checkCurrentStock() {
                const availableSeats = document.querySelectorAll('.seat.available').length;
                availableStock = availableSeats;
                stockInfo.textContent = availableStock;
                return availableStock;
            }

            // Function untuk show modal ketika mencapai limit
            function showStockLimitModal(stockLimit) {
                // Remove existing modal jika ada
                const existingModal = document.getElementById('stockLimitModal');
                if (existingModal) {
                    existingModal.remove();
                }

                // Create modal HTML
                const modalHTML = `
            <div class="modal fade" id="stockLimitModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Stok Terbatas!
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-ticket-alt text-warning" style="font-size: 3rem;"></i>
                            </div>
                            <h6 class="mb-3">Anda telah mencapai batas maksimal pemesanan</h6>
                            <p class="mb-2">Stok tiket yang tersedia saat ini: <strong>${stockLimit} tiket</strong></p>
                            <p class="text-muted mb-0">Silakan lanjutkan dengan jumlah tiket yang sudah dipilih atau hubungi customer service untuk informasi lebih lanjut.</p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                <i class="fas fa-check me-2"></i>Mengerti
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

                // Append modal ke body
                document.body.insertAdjacentHTML('beforeend', modalHTML);

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('stockLimitModal'));
                modal.show();

                // Remove modal dari DOM setelah ditutup
                document.getElementById('stockLimitModal').addEventListener('hidden.bs.modal', function() {
                    this.remove();
                });
            }

            // Toast function
            function showToast(message, type = 'info') {
                // Remove existing toast
                const existingToast = document.querySelector('.custom-toast');
                if (existingToast) {
                    existingToast.remove();
                }

                // Create toast
                const toast = document.createElement('div');
                let bgClass = 'custom-toast-info';
                let icon = 'fa-info-circle';

                switch (type) {
                    case 'error':
                        bgClass = 'custom-toast-error';
                        icon = 'fa-exclamation-circle';
                        break;
                    case 'success':
                        bgClass = 'custom-toast-success';
                        icon = 'fa-check-circle';
                        break;
                    case 'warning':
                        bgClass = 'custom-toast-warning';
                        icon = 'fa-exclamation-triangle';
                        break;
                }

                toast.className = `custom-toast ${bgClass}`;
                toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas ${icon} me-2"></i>
                <span>${message}</span>
            </div>
        `;

                document.body.appendChild(toast);

                // Show toast
                setTimeout(() => {
                    toast.style.opacity = '1';
                    toast.style.transform = 'translateX(0)';
                }, 100);

                // Hide toast
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 400);
                }, 4000);
            }

            // Quantity controls - HANYA SATU DEFINISI
            decreaseBtn.addEventListener('click', function() {
                if (requiredQuantity > 1) {
                    requiredQuantity--;
                    quantityInput.value = requiredQuantity;
                    updateQuantityDisplay();
                    clearExcessSeats();
                    validateQuantityStock();

                    // Re-enable increase button jika tidak di limit
                    const currentStock = checkCurrentStock();
                    if (requiredQuantity < currentStock) {
                        increaseBtn.disabled = false;
                        increaseBtn.style.opacity = '1';
                    }
                }
            });

            increaseBtn.addEventListener('click', function() {
                const currentStock = checkCurrentStock();

                // Cek jika sudah mencapai batas maksimal
                if (requiredQuantity >= currentStock) {
                    // Disable button increase
                    increaseBtn.disabled = true;
                    increaseBtn.style.opacity = '0.5';

                    // Show pop-up message
                    showStockLimitModal(currentStock);
                    return;
                }

                requiredQuantity++;
                quantityInput.value = requiredQuantity;
                updateQuantityDisplay();
                validateQuantityStock();

                // Cek jika setelah increment sudah mencapai limit
                if (requiredQuantity >= currentStock) {
                    increaseBtn.disabled = true;
                    increaseBtn.style.opacity = '0.5';
                    showToast(`Maksimal ${currentStock} tiket dapat dipesan (stok terbatas)`, 'warning');
                }
            });

            // Clear excess seats function
            function clearExcessSeats() {
                if (selectedSeats.length > requiredQuantity) {
                    const excessSeats = selectedSeats.slice(requiredQuantity);
                    excessSeats.forEach(seatNumber => {
                        const seatElement = document.querySelector(`.seat[data-seat="${seatNumber}"]`);
                        if (seatElement) {
                            seatElement.classList.remove('selected');
                            seatElement.classList.add('available');
                        }
                    });
                    selectedSeats = selectedSeats.slice(0, requiredQuantity);
                    updateSeatSelectionUI();
                }
            }

            // Seat selection
            document.querySelectorAll('.seat.available').forEach(seat => {
                seat.addEventListener('click', function() {
                    const seatNumber = this.dataset.seat;
                    toggleSeat(seatNumber, this);
                });
            });

            function toggleSeat(seatNumber, seatElement) {
                const seatIndex = selectedSeats.indexOf(seatNumber);

                if (seatIndex > -1) {
                    // Remove seat
                    selectedSeats.splice(seatIndex, 1);
                    seatElement.classList.remove('selected');
                    seatElement.classList.add('available');
                } else {
                    // Add seat
                    if (selectedSeats.length < requiredQuantity) {
                        selectedSeats.push(seatNumber);
                        seatElement.classList.remove('available');
                        seatElement.classList.add('selected');
                    } else {
                        showToast(`Maksimal ${requiredQuantity} kursi yang dapat dipilih!`, 'error');
                        return;
                    }
                }

                updateSeatSelectionUI();
                validateSeatSelection();
            }

            function updateSeatSelectionUI() {
                const selectedCount = selectedSeats.length;
                document.getElementById('selectedCount').textContent = selectedCount;

                if (selectedCount > 0) {
                    document.getElementById('selectedSeatInfo').style.display = 'block';
                    document.getElementById('selectedSeatsList').innerHTML =
                        selectedSeats.sort((a, b) => parseInt(a) - parseInt(b))
                        .map(seat => `<span class="badge bg-primary me-1 mb-1">${seat}</span>`).join('');
                } else {
                    document.getElementById('selectedSeatInfo').style.display = 'none';
                }
            }

            function validateSeatSelection() {
                const isComplete = selectedSeats.length === requiredQuantity;
                submitBtn.disabled = !isComplete;

                if (isComplete) {
                    submitBtn.classList.remove('btn-secondary');
                    submitBtn.classList.add('btn-primary');
                } else {
                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.add('btn-secondary');
                }
            }

            // Validasi quantity terhadap stok
            function validateQuantityStock() {
                const quantityField = document.getElementById('quantity');
                const currentStock = checkCurrentStock();

                if (requiredQuantity > currentStock) {
                    quantityField.classList.add('is-invalid');
                    quantityField.classList.remove('is-valid');

                    // Reset ke stok maksimal yang tersedia
                    requiredQuantity = Math.max(1, currentStock);
                    quantityInput.value = requiredQuantity;
                    updateQuantityDisplay();

                    showToast(`Jumlah tiket melebihi stok! Maksimal ${currentStock} tiket tersedia`, 'error');
                    return false;
                } else {
                    quantityField.classList.remove('is-invalid');
                    if (requiredQuantity > 0) {
                        quantityField.classList.add('is-valid');
                    }
                    return true;
                }
            }

            function updateQuantityDisplay() {
                document.getElementById('requiredCount').textContent = requiredQuantity;
                document.getElementById('ticketQtyDisplay').textContent = requiredQuantity;

                const subtotal = ticketPrice * requiredQuantity;
                document.getElementById('subtotalDisplay').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;

                // Update stock info
                const currentStock = checkCurrentStock();

                // Handle button states
                if (requiredQuantity >= currentStock) {
                    increaseBtn.disabled = true;
                    increaseBtn.style.opacity = '0.5';
                } else {
                    increaseBtn.disabled = false;
                    increaseBtn.style.opacity = '1';
                }

                if (requiredQuantity <= 1) {
                    decreaseBtn.disabled = true;
                    decreaseBtn.style.opacity = '0.5';
                } else {
                    decreaseBtn.disabled = false;
                    decreaseBtn.style.opacity = '1';
                }

                updateSeatSelectionUI();
                validateSeatSelection();
            }

            // Step navigation
            nextBtn.addEventListener('click', function() {
                if (validateStep1()) {
                    showStep(2);
                }
            });

            backBtn.addEventListener('click', function() {
                showStep(1);
            });

            function showStep(step) {
                // Hide all content
                document.querySelectorAll('.step-content').forEach(content => {
                    content.classList.remove('active');
                });

                // Reset step items
                document.querySelectorAll('.step-item').forEach(item => {
                    item.classList.remove('active', 'completed');
                });

                // Remove progress line classes
                const progressBar = document.querySelector('.step-progress');
                progressBar.classList.remove('step-1-completed');

                // Show current step
                setTimeout(() => {
                    document.getElementById(`step${step}-content`).classList.add('active');
                }, 100);

                document.getElementById(`step${step}`).classList.add('active');

                // Mark completed steps
                for (let i = 1; i < step; i++) {
                    document.getElementById(`step${i}`).classList.add('completed');
                    if (i === 1 && step === 2) {
                        progressBar.classList.add('step-1-completed');
                    }
                }

                currentStep = step;

                // Smooth scroll to top
                document.querySelector('.card-title').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }

            function validateStep1() {
                let isValid = true;
                const fields = [{
                        id: 'nama_lengkap',
                        minLength: 3,
                        message: 'Nama lengkap minimal 3 karakter'
                    },
                    {
                        id: 'email',
                        pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                        message: 'Email harus valid'
                    },
                    {
                        id: 'no_handphone',
                        pattern: /^08\d{8,12}$/,
                        message: 'Nomor HP harus valid (08xxxxxxxxx)'
                    },
                ];

                fields.forEach(field => {
                    const element = document.getElementById(field.id);
                    const value = element.value.trim();
                    let fieldValid = true;

                    if (!value) {
                        fieldValid = false;
                    } else if (field.minLength && value.length < field.minLength) {
                        fieldValid = false;
                    } else if (field.pattern && !field.pattern.test(value)) {
                        fieldValid = false;
                    }

                    if (fieldValid) {
                        element.classList.remove('is-invalid');
                        element.classList.add('is-valid');
                    } else {
                        element.classList.remove('is-valid');
                        element.classList.add('is-invalid');
                        isValid = false;
                    }
                });

                // Validasi quantity stock sebelum lanjut ke step 2
                if (!validateQuantityStock()) {
                    isValid = false;
                }

                if (!isValid) {
                    const firstInvalid = document.querySelector('.form-control.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstInvalid.focus();
                    }
                    showToast('Mohon lengkapi semua data dengan benar!', 'error');
                }

                return isValid;
            }

            // Real-time validation
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('blur', () => validateField(input));
                input.addEventListener('input', () => {
                    if (input.classList.contains('is-invalid')) {
                        input.classList.remove('is-invalid');
                    }
                });
            });

            function validateField(element) {
                const value = element.value.trim();
                let isValid = true;

                switch (element.id) {
                    case 'nama_lengkap':
                        isValid = value.length >= 3;
                        break;
                    case 'email':
                        isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
                        break;
                    case 'no_handphone':
                        isValid = /^08\d{8,12}$/.test(value);
                        break;
                }

                if (value && isValid) {
                    element.classList.remove('is-invalid');
                    element.classList.add('is-valid');
                } else if (value) {
                    element.classList.remove('is-valid');
                    element.classList.add('is-invalid');
                } else {
                    element.classList.remove('is-valid', 'is-invalid');
                }
            }

            // Form submission dengan validasi final
            form.addEventListener('submit', function(e) {
                const currentStock = checkCurrentStock();

                if (requiredQuantity > currentStock) {
                    e.preventDefault();
                    showToast(`Stok tidak mencukupi! Stok tersedia: ${currentStock} tiket`, 'error');
                    return false;
                }

                if (selectedSeats.length !== requiredQuantity) {
                    e.preventDefault();
                    showToast(`Silakan pilih ${requiredQuantity} kursi sesuai jumlah tiket!`, 'error');
                    return false;
                }

                // Set selected seats as JSON string
                document.getElementById('selected_seats').value = JSON.stringify(selectedSeats);

                // Set loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                submitBtn.disabled = true;
            });

            // Initialize
            updateQuantityDisplay();
            validateQuantityStock();
        });
    </script>
</body>

</html>
