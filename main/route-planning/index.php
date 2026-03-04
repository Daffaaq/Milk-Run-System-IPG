<?php
require_once '../../helper/auth.php';

isLogin();
?>

<?php
include '../layout/head.php';
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

<?php include '../layout/sidebar.php'; ?>
<?php include '../layout/header.php'; ?>

<div class="container-fluid">

    <!-- Header -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-semibold mb-0">Route Planning Data</h4>
                <ol class="breadcrumb border border-info px-3 py-2 rounded">
                    <li class="breadcrumb-item">
                        <a href="../dashboard/index.php" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="active text-primary fw-semibold">Route Planning Data</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Action Bar dengan button di kanan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex flex-wrap gap-3 align-items-center justify-content-between">
                    <!-- Teks di kiri -->
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-calendar-check text-primary"></i>
                        <span class="fw-semibold">Perencanaan rute Milk Run untuk tanggal:</span>
                        <span class="badge bg-primary rounded-pill px-3 py-2" id="selectedDateDisplay">
                            <?php echo date('d F Y', strtotime(date('Y-m-d'))); ?>
                        </span>
                    </div>

                    <!-- Button dan filter di kanan -->
                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <!-- Input Date Filter -->
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-calendar text-muted"></i>
                            <input type="date" class="form-control" style="width: auto;" value="<?php echo date('Y-m-d'); ?>" id="dateFilter" onchange="updateDateDisplay(this.value)">
                        </div>

                        <!-- Button Recalculate -->
                        <button type="button" class="btn btn-warning d-flex align-items-center gap-2">
                            <i class="ti ti-refresh"></i>
                            <span>Recalculate</span>
                        </button>

                        <!-- Button Approve Status -->
                        <button type="button" class="btn btn-success d-flex align-items-center gap-2">
                            <i class="ti ti-check"></i>
                            <span>Approve Status</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <!-- Card Total Routes -->
        <div class="col">
            <div class="card overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <p class="mb-1 fs-4 text-muted">Total Routes</p>
                            <h2 class="mb-0 fw-semibold">24</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Distance -->
        <div class="col">
            <div class="card overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <p class="mb-1 fs-4 text-muted">Total Distance</p>
                            <h2 class="mb-0 fw-semibold">18</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Suppliers -->
        <div class="col">
            <div class="card overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <p class="mb-1 fs-4 text-muted">Total Suppliers</p>
                            <h2 class="mb-0 fw-semibold">156</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Weight -->
        <div class="col">
            <div class="card overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <p class="mb-1 fs-4 text-muted">Total Weight</p>
                            <h2 class="mb-0 fw-semibold">2,450</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Volume -->
        <div class="col">
            <div class="card overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <p class="mb-1 fs-4 text-muted">Total Volume</p>
                            <h2 class="mb-0 fw-semibold">125.5</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Layout 2 Kolom: Kiri Lebih Lebar (8), Kanan (4) -->
    <div class="row mt-4">
        <!-- Kolom Kiri (Lebih Lebar) - col-8 -->
        <div class="col-lg-8 col-xl-8">
            <!-- Konten Kiri: Card untuk Route Planning -->

            <!-- Card Route 1 -->
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Header Route 1 di dalam card -->
                    <h4 class="fw-semibold mb-3">Route 1</h4>

                    <!-- Status dan Distance -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 fw-semibold">
                            <i class="ti ti-circle-check me-1"></i> Feasible
                        </span>
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-road text-muted"></i>
                            <span class="fw-semibold">Distance 165 km</span>
                        </div>
                    </div>

                    <!-- Urutan Perjalanan -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="ti ti-map-pin text-primary me-2"></i>
                            <span class="fw-semibold">Urutan Perjalanan:</span>
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <!-- Plant 1 Nganjuk - Biru (Asal/Tujuan) -->
                            <span class="badge bg-primary text-white p-2">
                                <i class="ti ti-building me-1"></i> Plant 1 Nganjuk
                            </span>
                            <i class="ti ti-arrow-narrow-right text-muted"></i>

                            <!-- Gudang Cibitung - Ungu (Transit) -->
                            <span class="badge bg-secondary text-white p-2" style="background-color: #6f42c1 !important;">
                                <i class="ti ti-warehouse me-1"></i> Gudang Cibitung
                            </span>
                            <i class="ti ti-arrow-narrow-right text-muted"></i>

                            <!-- PT Nisseieco Indonesia - Kuning dengan bintang (Prioritas) -->
                            <span class="badge bg-warning text-dark p-2">
                                <i class="ti ti-star-filled me-1" style="color: #FFD700;"></i> PT Nisseieco Indonesia
                            </span>
                            <i class="ti ti-arrow-narrow-right text-muted"></i>

                            <!-- Plant 1 Nganjuk - Biru (Asal/Tujuan) -->
                            <span class="badge bg-primary text-white p-2">
                                <i class="ti ti-building me-1"></i> Plant 1 Nganjuk
                            </span>
                        </div>
                    </div>

                    <!-- Kapasitas Berat dan Volume -->
                    <div class="row g-3">
                        <!-- Kapasitas Berat -->
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="ti ti-weight text-warning"></i>
                                    <span class="fw-semibold">Kapasitas Berat</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted">520 / 26000 kg</span>
                                    <span class="text-success fw-semibold">(2%)</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: 2%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Kapasitas Volume -->
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="ti ti-box text-info"></i>
                                    <span class="fw-semibold">Kapasitas Volume</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted">15.80 / 53 m³</span>
                                    <span class="text-primary fw-semibold">(30%)</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary" style="width: 30%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lihat Detail Supplier - Memicu Modal -->
                    <div class="mt-3 text-end">
                        <a href="#" class="text-primary text-decoration-none fw-semibold" data-bs-toggle="modal" data-bs-target="#detailSupplierModal1">
                            Lihat Detail Supplier <i class="ti ti-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan (Lebih Kecil) - col-4 -->
        <div class="col-lg-4 col-xl-4">
            <!-- Card Konfigurasi Rute -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <i class="ti ti-settings text-primary fs-5 me-2"></i>
                        <h5 class="fw-semibold mb-0">Konfigurasi Rute</h5>
                    </div>

                    <!-- Informasi Konfigurasi -->
                    <div class="mb-4">
                        <!-- Titik Asal -->
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="bg-primary bg-opacity-10 p-2 rounded">
                                <i class="ti ti-building text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-1">Titik Asal</p>
                                <div class="d-flex align-items-center gap-2" style="color: black;">
                                    <span>Plant 1 Nganjuk</span>
                                </div>
                                <small class="text-primary">Muatan: Finish Good</small>
                            </div>
                        </div>

                        <!-- Titik Transit -->
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="bg-secondary bg-opacity-10 p-2 rounded" style="color: #6f42c1;">
                                <i class="ti ti-building-warehouse" style="color: #6f42c1;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-1">Titik Transit</p>
                                <div class="d-flex flex-wrap align-items-center gap-2" style="color: black;">
                                    <span>Gudang Cibitung</span>
                                </div>
                                <small style="color: #6f42c1;">Muatan: Polybox</small>
                            </div>
                        </div>

                        <!-- Total Supplier -->
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="bg-warning bg-opacity-10 p-2 rounded">
                                <i class="ti ti-users text-warning"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-1">Total Supplier</p>
                                <div class="d-flex align-items-center">
                                    <h3 class="mb-0 me-2">1</h3>
                                </div>
                                <small class="text-success">Muatan: Raw Material (dari WMS)</small>
                            </div>
                        </div>

                        <!-- Total Jarak -->
                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-info bg-opacity-10 p-2 rounded">
                                <i class="ti ti-road text-info"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-1">Total Jarak</p>
                                <div class="d-flex align-items-center">
                                    <h3 class="mb-0 fw-semibold me-2">165</h3>
                                    <span class="text-muted">kilometer</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Card Route Map dengan Leaflet -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-map-2 text-primary"></i>
                            <h5 class="fw-semibold mb-0">Route Map</h5>
                        </div>
                        <span class="badge bg-light text-dark">
                            <i class="ti ti-current-location me-1"></i> Live Tracking
                        </span>
                    </div>

                    <!-- Container untuk Leaflet Map -->
                    <div id="routeMap" style="height: 300px; width: 100%; border-radius: 8px; z-index: 1;"></div>

                </div>
            </div>

            <!-- Card untuk Button Actions -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                        <!-- Button Lihat Peta Detail -->
                        <button type="button" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2 py-3" onclick="openDetailMap()">
                            <i class="ti ti-map-search fs-5"></i>
                            <span class="fw-semibold">Lihat Peta Detail</span>
                            <i class="ti ti-external-link ms-auto"></i>
                        </button>

                        <!-- Divider -->
                        <div class="position-relative my-2">
                            <hr class="text-muted">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">atau</span>
                        </div>

                        <!-- Button Export Route Plan -->
                        <button type="button" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 py-3" onclick="exportRoutePlan()">
                            <i class="ti ti-file-export fs-5"></i>
                            <span class="fw-semibold">Export Route Plan</span>
                            <i class="ti ti-chevron-down ms-auto"></i>
                        </button>

                        <!-- Opsi Export tambahan (dropdown sederhana) -->
                        <div class="btn-group w-100" role="group">
                            <button type="button" class="btn btn-outline-secondary" onclick="exportAs('pdf')">
                                <i class="ti ti-file-pdf me-1"></i> PDF
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="exportAs('excel')">
                                <i class="ti ti-file-spreadsheet me-1"></i> Excel
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="exportAs('image')">
                                <i class="ti ti-photo me-1"></i> Image
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- MODAL DETAIL SUPPLIER - ROUTE 1 (SEDERHANA) -->
<div class="modal fade" id="detailSupplierModal1" tabindex="-1" aria-labelledby="detailSupplierModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold" id="detailSupplierModal1Label">
                    <i class="ti ti-building me-2 text-primary"></i>
                    Detail Supplier - Route 1
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Daftar Supplier dalam Rute -->

                <!-- Supplier 1: PT Nisseieco Indonesia (Prioritas) -->
                <div class="mb-4 p-3 border rounded <?php echo 'border-warning'; ?>">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-semibold mb-0">
                            <i class="ti ti-star-filled me-1" style="color: #FFD700;"></i>
                            PT Nisseieco Indonesia
                        </h6>
                        <span class="badge bg-warning text-dark">Prioritas</span>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <small class="text-muted d-block">Muatan</small>
                            <span class="fw-semibold">Raw Material</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Berat</small>
                            <span class="fw-semibold">520 kg</span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <small class="text-muted d-block">Volume</small>
                            <span class="fw-semibold">15.80 m³</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL MAP - ROUTE 1 -->
