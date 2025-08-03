<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pembayaran Manual - Event Management</title>
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
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
            --dark: #2C2C2C;
            --white: #ffffff;
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
            background-color: var(--gray-100);
            color: var(--gray-700);
            font-size: 14px;
            line-height: 1.5;
        }

        /* Navbar */
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

        /* Cards */
        .card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: 1.5rem;
            border-bottom: none;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .card-header h4 i {
            margin-right: 0.75rem;
        }

        .card-body {
            padding: 2rem;
        }

        /* Status Badge */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-waiting {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        /* Bank Account Cards */
        .bank-card {
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .bank-card:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 15px rgba(212, 165, 116, 0.15);
        }

        .bank-logo {
            width: 60px;
            height: 40px;
            object-fit: contain;
            background: var(--gray-100);
            border-radius: 8px;
            padding: 5px;
        }

        .bank-info h6 {
            color: var(--dark);
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .account-number {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            font-family: 'Courier New', monospace;
        }

        .copy-btn {
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .copy-btn:hover {
            background: var(--primary-dark);
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed var(--gray-300);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            background: var(--gray-100);
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: var(--primary);
            background: rgba(212, 165, 116, 0.05);
        }

        .upload-area.dragover {
            border-color: var(--primary);
            background: rgba(212, 165, 116, 0.1);
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--gray-600);
            margin-bottom: 1rem;
        }

        /* Order Summary */
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .order-item:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary);
        }

        /* Payment Code Highlight */
        .payment-code-highlight {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 2px solid #ffc107;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            text-align: center;
        }

        .payment-code-highlight h5 {
            color: #856404;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .payment-code-number {
            font-size: 2rem;
            font-weight: 900;
            color: #856404;
            letter-spacing: 2px;
            font-family: 'Courier New', monospace;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            color: var(--white);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 165, 116, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #A67C52 100%);
            transform: translateY(-2px);
            color: var(--white);
            box-shadow: 0 6px 25px rgba(212, 165, 116, 0.4);
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            color: #0c5460;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
        }

        /* Timeline */
        .payment-timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2rem;
            top: 0.5rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--gray-300);
        }

        .timeline-item.active::before {
            background: var(--primary);
        }

        .timeline-item.completed::before {
            background: var(--success);
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            left: -1.7rem;
            top: 1.2rem;
            width: 2px;
            height: calc(100% - 0.7rem);
            background: var(--gray-300);
        }

        .timeline-item:last-child::after {
            display: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            .bank-card {
                padding: 1rem;
            }

            .upload-area {
                padding: 1.5rem;
            }

            .payment-code-number {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="#" class="navbar-brand">
                <img src="{{ asset('assets/media/logos/logo.png') }}" alt="Logo" height="50" />
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container" style="margin-top: 100px; padding-bottom: 3rem;">
        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
            </div>
        @endif

        <div class="row">
            <!-- Payment Instructions -->
            <div class="col-lg-8">
                <!-- Order Status -->
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-receipt"></i>Status Pesanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-1">Order ID: {{ $buyer->external_id }}</h6>
                                <small class="text-muted">{{ $buyer->created_at->format('d M Y, H:i') }}</small>
                            </div>
                            <span
                                class="status-badge 
                                @if ($buyer->payment_status === 'pending') status-pending
                                @elseif($buyer->payment_status === 'waiting_confirmation') status-waiting
                                @elseif($buyer->payment_status === 'confirmed') status-confirmed @endif">
                                @if ($buyer->payment_status === 'pending')
                                    Menunggu Pembayaran
                                @elseif($buyer->payment_status === 'waiting_confirmation')
                                    Menunggu Konfirmasi
                                @elseif($buyer->payment_status === 'confirmed')
                                    Terkonfirmasi
                                @endif
                            </span>
                        </div>

                        <!-- Payment Timeline -->
                        <div class="payment-timeline">
                            <div
                                class="timeline-item {{ $buyer->payment_status === 'pending' ? 'active' : 'completed' }}">
                                <h6>Pesanan Dibuat</h6>
                                <small class="text-muted">{{ $buyer->created_at->format('d M Y, H:i') }}</small>
                            </div>
                            <div
                                class="timeline-item {{ $buyer->payment_status === 'waiting_confirmation' ? 'active' : ($buyer->payment_status === 'confirmed' ? 'completed' : '') }}">
                                <h6>Upload Bukti Pembayaran</h6>
                                @if ($buyer->payment_proof)
                                    <small class="text-muted">{{ $buyer->updated_at->format('d M Y, H:i') }}</small>
                                @else
                                    <small class="text-muted">Belum diupload</small>
                                @endif
                            </div>
                            <div
                                class="timeline-item {{ $buyer->payment_status === 'confirmed' ? 'active completed' : '' }}">
                                <h6>Pembayaran Dikonfirmasi</h6>
                                @if ($buyer->payment_status === 'confirmed')
                                    <small
                                        class="text-muted">{{ $buyer->payment_confirmed_at ? $buyer->payment_confirmed_at->format('d M Y, H:i') : 'Sudah dikonfirmasi' }}</small>
                                @else
                                    <small class="text-muted">Menunggu konfirmasi admin</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if ($buyer->payment_status === 'pending' || $buyer->payment_status === 'waiting_confirmation')

                    <!-- Bank Account Information -->
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-university"></i>Informasi Rekening</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Penting!</strong> Transfer tepat sesuai dengan total yang tertera <strong>(Rp
                                    {{ number_format($buyer->total_amount, 0, ',', '.') }})</strong> dan simpan bukti
                                transfer untuk diupload.
                            </div>

                            <!-- Bank BCA -->
                            <div class="bank-card">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="bank-logo d-flex align-items-center justify-content-center">
                                            <strong style="color: #003d7a;">BCA</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="bank-info">
                                            <h6>Bank BCA</h6>
                                            <div class="account-number">8915260973</div>
                                            <small class="text-muted">a.n. Bagaskara Bayu Adhi</small>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <button class="copy-btn" onclick="copyToClipboard('8915260973')">
                                            <i class="fas fa-copy"></i> Copy
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Payment Proof -->
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-upload"></i>Upload Bukti Pembayaran</h4>
                        </div>
                        <div class="card-body">
                            @if (
                                $buyer->payment_proof &&
                                    ($buyer->payment_status === 'waiting_confirmation' || $buyer->payment_status === 'confirmed'))
                                <div class="alert alert-info">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Bukti pembayaran sudah diupload dan sedang menunggu verifikasi admin. Proses
                                    verifikasi maksimal 1x24 jam kerja.
                                </div>
                                <div class="text-center mb-3">
                                    <img src="{{ asset('storage/' . $buyer->payment_proof) }}" alt="Bukti Pembayaran"
                                        class="img-fluid" style="max-height: 300px; border-radius: 8px;">
                                </div>
                            @else
                                <form action="{{ route('payment.upload', $buyer->external_id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="payment_proof" class="form-label">Bukti Pembayaran <span
                                                class="text-danger">*</span></label>
                                        <div class="upload-area" id="uploadArea">
                                            <div class="upload-icon">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <h6>Pilih atau Drop File Disini</h6>
                                            <p class="text-muted mb-3">Format: JPG, PNG, JPEG (Max: 2MB)</p>
                                            <input type="file" class="form-control" id="payment_proof"
                                                name="payment_proof" accept="image/jpeg,image/png,image/jpg"
                                                style="display: none;" required>
                                            <button type="button" class="btn btn-primary"
                                                onclick="document.getElementById('payment_proof').click()">
                                                <i class="fas fa-folder-open me-2"></i>Pilih File
                                            </button>
                                        </div>
                                        @error('payment_proof')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div id="preview-container" class="mb-3" style="display: none;">
                                        <img id="preview-image" src="" alt="Preview" class="img-fluid"
                                            style="max-height: 200px; border-radius: 8px;">
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg w-100" id="upload-btn"
                                        disabled>
                                        <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card position-sticky" style="top: 100px;">
                    <div class="card-header">
                        <h4><i class="fas fa-shopping-cart"></i>Ringkasan Pesanan</h4>
                    </div>
                    <div class="card-body">
                        <!-- Event Info -->
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Event</h6>
                            <h5 class="mb-1">{{ $product->product_name }}</h5>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($product->event_date)->format('d M Y') }}
                            </small>
                        </div>

                        <hr>

                        <!-- Customer Info -->
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Pembeli</h6>
                            <p class="mb-1"><strong>{{ $buyer->nama_lengkap }}</strong></p>
                            <small class="text-muted">{{ $buyer->email }}</small><br>
                            <small class="text-muted">{{ $buyer->no_handphone }}</small>
                        </div>

                        <hr>

                        <!-- Order Details -->
                        <div class="order-item">
                            <span>{{ $ticket->name }}</span>
                            <span>{{ $buyer->quantity }}x</span>
                        </div>
                        <div class="order-item">
                            <span>Harga Tiket</span>
                            <span>Rp {{ number_format($buyer->ticket_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="order-item">
                            <span>Biaya Admin (5%)</span>
                            <span>Rp {{ number_format($buyer->admin_fee, 0, ',', '.') }}</span>
                        </div>
                        <div class="order-item">
                            <span>Kode Unik</span>
                            <span>Rp {{ number_format($buyer->payment_code, 0, ',', '.') }}</span>
                        </div>
                        <div class="order-item">
                            <span><strong>Total Pembayaran</strong></span>
                            <span><strong>Rp {{ number_format($buyer->total_amount, 0, ',', '.') }}</strong></span>
                        </div>

                        @if ($buyer->payment_status === 'confirmed')
                            <div class="mt-3">
                                <div class="alert alert-success text-center">
                                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                                    <h6>Pembayaran Berhasil!</h6>
                                    <small>Tiket Anda sudah aktif</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'toast show position-fixed top-0 end-0 m-3';
                toast.style.zIndex = '9999';
                toast.innerHTML = `
                    <div class="toast-header">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong class="me-auto">Berhasil</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        Nomor rekening berhasil disalin!
                    </div>
                `;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
            });
        }

        // File upload handling
        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('payment_proof');
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            const uploadBtn = document.getElementById('upload-btn');

            // Handle file selection
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        handleFilePreview(file);
                    } else {
                        resetPreview();
                    }
                });
            }

            // Handle drag and drop
            if (uploadArea) {
                uploadArea.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    uploadArea.classList.add('dragover');
                });

                uploadArea.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    uploadArea.classList.remove('dragover');
                });

                uploadArea.addEventListener('drop', function(e) {
                    e.preventDefault();
                    uploadArea.classList.remove('dragover');

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        const file = files[0];
                        if (file.type.startsWith('image/')) {
                            fileInput.files = files;
                            handleFilePreview(file);
                        } else {
                            alert('Hanya file gambar yang diperbolehkan!');
                        }
                    }
                });
            }

            function handleFilePreview(file) {
                // Validate file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB.');
                    resetFileInput();
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung! Gunakan JPG, PNG, atau JPEG.');
                    resetFileInput();
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImage && previewContainer) {
                        previewImage.src = e.target.result;
                        previewContainer.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);

                // Update upload area
                if (uploadArea) {
                    const titleElement = uploadArea.querySelector('h6');
                    const sizeElement = uploadArea.querySelector('p');
                    if (titleElement) titleElement.textContent = file.name;
                    if (sizeElement) sizeElement.textContent = `Ukuran: ${(file.size / 1024 / 1024).toFixed(2)} MB`;
                }

                // Enable upload button
                if (uploadBtn) {
                    uploadBtn.disabled = false;
                }
            }

            function resetFileInput() {
                if (fileInput) {
                    fileInput.value = '';
                }
                resetPreview();
            }

            function resetPreview() {
                if (previewContainer) {
                    previewContainer.style.display = 'none';
                }
                if (previewImage) {
                    previewImage.src = '';
                }

                // Reset upload area text
                if (uploadArea) {
                    const titleElement = uploadArea.querySelector('h6');
                    const sizeElement = uploadArea.querySelector('p');
                    if (titleElement) titleElement.textContent = 'Pilih atau Drop File Disini';
                    if (sizeElement) sizeElement.textContent = 'Format: JPG, PNG, JPEG (Max: 2MB)';
                }

                // Disable upload button
                if (uploadBtn) {
                    uploadBtn.disabled = true;
                }
            }
        });
    </script>
</body>

</html>
