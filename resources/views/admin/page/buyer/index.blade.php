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
                                <option value="confirmed">Confirmed</option>
                                <option value="pending">Pending</option>
                                <option value="waiting_confirmation">Waiting Confirmation</option>
                                <option value="rejected">Rejected</option>
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
                                    <th class="min-w-100px">Kursi</th>
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
                                            <div class="d-flex flex-column">
                                                @if ($buyer->seats->count() > 0)
                                                    @foreach ($buyer->seats as $seat)
                                                        <span
                                                            class="text-primary fw-bold mb-1">{{ $seat->seat_number }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted fs-7">Belum dipilih</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'confirmed' => 'success',
                                                    'pending' => 'warning',
                                                    'waiting_confirmation' => 'info',
                                                    'rejected' => 'danger',
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
                                            @if ($buyer->payment_status === 'waiting_confirmation' || $buyer->payment_status === 'pending')
                                                <a href="{{ route('admin.buyer.payment-confirmation', $buyer->id) }}"
                                                    class="btn btn-sm btn-warning" title="Konfirmasi Pembayaran">
                                                    <i class="ki-duotone ki-check-circle fs-3">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    Konfirmasi
                                                </a>
                                            @else
                                                <span class="text-muted fs-7">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="emptyState">
                                        <td colspan="10" class="text-center py-10">
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

    <!--begin::JavaScript for Client-side Filtering-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const resetFilters = document.getElementById('resetFilters');
            const tableRows = document.querySelectorAll('#kt_buyers_table tbody tr:not(#emptyState)');
            const filterInfo = document.getElementById('filterInfo');
            const filterText = document.getElementById('filterText');
            const clearFilterInfo = document.getElementById('clearFilterInfo');
            const noResults = document.getElementById('noResults');
            const totalResults = document.getElementById('totalResults');
            const filteredResults = document.getElementById('filteredResults');
            const filteredCount = document.getElementById('filteredCount');
            const paginationWrapper = document.getElementById('paginationWrapper');

            function filterTable() {
                const searchValue = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                let visibleCount = 0;
                let hasFilter = false;
                let filterTexts = [];

                console.log('Filtering with:', {
                    searchValue,
                    statusValue
                }); // Debug log

                tableRows.forEach(row => {
                    const searchData = row.getAttribute('data-search') || '';
                    const statusData = row.getAttribute('data-status') || '';

                    console.log('Row data:', {
                        searchData,
                        statusData
                    }); // Debug log

                    let showRow = true;

                    // Search filter
                    if (searchValue && !searchData.includes(searchValue)) {
                        showRow = false;
                    }

                    // Status filter
                    if (statusValue && statusData !== statusValue) {
                        showRow = false;
                    }

                    if (showRow) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Update filter info
                if (searchValue) {
                    filterTexts.push(`Pencarian: "${searchValue}"`);
                    hasFilter = true;
                }
                if (statusValue) {
                    const statusText = statusFilter.options[statusFilter.selectedIndex].text;
                    filterTexts.push(`Status: ${statusText}`);
                    hasFilter = true;
                }

                if (hasFilter) {
                    filterText.textContent = filterTexts.join(', ');
                    filterInfo.classList.remove('d-none');
                    filteredResults.classList.remove('d-none');
                    filteredCount.textContent = visibleCount;
                } else {
                    filterInfo.classList.add('d-none');
                    filteredResults.classList.add('d-none');
                }

                // Show/hide no results message
                if (visibleCount === 0 && tableRows.length > 0) {
                    noResults.classList.remove('d-none');
                } else {
                    noResults.classList.add('d-none');
                }

                // Hide pagination when filtering
                if (hasFilter && paginationWrapper) {
                    paginationWrapper.style.display = 'none';
                } else if (paginationWrapper) {
                    paginationWrapper.style.display = '';
                }
            }

            // Event listeners
            searchInput.addEventListener('input', filterTable);

            // Handle Select2 change event differently
            if (window.$ && $('#statusFilter').length) {
                // Jika menggunakan Select2
                $('#statusFilter').on('change', function() {
                    filterTable();
                });
            } else {
                // Fallback untuk select biasa
                statusFilter.addEventListener('change', filterTable);
            }

            resetFilters.addEventListener('click', function() {
                searchInput.value = '';

                // Reset select2 jika ada
                if (window.$ && $('#statusFilter').length) {
                    $('#statusFilter').val('').trigger('change');
                } else {
                    statusFilter.value = '';
                }

                filterTable();
            });

            clearFilterInfo.addEventListener('click', function() {
                searchInput.value = '';

                // Reset select2 jika ada
                if (window.$ && $('#statusFilter').length) {
                    $('#statusFilter').val('').trigger('change');
                } else {
                    statusFilter.value = '';
                }

                filterTable();
            });

            // Debug: Check if Select2 is loaded
            console.log('jQuery available:', typeof window.$ !== 'undefined');
            console.log('Select2 element:', document.getElementById('statusFilter'));
        });
    </script>
    <!--end::JavaScript-->
@endsection
