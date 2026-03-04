<?php
require_once '../../helper/auth.php';

isLogin();
?>

<?php include '../layout/head.php'; ?>

<!-- ApexCharts CSS dan JS -->
<link href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<?php include '../layout/sidebar.php'; ?>
<?php include '../layout/header.php'; ?>

<div class="container-fluid">

    <!-- Header -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-semibold mb-0">Report & Analytics</h4>
                <ol class="breadcrumb border border-info px-3 py-2 rounded">
                    <li class="breadcrumb-item">
                        <a href="../dashboard/index.php" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="active text-primary fw-semibold">Report & Analytics</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="row">
        <div class="col-12">
            <!-- Filter Card -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Filter Report</h5>

                    <div class="row g-3 align-items-end">
                        <!-- Date From -->
                        <div class="col-md-3">
                            <label for="dateFrom" class="form-label">Date From</label>
                            <input type="date" class="form-control" id="dateFrom" name="dateFrom">
                        </div>

                        <!-- Date To -->
                        <div class="col-md-3">
                            <label for="dateTo" class="form-label">Date To</label>
                            <input type="date" class="form-control" id="dateTo" name="dateTo">
                        </div>

                        <!-- Vehicle Dropdown -->
                        <div class="col-md-3">
                            <label for="vehicleSelect" class="form-label">Vehicle</label>
                            <select class="form-select select2" id="vehicleSelect" name="vehicle">
                                <option value="">Select Vehicle</option>
                                <option value="1">Vehicle 1 - B 1234 ABC</option>
                                <option value="2">Vehicle 2 - B 5678 DEF</option>
                                <option value="3">Vehicle 3 - B 9012 GHI</option>
                                <option value="4">Vehicle 4 - B 3456 JKL</option>
                                <option value="5">Vehicle 5 - B 7890 MNO</option>
                            </select>
                        </div>

                        <!-- Route Dropdown -->
                        <div class="col-md-3">
                            <label for="routeSelect" class="form-label">Route</label>
                            <select class="form-select select2" id="routeSelect" name="route">
                                <option value="">Select Route</option>
                                <option value="1">Jakarta - Bandung</option>
                                <option value="2">Jakarta - Surabaya</option>
                                <option value="3">Bandung - Yogyakarta</option>
                                <option value="4">Surabaya - Bali</option>
                                <option value="5">Jakarta - Yogyakarta</option>
                                <option value="6">Bandung - Surabaya</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mt-4">
        <!-- Total Trips -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-2 bg-primary bg-opacity-10 p-3">
                            <i class="ti ti-truck text-primary fs-6"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-normal text-muted">Total Trips</h6>
                            <h3 class="mb-0 fw-semibold">1,234</h3>
                            <div class="d-flex align-items-center mt-1">
                                <span class="badge bg-success-subtle text-success rounded-pill d-inline-flex align-items-center">
                                    <i class="ti ti-arrow-up fs-3 me-1"></i>+2.5%
                                </span>
                                <span class="text-muted fs-2 ms-2">vs Last Period</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Distance -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-2 bg-info bg-opacity-10 p-3">
                            <i class="ti ti-road text-info fs-6"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-normal text-muted">Total Distance</h6>
                            <h3 class="mb-0 fw-semibold">45,678 km</h3>
                            <div class="d-flex align-items-center mt-1">
                                <span class="badge bg-success-subtle text-success rounded-pill d-inline-flex align-items-center">
                                    <i class="ti ti-arrow-up fs-3 me-1"></i>+3.2%
                                </span>
                                <span class="text-muted fs-2 ms-2">vs Last Period</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Cost -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-2 bg-danger bg-opacity-10 p-3">
                            <i class="ti ti-currency-dollar text-danger fs-6"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-normal text-muted">Total Cost</h6>
                            <h3 class="mb-0 fw-semibold">$12,345</h3>
                            <div class="d-flex align-items-center mt-1">
                                <span class="badge bg-danger-subtle text-danger rounded-pill d-inline-flex align-items-center">
                                    <i class="ti ti-arrow-down fs-3 me-1"></i>-1.8%
                                </span>
                                <span class="text-muted fs-2 ms-2">vs Last Period</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Avg Cost/km -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-2 bg-warning bg-opacity-10 p-3">
                            <i class="ti ti-chart-line text-warning fs-6"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-normal text-muted">Avg Cost/km</h6>
                            <h3 class="mb-0 fw-semibold">$0.27</h3>
                            <div class="d-flex align-items-center mt-1">
                                <span class="badge bg-success-subtle text-success rounded-pill d-inline-flex align-items-center">
                                    <i class="ti ti-arrow-up fs-3 me-1"></i>+0.5%
                                </span>
                                <span class="text-muted fs-2 ms-2">vs Last Period</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- On-Time Delivery -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-2 bg-success bg-opacity-10 p-3">
                            <i class="ti ti-clock text-success fs-6"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-normal text-muted">On-Time Delivery</h6>
                            <h3 class="mb-0 fw-semibold">98.5%</h3>
                            <div class="d-flex align-items-center mt-1">
                                <span class="badge bg-success-subtle text-success rounded-pill d-inline-flex align-items-center">
                                    <i class="ti ti-arrow-up fs-3 me-1"></i>+1.2%
                                </span>
                                <span class="text-muted fs-2 ms-2">vs Last Period</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Avg Utilization -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-2 bg-secondary bg-opacity-10 p-3">
                            <i class="ti ti-percentage text-secondary fs-6"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-normal text-muted">Avg Utilization</h6>
                            <h3 class="mb-0 fw-semibold">76.3%</h3>
                            <div class="d-flex align-items-center mt-1">
                                <span class="badge bg-danger-subtle text-danger rounded-pill d-inline-flex align-items-center">
                                    <i class="ti ti-arrow-down fs-3 me-1"></i>-4.2%
                                </span>
                                <span class="text-muted fs-2 ms-2">vs Last Period</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mt-4">
        <!-- Cost per Route (Bar Chart) -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cost per Route (IDR x1000)</h5>
                    <div id="costPerRouteChart"></div>
                </div>
            </div>
        </div>

        <!-- Distance per Day (Line Chart) - 7 Hari -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Distance per Day (km)</h5>
                    <div id="distancePerDayChart"></div>
                </div>
            </div>
        </div>

        <!-- Vehicle Utilization (Bar Chart) -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Vehicle Utilization (%)</h5>
                    <div id="vehicleUtilizationChart"></div>
                </div>
            </div>
        </div>

        <!-- On-Time Performance (Pie Chart) -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">On-Time Performance</h5>
                    <div id="onTimePerformanceChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Route Report Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Detailed Route Report</h5>

                    <div class="table-responsive">
                        <table id="routeReportTable" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Route</th>
                                    <th>Distance (km)</th>
                                    <th>Cost (IDR)</th>
                                    <th>Cost/km</th>
                                    <th>Trips</th>
                                    <th>Avg Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Jakarta - Bandung</td>
                                    <td>150</td>
                                    <td>Rp 1,250,000</td>
                                    <td>Rp 8,333</td>
                                    <td>245</td>
                                    <td>2.5 jam</td>
                                </tr>
                                <tr>
                                    <td>Jakarta - Surabaya</td>
                                    <td>780</td>
                                    <td>Rp 2,100,000</td>
                                    <td>Rp 2,692</td>
                                    <td>189</td>
                                    <td>10.5 jam</td>
                                </tr>
                                <tr>
                                    <td>Bandung - Yogyakarta</td>
                                    <td>420</td>
                                    <td>Rp 1,750,000</td>
                                    <td>Rp 4,167</td>
                                    <td>156</td>
                                    <td>6.0 jam</td>
                                </tr>
                                <tr>
                                    <td>Surabaya - Bali</td>
                                    <td>320</td>
                                    <td>Rp 3,200,000</td>
                                    <td>Rp 10,000</td>
                                    <td>312</td>
                                    <td>5.5 jam</td>
                                </tr>
                                <tr>
                                    <td>Jakarta - Yogyakarta</td>
                                    <td>540</td>
                                    <td>Rp 2,800,000</td>
                                    <td>Rp 5,185</td>
                                    <td>278</td>
                                    <td>8.0 jam</td>
                                </tr>
                                <tr>
                                    <td>Bandung - Surabaya</td>
                                    <td>580</td>
                                    <td>Rp 1,950,000</td>
                                    <td>Rp 3,362</td>
                                    <td>167</td>
                                    <td>8.5 jam</td>
                                </tr>
                                <tr>
                                    <td>Medan - Pekanbaru</td>
                                    <td>420</td>
                                    <td>Rp 1,850,000</td>
                                    <td>Rp 4,405</td>
                                    <td>98</td>
                                    <td>7.0 jam</td>
                                </tr>
                                <tr>
                                    <td>Makassar - Pare-pare</td>
                                    <td>155</td>
                                    <td>Rp 950,000</td>
                                    <td>Rp 6,129</td>
                                    <td>145</td>
                                    <td>3.0 jam</td>
                                </tr>
                                <tr>
                                    <td>Palembang - Lampung</td>
                                    <td>280</td>
                                    <td>Rp 1,450,000</td>
                                    <td>Rp 5,179</td>
                                    <td>176</td>
                                    <td>4.5 jam</td>
                                </tr>
                                <tr>
                                    <td>Bali - Lombok</td>
                                    <td>150</td>
                                    <td>Rp 2,100,000</td>
                                    <td>Rp 14,000</td>
                                    <td>203</td>
                                    <td>3.5 jam</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include '../layout/footer.php'; ?>
