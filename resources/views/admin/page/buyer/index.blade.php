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
                        Data Pembeli
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.buyer.index') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Data Pembeli</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <button type="button" class="btn btn-light btn-sm" id="resetFilters">
                        <i class="ki-duotone ki-arrows-circle fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Reset Filter
                    </button>
                    <a href="{{ route('admin.buyer.export') }}" class="btn btn-primary">
                        <i class="ki-duotone ki-exit-down fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Export Excel
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

            <!--begin::Stats Cards-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <!--begin::Col - Total Pendapatan-->
                <div class="col-xl-6">
                    <!--begin::Statistics Widget-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Total Pendapatan</span>
                                <span class="text-muted fw-semibold fs-7">Total pendapatan dari penjualan tiket</span>
                            </h3>
                            <div class="card-toolbar">
                                <div class="btn-icon-h-50px">
                                    <i class="ki-duotone ki-wallet fs-3x text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </div>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <span class="fs-2hx fw-bold text-primary me-2 lh-1 ls-n2">
                                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <div class="d-flex fw-semibold text-gray-600">
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-arrow-up fs-3 me-1 text-success"></i>
                                    <span class="fw-semibold text-gray-600 fs-7">Status: Paid</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget-->
                </div>
                <!--end::Col-->

                <!--begin::Col - Tiket Terjual-->
                <div class="col-xl-6">
                    <!--begin::Statistics Widget-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Tiket Terjual</span>
                                <span class="text-muted fw-semibold fs-7">Total tiket yang berhasil dijual</span>
                            </h3>
                            <div class="card-toolbar">
                                <div class="btn-icon-h-50px">
                                    <i class="ki-duotone ki-ticket fs-3x text-success">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <span class="fs-2hx fw-bold text-success me-2 lh-1 ls-n2">
                                    {{ number_format($totalTicketsSold) }}
                                </span>
                                <span class="text-muted fw-semibold fs-6">tiket</span>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <div class="d-flex fw-semibold text-gray-600">
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-check-circle fs-3 me-1 text-success"></i>
                                    <span class="fw-semibold text-gray-600 fs-7">Status: Terjual</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Stats Cards-->

            <!--begin::Buyers Table-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" id="searchInput" data-kt-ecommerce-product-filter="search"
                                class="form-control form-control-solid w-250px ps-12"
                                placeholder="Cari pembeli, email, atau ID pesanan..." />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <!--begin::Status Filter-->
                        <div class="w-100 mw-150px">
                            <select class="form-select form-select-solid" id="statusFilter" data-control="select2"
                                data-placeholder="Filter Status" data-hide-search="true">
                                <option value="">Semua Status</option>
                                <option value="paid">Paid</option>
                                <option value="pending">Pending</option>
                                <option value="waiting_confirmation">Waiting Confirmation</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                        <!--end::Status Filter-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Filter Info-->
                    <div id="filterInfo" class="d-none alert alert-info d-flex align-items-center p-5 mb-5">
                        <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-info">Filter Aktif</h4>
                            <span id="filterText"></span>
                        </div>
                        <button type="button" class="btn btn-icon btn-sm btn-light-info ms-auto" id="clearFilterInfo">
                            <i class="ki-duotone ki-cross fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </button>
                    </div>
                    <!--end::Filter Info-->

                    <!--begin::Results Counter-->
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div class="text-muted fw-semibold">
                            <span id="totalResults">{{ $buyers->total() }}</span> data ditemukan
                            <span id="filteredResults" class="d-none">(<span id="filteredCount">0</span> hasil
                                filter)</span>
                        </div>
                    </div>
                    <!--end::Results Counter-->

                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_buyers_table">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">No</th>
                                    <th class="min-w-125px">ID Pesanan</th>
                                    <th class="min-w-150px">Informasi Pembeli</th>
                                    <th class="min-w-100px">Kontak</th>
                                    <th class="min-w-100px">Kategori Tiket</th>
                                    <th class="min-w-70px">Qty</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="min-w-100px">Tanggal</th>
                                    <th class="min-w-100px">Action</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-semibold text-gray-600">
                                @forelse ($buyers as $buyer)
                                    <tr data-status="{{ $buyer->payment_status }}"
                                        data-date="{{ $buyer->created_at->format('Y-m-d') }}"
                                        data-search="{{ strtolower($buyer->nama_lengkap . ' ' . $buyer->email . ' ' . $buyer->external_id . ' ' . $buyer->no_handphone) }}">
                                        <td>{{ $loop->iteration + ($buyers->currentPage() - 1) * $buyers->perPage() }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="text-gray-800 text-hover-primary fs-6 fw-bold">{{ $buyer->external_id }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex flex-column">
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ $buyer->nama_lengkap }}</a>
                                                    <span
                                                        class="text-muted fw-semibold text-muted d-block fs-7">{{ $buyer->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-gray-800">{{ $buyer->no_handphone }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge badge-light fw-bold">{{ $buyer->ticket->name }}</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-gray-800">{{ $buyer->quantity }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'paid' => 'success',
                                                    'pending' => 'warning',
                                                    'waiting_confirmation' => 'info',
                                                    'failed' => 'danger',
                                                ];
                                                $color = $statusColors[$buyer->payment_status] ?? 'secondary';
                                            @endphp
                                            <div class="badge badge-light-{{ $color }} fw-bold">
                                                {{ ucfirst(str_replace('_', ' ', $buyer->payment_status)) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="fw-bold text-gray-800">{{ $buyer->created_at->format('d/m/Y') }}</span>
                                                <span
                                                    class="text-muted fw-semibold fs-7">{{ $buyer->created_at->format('H:i') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($buyer->payment_status === 'waiting_confirmation')
                                                <button type="button"
                                                    class="btn btn-sm btn-warning btn-payment-confirmation"
                                                    data-buyer-id="{{ $buyer->id }}" title="Konfirmasi Pembayaran">
                                                    <i class="ki-duotone ki-check-circle fs-3">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    Konfirmasi
                                                </button>
                                            @else
                                                <span class="text-muted fs-7">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="emptyState">
                                        <td colspan="9" class="text-center py-10">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ki-duotone ki-file-deleted fs-3x text-muted mb-4">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <span class="text-muted fw-semibold fs-6">Belum ada data pembeli</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                    <!--end::Table-->

                    <!--begin::No Results-->
                    <div id="noResults" class="d-none text-center py-10">
                        <div class="d-flex flex-column align-items-center">
                            <i class="ki-duotone ki-file-deleted fs-3x text-muted mb-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span class="text-muted fw-semibold fs-6">Tidak ada data yang sesuai dengan filter</span>
                        </div>
                    </div>
                    <!--end::No Results-->

                    <!--begin::Pagination-->
                    @if ($buyers->hasPages())
                        <div class="d-flex justify-content-between align-items-center flex-wrap pt-6"
                            id="paginationWrapper">
                            <div class="d-flex align-items-center py-3">
                                <span class="text-muted">
                                    Menampilkan {{ $buyers->firstItem() }} hingga {{ $buyers->lastItem() }}
                                    dari {{ $buyers->total() }} data
                                </span>
                            </div>
                            <div class="d-flex align-items-center py-3">
                                <!--begin::Pages-->
                                <ul class="pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($buyers->onFirstPage())
                                        <li class="page-item previous disabled">
                                            <a href="#" class="page-link">
                                                <i class="previous"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item previous">
                                            <a href="{{ $buyers->previousPageUrl() }}" class="page-link">
                                                <i class="previous"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($buyers->getUrlRange(1, $buyers->lastPage()) as $page => $url)
                                        @if ($page == $buyers->currentPage())
                                            <li class="page-item active">
                                                <a href="#" class="page-link">{{ $page }}</a>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($buyers->hasMorePages())
                                        <li class="page-item next">
                                            <a href="{{ $buyers->nextPageUrl() }}" class="page-link">
                                                <i class="next"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item next disabled">
                                            <a href="#" class="page-link">
                                                <i class="next"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <!--end::Pages-->
                            </div>
                        </div>
                    @endif
                    <!--end::Pagination-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Buyers Table-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--begin::Payment Confirmation Modal-->
    <div class="modal fade" id="paymentConfirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Konfirmasi Pembayaran</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div id="modalLoading" class="text-center py-10">
                        <div class="spinner-border spinner-border-lg text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div id="modalContent" class="d-none">
                        <!--begin::Order Details-->
                        <div class="card card-flush border mb-7">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="fw-bold m-0">Detail Pesanan</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <div class="fw-semibold text-gray-600 mb-2">ID Pesanan:</div>
                                        <div class="fw-bold text-gray-800" id="modal-external-id">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fw-semibold text-gray-600 mb-2">Tanggal Pesanan:</div>
                                        <div class="fw-bold text-gray-800" id="modal-created-at">-</div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <div class="fw-semibold text-gray-600 mb-2">Nama Pembeli:</div>
                                        <div class="fw-bold text-gray-800" id="modal-nama-lengkap">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fw-semibold text-gray-600 mb-2">Email:</div>
                                        <div class="fw-bold text-gray-800" id="modal-email">-</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fw-semibold text-gray-600 mb-2">No. Handphone:</div>
                                        <div class="fw-bold text-gray-800" id="modal-no-handphone">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fw-semibold text-gray-600 mb-2">Kategori Tiket:</div>
                                        <div class="fw-bold text-gray-800" id="modal-ticket-name">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Order Details-->

                        <!--begin::Payment Details-->
                        <div class="card card-flush border mb-7">
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
                                                <td class="fw-semibold text-muted">Harga Tiket</td>
                                                <td class="text-end fw-bold" id="modal-ticket-price">Rp 0</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-muted">Quantity</td>
                                                <td class="text-end fw-bold" id="modal-quantity">0</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold text-muted">Biaya Admin</td>
                                                <td class="text-end fw-bold" id="modal-admin-fee">Rp 0</td>
                                            </tr>
                                            <tr class="border-bottom-0">
                                                <td colspan="2">
                                                    <hr class="my-2">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-dark fs-6">Total Pembayaran</td>
                                                <td class="text-end fw-bold text-primary fs-6" id="modal-total-amount">Rp
                                                    0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--end::Payment Details-->

                        <!--begin::Payment Proof-->
                        <div class="card card-flush border mb-7">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="fw-bold m-0">Bukti Pembayaran</h3>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <div id="paymentProofContainer">
                                    <div id="noPaymentProof" class="d-none">
                                        <i class="ki-duotone ki-file-deleted fs-3x text-muted mb-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <p class="text-muted">Tidak ada bukti pembayaran</p>
                                    </div>
                                    <div id="paymentProofImage" class="d-none">
                                        <img id="modal-payment-proof" src="" alt="Bukti Pembayaran"
                                            class="img-fluid rounded shadow-sm" style="max-height: 400px;">
                                        <div class="mt-3">
                                            <a href="#" id="modal-payment-proof-link" target="_blank"
                                                class="btn btn-sm btn-light-primary">
                                                <i class="ki-duotone ki-eye fs-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                Lihat Ukuran Penuh
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Payment Proof-->

                        <!--begin::Rejection Reason-->
                        <div id="rejectionReasonSection" class="d-none">
                            <div class="card card-flush border border-danger mb-7">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="fw-bold m-0 text-danger">Alasan Penolakan</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="rejectionReason" class="fw-semibold text-muted mb-2">Berikan alasan
                                            penolakan pembayaran:</label>
                                        <textarea class="form-control" id="rejectionReason" rows="4"
                                            placeholder="Masukkan alasan penolakan pembayaran..."></textarea>
                                        <div class="invalid-feedback" id="rejectionReasonError"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Rejection Reason-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <div id="modalActions" class="d-none">
                        <button type="button" class="btn btn-danger me-3" id="rejectPaymentButton">
                            <i class="ki-duotone ki-cross-circle fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Tolak Pembayaran
                        </button>
                        <button type="button" class="btn btn-success" id="confirmPaymentButton">
                            <i class="ki-duotone ki-check-circle fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Konfirmasi Pembayaran
                        </button>
                    </div>
                    <div id="rejectionActions" class="d-none">
                        <button type="button" class="btn btn-light me-3" id="cancelRejectionButton">Batal</button>
                        <button type="button" class="btn btn-danger" id="submitRejectionButton">
                            <span class="indicator-label">Tolak Pembayaran</span>
                            <span class="indicator-progress d-none">
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Payment Confirmation Modal-->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const searchInput = document.querySelector('#searchInput');
            const statusFilter = document.querySelector('#statusFilter');
            const table = document.querySelector('#kt_buyers_table tbody');
            const resetButton = document.querySelector('#resetFilters');
            const filterInfo = document.querySelector('#filterInfo');
            const filterText = document.querySelector('#filterText');
            const clearFilterInfo = document.querySelector('#clearFilterInfo');
            const totalResults = document.querySelector('#totalResults');
            const filteredResults = document.querySelector('#filteredResults');
            const filteredCount = document.querySelector('#filteredCount');
            const noResults = document.querySelector('#noResults');
            const paginationWrapper = document.querySelector('#paginationWrapper');
            const emptyState = document.querySelector('#emptyState');

            // Modal Elements
            const paymentModal = document.querySelector('#paymentConfirmationModal');
            const modalLoading = document.querySelector('#modalLoading');
            const modalContent = document.querySelector('#modalContent');
            const modalActions = document.querySelector('#modalActions');
            const rejectionSection = document.querySelector('#rejectionReasonSection');
            const rejectionActions = document.querySelector('#rejectionActions');

            // Buttons
            const confirmPaymentButton = document.querySelector('#confirmPaymentButton');
            const rejectPaymentButton = document.querySelector('#rejectPaymentButton');
            const cancelRejectionButton = document.querySelector('#cancelRejectionButton');
            const submitRejectionButton = document.querySelector('#submitRejectionButton');

            // Store original data
            const originalRows = Array.from(table.querySelectorAll('tr:not(#emptyState)'));
            const totalOriginalCount = originalRows.length;
            const originalTotalCount = totalResults ? parseInt(totalResults.textContent) : totalOriginalCount;

            let currentBuyerId = null;

            // Initialize Select2 if available
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('#statusFilter').select2({
                    placeholder: "Filter Status",
                    allowClear: true,
                    minimumResultsForSearch: Infinity
                });
            }

            // Payment Confirmation Modal Handler
            document.addEventListener('click', function(e) {
                if (e.target.closest('.btn-payment-confirmation')) {
                    const button = e.target.closest('.btn-payment-confirmation');
                    const buyerId = button.getAttribute('data-buyer-id');
                    showPaymentConfirmationModal(buyerId);
                }
            });

            // Show Payment Confirmation Modal
            function showPaymentConfirmationModal(buyerId) {
                currentBuyerId = buyerId;

                // Reset modal state
                modalLoading.classList.remove('d-none');
                modalContent.classList.add('d-none');
                modalActions.classList.add('d-none');
                rejectionSection.classList.add('d-none');
                rejectionActions.classList.add('d-none');

                // Show modal
                const modal = new bootstrap.Modal(paymentModal);
                modal.show();

                // Fetch payment proof data dengan URL yang benar
                fetch(`{{ route('admin.buyer.payment-proof', '') }}/${buyerId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            populateModalData(data.data);
                            modalLoading.classList.add('d-none');
                            modalContent.classList.remove('d-none');
                            modalActions.classList.remove('d-none');
                        } else {
                            showModalError(data.message || 'Gagal memuat data pembayaran');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showModalError('Terjadi kesalahan saat memuat data: ' + error.message);
                    });
            }

            // Populate Modal Data
            function populateModalData(data) {
                document.getElementById('modal-external-id').textContent = data.external_id || '-';

                // Format tanggal dengan benar
                let formattedDate = '-';
                if (data.created_at) {
                    try {
                        const date = new Date(data.created_at);
                        formattedDate = date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    } catch (e) {
                        formattedDate = data.created_at;
                    }
                }
                document.getElementById('modal-created-at').textContent = formattedDate;

                document.getElementById('modal-nama-lengkap').textContent = data.nama_lengkap || '-';
                document.getElementById('modal-email').textContent = data.email || '-';
                document.getElementById('modal-no-handphone').textContent = data.no_handphone || '-';
                document.getElementById('modal-ticket-name').textContent = data.ticket_name || '-';
                document.getElementById('modal-ticket-price').textContent = 'Rp ' + formatNumber(data
                    .ticket_price || 0);
                document.getElementById('modal-quantity').textContent = data.quantity || 0;
                document.getElementById('modal-admin-fee').textContent = 'Rp ' + formatNumber(data.admin_fee || 0);
                document.getElementById('modal-total-amount').textContent = 'Rp ' + formatNumber(data
                    .total_amount || 0);

                // Handle payment proof dengan pengecekan yang lebih baik
                const paymentProofContainer = document.getElementById('paymentProofContainer');
                const noPaymentProof = document.getElementById('noPaymentProof');
                const paymentProofImage = document.getElementById('paymentProofImage');
                const modalPaymentProof = document.getElementById('modal-payment-proof');
                const modalPaymentProofLink = document.getElementById('modal-payment-proof-link');

                if (data.payment_proof && data.payment_proof.trim() !== '') {
                    // Pastikan URL payment proof benar
                    let proofUrl = data.payment_proof;

                    // Jika tidak dimulai dengan http/https, tambahkan storage path
                    if (!proofUrl.startsWith('http')) {
                        proofUrl = `/storage/${data.payment_proof}`;
                    }

                    modalPaymentProof.src = proofUrl;
                    modalPaymentProofLink.href = proofUrl;

                    // Handle error loading image
                    modalPaymentProof.onerror = function() {
                        console.error('Failed to load image:', proofUrl);
                        noPaymentProof.classList.remove('d-none');
                        paymentProofImage.classList.add('d-none');
                    };

                    modalPaymentProof.onload = function() {
                        noPaymentProof.classList.add('d-none');
                        paymentProofImage.classList.remove('d-none');
                    };

                } else {
                    noPaymentProof.classList.remove('d-none');
                    paymentProofImage.classList.add('d-none');
                }
            }

            // Show Modal Error
            function showModalError(message) {
                modalLoading.classList.add('d-none');
                modalContent.innerHTML = `
                    <div class="text-center py-10">
                        <i class="ki-duotone ki-cross-circle fs-3x text-danger mb-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <p class="text-muted">${message}</p>
                    </div>
                `;
                modalContent.classList.remove('d-none');
            }

            // Confirm Payment
            confirmPaymentButton.addEventListener('click', function() {
                if (!currentBuyerId) return;

                // Show loading
                const button = this;
                const originalText = button.innerHTML;
                button.innerHTML = `
                        <span class="spinner-border spinner-border-sm align-middle me-2"></span>
                        Memproses...
                    `;
                button.disabled = true;

                fetch(`{{ route('admin.buyer.confirm-payment', '') }}/${currentBuyerId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Close modal
                            bootstrap.Modal.getInstance(paymentModal).hide();

                            // Show success message
                            showToast('success', 'Berhasil!', data.message);

                            // Update row status in table without reload
                            updateRowStatus(currentBuyerId, 'paid');

                            // Optional: reload setelah delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showToast('error', 'Gagal!', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('error', 'Error!',
                            'Terjadi kesalahan saat mengkonfirmasi pembayaran: ' + error.message);
                    })
                    .finally(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    });
            });

            function updateRowStatus(buyerId, newStatus) {
                const rows = document.querySelectorAll('tr[data-buyer-id="' + buyerId + '"]');
                rows.forEach(row => {
                    const statusBadge = row.querySelector('.badge');
                    const actionCell = row.querySelector('td:last-child');

                    if (statusBadge) {
                        statusBadge.className = 'badge badge-light-success fw-bold';
                        statusBadge.textContent = 'Paid';
                    }

                    if (actionCell) {
                        actionCell.innerHTML = '<span class="text-muted fs-7">-</span>';
                    }

                    // Update data attribute
                    row.setAttribute('data-status', newStatus);
                });
            }

            // Reject Payment Button
            rejectPaymentButton.addEventListener('click', function() {
                modalActions.classList.add('d-none');
                rejectionSection.classList.remove('d-none');
                rejectionActions.classList.remove('d-none');
                document.getElementById('rejectionReason').focus();
            });

            // Cancel Rejection
            cancelRejectionButton.addEventListener('click', function() {
                modalActions.classList.remove('d-none');
                rejectionSection.classList.add('d-none');
                rejectionActions.classList.add('d-none');
                document.getElementById('rejectionReason').value = '';
                document.getElementById('rejectionReasonError').textContent = '';
            });

            // Submit Rejection
            submitRejectionButton.addEventListener('click', function() {
                const reason = document.getElementById('rejectionReason').value.trim();
                const errorElement = document.getElementById('rejectionReasonError');
                const reasonInput = document.getElementById('rejectionReason');

                // Reset validation
                reasonInput.classList.remove('is-invalid');
                errorElement.textContent = '';

                // Validate reason
                if (!reason) {
                    errorElement.textContent = 'Alasan penolakan harus diisi';
                    reasonInput.classList.add('is-invalid');
                    reasonInput.focus();
                    return;
                }

                if (reason.length < 10) {
                    errorElement.textContent = 'Alasan penolakan minimal 10 karakter';
                    reasonInput.classList.add('is-invalid');
                    reasonInput.focus();
                    return;
                }

                // Show loading
                const button = this;
                const indicator = button.querySelector('.indicator-progress');
                const label = button.querySelector('.indicator-label');

                if (indicator) indicator.classList.remove('d-none');
                if (label) label.textContent = 'Memproses...';
                button.disabled = true;

                fetch(`{{ route('admin.buyer.reject-payment', '') }}/${currentBuyerId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            reason: reason
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Close modal
                            bootstrap.Modal.getInstance(paymentModal).hide();

                            // Show success message
                            showToast('success', 'Berhasil!', data.message);

                            // Update row status
                            updateRowStatus(currentBuyerId, 'failed');

                            // Reload page to update data
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showToast('error', 'Gagal!', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('error', 'Error!', 'Terjadi kesalahan saat menolak pembayaran: ' +
                            error.message);
                    })
                    .finally(() => {
                        if (indicator) indicator.classList.add('d-none');
                        if (label) label.textContent = 'Tolak Pembayaran';
                        button.disabled = false;
                    });
            });

            // Helper Functions
            function formatNumber(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }

            function showToast(type, title, message) {
                // Implement your toast notification here
                // This is a basic implementation
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alert = document.createElement('div');
                alert.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
                alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                alert.innerHTML = `
                    <strong>${title}</strong> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alert);

                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 5000);
            }

            // Filter function (existing code)
            function applyFilters() {
                const searchValue = searchInput ? searchInput.value.toLowerCase().trim() : '';
                const statusValue = statusFilter ? statusFilter.value.toLowerCase() : '';

                let visibleCount = 0;
                let hasActiveFilters = searchValue || statusValue;
                let filterDescriptions = [];

                if (emptyState) emptyState.style.display = 'none';

                originalRows.forEach(function(row) {
                    const searchData = row.getAttribute('data-search') || '';
                    const rowStatus = row.getAttribute('data-status') || '';

                    let showRow = true;

                    if (searchValue && !searchData.includes(searchValue)) {
                        showRow = false;
                    }

                    if (statusValue && rowStatus !== statusValue) {
                        showRow = false;
                    }

                    if (showRow) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (searchValue) {
                    filterDescriptions.push(`Pencarian: "${searchValue}"`);
                }
                if (statusValue) {
                    const statusText = statusValue.charAt(0).toUpperCase() + statusValue.slice(1).replace('_', ' ');
                    filterDescriptions.push(`Status: ${statusText}`);
                }

                if (hasActiveFilters && filterDescriptions.length > 0) {
                    if (filterInfo) {
                        filterInfo.classList.remove('d-none');
                    }
                    if (filterText) {
                        filterText.textContent = filterDescriptions.join(', ');
                    }
                    if (filteredResults) {
                        filteredResults.classList.remove('d-none');
                    }
                    if (filteredCount) {
                        filteredCount.textContent = visibleCount;
                    }
                } else {
                    if (filterInfo) {
                        filterInfo.classList.add('d-none');
                    }
                    if (filteredResults) {
                        filteredResults.classList.add('d-none');
                    }
                }

                if (visibleCount === 0 && hasActiveFilters) {
                    if (noResults) {
                        noResults.classList.remove('d-none');
                    }
                    if (paginationWrapper) {
                        paginationWrapper.style.display = 'none';
                    }
                } else {
                    if (noResults) {
                        noResults.classList.add('d-none');
                    }
                    if (paginationWrapper && !hasActiveFilters) {
                        paginationWrapper.style.display = '';
                    } else if (paginationWrapper && hasActiveFilters) {
                        paginationWrapper.style.display = 'none';
                    }

                    if (totalOriginalCount === 0 && !hasActiveFilters && emptyState) {
                        emptyState.style.display = '';
                    }
                }

                updateRowNumbers();
            }

            function updateRowNumbers() {
                let visibleIndex = 1;
                originalRows.forEach(function(row) {
                    if (row.style.display !== 'none') {
                        const numberCell = row.querySelector('td:first-child');
                        if (numberCell) {
                            numberCell.textContent = visibleIndex++;
                        }
                    }
                });
            }

            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = function() {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Event listeners for search and filter (existing code)
            if (searchInput) {
                searchInput.addEventListener('input', debounce(function() {
                    applyFilters();
                }, 200));

                searchInput.addEventListener('keyup', function() {
                    if (this.value === '') {
                        applyFilters();
                    }
                });
            }

            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    applyFilters();
                });

                if (typeof $ !== 'undefined') {
                    $('#statusFilter').on('select2:select select2:clear', function() {
                        setTimeout(applyFilters, 50);
                    });
                }
            }

            if (resetButton) {
                resetButton.addEventListener('click', function() {
                    if (searchInput) {
                        searchInput.value = '';
                    }

                    if (statusFilter) {
                        statusFilter.value = '';
                        if (typeof $ !== 'undefined' && $('#statusFilter').hasClass(
                                'select2-hidden-accessible')) {
                            $('#statusFilter').val('').trigger('change');
                        }
                    }

                    applyFilters();
                });
            }

            if (clearFilterInfo) {
                clearFilterInfo.addEventListener('click', function() {
                    if (resetButton) {
                        resetButton.click();
                    }
                });
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }

                if (e.key === 'Escape' && document.activeElement === searchInput) {
                    if (resetButton) {
                        resetButton.click();
                    }
                    searchInput.blur();
                }
            });

            // Initialize filters on page load
            applyFilters();
        });
    </script>
@endpush
