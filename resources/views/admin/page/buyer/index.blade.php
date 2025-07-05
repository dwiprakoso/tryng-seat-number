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
                        Pembeli</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Pembeli</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        {{-- <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li> --}}
                        <!--end::Item-->
                        <!--begin::Item-->
                        {{-- <li class="breadcrumb-item text-muted">Catalog</li> --}}
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
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                            <input type="text" data-kt-ecommerce-product-filter="search"
                                class="form-control form-control-solid w-250px ps-12" placeholder="Search Product" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                    <a href="{{ route('admin.buyer.export') }}" class="btn btn-light-primary">
                        <i class="ki-outline ki-exit-down fs-2 me-2"></i>
                        Export Excel
                    </a>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="text-start min-w-50px">No</th>
                                <th class="text-start min-w-200px">ID Pesanan</th>
                                <th class="text-start min-w-200px">Nama</th>
                                <th class="text-start min-w-70px">No Hp</th>
                                <th class="text-start min-w-100px">Email</th>
                                <th class="text-start min-w-100px">Kategori Tiket</th>
                                <th class="text-start min-w-100px">Jumlah</th>
                                <th class="text-start min-w-100px">Status</th>
                                <th class="text-start min-w-70px">Waktu Pemesanan</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach ($buyers as $buyer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $buyer->external_id }}</td>
                                    <td>{{ $buyer->nama_lengkap }}</td>
                                    <td>{{ $buyer->no_handphone }}</td>
                                    <td>{{ $buyer->email }}</td>
                                    <td>{{ $buyer->ticket->name }}</td>
                                    <td>{{ $buyer->quantity }}</td>
                                    <td>{{ $buyer->payment_status }}</td>
                                    <td>{{ $buyer->created_at->translatedFormat('l, d F Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
