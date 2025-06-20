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
                        Discounts</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Discounts</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
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
            <!--begin::Discounts-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                            <input type="text" data-kt-ecommerce-product-filter="search"
                                class="form-control form-control-solid w-250px ps-12" placeholder="Search Discount" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <div class="w-100 mw-150px">
                            <!--begin::Select2-->
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                data-placeholder="Status" data-kt-discount-filter="status">
                                <option></option>
                                <option value="all">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <!--end::Select2-->
                        </div>
                        <!--begin::Add discount-->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_discount">Add
                            Discount</button>
                        <!--end::Add discount-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_discounts_table">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-200px">Name</th>
                                <th class="text-start min-w-70px">Qty</th>
                                <th class="text-end min-w-100px">Price</th>
                                <th class="text-end min-w-100px">Ticket Category</th>
                                <th class="text-end min-w-100px">Status</th>
                                <th class="text-end min-w-70px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach ($discounts as $discount)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="ms-5">
                                                <!--begin::Title-->
                                                <span class="text-gray-800 fs-5 fw-bold">{{ $discount->name }}</span>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $discount->qty }}</span>
                                    </td>
                                    <td class="text-end pe-0">
                                        <span class="fw-bold">Rp {{ number_format($discount->price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-end pe-0">
                                        <span class="fw-bold">{{ $discount->ticket->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-end pe-0">
                                        @if ($discount->status == 'active')
                                            <span class="badge badge-light-success">Active</span>
                                        @else
                                            <span class="badge badge-light-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="#"
                                            class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                            <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3"
                                                    onclick="editDiscount({{ $discount->id }}, '{{ $discount->name }}', {{ $discount->qty }}, {{ $discount->price }}, {{ $discount->ticket_id }}, '{{ $discount->status }}')">Edit</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            {{-- <div class="menu-item px-3">
                                                <form action="{{ route('admin.discounts.destroy', $discount->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="menu-link px-3 border-0 bg-transparent"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </div> --}}
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Discounts-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--begin::Modal - Add Discount-->
    <div class="modal fade" id="kt_modal_add_discount" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_discount_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add Discount</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-discounts-modal-action="close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Form-->
                    <form id="kt_modal_add_discount_form" class="form" action="{{ route('admin.discounts.store') }}"
                        method="POST">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Discount Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder="" name="name"
                                    required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Quantity</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid" placeholder=""
                                    name="qty" min="1" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Price</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid" placeholder=""
                                    name="price" min="0" step="0.01" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Ticket Category</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="ticket_id" class="form-select form-select-solid" required>
                                    <option value="">Choose Ticket Category</option>
                                    @foreach ($tickets as $ticket)
                                        <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-15">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">Status</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="status" class="form-select form-select-solid" required>
                                    <option value="">Choose Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-discounts-modal-action="cancel">Discard</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add Discount-->

    <!--begin::Modal - Edit Discount-->
    <div class="modal fade" id="kt_modal_edit_discount" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Edit Discount</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Form-->
                    <form id="kt_modal_edit_discount_form" class="form" method="POST">
                        @csrf
                        @method('PUT')
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Discount Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="name"
                                    id="edit_name" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Quantity</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid" name="qty"
                                    id="edit_qty" min="1" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Price</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid" name="price"
                                    id="edit_price" min="0" step="0.01" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Ticket Category</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="ticket_id" class="form-select form-select-solid" id="edit_ticket_id"
                                    required>
                                    <option value="">Choose Ticket Category</option>
                                    @foreach ($tickets as $ticket)
                                        <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-15">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">Status</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="status" class="form-select form-select-solid" id="edit_status" required>
                                    <option value="">Choose Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Update</span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Edit Discount-->

    <script>
        function editDiscount(id, name, qty, price, ticketId, status) {
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_qty').value = qty;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_ticket_id').value = ticketId;
            document.getElementById('edit_status').value = status;

            // Set the form action to match the update route
            document.getElementById('kt_modal_edit_discount_form').action = '{{ route('admin.discounts.update', '') }}/' +
                id;

            var editModal = new bootstrap.Modal(document.getElementById('kt_modal_edit_discount'));
            editModal.show();
        }

        // Close modal handlers
        document.querySelectorAll('[data-kt-discounts-modal-action="close"]').forEach(function(element) {
            element.addEventListener('click', function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById('kt_modal_add_discount'));
                modal.hide();
            });
        });

        document.querySelectorAll('[data-kt-discounts-modal-action="cancel"]').forEach(function(element) {
            element.addEventListener('click', function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById('kt_modal_add_discount'));
                modal.hide();
            });
        });
    </script>
@endsection
