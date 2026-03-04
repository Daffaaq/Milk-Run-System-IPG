<?php
include '../layout/head.php';
?>

<?php include '../layout/sidebar.php'; ?>
<?php include '../layout/header.php'; ?>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<!-- Leaflet Routing Machine CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />

<style>
    /* Tambahkan di dalam <style> */
    .card {
        border: 1px solid rgba(0, 0, 0, 0.08) !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03) !important;
        transition: all 0.2s ease;
    }

    .card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08) !important;
        border-color: rgba(0, 0, 0, 0.15) !important;
    }

    /* Untuk statistics cards */
    .row.mt-4 .card {
        border: 1px solid #edf2f7 !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
    }

    /* Untuk right column cards */
    .col-md-4 .card {
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04) !important;
    }

    /* Untuk tracking card */
    .col-md-8 .card {
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04) !important;
    }

    /* Leaflet Map Container */
    #trackingMap {
        height: 700px;
        border-radius: 16px;
        z-index: 1;
        border: 1px solid #e2e8f0;
    }

    /* Live Indicator with Animation */
    .live-dot {
        width: 8px;
        height: 8px;
        background: #22c55e;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
        position: relative;
        animation: pulse-live 1.5s ease-in-out infinite;
    }

    @keyframes pulse-live {
        0% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        }

        50% {
            box-shadow: 0 0 0 6px rgba(34, 197, 94, 0.3);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
        }
    }

    .strikethrough {
        text-decoration: line-through;
        text-decoration-color: #9ca3af;
        opacity: 0.7;
    }

    .timeline-checkbox:checked {
        accent-color: #10b981;
    }

    .bg-secondary.bg-opacity-10 {
        background-color: rgba(108, 117, 125, 0.1) !important;
    }

    /* Leaflet Popup Custom */
    .leaflet-popup-content {
        font-family: inherit;
        font-size: 12px;
        font-weight: 500;
        margin: 10px;
    }

    .leaflet-popup-content .text-danger {
        color: #ef4444;
        font-weight: 600;
    }

    .delay-badge {
        background-color: #fee2e2;
        color: #dc2626;
        padding: 2px 8px;
        border-radius: 9999px;
        font-size: 10px;
        font-weight: 600;
        display: inline-block;
        margin-top: 4px;
    }

    /* Styling untuk panel routing */
    .leaflet-routing-container {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        font-size: 12px;
        max-height: 400px;
        overflow-y: auto;
        margin: 10px !important;
        width: 280px;
        transition: opacity 0.3s ease;
    }

    .leaflet-routing-container.hidden {
        display: none !important;
    }

    .leaflet-routing-container h3 {
        font-size: 13px;
        font-weight: 600;
        margin: 10px 0 5px 0;
        padding: 5px 0;
        border-bottom: 1px solid #eee;
    }

    .leaflet-routing-alternatives-container {
        margin-top: 10px;
    }

    .leaflet-routing-instruction {
        padding: 4px 0;
        font-size: 11px;
        border-bottom: 1px dashed #f0f0f0;
    }

    .leaflet-routing-geocoder {
        display: none;
    }

    .leaflet-routing-summary {
        background: #f8f9fa;
        padding: 8px;
        border-radius: 4px;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .leaflet-routing-collapse-btn {
        cursor: pointer;
        width: 26px;
        height: 26px;
        background: white;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        z-index: 1001;
        position: relative;
    }

    .leaflet-routing-collapse-btn:hover {
        background: #f0f0f0;
    }

    .leaflet-routing-collapse-btn:after {
        content: "✕";
        font-size: 14px;
        font-weight: bold;
        color: #666;
    }

    /* Style untuk tombol show routing di pojok kiri bawah */
    #showRoutingBtn {
        position: absolute;
        bottom: 20px;
        left: 20px;
        z-index: 1000;
        background: #4361ee;
        padding: 14px 28px;
        border-radius: 50px;
        box-shadow: 0 10px 25px rgba(67, 97, 238, 0.4);
        cursor: pointer;
        font-family: Arial, sans-serif;
        font-size: 16px;
        font-weight: 600;
        border: none;
        display: none;
        transition: all 0.3s ease;
        color: white;
        align-items: center;
        gap: 10px;
        letter-spacing: 0.5px;
    }

    #showRoutingBtn:hover {
        background: #3a56d4;
        box-shadow: 0 15px 30px rgba(67, 97, 238, 0.5);
        transform: translateY(-3px) scale(1.02);
    }

    #showRoutingBtn.visible {
        display: flex !important;
    }

    #showRoutingBtn i {
        font-size: 20px;
    }

    /* Animasi untuk tombol */
    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-8px);
        }
    }

    #showRoutingBtn.visible {
        animation: bounce 2s infinite ease-in-out;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-semibold mb-0">Tracking & Monitoring</h4>
                <ol class="breadcrumb border px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item">
                        <a href="index.html" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="active text-primary fw-semibold">Tracking & Monitoring</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mt-4">
        <!-- Active Trip Card -->
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card shadow-sm border-0" id="card-active-trip">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 p-3 bg-primary bg-opacity-10">
                            <i class="ti ti-truck text-primary fs-6"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-1">Active Trip</h6>
                            <h3 class="mb-0 fw-bold" id="active-trip-count">24</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- On Time Card -->
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card shadow-sm border-0" id="card-on-time">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 p-3 bg-success bg-opacity-10">
                            <i class="ti ti-clock-check text-success fs-6"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-1">On Time</h6>
                            <h3 class="mb-0 fw-bold" id="on-time-count">156</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delayed Card -->
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card shadow-sm border-0" id="card-delayed">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 p-3 bg-danger bg-opacity-10">
                            <i class="ti ti-clock-exclamation text-danger fs-6"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-1">Delayed</h6>
                            <h3 class="mb-0 fw-bold" id="delayed-count">8</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Today Card -->
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card shadow-sm border-0" id="card-completed">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 p-3 bg-info bg-opacity-10">
                            <i class="ti ti-circle-check text-info fs-6"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-1">Completed Today</h6>
                            <h3 class="mb-0 fw-bold" id="completed-count">42</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Vehicle Tracking Card -->
    <div class="row mt-2">
        <!-- Left Column - Live Vehicle Tracking dengan Leaflet -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-semibold mb-0">Live Vehicle Tracking</h5>
                        <div class="text-muted">
                            <span class="live-dot"></span> Live
                        </div>
                    </div>

                    <!-- Leaflet Map Container -->
                    <div id="trackingMap"></div>
                </div>
            </div>
        </div>

        <!-- Right Column - Trip Details -->
        <div class="col-md-4">
            <!-- RT 001 -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <!-- Trip Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-semibold mb-1">RT-001</h5>
                            <p class="text-muted mb-0">TRK-001 • John Doe</p>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                            At Supplier
                        </span>
                    </div>

                    <!-- Supplier Info -->
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="ti ti-building-warehouse text-muted me-2"></i>
                            <span class="fw-semibold">PT Supplier Beta</span>
                        </div>
                        <div class="d-flex align-items-center text-muted">
                            <i class="ti ti-clock me-2"></i>
                            <span>ETA: 11:30</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Progress</span>
                            <span class="fw-semibold small">60%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="timeline-steps">
                        <!-- Plant -->
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="plantCheck001" checked onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="plantCheck001" class="fw-semibold timeline-label" id="label-plant001">Plant</label>
                                    <span class="text-muted timeline-time" id="time-plant001">08:00</span>
                                </div>
                            </div>
                        </div>

                        <!-- PT Supplier Alpha -->
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="alphaCheck001" checked onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="alphaCheck001" class="fw-semibold timeline-label" id="label-alpha001">PT Supplier Alpha</label>
                                    <span class="text-muted timeline-time" id="time-alpha001">09:15</span>
                                </div>
                            </div>
                        </div>

                        <!-- PT Supplier Beta (Current) -->
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="betaCheck001" onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="betaCheck001" class="fw-semibold timeline-label" id="label-beta001">PT Supplier Beta</label>
                                    <span class="text-muted timeline-time" id="time-beta001">10:30</span>
                                </div>
                            </div>
                        </div>

                        <!-- PT Supplier Gamma (Upcoming) -->
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="gammaCheck001" onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="gammaCheck001" class="text-muted timeline-label" id="label-gamma001">PT Supplier Gamma</label>
                                </div>
                            </div>
                        </div>

                        <!-- Plant Return (Upcoming) -->
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="returnCheck001" onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="returnCheck001" class="text-muted timeline-label" id="label-return001">Plant Return</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RT 002 -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <!-- Trip Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-semibold mb-1">RT-002</h5>
                            <p class="text-muted mb-0">TRK-002 • Jane Smith</p>
                        </div>
                        <span class="badge bg-secondary bg-opacity-10 text-dark px-3 py-2 rounded-pill">
                            On The Way
                        </span>
                    </div>

                    <!-- Supplier Info -->
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="ti ti-building-warehouse text-muted me-2"></i>
                            <span class="fw-semibold">En route to CV Supplier Delta</span>
                        </div>
                        <div class="d-flex align-items-center text-muted">
                            <i class="ti ti-clock me-2"></i>
                            <span>ETA: 12:00</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Progress</span>
                            <span class="fw-semibold small">40%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="timeline-steps">
                        <!-- Plant -->
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="plantCheck002" checked onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="plantCheck002" class="fw-semibold timeline-label" id="label-plant002">Plant</label>
                                    <span class="text-muted timeline-time" id="time-plant002">09:00</span>
                                </div>
                            </div>
                        </div>

                        <!-- PT Supplier Epsilon -->
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="epsilonCheck002" checked onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="epsilonCheck002" class="fw-semibold timeline-label" id="label-epsilon002">PT Supplier Epsilon</label>
                                    <span class="text-muted timeline-time" id="time-epsilon002">10:15</span>
                                </div>
                            </div>
                        </div>

                        <!-- CV Supplier Delta (Current) -->
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="deltaCheck002" onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="deltaCheck002" class="fw-semibold timeline-label" id="label-delta002">CV Supplier Delta</label>
                                </div>
                            </div>
                        </div>

                        <!-- Plant Return (Upcoming) -->
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="returnCheck002" onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="returnCheck002" class="text-muted timeline-label" id="label-return002">Plant Return</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RT 005 -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <!-- Trip Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-semibold mb-1">RT-005</h5>
                            <p class="text-muted mb-0">TRK-005 • David Browne</p>
                        </div>
                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                            Delayed
                        </span>
                    </div>

                    <!-- Supplier Info -->
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="ti ti-building-warehouse text-muted me-2"></i>
                            <span class="fw-semibold">PT Supplier Zeta</span>
                        </div>
                        <div class="d-flex align-items-center text-muted">
                            <i class="ti ti-clock me-2"></i>
                            <span>ETA: 14:30</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Progress</span>
                            <span class="fw-semibold small">25%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="timeline-steps">
                        <!-- Plant -->
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="plantCheck005" checked onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="plantCheck005" class="fw-semibold timeline-label" id="label-plant005">Plant</label>
                                    <span class="text-muted timeline-time" id="time-plant005">08:30</span>
                                </div>
                            </div>
                        </div>

                        <!-- PT Supplier Zeta (Current) -->
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="zetaCheck005" onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="zetaCheck005" class="fw-semibold timeline-label" id="label-zeta005">PT Supplier Zeta</label>
                                    <span class="text-muted timeline-time" id="time-zeta005">10:45</span>
                                </div>
                            </div>
                        </div>

                        <!-- CV Supplier Eta (Upcoming) -->
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="etaCheck005" onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="etaCheck005" class="fw-semibold timeline-label" id="label-eta005">CV Supplier Eta</label>
                                </div>
                            </div>
                        </div>

                        <!-- Plant Return (Upcoming) -->
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <input class="form-check-input timeline-checkbox" type="checkbox" value="" id="returnCheck005" onchange="toggleStrikethrough(this)">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <label for="returnCheck005" class="text-muted timeline-label" id="label-return005">Plant Return</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Delayed Warning - Dibawah Timeline -->
                    <div class="mt-4">
                        <div class="d-flex align-items-center p-2 bg-danger bg-opacity-10 rounded-3">
                            <i class="ti ti-alert-triangle-filled text-danger me-2" style="font-size: 18px;"></i>
                            <span class="text-danger fw-semibold small">Vehicle delayed at current location</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Leaflet Routing Machine JS -->
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