<div class="modal fade" id="detailMapModal" tabindex="-1" aria-labelledby="detailMapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" id="detailMapModalLabel">
                    <i class="ti ti-map-2 text-primary me-2"></i>
                    Detail Route Map - Route 1
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Container untuk Map Detail -->
                <div id="detailRouteMap" style="height: 500px; width: 100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="exportAs('image')">
                    <i class="ti ti-photo me-1"></i> Export Map
                </button>
            </div>
        </div>
    </div>
</div>


<?php include '../layout/footer.php'; ?>
<?php include '../layout/scripts.php'; ?>

<script>
    function updateDateDisplay(dateValue) {
        if (dateValue) {
            const date = new Date(dateValue);
            const options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            const formattedDate = date.toLocaleDateString('id-ID', options);
            document.getElementById('selectedDateDisplay').textContent = formattedDate;
        }
    }

    let map, routingControl;

    function initRouteMap() {
        // Koordinat dummy untuk rute
        const startPoint = [-7.5995, 111.9075]; // Plant Nganjuk
        const transitPoint = [-6.2088, 106.8456]; // Gudang Cibitung
        const supplierPoint = [-6.2008, 106.8526]; // PT Nisseieco Indonesia (sekitar Cibitung)

        // Inisialisasi map
        map = L.map('routeMap').setView(startPoint, 10);

        // Tambah tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Routing control dengan waypoints
        routingControl = L.Routing.control({
            waypoints: [
                L.latLng(startPoint[0], startPoint[1]),
                L.latLng(transitPoint[0], transitPoint[1]),
                L.latLng(supplierPoint[0], supplierPoint[1]),
                L.latLng(startPoint[0], startPoint[1])
            ],
            routeWhileDragging: false,
            showAlternatives: false,
            fitSelectedRoutes: true,
            lineOptions: {
                styles: [{
                    color: '#5D87FF',
                    opacity: 0.8,
                    weight: 5
                }]
            },
            // Kustomisasi ikon untuk waypoints
            createMarker: function(i, wp, nWps) {
                let markerIcon = L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-' +
                        (i === 0 ? 'blue' : i === 1 ? 'violet' : i === 2 ? 'gold' : 'blue') + '.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                let popupContent = '';
                if (i === 0) popupContent = '<b>Plant 1 Nganjuk</b><br>Asal & Tujuan Akhir';
                else if (i === 1) popupContent = '<b>Gudang Cibitung</b><br>Titik Transit';
                else if (i === 2) popupContent = '<b>PT Nisseieco Indonesia</b><br>Supplier Prioritas';

                return L.marker(wp.latLng, {
                    icon: markerIcon
                }).bindPopup(popupContent);
            }
        }).addTo(map);

        // Event listener ketika route ditemukan
        routingControl.on('routesfound', function(e) {
            const routes = e.routes;
            const summary = routes[0].summary;

            // Update informasi di card jika diperlukan
            console.log('Total distance: ' + (summary.totalDistance / 1000).toFixed(2) + ' km');
            console.log('Total time: ' + (summary.totalTime / 3600).toFixed(2) + ' hours');
        });
    }

    // Fungsi untuk membuka peta detail dalam modal
    function openDetailMap() {
        // Buka modal detail map
        const detailModal = new bootstrap.Modal(document.getElementById('detailMapModal'));
        detailModal.show();

        // Tunggu modal tampil sempurna
        setTimeout(function() {
            initDetailMap();
        }, 500);
    }

    // Inisialisasi detail map
    // Inisialisasi detail map
    function initDetailMap() {
        // Cek apakah elemen map sudah ada
        const mapElement = document.getElementById('detailRouteMap');
        if (!mapElement) return;

        // Bersihkan konten sebelumnya
        mapElement.innerHTML = '';

        // Koordinat untuk rute
        const startPoint = [-7.5995, 111.9075]; // Plant Nganjuk
        const transitPoint = [-6.2088, 106.8456]; // Gudang Cibitung
        const supplierPoint = [-6.2008, 106.8526]; // PT Nisseieco Indonesia

        // Buat map baru dengan view yang lebih luas
        const detailMap = L.map('detailRouteMap').setView([-6.5, 109.5], 7);

        // Tambah tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(detailMap);

        // ========== SEGMEN 1: Plant Nganjuk ke Gudang Cibitung ==========
        L.Routing.control({
            waypoints: [
                L.latLng(startPoint[0], startPoint[1]),
                L.latLng(transitPoint[0], transitPoint[1])
            ],
            routeWhileDragging: false,
            showAlternatives: false,
            fitSelectedRoutes: false, // Jangan auto-fit biar tidak bentrok
            show: false,
            lineOptions: {
                styles: [{
                    color: '#FF6B6B', // Merah coral
                    opacity: 0.9,
                    weight: 6
                }]
            },
            router: L.Routing.osrmv1({
                serviceUrl: 'https://router.project-osrm.org/route/v1',
                profile: 'driving',
                timeout: 10000
            }),
            createMarker: function() {
                return null;
            } // Tidak buat marker
        }).addTo(detailMap);

        // ========== SEGMEN 2: Gudang Cibitung ke PT Nisseieco ==========
        L.Routing.control({
            waypoints: [
                L.latLng(transitPoint[0], transitPoint[1]),
                L.latLng(supplierPoint[0], supplierPoint[1])
            ],
            routeWhileDragging: false,
            showAlternatives: false,
            fitSelectedRoutes: false,
            show: false,
            lineOptions: {
                styles: [{
                    color: '#4ECDC4', // Turquoise
                    opacity: 0.9,
                    weight: 6
                }]
            },
            router: L.Routing.osrmv1({
                serviceUrl: 'https://router.project-osrm.org/route/v1',
                profile: 'driving',
                timeout: 10000
            }),
            createMarker: function() {
                return null;
            }
        }).addTo(detailMap);

        // ========== SEGMEN 3: PT Nisseieco kembali ke Plant Nganjuk ==========
        L.Routing.control({
            waypoints: [
                L.latLng(supplierPoint[0], supplierPoint[1]),
                L.latLng(startPoint[0], startPoint[1])
            ],
            routeWhileDragging: false,
            showAlternatives: false,
            fitSelectedRoutes: false,
            show: false,
            lineOptions: {
                styles: [{
                    color: '#FFD93D', // Kuning cerah
                    opacity: 0.9,
                    weight: 6
                }]
            },
            router: L.Routing.osrmv1({
                serviceUrl: 'https://router.project-osrm.org/route/v1',
                profile: 'driving',
                timeout: 10000
            }),
            createMarker: function() {
                return null;
            }
        }).addTo(detailMap);

        // ========== MARKER TETAP DENGAN ROUTING CONTROL ==========
        // Marker Plant (Start/End) - Biru
        L.marker(startPoint, {
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [30, 50],
                iconAnchor: [15, 50],
                popupAnchor: [1, -40],
                shadowSize: [50, 50]
            })
        }).bindPopup('<b>🏭 Plant 1 Nganjuk</b><br>Asal & Tujuan Akhir<br>Berangkat: 07:00 WIB | Tiba: 12:00 WIB').addTo(detailMap);

        // Marker Transit - Ungu
        L.marker(transitPoint, {
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [30, 50],
                iconAnchor: [15, 50],
                popupAnchor: [1, -40],
                shadowSize: [50, 50]
            })
        }).bindPopup('<b>🏢 Gudang Cibitung</b><br>Titik Transit<br>Estimasi tiba: 08:30 WIB<br>Muatan: Polybox').addTo(detailMap);

        // Marker Supplier - Emas
        L.marker(supplierPoint, {
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [30, 50],
                iconAnchor: [15, 50],
                popupAnchor: [1, -40],
                shadowSize: [50, 50]
            })
        }).bindPopup('<b>⭐ PT Nisseieco Indonesia</b><br>Supplier Prioritas<br>Estimasi tiba: 10:30 WIB<br>Muatan: 520 kg').addTo(detailMap);

        // ========== TAMBAHKAN LEGENDA ==========
        const legend = L.control({
            position: 'bottomleft'
        });

        legend.onAdd = function() {
            const div = L.DomUtil.create('div', 'info legend');
            div.style.backgroundColor = 'white';
            div.style.padding = '10px';
            div.style.borderRadius = '5px';
            div.style.boxShadow = '0 0 10px rgba(0,0,0,0.2)';
            div.style.border = '2px solid #ddd';
            div.innerHTML = `
            <div style="font-weight: bold; margin-bottom: 8px; font-size: 14px;">🗺️ LEGENDA RUTE</div>
            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                <div style="width: 25px; height: 6px; background: #FF6B6B; margin-right: 8px; border-radius: 3px;"></div>
                <span style="font-size: 12px;">Segmen 1: Plant → Transit (280 km)</span>
            </div>
            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                <div style="width: 25px; height: 6px; background: #4ECDC4; margin-right: 8px; border-radius: 3px;"></div>
                <span style="font-size: 12px;">Segmen 2: Transit → Supplier (15 km)</span>
            </div>
            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                <div style="width: 25px; height: 6px; background: #FFD93D; margin-right: 8px; border-radius: 3px;"></div>
                <span style="font-size: 12px;">Segmen 3: Supplier → Plant (295 km)</span>
            </div>
            <hr style="margin: 5px 0; border-color: #eee;">
            <div style="display: flex; align-items: center; margin-top: 5px;">
                <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png" width="15" style="margin-right: 8px;">
                <span style="font-size: 12px;">Plant Nganjuk</span>
            </div>
            <div style="display: flex; align-items: center;">
                <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png" width="15" style="margin-right: 8px;">
                <span style="font-size: 12px;">Gudang Cibitung</span>
            </div>
            <div style="display: flex; align-items: center;">
                <img src="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png" width="15" style="margin-right: 8px;">
                <span style="font-size: 12px;">PT Nisseieco</span>
            </div>
        `;
            return div;
        };

        legend.addTo(detailMap);

        // ========== TAMBAHKAN INFO TOTAL ==========
        const totalInfo = L.control({
            position: 'topright'
        });

        totalInfo.onAdd = function() {
            const div = L.DomUtil.create('div', 'info total');
            div.style.backgroundColor = 'white';
            div.style.padding = '12px 15px';
            div.style.borderRadius = '8px';
            div.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            div.style.border = '2px solid #5D87FF';
            div.style.fontWeight = 'bold';
            div.innerHTML = `
            <div style="font-size: 14px; margin-bottom: 8px; color: #5D87FF;">📊 RINGKASAN RUTE</div>
            <div style="display: flex; justify-content: space-between; gap: 20px;">
                <div>
                    <div style="font-size: 12px; color: #666;">Total Jarak</div>
                    <div style="font-size: 18px; color: #FF6B6B;">590 km</div>
                </div>
                <div>
                    <div style="font-size: 12px; color: #666;">Estimasi Waktu</div>
                    <div style="font-size: 18px; color: #4ECDC4;">5 Jam</div>
                </div>
                <div>
                    <div style="font-size: 12px; color: #666;">Supplier</div>
                    <div style="font-size: 18px; color: #FFD93D;">1</div>
                </div>
            </div>
        `;
            return div;
        };

        totalInfo.addTo(detailMap);

        // Tambah kontrol skala
        L.control.scale({
            imperial: false,
            metric: true,
            position: 'bottomright',
            maxWidth: 200
        }).addTo(detailMap);

        // Force resize map
        setTimeout(() => {
            detailMap.invalidateSize();
        }, 200);

        // Simpan ke window
        window.detailMap = detailMap;
    }

    // Fungsi export route plan
    function exportRoutePlan() {
        // Implementasi export
        Swal.fire({
            title: 'Export Route Plan',
            text: 'Pilih format export yang diinginkan',
            icon: 'info',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'PDF',
            denyButtonText: 'Excel',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                exportAs('pdf');
            } else if (result.isDenied) {
                exportAs('excel');
            }
        });
    }

    function exportAs(format) {
        // Simulasi export berdasarkan format
        let message = '';
        let icon = 'success';

        switch (format) {
            case 'pdf':
                message = 'Route Plan berhasil diexport sebagai PDF';
                break;
            case 'excel':
                message = 'Route Plan berhasil diexport sebagai Excel';
                break;
            case 'image':
                message = 'Route Map berhasil diexport sebagai Image';
                break;
            default:
                message = 'Export berhasil';
        }

        // Tampilkan notifikasi (gunakan Swal atau toast)
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Berhasil!',
                text: message,
                icon: icon,
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            alert(message);
        }
    }

    // Simple Chart JS - Anda perlu memasukkan library Chart.js di head atau footer
    // Ini hanya contoh, pastikan Chart.js sudah di-load
    document.addEventListener('DOMContentLoaded', function() {
        initRouteMap();

        // Event listener untuk modal hidden
        const detailMapModal = document.getElementById('detailMapModal');
        if (detailMapModal) {
            detailMapModal.addEventListener('hidden.bs.modal', function() {
                // Destroy map jika ada
                if (window.detailMap) {
                    window.detailMap.remove();
                    window.detailMap = null;
                }

                // Bersihkan container
                const mapElement = document.getElementById('detailRouteMap');
                if (mapElement) {
                    mapElement.innerHTML = '';
                }

                console.log('Modal ditutup, map di-destroy');
            });
        }

        const ctx = document.getElementById('routeChart');
        if (ctx) {
            // Jika menggunakan Chart.js
            // new Chart(ctx, {
            //     type: 'doughnut',
            //     data: {
            //         labels: ['Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Bekasi'],
            //         datasets: [{
            //             data: [8, 5, 4, 4, 3],
            //             backgroundColor: [
            //                 '#5D87FF',
            //                 '#49BEFF',
            //                 '#FFAE1F',
            //                 '#FA896B',
            //                 '#13DEB9'
            //             ],
            //             borderWidth: 0
            //         }]
            //     },
            //     options: {
            //         responsive: true,
            //         maintainAspectRatio: false,
            //         plugins: {
            //             legend: {
            //                 display: false
            //             }
            //         }
            //     }
            // });
        }
    });
</script>