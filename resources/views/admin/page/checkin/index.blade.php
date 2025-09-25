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
                        Data Check-in
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.checkin.index') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Data Check-in</li>
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
                <!--begin::Col - Total Check-in-->
                <div class="col-xl-4">
                    <!--begin::Statistics Widget-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Total Check-in</span>
                                <span class="text-muted fw-semibold fs-7">Semua tiket yang sudah check-in</span>
                            </h3>
                            <div class="card-toolbar">
                                <div class="btn-icon-h-50px">
                                    <i class="ki-duotone ki-check-circle fs-3x text-success">
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
                                    {{ number_format($totalCheckedIn) }}
                                </span>
                                <span class="text-muted fw-semibold fs-6">/ {{ number_format($totalPaidTickets) }}
                                    tiket</span>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <div class="d-flex fw-semibold text-gray-600">
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-arrow-up fs-3 me-1 text-success"></i>
                                    <span class="fw-semibold text-gray-600 fs-7">{{ number_format($checkinPercentage, 1) }}%
                                        sudah check-in</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget-->
                </div>
                <!--end::Col-->

                <!--begin::Col - Online Booking Stats-->
                {{-- <div class="col-xl-4">
                    <!--begin::Statistics Widget-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Online Booking</span>
                                <span class="text-muted fw-semibold fs-7">Tiket online yang check-in</span>
                            </h3>
                            <div class="card-toolbar">
                                <div class="btn-icon-h-50px">
                                    <i class="ki-duotone ki-tablet fs-3x text-primary">
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
                                <span class="fs-2hx fw-bold text-primary me-2 lh-1 ls-n2">
                                    {{ number_format($buyersStats['total_checkin']) }}
                                </span>
                                <span class="text-muted fw-semibold fs-6">/ {{ number_format($buyersStats['total_paid']) }}
                                    tiket</span>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <div class="progress h-6px w-100 bg-light-primary">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{ $buyersStats['percentage'] }}%"
                                    aria-valuenow="{{ $buyersStats['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <div class="d-flex fw-semibold text-gray-600 mt-3">
                                <span
                                    class="fw-semibold text-gray-600 fs-7">{{ number_format($buyersStats['percentage'], 1) }}%
                                    completed</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget-->
                </div> --}}
                <!--end::Col-->

                <!--begin::Col - OTS Stats-->
                {{-- <div class="col-xl-4">
                    <!--begin::Statistics Widget-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">On The Spot</span>
                                <span class="text-muted fw-semibold fs-7">Tiket OTS langsung check-in</span>
                            </h3>
                            <div class="card-toolbar">
                                <div class="btn-icon-h-50px">
                                    <i class="ki-duotone ki-shop fs-3x text-warning">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </div>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <span class="fs-2hx fw-bold text-warning me-2 lh-1 ls-n2">
                                    {{ number_format($otsStats['total_checkin']) }}
                                </span>
                                <span class="text-muted fw-semibold fs-6">/ {{ number_format($otsStats['total_tickets']) }}
                                    tiket</span>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <div class="progress h-6px w-100 bg-light-warning">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 100%"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex fw-semibold text-gray-600 mt-3">
                                <span class="fw-semibold text-gray-600 fs-7">100% completed</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget-->
                </div> --}}
                <!--end::Col-->
            </div>
            <!--end::Stats Cards-->

            <!--begin::Filter Tabs-->
            <div class="card card-flush mb-5">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <!--begin::Filter Tabs-->
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link {{ $filterType == 'all' ? 'active' : '' }}"
                                    href="{{ route('admin.checkin.index', ['type' => 'all']) }}">
                                    <i class="ki-duotone ki-element-11 fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                    Semua Data
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link {{ $filterType == 'buyers' ? 'active' : '' }}"
                                    href="{{ route('admin.checkin.index', ['type' => 'buyers']) }}">
                                    <i class="ki-duotone ki-tablet fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Online Booking
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $filterType == 'ots' ? 'active' : '' }}"
                                    href="{{ route('admin.checkin.index', ['type' => 'ots']) }}">
                                    <i class="ki-duotone ki-shop fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                    On The Spot
                                </a>
                            </li> --}}
                        </ul>
                        <!--end::Filter Tabs-->
                    </div>
                </div>
            </div>
            <!--end::Filter Tabs-->

            <!--begin::Checkins Table-->
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
                                placeholder="Cari nama, email, atau ID pesanan..." />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
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
                            <span id="totalResults">{{ $checkins->total() }}</span> data ditemukan
                            <span id="filteredResults" class="d-none">(<span id="filteredCount">0</span> hasil
                                filter)</span>
                        </div>
                    </div>
                    <!--end::Results Counter-->

                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_checkins_table">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">No</th>
                                    <th class="min-w-125px">ID Pesanan</th>
                                    <th class="min-w-200px">Nama</th>
                                    <th class="min-w-200px">Email/Phone</th>
                                    <th class="min-w-70px">Qty</th>
                                    <th class="min-w-100px">Tipe</th>
                                    <th class="min-w-150px">Waktu Check-in</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-semibold text-gray-600">
                                @forelse ($checkins as $checkin)
                                    <tr
                                        data-search="{{ strtolower($checkin->nama_lengkap . ' ' . $checkin->email . ' ' . $checkin->external_id) }}">
                                        <td>{{ $loop->iteration + ($checkins->currentPage() - 1) * $checkins->perPage() }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="text-gray-800 text-hover-primary fs-6 fw-bold">{{ $checkin->external_id }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ $checkin->nama_lengkap }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-muted fw-semibold">{{ $checkin->email }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-light-success fw-bold">{{ $checkin->qty }}</span>
                                        </td>
                                        <td>
                                            @if ($checkin->source_table === 'buyers')
                                                <span class="badge badge-light-primary">
                                                    <i class="ki-duotone ki-tablet fs-6 me-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    Online
                                                </span>
                                            @else
                                                <span class="badge badge-light-warning">
                                                    <i class="ki-duotone ki-shop fs-6 me-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                    OTS
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="fw-bold text-gray-800">{{ \Carbon\Carbon::parse($checkin->checked_in_at)->format('d/m/Y') }}</span>
                                                <span
                                                    class="text-muted fw-semibold fs-7">{{ \Carbon\Carbon::parse($checkin->checked_in_at)->format('H:i:s') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="emptyState">
                                        <td colspan="7" class="text-center py-10">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ki-duotone ki-file-deleted fs-3x text-muted mb-4">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <span class="text-muted fw-semibold fs-6">Belum ada data check-in</span>
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
                    @if ($checkins->hasPages())
                        <div class="d-flex justify-content-between align-items-center flex-wrap pt-6"
                            id="paginationWrapper">
                            <div class="d-flex align-items-center py-3">
                                <span class="text-muted">
                                    Menampilkan {{ $checkins->firstItem() }} hingga {{ $checkins->lastItem() }}
                                    dari {{ $checkins->total() }} data
                                </span>
                            </div>
                            <div class="d-flex align-items-center py-3">
                                <!--begin::Pages-->
                                <ul class="pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($checkins->onFirstPage())
                                        <li class="page-item previous disabled">
                                            <a href="#" class="page-link">
                                                <i class="previous"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item previous">
                                            <a href="{{ $checkins->previousPageUrl() }}" class="page-link">
                                                <i class="previous"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($checkins->getUrlRange(1, $checkins->lastPage()) as $page => $url)
                                        @if ($page == $checkins->currentPage())
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
                                    @if ($checkins->hasMorePages())
                                        <li class="page-item next">
                                            <a href="{{ $checkins->nextPageUrl() }}" class="page-link">
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
            <!--end::Checkins Table-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const searchInput = document.querySelector('#searchInput');
            const table = document.querySelector('#kt_checkins_table tbody');
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

            // Store original data
            const originalRows = Array.from(table.querySelectorAll('tr:not(#emptyState)'));
            const totalOriginalCount = originalRows.length;

            // Filter function
            function applyFilters() {
                const searchValue = searchInput ? searchInput.value.toLowerCase().trim() : '';

                let visibleCount = 0;
                let hasActiveFilters = searchValue;

                // Hide empty state initially
                if (emptyState) emptyState.style.display = 'none';

                // Show all rows first, then filter
                originalRows.forEach(function(row) {
                    const searchData = row.getAttribute('data-search') || '';
                    let showRow = true;

                    // Search filter - check if search value is found in search data
                    if (searchValue && !searchData.includes(searchValue)) {
                        showRow = false;
                    }

                    // Show/hide row
                    if (showRow) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show/hide filter info
                if (hasActiveFilters) {
                    if (filterInfo) {
                        filterInfo.classList.remove('d-none');
                    }
                    if (filterText) {
                        filterText.textContent = `Pencarian: "${searchValue}"`;
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

                // Show/hide no results message
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

                    // Show empty state if no original data and no filters
                    if (totalOriginalCount === 0 && !hasActiveFilters && emptyState) {
                        emptyState.style.display = '';
                    }
                }

                // Update row numbers for visible rows
                updateRowNumbers();
            }

            // Update row numbers for visible rows
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

            // Debounce function for search input
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

            // Event listeners
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

            // Reset filters
            if (resetButton) {
                resetButton.addEventListener('click', function() {
                    if (searchInput) {
                        searchInput.value = '';
                    }
                    applyFilters();
                });
            }

            // Clear filter info
            if (clearFilterInfo) {
                clearFilterInfo.addEventListener('click', function() {
                    if (resetButton) {
                        resetButton.click();
                    }
                });
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + K to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }

                // Escape to clear search
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
