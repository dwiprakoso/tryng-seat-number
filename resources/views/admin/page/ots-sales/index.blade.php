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
                        OTS Sales</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.buyer.index') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">OTS Sales</li>
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
            <!--begin::OTS Sales-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <div class="w-100 mw-150px">
                            <!--begin::Select2-->
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                data-placeholder="Payment Method" data-kt-sales-filter="payment">
                                <option></option>
                                <option value="all">All</option>
                                <option value="cash">Cash</option>
                                <option value="cashless">Cashless</option>
                            </select>
                            <!--end::Select2-->
                        </div>
                        <!--begin::Export-->
                        <a href="{{ route('admin.ots-sales.export') }}" class="btn btn-light-primary">
                            <i class="ki-outline ki-exit-up fs-2"></i>Export Excel
                        </a>
                        <!--end::Export-->
                        <!--begin::Add sale-->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_sale">Add
                            Sale</button>
                        <!--end::Add sale-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ots_sales_table">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-150px">Name</th>
                                <th class="min-w-100px">Phone</th>
                                <th class="min-w-150px">Ticket</th>
                                <th class="text-center min-w-70px">Qty</th>
                                <th class="text-end min-w-100px">Seats</th>
                                <th class="text-end min-w-100px">Total</th>
                                <th class="text-center min-w-100px">Payment</th>
                                <th class="text-center min-w-100px">Date</th>
                                <th class="text-end min-w-70px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach ($otsSales as $sale)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-800 fs-6 fw-bold">{{ $sale->nama_lengkap }}</span>
                                            <span class="text-muted fs-7">{{ $sale->external_id }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $sale->no_handphone }}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-800 fs-6 fw-bold">{{ $sale->ticket->name }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold">{{ $sale->quantity }}</span>
                                    </td>
                                    <td class="text-end pe-0">
                                        <div class="d-flex flex-wrap gap-1 justify-content-end">
                                            @foreach ($sale->bookingSeats as $booking)
                                                <span
                                                    class="badge badge-light-info fs-8">{{ $booking->seat->seat_number }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-end pe-0">
                                        <div class="d-flex flex-column align-items-end">
                                            <span class="fw-bold">Rp
                                                {{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                                            @if ($sale->admin_fee > 0)
                                                <span class="text-muted fs-8">(+Rp
                                                    {{ number_format($sale->admin_fee, 0, ',', '.') }} fee)</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge {{ $sale->payment_method === 'cash' ? 'badge-light-success' : 'badge-light-primary' }} fs-7 fw-bold">
                                            {{ ucfirst($sale->payment_method) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold">{{ $sale->created_at->format('d/m/Y H:i') }}</span>
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
                                            {{-- <div class="menu-item px-3">
                                                <a href="{{ route('verify', $sale->external_id) }}" class="menu-link px-3"
                                                    target="_blank">View Ticket</a>
                                            </div> --}}
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <form action="{{ route('admin.ots-sales.destroy', $sale->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="menu-link px-3 border-0 bg-transparent"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </div>
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
            <!--end::OTS Sales-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--begin::Modal - Add Sale-->
    <div class="modal fade" id="kt_modal_add_sale" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_sale_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add OTS Sale</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-sales-modal-action="close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Form-->
                    <form id="kt_modal_add_sale_form" class="form" action="{{ route('admin.ots-sales.store') }}"
                        method="POST">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Nama Lengkap</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan nama lengkap" name="nama_lengkap" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">No. Handphone</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder="08xxxxxxxxxx"
                                    name="no_handphone" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">Email (Opsional)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" class="form-control form-control-solid"
                                    placeholder="email@example.com" name="email" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Ticket</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="ticket_id" class="form-select form-select-solid" id="ticket_select"
                                    required>
                                    <option value="">Choose Ticket</option>
                                    @foreach ($tickets as $ticket)
                                        <option value="{{ $ticket->id }}" data-price="{{ $ticket->price }}"
                                            data-qty="{{ $ticket->qty }}">
                                            {{ $ticket->name }} (Rp {{ number_format($ticket->price, 0, ',', '.') }}) -
                                            Stock: {{ $ticket->qty }}
                                        </option>
                                    @endforeach
                                </select>
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
                                <input type="number" class="form-control form-control-solid" placeholder="1"
                                    name="quantity" id="quantity_input" min="1" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Seat Selection-->
                            <div class="fv-row mb-7" id="seat_selection_area" style="display: none;">
                                <label class="fs-6 fw-semibold mb-2">Pilih Kursi</label>
                                <div class="card bg-light-secondary">
                                    <div class="card-body p-5">
                                        <div id="seats_container" class="d-flex flex-wrap gap-2">
                                            <!-- Seats akan di-load via AJAX -->
                                        </div>
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <span class="badge badge-light-success me-2">●</span> Available
                                                <span class="badge badge-light-danger me-2 ms-3">●</span> Booked
                                                <span class="badge badge-primary me-2 ms-3">●</span> Selected
                                            </small>
                                        </div>
                                        <div class="mt-3" id="selected_seats_info" style="display: none;">
                                            <strong>Kursi terpilih:</strong>
                                            <span id="selected_seats_display"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Seat Selection-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Payment Method</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="payment_method" class="form-select form-select-solid" id="payment_method"
                                    required>
                                    <option value="">Choose Payment Method</option>
                                    <option value="cash">Cash</option>
                                    <option value="cashless">Cashless (+5% admin fee)</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!-- Hidden input untuk selected seats -->
                            <input type="hidden" name="selected_seats" id="selected_seats_input" />

                            <!--begin::Summary-->
                            <div class="fv-row mb-15" id="price_summary" style="display: none;">
                                <div class="card bg-light-primary">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span id="subtotal_display">Rp 0</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2" id="admin_fee_row"
                                            style="display: none;">
                                            <span>Admin Fee (5%):</span>
                                            <span id="admin_fee_display">Rp 0</span>
                                        </div>
                                        <div class="separator my-3"></div>
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total:</span>
                                            <span id="total_display">Rp 0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Summary-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-sales-modal-action="cancel">Discard</button>
                            <button type="submit" class="btn btn-primary" id="submit_button" disabled>
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
    <!--end::Modal - Add Sale-->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ticketSelect = document.getElementById('ticket_select');
            const quantityInput = document.getElementById('quantity_input');
            const paymentMethod = document.getElementById('payment_method');
            const priceSummary = document.getElementById('price_summary');
            const subtotalDisplay = document.getElementById('subtotal_display');
            const adminFeeDisplay = document.getElementById('admin_fee_display');
            const adminFeeRow = document.getElementById('admin_fee_row');
            const totalDisplay = document.getElementById('total_display');
            const seatSelectionArea = document.getElementById('seat_selection_area');
            const seatsContainer = document.getElementById('seats_container');
            const selectedSeatsInput = document.getElementById('selected_seats_input');
            const selectedSeatsInfo = document.getElementById('selected_seats_info');
            const selectedSeatsDisplay = document.getElementById('selected_seats_display');
            const submitButton = document.getElementById('submit_button');

            let selectedSeats = [];

            // Data tickets - cara yang lebih aman
            const ticketsRawData = {!! json_encode(
                $tickets->map(function ($ticket) {
                    return [
                        'id' => $ticket->id,
                        'name' => $ticket->name,
                        'price' => $ticket->price,
                        'qty' => $ticket->qty,
                        'seats' => $ticket->seats
                            ? $ticket->seats->map(function ($seat) {
                                return [
                                    'id' => $seat->id,
                                    'seat_number' => $seat->seat_number,
                                    'is_booked' => $seat->is_booked ?? false,
                                ];
                            })
                            : [],
                    ];
                }),
            ) !!};

            // Convert array to object dengan ticket ID sebagai key
            const ticketsData = {};
            ticketsRawData.forEach(ticket => {
                ticketsData[ticket.id] = ticket;
            });

            // Load seats (tanpa AJAX)
            function loadSeats(ticketId) {
                const ticketData = ticketsData[ticketId];

                if (!ticketData || !ticketData.seats || ticketData.seats.length === 0) {
                    seatsContainer.innerHTML = '<p class="text-danger">No seats available for this ticket.</p>';
                    return;
                }

                const seats = ticketData.seats;
                seatsContainer.innerHTML = '';

                seats.forEach(seat => {
                    const seatBtn = document.createElement('button');
                    seatBtn.type = 'button';
                    seatBtn.className = 'btn btn-sm seat-btn';
                    seatBtn.textContent = seat.seat_number;
                    seatBtn.dataset.seatId = seat.id;
                    seatBtn.dataset.seatNumber = seat.seat_number;

                    if (seat.is_booked) {
                        seatBtn.className += ' btn-light-danger';
                        seatBtn.disabled = true;
                    } else {
                        seatBtn.className += ' btn-light-success';
                        seatBtn.addEventListener('click', () => toggleSeat(seat.seat_number, seat.id));
                    }

                    seatsContainer.appendChild(seatBtn);
                });

                resetSeatSelection();
            }

            // Toggle seat selection
            function toggleSeat(seatNumber, seatId) {
                const quantity = parseInt(quantityInput.value) || 0;
                const seatData = `${seatId}:${seatNumber}`;
                const seatIndex = selectedSeats.indexOf(seatData);

                if (seatIndex > -1) {
                    selectedSeats.splice(seatIndex, 1);
                } else {
                    if (selectedSeats.length < quantity) {
                        selectedSeats.push(seatData);
                    } else {
                        alert(`Maksimal ${quantity} kursi sesuai dengan quantity tiket`);
                        return;
                    }
                }

                updateSeatButtons();
                updateSelectedSeatsDisplay();
                validateForm();
            }

            // Update seat button styles
            function updateSeatButtons() {
                document.querySelectorAll('.seat-btn').forEach(btn => {
                    const seatData = `${btn.dataset.seatId}:${btn.dataset.seatNumber}`;
                    const isSelected = selectedSeats.includes(seatData);

                    if (!btn.disabled) {
                        if (isSelected) {
                            btn.className = 'btn btn-sm seat-btn btn-primary';
                        } else {
                            btn.className = 'btn btn-sm seat-btn btn-light-success';
                        }
                    }
                });
            }

            // Update selected seats display
            function updateSelectedSeatsDisplay() {
                if (selectedSeats.length > 0) {
                    const seatNumbers = selectedSeats.map(seat => seat.split(':')[1]);
                    selectedSeatsDisplay.textContent = seatNumbers.sort().join(', ');
                    selectedSeatsInfo.style.display = 'block';
                } else {
                    selectedSeatsInfo.style.display = 'none';
                }

                // Kirim data seat IDs ke form
                const seatIds = selectedSeats.map(seat => seat.split(':')[0]);
                selectedSeatsInput.value = JSON.stringify(seatIds);
            }

            // Reset seat selection
            function resetSeatSelection() {
                selectedSeats = [];
                updateSeatButtons();
                updateSelectedSeatsDisplay();
                validateForm();
            }

            // Validate form
            function validateForm() {
                const quantity = parseInt(quantityInput.value) || 0;
                const ticketId = ticketSelect.value;
                const paymentMethodValue = paymentMethod.value;
                const namaLengkap = document.querySelector('input[name="nama_lengkap"]').value.trim();
                const noHandphone = document.querySelector('input[name="no_handphone"]').value.trim();

                const isValid = ticketId && quantity > 0 && selectedSeats.length === quantity &&
                    paymentMethodValue && namaLengkap && noHandphone;

                submitButton.disabled = !isValid;
            }

            // Calculate total
            function calculateTotal() {
                const ticketId = ticketSelect.value;
                const quantity = parseInt(quantityInput.value) || 0;
                const paymentMethodValue = paymentMethod.value;

                if (ticketId && ticketsData[ticketId] && quantity > 0) {
                    const price = ticketsData[ticketId].price;
                    const subtotal = price * quantity;
                    const adminFee = paymentMethodValue === 'cashless' ? subtotal * 0.05 : 0;
                    const total = subtotal + adminFee;

                    subtotalDisplay.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                    adminFeeDisplay.textContent = 'Rp ' + adminFee.toLocaleString('id-ID');
                    totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');

                    if (paymentMethodValue === 'cashless') {
                        adminFeeRow.style.display = 'flex';
                    } else {
                        adminFeeRow.style.display = 'none';
                    }

                    priceSummary.style.display = 'block';
                } else {
                    priceSummary.style.display = 'none';
                }
            }

            // Event listeners
            ticketSelect.addEventListener('change', function() {
                const ticketId = this.value;

                if (ticketId && ticketsData[ticketId]) {
                    const maxQty = ticketsData[ticketId].qty;
                    quantityInput.setAttribute('max', maxQty);
                    quantityInput.value = Math.min(parseInt(quantityInput.value) || 1, maxQty);

                    loadSeats(ticketId);
                    seatSelectionArea.style.display = 'block';
                } else {
                    seatSelectionArea.style.display = 'none';
                    selectedSeats = [];
                    updateSelectedSeatsDisplay();
                }

                calculateTotal();
            });

            quantityInput.addEventListener('input', function() {
                if (selectedSeats.length > parseInt(this.value)) {
                    resetSeatSelection();
                }
                calculateTotal();
                validateForm();
            });

            document.querySelector('input[name="nama_lengkap"]').addEventListener('input', validateForm);
            document.querySelector('input[name="no_handphone"]').addEventListener('input', validateForm);
            paymentMethod.addEventListener('change', function() {
                calculateTotal();
                validateForm();
            });

            // Form submission validation
            document.getElementById('kt_modal_add_sale_form').addEventListener('submit', function(e) {
                const quantity = parseInt(quantityInput.value) || 0;
                const ticketId = ticketSelect.value;

                if (!ticketId) {
                    e.preventDefault();
                    alert('Silakan pilih tiket terlebih dahulu');
                    return false;
                }

                if (selectedSeats.length !== quantity) {
                    e.preventDefault();
                    alert(`Silakan pilih ${quantity} kursi sesuai dengan quantity tiket`);
                    return false;
                }

                submitButton.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';
                submitButton.disabled = true;
            });

            // Modal reset handlers
            document.querySelectorAll('[data-kt-sales-modal-action="close"], [data-kt-sales-modal-action="cancel"]')
                .forEach(function(element) {
                    element.addEventListener('click', resetModal);
                });

            document.querySelector('button[type="reset"]').addEventListener('click', resetModal);

            function resetModal() {
                document.getElementById('kt_modal_add_sale_form').reset();
                seatSelectionArea.style.display = 'none';
                priceSummary.style.display = 'none';
                selectedSeats = [];
                updateSelectedSeatsDisplay();
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="indicator-label">Submit</span>';
                quantityInput.removeAttribute('max');
            }
        });
    </script>

    <style>
        .seat-btn {
            min-width: 50px;
            margin: 2px;
            font-size: 12px;
            font-weight: bold;
        }

        .seat-btn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        #seats_container {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
@endsection
