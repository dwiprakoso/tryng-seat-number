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
                        Data Kursi
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.seats.index') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Data Kursi</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                {{-- <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <button type="button" class="btn btn-light btn-sm" id="resetFilters">
                        <i class="ki-duotone ki-arrows-circle fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Reset Filter
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSeatModal">
                        <i class="ki-duotone ki-plus fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Tambah Kursi
                    </button>
                </div> --}}
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
                <!--begin::Col - Total Kursi-->
                <div class="col-xl-4">
                    <!--begin::Statistics Widget-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Total Kursi</span>
                                <span class="text-muted fw-semibold fs-7">Jumlah seluruh kursi</span>
                            </h3>
                            <div class="card-toolbar">
                                <div class="btn-icon-h-50px">
                                    <i class="ki-duotone ki-chair fs-3x text-primary">
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
                                    {{ number_format($totalSeats) }}
                                </span>
                                <span class="text-muted fw-semibold fs-6">kursi</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget-->
                </div>
                <!--end::Col-->

                <!--begin::Col - Kursi Terpesan-->
                <div class="col-xl-4">
                    <!--begin::Statistics Widget-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Kursi Terpesan</span>
                                <span class="text-muted fw-semibold fs-7">Kursi yang sudah dipesan</span>
                            </h3>
                            <div class="card-toolbar">
                                <div class="btn-icon-h-50px">
                                    <i class="ki-duotone ki-check-circle fs-3x text-danger">
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
                                <span class="fs-2hx fw-bold text-danger me-2 lh-1 ls-n2">
                                    {{ number_format($bookedSeats) }}
                                </span>
                                <span class="text-muted fw-semibold fs-6">kursi</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget-->
                </div>
                <!--end::Col-->

                <!--begin::Col - Kursi Tersedia-->
                <div class="col-xl-4">
                    <!--begin::Statistics Widget-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Kursi Tersedia</span>
                                <span class="text-muted fw-semibold fs-7">Kursi yang masih tersedia</span>
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
                                    {{ number_format($availableSeats) }}
                                </span>
                                <span class="text-muted fw-semibold fs-6">kursi</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Stats Cards-->

            <!--begin::Seats Table-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <form method="GET" action="{{ route('admin.seats.index') }}" id="searchForm">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" name="search" id="searchInput"
                                    class="form-control form-control-solid w-250px ps-12" placeholder="Cari nomor kursi..."
                                    value="{{ request('search') }}" />
                            </div>
                        </form>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    {{-- <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <!--begin::Status Filter-->
                        <div class="w-100 mw-150px">
                            <select class="form-select form-select-solid" id="statusFilter" data-control="select2"
                                data-placeholder="Filter Status" data-hide-search="true">
                                <option value="">Semua Status</option>
                                <option value="1">Terpesan</option>
                                <option value="0">Tersedia</option>
                            </select>
                        </div>
                        <!--end::Status Filter-->
                    </div> --}}
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
                            <span id="totalResults">{{ $seats->total() }}</span> data ditemukan
                            <span id="filteredResults" class="d-none">(<span id="filteredCount">0</span> hasil
                                filter)</span>
                        </div>
                    </div>
                    <!--end::Results Counter-->

                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_seats_table">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">No</th>
                                    <th class="min-w-125px">Nomor Kursi</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="min-w-125px">Tanggal Dibuat</th>
                                    <th class="min-w-125px">Terakhir Update</th>
                                    {{-- <th class="min-w-100px">Action</th> --}}
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-semibold text-gray-600">
                                @forelse ($seats as $seat)
                                    <tr data-status="{{ $seat->is_booked ? '1' : '0' }}"
                                        data-search="{{ strtolower($seat->seat_number) }}">
                                        <td>{{ $loop->iteration + ($seats->currentPage() - 1) * $seats->perPage() }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="text-gray-800 text-hover-primary fs-6 fw-bold">{{ $seat->seat_number }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge badge-light-{{ $seat->status_color }} fw-bold">
                                                {{ $seat->status }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-gray-800">
                                                    {{ $seat->created_at ? $seat->created_at->format('d/m/Y') : '-' }}
                                                </span>
                                                <span class="text-muted fw-semibold fs-7">
                                                    {{ $seat->created_at ? $seat->created_at->format('H:i') : '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-gray-800">
                                                    {{ $seat->updated_at ? $seat->updated_at->format('d/m/Y') : '-' }}
                                                </span>
                                                <span class="text-muted fw-semibold fs-7">
                                                    {{ $seat->updated_at ? $seat->updated_at->format('H:i') : '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div class="d-flex gap-2">
                                                <!-- Edit -->
                                                <button type="button" class="btn btn-icon btn-sm btn-light edit-seat-btn"
                                                    data-id="{{ $seat->id }}"
                                                    data-seat-number="{{ $seat->seat_number }}"
                                                    data-is-booked="{{ $seat->is_booked ? '1' : '0' }}"
                                                    data-bs-toggle="modal" data-bs-target="#editSeatModal"
                                                    title="Edit Kursi">
                                                    <i class="ki-outline ki-pencil fs-3 text-warning"></i>
                                                </button>

                                                <!-- Delete -->
                                                <form action="{{ route('admin.seats.destroy', $seat->id) }}"
                                                    method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-icon btn-sm btn-light delete-btn"
                                                        title="Hapus Kursi">
                                                        <i class="ki-outline ki-trash fs-3 text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>

                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr id="emptyState">
                                        <td colspan="6" class="text-center py-10">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ki-duotone ki-file-deleted fs-3x text-muted mb-4">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <span class="text-muted fw-semibold fs-6">Belum ada data kursi</span>
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
                    @if ($seats->hasPages())
                        <div class="d-flex justify-content-between align-items-center flex-wrap pt-6"
                            id="paginationWrapper">
                            <div class="d-flex align-items-center py-3">
                                <span class="text-muted">
                                    Menampilkan {{ $seats->firstItem() }} hingga {{ $seats->lastItem() }}
                                    dari {{ $seats->total() }} data
                                </span>
                            </div>
                            <div class="d-flex align-items-center py-3">
                                <!--begin::Pages-->
                                <ul class="pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($seats->onFirstPage())
                                        <li class="page-item previous disabled">
                                            <a href="#" class="page-link">
                                                <i class="previous"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item previous">
                                            <a href="{{ $seats->previousPageUrl() }}" class="page-link">
                                                <i class="previous"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($seats->getUrlRange(1, $seats->lastPage()) as $page => $url)
                                        @if ($page == $seats->currentPage())
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
                                    @if ($seats->hasMorePages())
                                        <li class="page-item next">
                                            <a href="{{ $seats->nextPageUrl() }}" class="page-link">
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
            <!--end::Seats Table-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--begin::Create Seat Modal-->
    <div class="modal fade" id="createSeatModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Tambah Kursi Baru</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <form action="{{ route('admin.seats.store') }}" method="POST">
                    @csrf
                    <div class="modal-body py-10 px-lg-17">
                        <div class="scroll-y me-n7 pe-7" data-kt-scroll="true"
                            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_add_seat_header"
                            data-kt-scroll-wrappers="#kt_modal_add_seat_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Nomor Kursi</label>
                                <input type="text"
                                    class="form-control form-control-solid @error('seat_number') is-invalid @enderror"
                                    name="seat_number" value="{{ old('seat_number') }}"
                                    placeholder="Masukkan nomor kursi" />
                                @error('seat_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            {{-- <div class="fv-row mb-15">
                                <label class="fs-6 fw-semibold mb-2">Status</label>
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" name="is_booked"
                                        id="is_booked_create" {{ old('is_booked') ? 'checked' : '' }} />
                                    <label class="form-check-label fw-semibold text-gray-400 ms-3" for="is_booked_create">
                                        Kursi Terpesan
                                    </label>
                                </div>
                            </div> --}}
                            <!--end::Input group-->
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Create Seat Modal-->

    <!--begin::Edit Seat Modal-->
    <div class="modal fade" id="editSeatModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Edit Kursi</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <form id="editSeatForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-10 px-lg-17">
                        <div class="scroll-y me-n7 pe-7" data-kt-scroll="true"
                            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_edit_seat_header"
                            data-kt-scroll-wrappers="#kt_modal_edit_seat_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Nomor Kursi</label>
                                <input type="text" class="form-control form-control-solid" name="seat_number"
                                    id="edit_seat_number" placeholder="Masukkan nomor kursi" />
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            {{-- <div class="fv-row mb-15">
                                <label class="fs-6 fw-semibold mb-2">Status</label>
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" name="is_booked"
                                        id="edit_is_booked" />
                                    <label class="form-check-label fw-semibold text-gray-400 ms-3" for="edit_is_booked">
                                        Kursi Terpesan
                                    </label>
                                </div>
                            </div> --}}
                            <!--end::Input group-->
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Edit Seat Modal-->

    <!--begin::JavaScript for Client-side Filtering and Modal Handling-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');
            let searchTimeout;

            // Auto-submit form setelah user berhenti mengetik (debounce)
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function() {
                        searchForm.submit();
                    }, 500); // Submit setelah 500ms user berhenti mengetik
                });

                // Submit juga saat Enter ditekan
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(searchTimeout);
                        searchForm.submit();
                    }
                });
            }

            // Handle edit seat modal (tetap sama)
            document.querySelectorAll('.edit-seat-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const seatId = this.getAttribute('data-id');
                    const seatNumber = this.getAttribute('data-seat-number');

                    const editForm = document.getElementById('editSeatForm');
                    if (editForm) {
                        editForm.action = '{{ route('admin.seats.update', ':id') }}'.replace(':id',
                            seatId);
                    }

                    const editSeatNumberInput = document.getElementById('edit_seat_number');
                    if (editSeatNumberInput) {
                        editSeatNumberInput.value = seatNumber;
                    }
                });
            });

            // Handle delete confirmation (tetap sama)
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Apakah Anda yakin ingin menghapus kursi ini?')) {
                        this.closest('form').submit();
                    }
                });
            });

            // Modal handling (tetap sama)
            @if (session('showCreateModal') || $errors->any())
                const createModal = new bootstrap.Modal(document.getElementById('createSeatModal'));
                createModal.show();
            @endif

            @if (session('showEditModal'))
                const editModal = new bootstrap.Modal(document.getElementById('editSeatModal'));
                editModal.show();

                @if (session('editSeatId'))
                    const editSeatId = {{ session('editSeatId') }};
                    const editForm = document.getElementById('editSeatForm');
                    if (editForm) {
                        editForm.action = '{{ route('admin.seats.update', ':id') }}'.replace(':id', editSeatId);
                    }
                @endif
            @endif
        });
    </script>
    <!--end::JavaScript-->
@endsection
