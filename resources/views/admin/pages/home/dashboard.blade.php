@extends('admin.layouts.master')

@section('title', settings('app_title') ? settings('app_title') : 'POS')

@push('styles')
    <style>
        .background-primary {
            background: #4ACE8B !important;
        }

        .card .card-body {
            padding: 0 1.25rem 1.25rem;
        }

        .table td {
            font-size: 0.875rem;
        }
        .table th,
        .table td {
            line-height: 0;
            font-weight: 500;
        }
        .br-15 {
            border-radius: 15px;
        }
        .admin-dashboard-card-design {
            cursor: pointer;
            border-radius: 20px;
            box-shadow: 3px 4px 8px #0d9953d4;
            transition: all 0.5s;
        }
        .admin-dashboard-card-design:hover {
            background: transparent;
            transform: translateY(-2%);
            box-shadow: 0px 0px 10px #00000099, inset 0px 0px 15px #0d9953;
        }
        .input-group {
            position: relative;
            .date-icon {
                z-index: 3;
                color: #fff;
                top: 0.85rem;
                right: 0.65rem;
                cursor: pointer;
                position: absolute;
            }
        }
        .title-border {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        ::placeholder {
            color: #fff !important;
            opacity: 0.6 !important;
        }

        .stretch-card {
            width: 18%;
        }
        .card-1 {
            background-color: #f0e7f99c;
        }
        .card-2 {
            background-color: #e8f9e787;
        }
        .card-3 {
            background-color: #f9f7e7a1;
        }
        .card-4 {
            background-color: #f9e7e7ad;
        }
        .card-5 {
            background-color: #e7f9f38a;
        }
        .dashboard-icon {
            font-size: 5rem;
        }
        .sale-icon i {
            color:#69b061;
        }
        .collection-icon i {
            color:#50acaa;
        }
        .due-icon i {
            color:#d4b20a;
        }
        .expense-icon i {
            color:#c04e4e;
        }
        .customer-icon i {
            color:#0bb287;
        }
        .badge-dashboard {
            background: #fff;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: 600;
        }
        .border-success {
            border: 1px solid var(--success);
        }
        .border-danger {
            border: 1px solid var(--danger);
        }
        .dateRange {
            color: white;
            border-radius: 8px !important; 
            background: #4ACE8B; 
        }
        .active {
            background-color: #089d51;
            border-color: #089d51;
        }

        /* =============  Responsive ===========*/
        @media (max-width: 1380px) {
            .card-title{
                font-size: 1rem;
            }
            .price-title{
                font-size: 1rem;
            } 
            .dashboard-icon{
                font-size: 3rem;
            }   
        }
        @media (max-width: 992px) {
            .stretch-card {
                width: 49.5%;
            }
        }
        @media (max-width: 768px) {
            .stretch-card {
                width: 100%;
            }
        }
        @media (max-width: 576px) {
            .card-title{
                font-size: 1rem;
            }
            .price-title{
                font-size: 1rem;
            } 
            .dashboard-icon{
                font-size: 3rem;
            } 
        }

    </style>
@endpush

@section('content')

    <div class="content-wrapper">
        <div class="content-header">

            <div class="row">
                <div class="col-xxl-6 col-lg-6 col-md-3 d-block mb-2">
                    <h4 class="content-title text-blod" style="font-size: 20px; font-weight:900;">DASHBOARD </h4>
                </div>

                <div class="col-xxl-6 col-lg-6 col-md-9 text-right">

                    <div class="row">
                        <div class="col-xxl-6 col-lg-7 col-md-7 d-flex justify-content-between mb-2">
                            <form class="mobile-res">
                                <button type="submit" class="btn btn2-secondary {{ $filterDate['today'] == 1 ? 'active' : '' }}">
                                    <input type="hidden" name="today" value="1">
                                    Today
                                </button>
                            </form>

                            <form class="mobile-res">
                                <button type="submit" class="btn btn2-secondary {{ $filterDate['this_month'] == 1 ? 'active' : '' }}">
                                    <input type="hidden" name="this_month" value="1">
                                    This Month
                                </button>
                            </form>

                            <form class="mobile-res">
                                <button type="submit" class="btn btn2-secondary {{ $filterDate['last_month'] == 1 ? 'active' : '' }}">
                                    <input type="hidden" name="last_month" value="1">
                                    Last Month
                                </button>
                            </form>
                        </div>

                        <form enctype='multipart/form-data' id='dateForm'>
                            <div class="form-group">
                                <input type="hidden" name="from" value="">
                                <input type="hidden" name="to" value="">
                            </div>
                        </form>

                        <form class="col-xxl-6 col-md-5">
                            <div class="input-group with-icon">
                                <input type="text" name="date_range" class="form-control dateRange {{ $date_range ? 'active' : '' }}" id="daterangepicker" value="{{ $date_range }}"
                                placeholder="{{ settings('date_format') }} - {{ settings('date_format') }}" />
                                <i class="date-icon fa-solid fa-calendar-days"></i>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div class="row d-flex ml-1 mr-1 justify-content-between">

            <div class="stretch-card">
                <div class="card admin-dashboard-card-design mt-2 mb-2 card-1" style="cursor: default !important">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Sales</p>
                                <h3 class="price-title">{{ $totalSales }}</h3>
                                {{-- <h4 class="badge badge-dashboard text-success mt-2 border-success">
                                    <i class="fa-solid fa-sort-up"></i> 15.78%
                                </h4> --}}
                            </div>
                            <div class="dashboard-icon sale-icon">
                                <i class="fa-solid fa-cart-arrow-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="stretch-card">
                <div class="card admin-dashboard-card-design mt-2 mb-2 card-2" style="cursor: default !important">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Collections</p>
                                <h3 class="price-title">{{ $totalCollection }}</h3>
                                {{-- <h4 class="badge badge-dashboard text-danger mt-2 border-danger">
                                    <i class="fa-solid fa-sort-down"></i> -19.07%
                                </h4> --}}
                            </div>
                            <div class="dashboard-icon collection-icon">
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="stretch-card">
                <div class="card admin-dashboard-card-design mt-2 mb-2 card-3" style="cursor: default !important">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Dues</p>
                                <h3 class="price-title">{{ $totalDue }}</h3>
                            </div>
                            <div class="dashboard-icon due-icon">
                                <i class="fa-solid fa-money-check-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="stretch-card">
                <div class="card admin-dashboard-card-design mt-2 mb-2 card-4" style="cursor: default !important">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Expenses</p>
                                <h3 class="price-title">{{ $totalExpense }}</h3>
                            </div>
                            <div class="dashboard-icon expense-icon">
                                <i class="fa-solid fa-circle-dollar-to-slot"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="stretch-card">
                <div class="card admin-dashboard-card-design mt-2 mb-2 card-5">
                    <a style="text-decoration: none; color: #1F1F1F" href="{{ url('/customers') }}" class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <p class="card-title">Customers</p>
                                <h3 class="price-title">{{ $totalCustomer }}</h3>
                            </div>
                            <div class="dashboard-icon customer-icon">
                                <i class="fa-solid fa-people-group"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        {{-- All Charts --}}
        {{-- <div class="row">
            <div class="col-lg-12 col-md-12 stretch-card mt-4">
                <div class="card admin-dashboard-card-design mt-2 mb-2">
                    <div class="client-card-title d-block text-center text-white background-primary pb-3 title-border">
                        <span><b>POS Analytics Chart</b></span>
                    </div>
                    <div class="p-4">
                        <div id="columnchart_material" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
@stop

@include('admin.assets.chart')
@include('admin.assets.date-range-picker')


@push('scripts')

    @vite('resources/admin_assets/js/pages/home/dashboard.js')

    <script type="text/javascript">

        // Start Date Range picker & submit from
        $(function() {
            var options = {};
            options.opens = 'left',
            options.locale = {
                format: inputDateFormat,
                separator: ' - ',
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
                firstDay: 1
            }

            $('#daterangepicker').daterangepicker(options, function(start, end, label) {
                $('#dateForm').find('input[name="from"]').val(start.format('YYYY-MM-DD'));
                $('#dateForm').find('input[name="to"]').val(end.format('YYYY-MM-DD'));

                $('#dateForm').submit();
            });

            // Date range value clear
            // $('#daterangepicker').val("");
            $('#daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
                $('#daterangepicker').val("");
            });

        });
        // End Date Range picker


        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Purchase', 'Sales', 'Collection'],

                @php
                    // $currentMonth = now()->addMonth()->format('m');
                    $currentMonth = now()->format('m');
                    $currentYear = now()->format('Y');

                @endphp

                @foreach ($orderCharts as $index => $val)
                    [
                        @foreach ($monthsArray as $key => $month )
                            @if ($key == $index)
                                @if ($index > $currentMonth) '{{ $month }}, {{ $currentYear - 1 }}',
                                @else '{{ $month }}, {{ $currentYear }}',
                                @endif
                            @endif
                        @endforeach
                        @foreach ($val as $i => $v)
                            {{ $v }},
                        @endforeach
                    ],
                @endforeach

                // ['Jan', 1000, 400, 200],
                // ['Feb', 1170, 460, 250],
                // ['Mar', 660, 1120, 300],
                // ['Apr', 1030, 540, 350],
                // ['May', 1030, 540, 350],
                // ['Jun', 1030, 540, 350],
                // ['Jul', 1030, 540, 350],
                // ['Aug', 1030, 540, 350],
                // ['Sep', 1030, 540, 350],
                // ['Oct', 1030, 540, 350],
                // ['Nov', 1030, 540, 350],
                // ['Dec', 1030, 540, 350],
            ]);

            var options = {
                chart: {
                    title: 'Company Performance',
                    subtitle: 'Purchase, Sales & Collection: Last 12 Months',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }


    </script>
@endpush