<script>
    // Function toggle strikethrough
    function toggleStrikethrough(checkbox) {
        const itemDiv = checkbox.closest('.d-flex.align-items-start');
        const label = itemDiv.querySelector('.timeline-label');
        const time = itemDiv.querySelector('.timeline-time');

        if (checkbox.checked) {
            label.classList.add('strikethrough');
            if (time) time.classList.add('strikethrough');
        } else {
            label.classList.remove('strikethrough');
            if (time) time.classList.remove('strikethrough');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Set strikethrough untuk checkbox yang sudah checked
        const checkboxes = document.querySelectorAll('.timeline-checkbox:checked');
        checkboxes.forEach(checkbox => {
            toggleStrikethrough(checkbox);
        });

        // ==================== KOORDINAT ====================
        const plantCoord = [-7.606533515531824, 112.06820773523405];
        const hulaneCoord = [-6.30921126957323, 107.18010495246256];
        const ewindoCoord = [-6.948674529117419, 107.80151601187984];
        const supplierDeltaCoord = [-6.32039568554594, 107.07143722210316];

        const coords = [plantCoord, hulaneCoord, ewindoCoord, supplierDeltaCoord];
        const colors = ['red', 'violet', 'yellow', 'green'];
        const names = ['🏭 PLANT', '🏭 PT Hulane', '🏭 PT EWINDO', '🏢 Final Supplier'];

        // ==================== INIT MAP ====================
        const map = L.map('trackingMap').setView([-7.2, 109.5], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // ==================== MARKER CUSTOM ====================
        coords.forEach((coord, i) => {
            L.marker(coord, {
                icon: L.icon({
                    iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${colors[i]}.png`,
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41]
                })
            }).addTo(map).bindPopup(`<b>${names[i]}</b>`);
        });

        // ==================== ROUTING ====================
        const routingControl = L.Routing.control({
            waypoints: coords.map(c => L.latLng(c[0], c[1])),
            routeWhileDragging: true,
            addWaypoints: false,
            createMarker: () => null,
            showAlternatives: false,
            lineOptions: {
                styles: [{
                    color: 'blue',
                    opacity: 0.7,
                    weight: 4
                }]
            }
        }).addTo(map);

        // ==================== TOMBOL SHOW ROUTE - VERSION FINAL ====================

        // Buat tombol
        const mapContainer = map.getContainer();
        const showBtn = L.DomUtil.create('div', '', mapContainer);
        showBtn.id = 'showRoutingBtn';
        showBtn.innerHTML = '<i>🗺️</i> Tampilkan Panel Rute';
        mapContainer.appendChild(showBtn);

        // Variable untuk tracking status
        let isPanelVisible = true;

        // Fungsi untuk update tombol
        function updateButtonVisibility() {
            const routingContainer = document.querySelector('.leaflet-routing-container');

            if (!routingContainer) return;

            const isHidden = routingContainer.style.display === 'none' ||
                window.getComputedStyle(routingContainer).display === 'none';

            if (isHidden && isPanelVisible) {
                isPanelVisible = false;
                showBtn.classList.add('visible');
            } else if (!isHidden && !isPanelVisible) {
                isPanelVisible = true;
                showBtn.classList.remove('visible');
            }
        }

        // Biarin tombol close asli jalan sendiri, kita cuma pantau perubahannya
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    updateButtonVisibility();
                }
            });
        });

        // Mulai observasi setelah routing container muncul
        routingControl.on('routesfound', function() {
            setTimeout(() => {
                const routingContainer = document.querySelector('.leaflet-routing-container');
                if (routingContainer) {
                    observer.observe(routingContainer, {
                        attributes: true,
                        attributeFilter: ['style']
                    });
                }
                updateButtonVisibility();
            }, 1000);
        });

        // Klik tombol show untuk menampilkan panel
        showBtn.addEventListener('click', function() {
            const routingContainer = document.querySelector('.leaflet-routing-container');
            if (routingContainer) {
                routingContainer.style.display = 'block';
                this.classList.remove('visible');
                isPanelVisible = true;
            }
        });

        // Cek status setiap 1 detik sebagai backup
        setInterval(updateButtonVisibility, 1000);

        // Route segment warna
        routingControl.on('routesfound', function(e) {
            const route = e.routes[0];

            // Hapus polyline sebelumnya
            map.eachLayer(function(layer) {
                if (layer instanceof L.Polyline && layer.options.color) {
                    if (layer.options.color.startsWith('#')) {
                        map.removeLayer(layer);
                    }
                }
            });

            // Tambah polyline warna-warni
            const colors = ['#4361ee', '#f72585', '#7209b7'];

            for (let i = 0; i < route.coordinates.length - 1; i++) {
                const colorIndex = Math.floor((i / (route.coordinates.length - 1)) * colors.length);
                L.polyline([route.coordinates[i], route.coordinates[i + 1]], {
                    color: colors[colorIndex],
                    weight: 5,
                    opacity: 0.9
                }).addTo(map);
            }
        });

        // Auto resize map
        setTimeout(() => {
            map.invalidateSize();
        }, 500);
    });
</script>

<?php include '../layout/footer.php'; ?>
<?php include '../layout/scripts.php'; ?>