<?php include '../layout/scripts.php'; ?>

<!-- DataTables JS -->

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- SCRIPT UNTUK FUNGSIONALITAS TAMBAHAN -->
<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%',
        });

        // Set default date values (opsional)
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        var firstDay = yyyy + '-' + mm + '-01';
        var todayFormatted = yyyy + '-' + mm + '-' + dd;

        // Set default dates (dari awal bulan sampai hari ini)
        $('#dateFrom').val(firstDay);
        $('#dateTo').val(todayFormatted);

        // Handle apply filter button click
        $('.btn-primary').click(function() {
            var dateFrom = $('#dateFrom').val();
            var dateTo = $('#dateTo').val();
            var vehicle = $('#vehicleSelect').val();
            var route = $('#routeSelect').val();

            console.log('Filter Applied:', {
                dateFrom: dateFrom,
                dateTo: dateTo,
                vehicle: vehicle,
                route: route
            });

            alert('Filter applied!\nDate From: ' + dateFrom + '\nDate To: ' + dateTo +
                '\nVehicle: ' + (vehicle ? $('#vehicleSelect option:selected').text() : 'All') +
                '\nRoute: ' + (route ? $('#routeSelect option:selected').text() : 'All'));
        });

        // Handle reset button click
        $('.btn-outline-secondary').click(function() {
            $('#dateFrom').val(firstDay);
            $('#dateTo').val(todayFormatted);
            $('#vehicleSelect').val('').trigger('change');
            $('#routeSelect').val('').trigger('change');

            console.log('Filter Reset');
        });

        // Initialize DataTable
        $('#routeReportTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            order: [
                [0, 'asc']
            ],
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Semua"]
            ]
        });

        // Initialize Charts
        initCharts();
    });

    function initCharts() {
        // 1. Cost per Route - Bar Chart
        var costPerRouteOptions = {
            series: [{
                name: 'Cost (IDR x1000)',
                data: [1250, 2100, 1750, 3200, 2800, 1950]
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: '55%',
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['Jakarta-Bandung', 'Jakarta-Surabaya', 'Bandung-Yogyakarta', 'Surabaya-Bali', 'Jakarta-Yogyakarta', 'Bandung-Surabaya'],
                labels: {
                    rotate: -45,
                    trim: true,
                    maxHeight: 120
                }
            },
            yaxis: {
                title: {
                    text: 'Cost (IDR x1000)'
                }
            },
            colors: ['#5D87FF'],
            grid: {
                borderColor: '#f1f1f1'
            }
        };

        var costPerRouteChart = new ApexCharts(document.querySelector("#costPerRouteChart"), costPerRouteOptions);
        costPerRouteChart.render();

        // 2. Distance per Day - Line Chart (7 Hari - Senin sampai Minggu)
        var distancePerDayOptions = {
            series: [{
                name: 'Distance (km)',
                data: [456, 389, 512, 478, 543, 601, 432]
            }],
            chart: {
                type: 'line',
                height: 300,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 4,
                colors: ['#49BEFF']
            },
            xaxis: {
                categories: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                title: {
                    text: 'Hari'
                }
            },
            yaxis: {
                title: {
                    text: 'Distance (km)'
                },
                min: 300,
                max: 700
            },
            markers: {
                size: 6,
                colors: ['#49BEFF'],
                strokeColors: '#fff',
                strokeWidth: 3,
                hover: {
                    size: 8
                }
            },
            grid: {
                borderColor: '#f1f1f1',
                padding: {
                    top: 30
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + ' km'
                    }
                }
            }
        };

        var distancePerDayChart = new ApexCharts(document.querySelector("#distancePerDayChart"), distancePerDayOptions);
        distancePerDayChart.render();

        // 3. Vehicle Utilization - Bar Chart
        var vehicleUtilizationOptions = {
            series: [{
                name: 'Utilization %',
                data: [78, 92, 65, 88, 71, 84, 76, 69, 82, 73]
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    barHeight: '55%',
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['TRK001', 'TRK002', 'TRK003', 'TRK004', 'TRK005', 'TRK006', 'TRK007', 'TRK008', 'TRK009', 'TRK0010'],
                title: {
                    text: 'Utilization %'
                },
                max: 100
            },
            yaxis: {
                title: {
                    text: 'Vehicle'
                }
            },
            colors: ['#FFAE1F'],
            grid: {
                borderColor: '#f1f1f1'
            }
        };

        var vehicleUtilizationChart = new ApexCharts(document.querySelector("#vehicleUtilizationChart"), vehicleUtilizationOptions);
        vehicleUtilizationChart.render();

        // 4. On-Time Performance - Pie Chart
        var onTimePerformanceOptions = {
            series: [94.5, 3.2],
            chart: {
                type: 'pie',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            labels: ['On Time (94.5%)', 'Delayed (3.2%)'],
            colors: ['#13DEB9', '#FA896B'],
            legend: {
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            dataLabels: {
                enabled: false
            }
        };

        var onTimePerformanceChart = new ApexCharts(document.querySelector("#onTimePerformanceChart"), onTimePerformanceOptions);
        onTimePerformanceChart.render();
    }
</script>

<!-- Tambahkan CSS untuk membuat placeholder Select2 di tengah dan value di kiri -->
<style>
    /* Menyesuaikan tinggi Select2 dengan Bootstrap */
    .select2-container--bootstrap-5 .select2-selection {
        min-height: 38px;
        border: 1px solid #ced4da !important;
    }

    /* Styling untuk cards */
    .badge.bg-success-subtle {
        background-color: #e8f5e9 !important;
        color: #2e7d32 !important;
    }

    .badge.bg-danger-subtle {
        background-color: #ffebee !important;
        color: #c62828 !important;
    }

    .badge .ti {
        font-size: 14px;
    }

    /* Hover effect untuk cards */
    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* Styling untuk charts container */
    #costPerRouteChart,
    #distancePerDayChart,
    #vehicleUtilizationChart,
    #onTimePerformanceChart {
        min-height: 300px;
        width: 100%;
    }
</style>