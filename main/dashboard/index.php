<?php
include '../layout/head.php';
?>
<?php include '../layout/sidebar.php'; ?>
<?php include '../layout/header.php'; ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-semibold mb-0">Dashboard</h4>
                <ol class="breadcrumb border border-info px-3 py-2 rounded">
                    <li class="breadcrumb-item">
                        <a href="index.html" class="text-muted">Dashboard</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Summary Cards Row -->
    <div class="row">

        <!-- Card Total Trips Today -->
        <div class="col-lg-3">
            <div class="card overflow-hidden">
                <div class="card-body p-4">

                    <!-- Baris 1: Judul + Icon -->
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0 small fw-medium text-muted">Total Trips Today</p>
                        <div class="bg-primary bg-opacity-10 p-2 rounded">
                            <i class="ti ti-truck text-primary fs-5"></i>
                        </div>
                    </div>

                    <!-- Baris 2: Angka + Growth -->
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h2 class="mb-0 fw-semibold">156</h2>
                        <span class="text-success fw-semibold small">
                            <i class="ti ti-arrow-up me-1"></i> +12.5%
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Card Active Vehicles -->
        <div class="col-lg-3">
            <div class="card overflow-hidden">
                <div class="card-body p-4">

                    <!-- Baris 1: Judul + Icon -->
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0 small fw-medium text-muted">Active Vehicles</p>
                        <div class="bg-success bg-opacity-10 p-2 rounded">
                            <i class="ti ti-truck-delivery text-success fs-5"></i>
                        </div>
                    </div>

                    <!-- Baris 2: Angka + Growth -->
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h2 class="mb-0 fw-semibold">42/60</h2>
                        <span class="text-success fw-semibold small">
                            <i class="ti ti-arrow-up me-1"></i> +5.2%
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Card On-Time Delivery -->
        <div class="col-lg-3">
            <div class="card overflow-hidden">
                <div class="card-body p-4">

                    <!-- Baris 1: Judul + Icon -->
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0 small fw-medium text-muted">On-Time Delivery</p>
                        <div class="p-2 rounded" style="background-color: rgba(111, 66, 193, 0.1);">
                            <i class="ti ti-clock-check fs-5" style="color: #6f42c1;"></i>
                        </div>
                    </div>

                    <!-- Baris 2: Angka + Growth -->
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h2 class="mb-0 fw-semibold">94.8%</h2>
                        <span class="text-success fw-semibold small">
                            <i class="ti ti-arrow-up me-1"></i> +2.3%
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Card Capacity Utilization -->
        <div class="col-lg-3">
            <div class="card overflow-hidden">
                <div class="card-body p-4">

                    <!-- Baris 1: Judul + Icon -->
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0 small fw-medium text-muted">Capacity Utilization</p>
                        <div class="bg-warning bg-opacity-10 p-2 rounded">
                            <i class="ti ti-chart-bar text-warning fs-5"></i>
                        </div>
                    </div>

                    <!-- Baris 2: Angka + Growth -->
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h2 class="mb-0 fw-semibold">78%</h2>
                        <span class="text-danger fw-semibold small">
                            <i class="ti ti-arrow-down me-1"></i> -3.1%
                        </span>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Optional: Add spacing for future content -->
    <div class="row mt-4">
        <div class="col-12">
            <!-- Tempat untuk konten dashboard lainnya -->
        </div>
    </div>

</div>

<?php include '../layout/footer.php'; ?>
<?php include '../layout/scripts.php'; ?>