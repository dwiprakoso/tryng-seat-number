@extends('admin.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Konfirmasi Pembayaran
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.buyer.index') }}" class="text-muted text-hover-primary">Data Pembeli</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Konfirmasi Pembayaran</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('admin.buyer.index') }}" class="btn btn-light">
                        <i class="ki-duotone ki-arrow-left fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Kembali ke Data Pembeli
                    </a>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">

            <!--begin::Alert Messages-->
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                    <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-success">Berhasil</h4>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                    <i class="ki-duotone ki-information-5 fs-2hx text-danger me-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-danger">Error</h4>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif
            <!--end::Alert Messages-->

            <div class="row">
                <div class="col-lg-8">
                    <!--begin::Order Details-->
                    <div class="card card-flush mb-7">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="fw-bold m-0">Detail Pesanan</h3>
                            </div>
                            <div class="card-toolbar">
                                @php
                                    $statusColors = [
                                        'confirmed' => 'success',
                                        'pending' => 'warning',
                                        'waiting_confirmation' => 'info',
                                        'rejected' => 'danger',
                                        'failed' => 'danger',
                                    ];
                                    $color = $statusColors[$buyer->payment_status] ?? 'secondary';
                                @endphp
                                <div class="badge badge-light-{{ $color }} fw-bold">
                                    {{ ucfirst(str_replace('_', ' ', $buyer->payment_status)) }}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <div class="fw-semibold text-gray-600 mb-2">ID Pesanan:</div>
                                    <div class="fw-bold text-gray-800 fs-6">{{ $buyer->external_id }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fw-semibold text-gray-600 mb-2">Tanggal Pesanan:</div>
                                    <div class="fw-bold text-gray-800 fs-6">{{ $buyer->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <div class="fw-semibold text-gray-600 mb-2">Nama Pembeli:</div>
                                    <div class="fw-bold text-gray-800 fs-6">{{ $buyer->nama_lengkap }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fw-semibold text-gray-600 mb-2">Email:</div>
                                    <div class="fw-bold text-gray-800 fs-6">{{ $buyer->email }}</div>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <div class="fw-semibold text-gray-600 mb-2">No. Handphone:</div>
                                    <div class="fw-bold text-gray-800 fs-6">{{ $buyer->no_handphone }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fw-semibold text-gray-600 mb-2">Kategori Tiket:</div>
                                    <div class="fw-bold text-gray-800 fs-6">{{ $buyer->ticket->name }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fw-semibold text-gray-600 mb-2">Jumlah Tiket:</div>
                                    <div class="fw-bold text-gray-800 fs-6">{{ $buyer->quantity }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fw-semibold text-gray-600 mb-2">No Kursi:</div>
                                    <div class="fw-bold text-gray-800 fs-6">
                                        @if ($buyer->seats->count() > 0)
                                            @foreach ($buyer->seats as $seat)
                                                <span class="=text-primary fw-bold me-1">{{ $seat->seat_number }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted"> - </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Order Details-->

                    <!--begin::Payment Details-->
                    <div class="card card-flush mb-7">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="fw-bold m-0">Detail Pembayaran</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                    <tbody>
                                        <tr>
                                            <td class="fw-semibold text-muted">Harga Tiket ({{ $buyer->quantity }} x
                                                {{ number_format($buyer->ticket_price, 0, ',', '.') }} )</td>
                                            <td class="text-end fw-bold">Rp
                                                {{ number_format($buyer->ticket_price * $buyer->quantity, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td class="fw-semibold text-muted">Quantity</td>
                                            <td class="text-end fw-bold">{{ $buyer->quantity }}</td>
                                        </tr> --}}
                                        <tr>
                                            <td class="fw-semibold text-muted">Unique Code</td>
                                            <td class="text-end fw-bold">Rp
                                                {{ number_format($buyer->payment_code, 0, ',', '.') }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <td class="fw-semibold text-muted">Biaya Admin</td>
                                            <td class="text-end fw-bold">Rp
                                                {{ number_format($buyer->admin_fee ?? 0, 0, ',', '.') }}</td>
                                        </tr> --}}
                                        <tr class="border-bottom-0">
                                            <td colspan="2">
                                                <hr class="my-2">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-dark fs-6">Total Pembayaran</td>
                                            <td class="text-end fw-bold">Rp
                                                {{ number_format($buyer->total_amount, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end::Payment Details-->

                    <!--begin::Payment Proof-->
                    <div class="card card-flush mb-7">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="fw-bold m-0">Bukti Pembayaran</h3>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            @if ($buyer->payment_proof)
                                <div class="mb-5">
                                    <img src="{{ asset('storage/' . $buyer->payment_proof) }}" alt="Bukti Pembayaran"
                                        class="img-fluid rounded shadow-sm" style="max-height: 400px;">
                                </div>
                                <div>
                                    <a href="{{ asset('storage/' . $buyer->payment_proof) }}" target="_blank"
                                        class="btn btn-sm btn-light-primary">
                                        <i class="ki-duotone ki-eye fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        Lihat Ukuran Penuh
                                    </a>
                                </div>
                            @else
                                <div class="py-10">
                                    <i class="ki-duotone ki-file-deleted fs-3x text-muted mb-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <p class="text-muted fw-semibold fs-6">Tidak ada bukti pembayaran</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!--end::Payment Proof-->
                </div>

                <div class="col-lg-4">
                    <!--begin::Action Card-->
                    <div class="card card-flush position-sticky" style="top: 100px;">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="fw-bold m-0">Aksi Pembayaran</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($buyer->payment_status === 'waiting_confirmation')
                                <!--begin::Alert-->
                                <div class="alert alert-warning d-flex align-items-center p-5 mb-7">
                                    <i class="ki-duotone ki-shield-search fs-2hx text-warning me-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-warning">Menunggu Konfirmasi</h4>
                                        <span>Pembayaran ini memerlukan konfirmasi manual dari admin.</span>
                                    </div>
                                </div>
                                <!--end::Alert-->

                                <!--begin::Confirm Payment Form-->
                                <form action="{{ route('admin.buyer.confirm-payment', $buyer->id) }}" method="POST"
                                    class="mb-5">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100 mb-3"
                                        onclick="return confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?')">
                                        <i class="ki-duotone ki-check-circle fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Konfirmasi Pembayaran
                                    </button>
                                </form>
                                <!--end::Confirm Payment Form-->

                                <!--begin::Reject Payment Button-->
                                <button type="button" class="btn btn-danger w-100" id="showRejectForm">
                                    <i class="ki-duotone ki-cross-circle fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Tolak Pembayaran
                                </button>
                                <!--end::Reject Payment Button-->

                                <!--begin::Rejection Form (Hidden by default)-->
                                <div id="rejectionForm" class="d-none mt-7">
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                                        <i class="ki-duotone ki-information-5 fs-2hx text-danger me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-danger">Tolak Pembayaran</h4>
                                            <span>Berikan alasan penolakan yang jelas.</span>
                                        </div>
                                    </div>

                                    <form action="{{ route('admin.buyer.reject-payment', $buyer->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-5">
                                            <label for="reason" class="fw-semibold text-muted mb-2">Alasan Penolakan
                                                <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4"
                                                placeholder="Masukkan alasan penolakan pembayaran..." required>{{ old('reason') }}</textarea>
                                            @error('reason')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-flex gap-3">
                                            <button type="button" class="btn btn-light flex-fill" id="cancelReject">
                                                Batal
                                            </button>
                                            <button type="submit" class="btn btn-danger flex-fill"
                                                onclick="return confirm('Apakah Anda yakin ingin menolak pembayaran ini?')">
                                                <i class="ki-duotone ki-cross fs-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                Tolak Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!--end::Rejection Form-->

                                <!--begin::Info-->
                                <div class="separator separator-dashed my-7"></div>
                                <div class="text-muted fw-semibold fs-7">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="ki-duotone ki-information-5 fs-6 text-muted me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        Setelah dikonfirmasi, email notifikasi akan dikirim ke pembeli.
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-shield-cross fs-6 text-muted me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Penolakan pembayaran tidak dapat dibatalkan.
                                    </div>
                                </div>
                                <!--end::Info-->
                            @elseif ($buyer->payment_status === 'pending')
                                <!--begin::Pending Alert-->
                                <div class="alert alert-warning d-flex align-items-center p-5 mb-7">
                                    <i class="ki-duotone ki-time fs-2hx text-warning me-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-warning">Status Pending</h4>
                                        <span>Pembayaran masih dalam status pending. Hanya dapat ditolak, tidak dapat
                                            dikonfirmasi.</span>
                                    </div>
                                </div>
                                <!--end::Pending Alert-->

                                <!--begin::Reject Payment Button-->
                                <button type="button" class="btn btn-danger w-100" id="showRejectForm">
                                    <i class="ki-duotone ki-cross-circle fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Tolak Pembayaran
                                </button>
                                <!--end::Reject Payment Button-->

                                <!--begin::Rejection Form (Hidden by default)-->
                                <div id="rejectionForm" class="d-none mt-7">
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                                        <i class="ki-duotone ki-information-5 fs-2hx text-danger me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-danger">Tolak Pembayaran</h4>
                                            <span>Berikan alasan penolakan yang jelas.</span>
                                        </div>
                                    </div>

                                    <form action="{{ route('admin.buyer.reject-payment', $buyer->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-5">
                                            <label for="reason" class="fw-semibold text-muted mb-2">Alasan Penolakan
                                                <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4"
                                                placeholder="Masukkan alasan penolakan pembayaran..." required>{{ old('reason') }}</textarea>
                                            @error('reason')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-flex gap-3">
                                            <button type="button" class="btn btn-light flex-fill" id="cancelReject">
                                                Batal
                                            </button>
                                            <button type="submit" class="btn btn-danger flex-fill"
                                                onclick="return confirm('Apakah Anda yakin ingin menolak pembayaran ini?')">
                                                <i class="ki-duotone ki-cross fs-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                Tolak Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!--end::Rejection Form-->

                                <!--begin::Info-->
                                <div class="separator separator-dashed my-7"></div>
                                <div class="text-muted fw-semibold fs-7">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="ki-duotone ki-information-5 fs-6 text-muted me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        Status pending tidak dapat dikonfirmasi secara manual.
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-shield-cross fs-6 text-muted me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Penolakan pembayaran tidak dapat dibatalkan.
                                    </div>
                                </div>
                                <!--end::Info-->
                            @else
                                <!--begin::Status Info-->
                                <div class="alert alert-info d-flex align-items-center p-5">
                                    <i class="ki-duotone ki-information-5 fs-2hx text-info me-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-info">Status:
                                            {{ ucfirst(str_replace('_', ' ', $buyer->payment_status)) }}</h4>
                                        <span>
                                            @if ($buyer->payment_status === 'confirmed')
                                                Pembayaran telah dikonfirmasi.
                                            @elseif($buyer->payment_status === 'rejected')
                                                Pembayaran ditolak.
                                                @if ($buyer->rejection_reason)
                                                    <br><strong>Alasan:</strong> {{ $buyer->rejection_reason }}
                                                @endif
                                            @else
                                                Pembayaran sedang diproses.
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <!--end::Status Info-->
                            @endif
                        </div>
                    </div>
                    <!--end::Action Card-->
                </div>
            </div>

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--begin::JavaScript-->
    @if (in_array($buyer->payment_status, ['waiting_confirmation', 'pending']))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const showRejectBtn = document.getElementById('showRejectForm');
                const rejectionForm = document.getElementById('rejectionForm');
                const cancelRejectBtn = document.getElementById('cancelReject');

                if (showRejectBtn && rejectionForm && cancelRejectBtn) {
                    showRejectBtn.addEventListener('click', function() {
                        rejectionForm.classList.remove('d-none');
                        showRejectBtn.classList.add('d-none');
                    });

                    cancelRejectBtn.addEventListener('click', function() {
                        rejectionForm.classList.add('d-none');
                        showRejectBtn.classList.remove('d-none');
                        // Reset form
                        const reasonField = document.getElementById('reason');
                        if (reasonField) {
                            reasonField.value = '';
                            reasonField.classList.remove('is-invalid');
                        }
                    });
                }
            });
        </script>
    @endif
    <!--end::JavaScript-->
@endsection
