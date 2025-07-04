<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dashboard - Event Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        :root {
            --kt-primary: #009ef7;
            --kt-success: #50cd89;
            --kt-info: #7239ea;
            --kt-warning: #ffc700;
            --kt-danger: #f1416c;
            --kt-dark: #181c32;
            --kt-light: #f5f8fa;
            --kt-gray-100: #f9f9f9;
            --kt-gray-200: #eff2f5;
            --kt-gray-300: #e4e6ea;
            --kt-gray-400: #b5b5c3;
            --kt-gray-500: #a1a5b7;
            --kt-gray-600: #7e8299;
            --kt-gray-700: #5e6278;
            --kt-gray-800: #3f4254;
            --kt-gray-900: #181c32;
            --kt-white: #ffffff;
        }

        body {
            font-family: Inter, Helvetica, sans-serif;
            background-color: var(--kt-light);
            margin: 0;
            padding: 20px;
        }

        .page-title {
            margin-bottom: 2rem;
        }

        .page-title h1 {
            color: var(--kt-gray-900);
            font-weight: 600;
            font-size: 1.75rem;
            margin: 0;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item {
            color: var(--kt-gray-500);
            font-size: 0.875rem;
        }

        .breadcrumb-item.active {
            color: var(--kt-gray-700);
        }

        /* Stats Cards */
        .stats-card {
            background: var(--kt-white);
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075);
            border: 0;
            margin-bottom: 2rem;
            transition: box-shadow 0.15s ease-in-out;
        }

        .stats-card:hover {
            box-shadow: 0 1rem 3rem 1rem rgba(0, 0, 0, 0.175);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--kt-gray-900);
            margin-bottom: 0.5rem;
        }

        .stats-label {
            color: var(--kt-gray-600);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .stats-change {
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .stats-change.positive {
            color: var(--kt-success);
        }

        .stats-change.negative {
            color: var(--kt-danger);
        }

        /* Cards */
        .card {
            background: var(--kt-white);
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075);
            border: 0;
            margin-bottom: 2rem;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--kt-gray-200);
            padding: 1.5rem 1.5rem 1rem;
        }

        .card-title {
            color: var(--kt-gray-900);
            font-weight: 600;
            font-size: 1.125rem;
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Tables */
        .table {
            margin: 0;
        }

        .table th {
            border-top: 0;
            border-bottom: 1px solid var(--kt-gray-200);
            color: var(--kt-gray-600);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 0.75rem;
        }

        .table td {
            border-top: 1px solid var(--kt-gray-200);
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        /* Badges */
        .badge {
            font-weight: 600;
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }

        .badge-success {
            background-color: rgba(80, 205, 137, 0.1);
            color: var(--kt-success);
        }

        .badge-warning {
            background-color: rgba(255, 199, 0, 0.1);
            color: var(--kt-warning);
        }

        .badge-danger {
            background-color: rgba(241, 65, 108, 0.1);
            color: var(--kt-danger);
        }

        .badge-info {
            background-color: rgba(114, 57, 234, 0.1);
            color: var(--kt-info);
        }

        /* Progress bars */
        .progress {
            height: 6px;
            background-color: var(--kt-gray-200);
            border-radius: 3px;
        }

        .progress-bar {
            border-radius: 3px;
        }

        /* Avatar */
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            background-color: var(--kt-gray-200);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--kt-gray-600);
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .stats-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .stats-number {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="page-title">
            <h1>Dashboard</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>

        <!-- Stats Cards Row -->
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stats-card">
                    <div class="stats-icon"
                        style="background: linear-gradient(135deg, var(--kt-primary) 0%, #0570de 100%);">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stats-number">{{ $totalProducts }}</div>
                    <div class="stats-label">Total Events</div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stats-card">
                    <div class="stats-icon"
                        style="background: linear-gradient(135deg, var(--kt-success) 0%, #47be7d 100%);">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="stats-number">{{ $totalTickets }}</div>
                    <div class="stats-label">Total Tickets</div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stats-card">
                    <div class="stats-icon"
                        style="background: linear-gradient(135deg, var(--kt-warning) 0%, #f1bc00 100%);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-number">{{ $totalBuyers }}</div>
                    <div class="stats-label">Total Buyers</div>
                    <div class="stats-change positive">
                        <i class="fas fa-arrow-up"></i> {{ $recentBuyers }} this month
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stats-card">
                    <div class="stats-icon"
                        style="background: linear-gradient(135deg, var(--kt-info) 0%, #6726d8 100%);">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stats-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="stats-label">Total Revenue</div>
                    <div class="stats-change positive">
                        <i class="fas fa-arrow-up"></i> Rp {{ number_format($recentRevenue, 0, ',', '.') }} this month
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Orders -->
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Orders</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Event</th>
                                        <th>Ticket Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3">
                                                        {{ strtoupper(substr($order->nama_lengkap, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $order->nama_lengkap }}</div>
                                                        <div class="text-muted small">{{ $order->no_handphone }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold">
                                                    {{ $order->ticket->product->product_name ?? 'N/A' }}</div>
                                                <div class="text-muted small">
                                                    {{ $order->ticket->product->location ?? 'N/A' }}</div>
                                            </td>
                                            <td>{{ $order->ticket->name ?? 'N/A' }}</td>
                                            <td class="fw-bold">Rp
                                                {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($order->payment_status == 'paid')
                                                    <span class="badge badge-success">Paid</span>
                                                @elseif($order->payment_status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @else
                                                    <span class="badge badge-danger">Failed</span>
                                                @endif
                                            </td>
                                            <td class="text-muted">{{ $order->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Status & Top Products -->
            <div class="col-xl-4">
                <!-- Payment Status Distribution -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Payment Status</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $total = array_sum($paymentStatusData->toArray());
                        @endphp
                        @foreach ($paymentStatusData as $status => $count)
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    @if ($status == 'paid')
                                        <div class="w-4px h-15px bg-success rounded me-3"></div>
                                        <span class="fw-semibold text-gray-800">Paid</span>
                                    @elseif($status == 'pending')
                                        <div class="w-4px h-15px bg-warning rounded me-3"></div>
                                        <span class="fw-semibold text-gray-800">Pending</span>
                                    @else
                                        <div class="w-4px h-15px bg-danger rounded me-3"></div>
                                        <span class="fw-semibold text-gray-800">Failed</span>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold">{{ $count }}</span>
                                    <span
                                        class="text-muted">({{ $total > 0 ? round(($count / $total) * 100, 1) : 0 }}%)</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Top Products -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Top Selling Events</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($topProducts as $product)
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                        {{ strtoupper(substr($product->product_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ \Str::limit($product->product_name, 20) }}</div>
                                        <div class="text-muted small">{{ $product->location }}</div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">{{ $product->total_buyers }}</div>
                                    <div class="text-muted small">sales</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Upcoming Events</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Location</th>
                                        <th>Event Date</th>
                                        <th>Available Tickets</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($upcomingEvents as $event)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3">
                                                        {{ strtoupper(substr($event->product_name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $event->product_name }}</div>
                                                        <div class="text-muted small">
                                                            {{ \Str::limit($event->product_description, 50) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $event->location }}</td>
                                            <td class="fw-bold">
                                                {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                                            <td>{{ $event->tickets->sum('qty') }} tickets</td>
                                            <td>
                                                @if (\Carbon\Carbon::parse($event->event_date)->isFuture())
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-info">Past Event</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
