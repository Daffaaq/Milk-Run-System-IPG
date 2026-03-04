<?php
include '../layout/head.php';
?>

<?php include '../layout/sidebar.php'; ?>
<?php include '../layout/header.php'; ?>

<!-- CSS tambahan -->
<style>
    /* Menyesuaikan tinggi Select2 dengan Bootstrap */
    .select2-container--bootstrap-5 .select2-selection {
        min-height: 38px;
        border: 1px solid #ced4da !important;
    }

    /* Card dengan border lebih jelas */
    .card {
        border: 1px solid #e0e4e9 !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        border-radius: 12px;
    }

    /* Header card biar lebih jelas */
    .card-title {
        font-weight: 600;
        color: #1e293b;
        border-bottom: 1px solid #edf2f7;
        padding-bottom: 0.75rem;
        margin-bottom: 1.25rem !important;
    }

    /* Styling untuk alert */
    .alert-danger {
        color: #b91c1c;
        border: 1px solid #fecaca;
        border-radius: 0.375rem;
        background-color: #fef2f2;
    }

    /* Garis pembatas lebih jelas */
    hr {
        opacity: 0.3;
        margin: 1.25rem 0;
        border: 0;
        border-top: 1px solid #e2e8f0;
    }

    /* Styling untuk icon */
    .icon-map-pin,
    .icon-truck {
        font-size: 1.2rem;
        vertical-align: middle;
    }

    /* Label di atas input */
    .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.4rem;
        display: block;
        font-size: 0.9rem;
    }

    /* Input styling */
    .form-control,
    .form-select {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Mengurangi jarak antar form group */
    .form-group {
        margin-bottom: 1.25rem;
    }

    /* Text kecil untuk keterangan */
    .text-muted-small {
        font-size: 0.8rem;
        margin-top: 0.3rem;
        color: #64748b;
    }

    /* Styling untuk summary card */
    .summary-card {
        border: 1px solid #e0e4e9 !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        background-color: #ffffff;
        min-height: 380px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .summary-placeholder {
        text-align: center;
        color: #94a3b8;
    }

    .summary-placeholder i {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
    }

    .summary-placeholder p {
        font-size: 1rem;
        margin-bottom: 0.25rem;
        color: #64748b;
    }

    .summary-placeholder .small {
        font-size: 0.85rem;
        color: #94a3b8;
    }

    /* Memperkecil jarak dalam card */
    .card-body {
        padding: 1.5rem;
    }

    /* Border container */
    .container-fluid {
        background-color: #f8fafc;
        min-height: 100vh;
        padding-bottom: 20px;
    }

    /* Force hide alert dengan important */
    #alertPeringatan {
        display: none !important;
    }

    #alertPeringatan.show-alert {
        display: flex !important;
    }

    #alertPeringatan.hide-alert {
        display: none !important;
    }

    /* Card muatan transit hidden by default */
    #cardMuatanTransit {
        display: none;
    }

    #cardMuatanTransit.show-card {
        display: block;
    }

    /* Toggle Switch styling */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: .3s;
        border-radius: 24px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    input:checked+.toggle-slider {
        background-color: #3b82f6;
    }

    input:checked+.toggle-slider:before {
        transform: translateX(20px);
    }

    input:disabled+.toggle-slider {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .toggle-label {
        font-weight: 600;
        color: #334155;
        cursor: pointer;
    }

    input:disabled~.toggle-label {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Container untuk toggle dan label */
    .toggle-container {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .supplier-item {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        background-color: #ffffff;
        transition: all 0.2s;
    }

    .supplier-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    .supplier-priority-badge {
        background-color: #ffc107;
        color: #000;
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
    }

    .supplier-priority-badge i {
        font-size: 0.8rem;
    }

    .supplier-id {
        font-size: 0.8rem;
        color: #64748b;
    }

    .supplier-wms-data {
        font-size: 0.85rem;
        color: #334155;
        background-color: #f1f5f9;
        padding: 0.2rem 0.5rem;
        border-radius: 6px;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-semibold mb-0">Order / Demand Input</h4>
                <ol class="breadcrumb border px-3 py-2 rounded mb-0">
                    <li class="breadcrumb-item">
                        <a href="index.html" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="active text-primary fw-semibold">Order / Demand Input</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Layout Utama: 2 Kolom -->
    <div class="row mt-3">
        <!-- Kolom Kiri: Konfigurasi Rute -->
        <div class="col-lg-8">
            <!-- Card Konfigurasi Rute -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Konfigurasi Rute</h5>

                    <!-- Form Konfigurasi Rute -->
                    <div class="konfigurasi-rute">
                        <!-- Tanggal Penjemputan -->
                        <div class="form-group">
                            <label class="form-label fw-semibold">Tanggal Penjemputan</label>
                            <input type="date" class="form-control" id="tanggalPenjemputan" value="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <!-- Titik Asal dengan Icon -->
                        <div class="form-group">
                            <div class="d-flex align-items-center mb-1">
                                <i class="ti ti-map-pin me-1 icon-map-pin text-primary"></i>
                                <label class="form-label fw-semibold mb-0">Titik Asal (Origin)</label>
                            </div>
                            <select class="form-select select2" id="titikAsal" style="width: 100%;">
                                <option value="">Pilih titik asal...</option>
                                <option value="1">Plant 1 Nganjuk</option>
                                <option value="2">Plant Jakarta</option>
                                <option value="3">Plant Surabaya</option>
                                <option value="4">Plant Medan</option>
                            </select>
                            <div class="text-muted-small" style="color: blue;">
                                Muatan otomatis: Finish Good
                            </div>
                        </div>

                        <!-- Titik Transit dengan Icon -->
                        <div class="form-group">
                            <div class="d-flex align-items-center mb-1">
                                <i class="ti ti-truck me-1 icon-truck text-success"></i>
                                <label class="form-label fw-semibold mb-0">Titik Transit</label>
                            </div>
                            <select class="form-select select2" id="titikTransit" style="width: 100%;">
                                <option value="">Pilih titik transit...</option>
                                <option value="5">Gudang Cibitung</option>
                                <option value="6">Transit Merak</option>
                                <option value="7">Transit Gresik</option>
                                <option value="8">Transit Belawan</option>
                            </select>
                            <div class="text-muted-small" style="color: indigo;">
                                Aktivitas otomatis: Turunkan Finish Good
                            </div>
                        </div>

                        <!-- Pesan peringatan -->
                        <div class="alert alert-danger py-2 px-3 mt-3 d-flex align-items-center" id="alertPeringatan" role="alert" style="display: none;">
                            <span class="me-2">🔴</span>
                            <span>Pilih Titik Asal dan Titik Transit terlebih dahulu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Konfigurasi Muatan di Transit (hidden by default) -->
            <div class="card mt-3" id="cardMuatanTransit">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Konfigurasi Muatan di Transit</h5>
                    <p class="text-muted-small mb-3">Pilih muatan yang akan diambil di titik transit (input manual)</p>

                    <!-- Ambil Raw Material di Transit - Card Style -->
                    <div class="card mb-3" style="background-color: #f0f9ff; border: 1px solid #bae6fd;">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-package me-2 text-primary" style="font-size: 1.2rem;"></i>
                                    <span class="fw-semibold">Ambil Raw Material di Transit</span>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="toggleRawMaterial" disabled>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <!-- Collapsible content untuk Raw Material - tanpa card putih -->
                            <div class="collapse mt-3" id="collapseRawMaterial">
                                <div class="d-flex gap-2 align-items-end">
                                    <div style="flex: 1;">
                                        <label class="form-label small">QTY</label>
                                        <input type="number" class="form-control form-control-sm" id="rawQty" placeholder="QTY" min="0" step="0.01" disabled>
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="form-label small">Berat (kg)</label>
                                        <input type="number" class="form-control form-control-sm" id="rawBerat" placeholder="Berat" min="0" step="0.01" disabled>
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="form-label small">Volume (m³)</label>
                                        <input type="number" class="form-control form-control-sm" id="rawVolume" placeholder="Volume" min="0" step="0.01" disabled>
                                    </div>
                                </div>
                                <!-- Pesan peringatan Raw Material - warna biru tua -->
                                <div class="d-flex align-items-center mt-2" style="font-size: 0.8rem; color: #0369a1;">
                                    <i class="ti ti-alert-circle-filled me-1"></i>
                                    <span>Data ini tidak berasal dari WMS, input manual diperlukan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ambil Polybox di Transit - Card Style -->
                    <div class="card mb-3" style="background-color: #f0fdf4; border: 1px solid #bbf7d0;">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-box me-2 text-success" style="font-size: 1.2rem;"></i>
                                    <span class="fw-semibold">Ambil Polybox di Transit</span>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="togglePolybox" disabled>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <!-- Collapsible content untuk Polybox - tanpa card putih -->
                            <div class="collapse mt-3" id="collapsePolybox">
                                <div class="d-flex gap-2 align-items-end">
                                    <div style="flex: 1;">
                                        <label class="form-label small">Jumlah</label>
                                        <input type="number" class="form-control form-control-sm" id="polyboxJumlah" placeholder="Jumlah" min="0" disabled>
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="form-label small">Volume (m³)</label>
                                        <input type="number" class="form-control form-control-sm" id="polyboxVolume" placeholder="Volume" min="0" step="0.01" disabled>
                                    </div>
                                </div>
                                <!-- Pesan peringatan Polybox - warna hijau tua -->
                                <div class="d-flex align-items-center mt-2" style="font-size: 0.8rem; color: #166534;">
                                    <i class="ti ti-alert-circle-filled me-1"></i>
                                    <span>Input jumlah dan volume polybox yang akan diambil</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Supplier (Milk Run) -->
            <div class="card mt-2" id="cardSupplier">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h5 class="card-title fw-semibold mb-0">Supplier (Milk Run)</h5>
                        <button class="btn btn-primary btn-sm" id="btnAddSupplier" disabled>
                            <i class="ti ti-plus me-1"></i>Add Supplier
                        </button>
                    </div>
                    <p class="text-muted-small mb-2" style="color: green;">Muatan otomatis: Raw Material</p>

                    <!-- Empty State - Belum ada supplier -->
                    <div id="emptySupplier" class="text-center py-5">
                        <i class="ti ti-truck-delivery" style="font-size: 3rem; color: #cbd5e1;"></i>
                        <p class="mt-2 text-muted">Belum ada supplier</p>
                        <p class="small text-muted">Pilih Titik Asal dan Titik Transit terlebih dahulu</p>
                    </div>

                    <!-- Daftar Supplier (akan tampil setelah ditambah) -->
                    <div id="listSupplier" style="display: none;">
                        <!-- Item Supplier akan ditambahkan via JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Card Generate Route -->
            <div class="d-flex justify-content-end mt-2 mb-3">
                <button class="btn btn-primary" id="btnGenerateRoute" style="width: 200px;" disabled>
                    <i class="ti ti-route me-2"></i>Generate Route
                </button>
            </div>
        </div>

        <!-- Kolom Kanan: Summary -->
        <div class="col-lg-4">
            <!-- Card Summary (1) - placeholder dulu -->
            <div class="card mb-3" style="border: 1px solid #e0e4e9; border-radius: 12px; background: linear-gradient(145deg, #ffffff, #f8fafc);">
                <div class="card-body" style="padding: 1.25rem;">
                    <h5 class="fw-semibold mb-3" style="color: #1e293b; display: flex; align-items: center; gap: 8px;">
                        <i class="ti ti-list-details" style="color: #3b82f6; font-size: 1.3rem;"></i>
                        <span>Summary</span>
                    </h5>

                    <!-- Fokus ke Tanggal Penjemputan aja dulu -->
                    <div class="d-flex align-items-center p-3 rounded-3" style="background: linear-gradient(45deg, #eef2ff, #f5f3ff); border: 1px solid #c7d2fe;">
                        <div class="rounded-circle p-2 me-3" style="background-color: #6366f1;">
                            <i class="ti ti-calendar-event text-white" style="font-size: 1.2rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <span class="text-muted small d-block" style="font-size: 0.75rem;">Tanggal Penjemputan</span>
                            <span class="fw-bold" style="color: #1e293b; font-size: 1.2rem;" id="summaryTanggal">-</span>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label fw-semibold mb-2">Alur Rute (Vertikal)</label>

                        <!-- Vertical route dengan line terhubung -->
                        <div class="vertical-route p-2" style="background: #ffffff; border-radius: 16px; border: 1px solid #f1f5f9;">

                            <!-- Origin -->
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                    <i class="ti ti-map-pin text-white" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <span class="fw-semibold d-block" style="font-size: 0.8rem;">Origin</span>
                                    <small class="text-muted" id="verticalOriginAwal">-</small>
                                </div>
                            </div>

                            <!-- Garis vertikal -->
                            <div class="ms-3 ps-3 mb-2" style="border-left: 2px dashed #cbd5e1;">
                                <div class="py-1"></div>
                            </div>

                            <!-- Transit -->
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                    <i class="ti ti-building-warehouse text-white" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <span class="fw-semibold d-block" style="font-size: 0.8rem;">Transit</span>
                                    <small class="text-muted" id="verticalTransitName">-</small>
                                </div>
                            </div>

                            <!-- Garis vertikal -->
                            <div class="ms-3 ps-3 mb-2" style="border-left: 2px dashed #cbd5e1;">
                                <div class="py-1"></div>
                            </div>

                            <!-- Suppliers -->
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                    <i class="ti ti-truck-delivery text-white" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <span class="fw-semibold d-block" style="font-size: 0.8rem;">Suppliers</span>
                                    <small class="text-muted" id="verticalSupplierCount">0</small>
                                </div>
                            </div>

                            <!-- Garis vertikal -->
                            <div class="ms-3 ps-3 mb-2" style="border-left: 2px dashed #cbd5e1;">
                                <div class="py-1"></div>
                            </div>

                            <!-- Kembali ke Origin -->
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                    <i class="ti ti-map-pin text-white" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <span class="fw-semibold d-block" style="font-size: 0.8rem;">Kembali</span>
                                    <small class="text-muted" id="verticalOriginAkhir">-</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TOTAL SUPPLIER - Ditambahkan di sini -->
                    <div class="d-flex align-items-center justify-content-between mt-3 p-3 rounded-3" style="background: linear-gradient(45deg, #f8fafc, #f1f5f9); border: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle p-2 me-3" style="background-color: #f59e0b;">
                                <i class="ti ti-users text-white" style="font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <span class="text-muted small d-block" style="font-size: 0.75rem;">Total Supplier</span>
                                <span class="fw-bold" style="color: #1e293b; font-size: 1.2rem;" id="totalSupplierValue">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-3 p-3 rounded-3" style="background: linear-gradient(45deg, #f0f9ff, #e0f2fe); border: 1px solid #bae6fd;">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle p-2 me-3" style="background-color: #0284c7;">
                                <i class="ti ti-package text-white" style="font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <span class="text-muted small d-block" style="font-size: 0.75rem;">Total Volume (dari WMS)</span>
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        <span class="fw-bold" style="color: #0284c7; font-size: 1.2rem;" id="totalBerat">520</span>
                                        <span class="text-muted small" style="font-size: 0.7rem;">Kg</span>
                                    </div>
                                    <div class="mx-1 text-muted">•</div>
                                    <div>
                                        <span class="fw-bold" style="color: #0284c7; font-size: 1.2rem;" id="totalVolume">15.28</span>
                                        <span class="text-muted small" style="font-size: 0.7rem;">m³</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SISA KAPASITAS (GAP) - Ditambahkan di sini -->
                    <div class="d-flex align-items-center justify-content-between mt-3 p-3 rounded-3" style="background: linear-gradient(45deg, #fff1f0, #fee9e7); border: 1px solid #fecaca;">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle p-2 me-3" style="background-color: #dc2626;">
                                <i class="ti ti-scale text-white" style="font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <span class="text-muted small d-block" style="font-size: 0.75rem;">Sisa Kapasitas (Gap)</span>
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        <span class="fw-bold" style="color: #dc2626; font-size: 1.2rem;" id="sisaBerat">25.480</span>
                                        <span class="text-muted small" style="font-size: 0.7rem;">Kg</span>
                                    </div>
                                    <div class="mx-1 text-muted">•</div>
                                    <div>
                                        <span class="fw-bold" style="color: #dc2626; font-size: 1.2rem;" id="sisaVolume">37.20</span>
                                        <span class="text-muted small" style="font-size: 0.7rem;">m³</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info tambahan yang statis dulu -->
                    <div class="mt-3 pt-2 text-muted small text-center" style="border-top: 1px dashed #e2e8f0;">
                        <i class="ti ti-info-circle me-1"></i>
                        Summary lainnya akan ditambahkan
                    </div>
                </div>
            </div>

            <!-- Card Jenis Muatan (2) -->
            <div class="card mb-3" style="border: 1px solid #e0e4e9; border-radius: 12px; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <h5 class="fw-semibold mb-3" style="color: #1e293b;">Jenis Muatan
                    </h5>

                    <!-- Finish Good -->
                    <div class="d-flex align-items-center mb-3 p-2 rounded" style="background: linear-gradient(45deg, #e8f0fe, #f0f7ff); border-left: 4px solid #3b82f6;">
                        <div class="d-flex align-items-center justify-content-center rounded-circle me-3" style="width: 36px; height: 36px; background-color: #3b82f6;">
                            <i class="ti ti-check text-white" style="font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <span class="fw-semibold d-block" style="color: #1e293b;">1. Finish Good</span>
                            <small class="text-muted" style="color: #64748b !important;">Di Titik Asal</small>
                        </div>
                    </div>

                    <!-- Polybox -->
                    <div class="d-flex align-items-center mb-3 p-2 rounded" style="background: linear-gradient(45deg, #f0fdf4, #f5fff9); border-left: 4px solid #10b981;">
                        <div class="d-flex align-items-center justify-content-center rounded-circle me-3" style="width: 36px; height: 36px; background-color: #10b981;">
                            <i class="ti ti-box text-white" style="font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <span class="fw-semibold d-block" style="color: #1e293b;">2. Polybox</span>
                            <small class="text-muted" style="color: #64748b !important;">Di Titik Transit</small>
                        </div>
                    </div>

                    <!-- Raw Material -->
                    <div class="d-flex align-items-center p-2 rounded" style="background: linear-gradient(45deg, #fef9e7, #fff8e7); border-left: 4px solid #f59e0b;">
                        <div class="d-flex align-items-center justify-content-center rounded-circle me-3" style="width: 36px; height: 36px; background-color: #f59e0b;">
                            <i class="ti ti-truck-delivery text-white" style="font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <span class="fw-semibold d-block" style="color: #1e293b;">3. Raw Material</span>
                            <small class="text-muted" style="color: #64748b !important;">Dari Supplier (via WMS)</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Daftar Supplier (3) - Awalnya hidden, muncul kalau ada supplier -->
            <div class="card" style="border: 1px solid #e0e4e9; border-radius: 12px; background-color: #ffffff; display: none;" id="cardDaftarSupplier">
                <div class="card-body" style="padding: 1.25rem;">
                    <h5 class="fw-semibold mb-3" style="color: #1e293b; display: flex; align-items: center; gap: 8px;">
                        <i class="ti ti-users" style="color: #8b5cf6; font-size: 1.2rem;"></i>
                        <span>Daftar Supplier</span>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary ms-2" id="supplierCountBadge" style="font-size: 0.7rem;">0</span>
                    </h5>

                    <!-- Daftar Supplier (akan diisi via JavaScript) -->
                    <div id="listSupplierDetail">
                        <!-- Item Supplier akan ditambahkan via JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Card Catatan (4) -->
            <div class="card mb-3" style="border: 1px solid #e0e4e9; border-radius: 12px; background: linear-gradient(135deg, #fff4e6, #ffe9d9);">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle p-2" style="background-color: #f97316;">
                            <i class="ti ti-alert-triangle text-white" style="font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-2" style="color: #9a3412;">Catatan Penting</h6>
                            <ul class="list-unstyled mb-0" style="color: #7b341e;">
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="ti ti-circle-filled me-2" style="font-size: 0.4rem; color: #f97316;"></i>
                                    <span>Jenis muatan otomatis sesuai titik</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="ti ti-circle-filled me-2" style="font-size: 0.4rem; color: #f97316;"></i>
                                    <span>Detail material dari sistem WMS</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="ti ti-circle-filled me-2" style="font-size: 0.4rem; color: #f97316;"></i>
                                    <span>Pilih supplier untuk Milk Run</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah Supplier Milk Run -->
<div class="modal fade" id="modalAddSupplier" tabindex="-1" aria-labelledby="modalAddSupplierLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" id="modalAddSupplierLabel">Tambah Supplier Milk Run</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted-small mb-3">Pilih supplier dan konfigurasi prioritasnya</p>

                <!-- Dropdown Supplier -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Supplier</label>
                    <select class="form-select select2-modal" id="selectSupplier" style="width: 100%;">
                        <option value="">Pilih supplier...</option>
                        <option value="1">PT Nisseieco Indonesia (VL00371)</option>
                        <option value="2">PT Astra Honda (AH67890)</option>
                        <option value="3">PT Toyota Boshoku (TB45678)</option>
                        <option value="4">PT Denso Indonesia (DI23456)</option>
                    </select>
                </div>

                <!-- Titik Prioritas Toggle -->
                <div class="d-flex justify-content-between align-items-center p-3 rounded" style="background-color: #fff9c4; border: 1px solid #ffe082;">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-star-filled me-2 text-warning" style="font-size: 1.2rem;"></i>
                        <div>
                            <span class="fw-semibold d-block">Titik Prioritas</span>
                            <small class="text-muted">Supplier prioritas akan ditempatkan di urutan awal rute (setelah titik transit)</small>
                        </div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="togglePrioritas">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanSupplier" disabled>Tambah Supplier</button>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>
<?php include '../layout/scripts.php'; ?>

<!-- Tambahkan CSS dan JS untuk Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Inisialisasi Select2 dan fungsi lainnya -->
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 untuk dropdown
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        // Fungsi untuk cek dan update alert serta card muatan transit
        function cekStatus() {
            let asal = $('#titikAsal').val();
            let transit = $('#titikTransit').val();

            $('#alertPeringatan').removeClass('show-alert hide-alert');
            $('#cardMuatanTransit').removeClass('show-card');

            if (asal && transit && asal !== '' && transit !== '') {
                $('#alertPeringatan').addClass('hide-alert').removeAttr('style');
                $('#cardMuatanTransit').addClass('show-card');

                // Enable toggle switch
                $('#toggleRawMaterial, #togglePolybox').prop('disabled', false);
            } else {
                $('#alertPeringatan').addClass('show-alert').removeAttr('style');
                $('#cardMuatanTransit').removeClass('show-card');

                // Reset semua toggle dan input, disable
                $('#toggleRawMaterial, #togglePolybox').prop('checked', false).prop('disabled', true);
                $('#rawQty, #rawBerat, #rawVolume, #polyboxJumlah, #polyboxVolume').val('').prop('disabled', true);

                // Sembunyikan collapse
                $('#collapseRawMaterial, #collapsePolybox').collapse('hide');
            }
        }

        // Event listener untuk perubahan di titik asal dan transit
        $('#titikAsal, #titikTransit').on('change select2:select select2:clear', function() {
            cekStatus();
        });

        // Trigger awal
        setTimeout(cekStatus, 500);

        // Handle collapse untuk Raw Material
        $('#toggleRawMaterial').on('change', function() {
            if ($(this).is(':checked')) {
                $('#collapseRawMaterial').collapse('show');
                // Enable input di dalamnya
                $('#rawQty, #rawBerat, #rawVolume').prop('disabled', false);
            } else {
                $('#collapseRawMaterial').collapse('hide');
                // Kosongkan dan disable input saat toggle off
                $('#rawQty, #rawBerat, #rawVolume').val('').prop('disabled', true);
            }
        });

        // Handle collapse untuk Polybox
        $('#togglePolybox').on('change', function() {
            if ($(this).is(':checked')) {
                $('#collapsePolybox').collapse('show');
                // Enable input di dalamnya
                $('#polyboxJumlah, #polyboxVolume').prop('disabled', false);
            } else {
                $('#collapsePolybox').collapse('hide');
                // Kosongkan dan disable input saat toggle off
                $('#polyboxJumlah, #polyboxVolume').val('').prop('disabled', true);
            }
        });

        // Prevent collapse from closing when clicking inside
        $('#collapseRawMaterial, #collapsePolybox').on('click', function(e) {
            e.stopPropagation();
        });

        let daftarSupplier = [];

        // Update status tombol Add Supplier berdasarkan toggle origin & transit
        function updateButtonStatus() {
            let asal = $('#titikAsal').val();
            let transit = $('#titikTransit').val();

            if (asal && transit && asal !== '' && transit !== '') {
                $('#btnAddSupplier').prop('disabled', false);
                $('#btnGenerateRoute').prop('disabled', false);
            } else {
                $('#btnAddSupplier').prop('disabled', true);
                $('#btnGenerateRoute').prop('disabled', true);
            }
        }

        // Panggil di fungsi cekStatus
        function cekStatus() {
            let asal = $('#titikAsal').val();
            let transit = $('#titikTransit').val();

            $('#alertPeringatan').removeClass('show-alert hide-alert');
            $('#cardMuatanTransit').removeClass('show-card');

            if (asal && transit && asal !== '' && transit !== '') {
                $('#alertPeringatan').addClass('hide-alert').removeAttr('style');
                $('#cardMuatanTransit').addClass('show-card');
                $('#toggleRawMaterial, #togglePolybox').prop('disabled', false);
                $('#btnAddSupplier').prop('disabled', false);
                $('#btnGenerateRoute').prop('disabled', false);
            } else {
                $('#alertPeringatan').addClass('show-alert').removeAttr('style');
                $('#cardMuatanTransit').removeClass('show-card');
                $('#toggleRawMaterial, #togglePolybox').prop('checked', false).prop('disabled', true);
                $('#rawQty, #rawBerat, #rawVolume, #polyboxJumlah, #polyboxVolume').val('').prop('disabled', true);
                $('#collapseRawMaterial, #collapsePolybox').collapse('hide');
                $('#btnAddSupplier').prop('disabled', true);
                $('#btnGenerateRoute').prop('disabled', true);
            }
        }

        // Inisialisasi Select2 di modal
        $('#modalAddSupplier').on('shown.bs.modal', function() {
            $('.select2-modal').select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $('#modalAddSupplier')
            });
        });

        // Enable/disable tombol simpan berdasarkan pilihan supplier
        $('#selectSupplier').on('change', function() {
            $('#btnSimpanSupplier').prop('disabled', $(this).val() === '');
        });

        // Reset modal ketika ditutup
        $('#modalAddSupplier').on('hidden.bs.modal', function() {
            $('#selectSupplier').val('').trigger('change');
            $('#togglePrioritas').prop('checked', false);
            $('#btnSimpanSupplier').prop('disabled', true);
        });

        // Tombol Add Supplier
        $('#btnAddSupplier').on('click', function() {
            $('#modalAddSupplier').modal('show');
        });

        // Simpan Supplier
        $('#btnSimpanSupplier').on('click', function() {
            let supplierId = $('#selectSupplier').val();
            let supplierText = $('#selectSupplier option:selected').text();
            let isPrioritas = $('#togglePrioritas').is(':checked');

            // Extract nama dan ID dari text
            let matches = supplierText.match(/(.+)\((.+)\)/);
            let nama = matches ? matches[1].trim() : supplierText;
            let id = matches ? matches[2].trim() : '';

            let supplier = {
                id: supplierId,
                nama: nama,
                kode: id,
                prioritas: isPrioritas,
                wms: {
                    berat: Math.floor(Math.random() * 500) + 200, // dummy data
                    volume: (Math.random() * 10 + 5).toFixed(1)
                }
            };

            daftarSupplier.push(supplier);
            renderSupplierList();

            $('#modalAddSupplier').modal('hide');
        });

        // Render daftar supplier
        // Di dalam fungsi renderSupplierList, tambahkan update untuk dropdown modal
        function renderSupplierList() {
            let listContainer = $('#listSupplier');
            let listDetailContainer = $('#listSupplierDetail');
            let emptyContainer = $('#emptySupplier');
            let cardDaftarSupplier = $('#cardDaftarSupplier');
            let supplierCountBadge = $('#supplierCountBadge');
            let selectSupplier = $('#selectSupplier');

            if (daftarSupplier.length > 0) {
                // Hide empty state di card kiri
                emptyContainer.hide();

                // Show list container di card kiri
                listContainer.show();

                // Show card daftar supplier di kanan
                cardDaftarSupplier.show();

                // Update badge count
                supplierCountBadge.text(daftarSupplier.length);

                // Sort by prioritas (prioritas dulu)
                let sorted = [...daftarSupplier].sort((a, b) => (b.prioritas ? 1 : 0) - (a.prioritas ? 1 : 0));

                // Render untuk card supplier di kiri (dengan button delete)
                let htmlKiri = '';
                sorted.forEach((supplier, index) => {
                    htmlKiri += `
                <div class="supplier-item" data-id="${supplier.id}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="fw-semibold">${index + 1}. ${supplier.nama}</span>
                                ${supplier.prioritas ? '<span class="supplier-priority-badge"><i class="ti ti-star-filled"></i> Prioritas</span>' : ''}
                            </div>
                            <div class="supplier-id mb-2">ID: ${supplier.kode}</div>
                            <div class="supplier-wms-data">
                                Data dari WMS: ${supplier.wms.berat} kg • ${supplier.wms.volume} m³
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <label class="toggle-switch mb-0">
                                <input type="checkbox" class="toggle-prioritas" ${supplier.prioritas ? 'checked' : ''} data-id="${supplier.id}">
                                <span class="toggle-slider"></span>
                            </label>
                            <button class="btn btn-outline-danger btn-icon btn-delete-supplier" data-id="${supplier.id}">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
                });
                listContainer.html(htmlKiri);

                // Render untuk card daftar supplier di kanan (tanpa button delete)
                let htmlKanan = '';
                sorted.forEach((supplier, index) => {
                    htmlKanan += `
                <div class="d-flex justify-content-between align-items-start mb-3 pb-2" style="border-bottom: 1px solid #f1f5f9; ${index === sorted.length - 1 ? 'border-bottom: none;' : ''}">
                    <div style="width: 100%;">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <span class="fw-semibold" style="font-size: 0.9rem;">${supplier.nama}</span>
                            ${supplier.prioritas ? '<span class="badge bg-warning bg-opacity-10 text-warning" style="font-size: 0.6rem;"><i class="ti ti-star-filled me-1" style="font-size: 0.6rem;"></i>Prioritas</span>' : ''}
                        </div>
                        <div class="text-muted small mb-2" style="font-size: 0.7rem; background-color: #f1f5f9; padding: 0.15rem 0.5rem; border-radius: 12px; display: inline-block;">ID: ${supplier.kode}</div>
                        <div class="small" style="font-size: 0.7rem; color: #475569; background-color: #f8fafc; padding: 0.25rem 0.5rem; border-radius: 20px; border: 1px solid #e2e8f0; display: inline-block; width: 100%;">
                            <i class="ti ti-database me-1" style="color: #0284c7;"></i>
                            ${supplier.wms.berat} kg • ${supplier.wms.volume} m³
                        </div>
                    </div>
                </div>
            `;
                });
                listDetailContainer.html(htmlKanan);

                // Update dropdown modal - hilangkan supplier yang sudah dipilih
                let allOptions = [{
                        id: '1',
                        text: 'PT Nisseieco Indonesia (VL00371)'
                    },
                    {
                        id: '2',
                        text: 'PT Astra Honda (AH67890)'
                    },
                    {
                        id: '3',
                        text: 'PT Toyota Boshoku (TB45678)'
                    },
                    {
                        id: '4',
                        text: 'PT Denso Indonesia (DI23456)'
                    }
                ];

                // Filter supplier yang belum dipilih
                let availableOptions = allOptions.filter(opt =>
                    !daftarSupplier.some(s => s.id == opt.id)
                );

                // Bangun HTML untuk dropdown
                let optionsHtml = '<option value="">Pilih supplier...</option>';
                availableOptions.forEach(opt => {
                    optionsHtml += `<option value="${opt.id}">${opt.text}</option>`;
                });

                // Update select dan refresh Select2
                selectSupplier.html(optionsHtml);
                selectSupplier.trigger('change');

            } else {
                // Show empty state di card kiri
                emptyContainer.show();

                // Hide list container di card kiri
                listContainer.hide();

                // Hide card daftar supplier di kanan
                cardDaftarSupplier.hide();

                // Reset dropdown ke semua option
                let allOptions = [{
                        id: '1',
                        text: 'PT Nisseieco Indonesia (VL00371)'
                    },
                    {
                        id: '2',
                        text: 'PT Astra Honda (AH67890)'
                    },
                    {
                        id: '3',
                        text: 'PT Toyota Boshoku (TB45678)'
                    },
                    {
                        id: '4',
                        text: 'PT Denso Indonesia (DI23456)'
                    }
                ];

                let optionsHtml = '<option value="">Pilih supplier...</option>';
                allOptions.forEach(opt => {
                    optionsHtml += `<option value="${opt.id}">${opt.text}</option>`;
                });

                selectSupplier.html(optionsHtml);
                selectSupplier.trigger('change');
            }
        }

        // Hapus handler untuk btn-delete-supplier-detail karena sudah tidak dipakai
        // Handle delete supplier - ini yang bener
        $(document).on('click', '.btn-delete-supplier', function() {
            let id = $(this).data('id');
            console.log('Deleting supplier with id:', id); // untuk debugging

            // Filter daftarSupplier
            daftarSupplier = daftarSupplier.filter(s => s.id != id);

            // Render ulang
            renderSupplierList();

            // Update total supplier di summary
            updateTotalSupplier();

            // Trigger event
            $(document).trigger('supplierListChanged');
        });

        // Handle toggle prioritas
        $(document).on('change', '.toggle-prioritas', function() {
            let id = $(this).data('id');
            let checked = $(this).is(':checked');

            let supplier = daftarSupplier.find(s => s.id == id);
            if (supplier) {
                supplier.prioritas = checked;
                renderSupplierList();
            }
        });

        // Handle generate route
        $('#btnGenerateRoute').on('click', function() {
            alert('Generate Route - akan diimplementasikan');
        });

        // Fungsi update summary tanggal
        function updateSummaryTanggal() {
            let tanggal = $('#tanggalPenjemputan').val();
            if (tanggal) {
                // Format tanggal ke format Indonesia
                let date = new Date(tanggal);
                let options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                let formattedDate = date.toLocaleDateString('id-ID', options);

                // Capitalize first letter (karena hasilnya biasanya lowercase)
                formattedDate = formattedDate.charAt(0).toUpperCase() + formattedDate.slice(1);

                $('#summaryTanggal').text(formattedDate);
            } else {
                $('#summaryTanggal').text('-');
            }
        }

        // Trigger update saat halaman load
        updateSummaryTanggal();

        // Update saat tanggal berubah
        $('#tanggalPenjemputan').on('change', updateSummaryTanggal);

        function updateSimpleRoute() {
            let asal = $('#titikAsal option:selected').text();
            let transit = $('#titikTransit option:selected').text();
            let supplierCount = daftarSupplier ? daftarSupplier.length : 0;

            // Update untuk horizontal
            let shortAsal = (asal && asal !== 'Pilih titik asal...') ? (asal.length > 10 ? asal.substr(0, 8) + '..' : asal) : '-';
            let shortTransit = (transit && transit !== 'Pilih titik transit...') ? (transit.length > 10 ? transit.substr(0, 8) + '..' : transit) : '-';

            $('#simpleOriginAwal, #simpleOriginAkhir').text(shortAsal);
            $('#simpleTransitName').text(shortTransit);
            $('#simpleSupplierCount').text(supplierCount);

            // Update untuk vertical
            $('#verticalOriginAwal, #verticalOriginAkhir').text(asal && asal !== 'Pilih titik asal...' ? asal : '-');
            $('#verticalTransitName').text(transit && transit !== 'Pilih titik transit...' ? transit : '-');
            $('#verticalSupplierCount').text(supplierCount);

            // Update status badge
            if (asal && transit && asal !== 'Pilih titik asal...' && transit !== 'Pilih titik transit...') {
                if (supplierCount > 0) {
                    $('#routeStatusSimple').html('<i class="ti ti-check me-1"></i> Rute siap');
                    $('#routeStatusSimple').removeClass('bg-light').addClass('bg-success text-white');
                } else {
                    $('#routeStatusSimple').html('<i class="ti ti-alert-triangle me-1"></i> Tambah supplier');
                    $('#routeStatusSimple').removeClass('bg-light').addClass('bg-warning text-dark');
                }
            } else {
                $('#routeStatusSimple').html('<i class="ti ti-info-circle me-1"></i> Pilih titik asal & transit');
                $('#routeStatusSimple').removeClass('bg-success bg-warning').addClass('bg-light');
            }
        }

        // Update on changes
        $('#titikAsal, #titikTransit').on('change', updateSimpleRoute);

        // Update when suppliers change
        $(document).on('supplierListChanged', updateSimpleRoute);

        // Override renderSupplierList to trigger event
        let originalRender = renderSupplierList;
        renderSupplierList = function() {
            originalRender();
            updateTotalSupplier();
            $(document).trigger('supplierListChanged');
        };

        // Initial update
        setTimeout(updateSimpleRoute, 500);

        function updateTotalSupplier() {
            let supplierCount = daftarSupplier ? daftarSupplier.length : 0;
            $('#totalSupplierValue').text(supplierCount);

            // Update badge status
            if (supplierCount > 0) {
                $('#supplierStatusBadge').html('<i class="ti ti-check me-1"></i>' + supplierCount + ' supplier terpilih');
                $('#supplierStatusBadge').removeClass('bg-warning bg-opacity-10 text-warning').addClass('bg-success bg-opacity-10 text-success');
            } else {
                $('#supplierStatusBadge').html('<i class="ti ti-truck-delivery me-1"></i>Belum ada');
                $('#supplierStatusBadge').removeClass('bg-success bg-opacity-10 text-success').addClass('bg-warning bg-opacity-10 text-warning');
            }
        }
        setTimeout(function() {
            updateTotalSupplier();
        }, 500);

        // Tambahkan fungsi untuk update sisa kapasitas
        function updateSisaKapasitas() {
            // Ambil nilai dari input transit
            let rawBerat = parseFloat($('#rawBerat').val()) || 0;
            let rawVolume = parseFloat($('#rawVolume').val()) || 0;
            let polyboxVolume = parseFloat($('#polyboxVolume').val()) || 0;

            // Total volume dari polybox dan raw material
            let totalVolumeTransit = rawVolume + polyboxVolume;

            // Ambil total dari WMS (dari supplier)
            let totalWmsBerat = parseFloat($('#totalBerat').text()) || 0;
            let totalWmsVolume = parseFloat($('#totalVolume').text()) || 0;

            // Hitung sisa kapasitas (asumsi kapasitas awal 30.000 kg dan 50 m³)
            // Ganti nilai ini sesuai dengan kapasitas kendaraan sebenarnya
            let kapasitasMaxBerat = 30000; // 30.000 kg
            let kapasitasMaxVolume = 50; // 50 m³

            // Total muatan = WMS + Transit
            let totalMuatanBerat = totalWmsBerat + rawBerat;
            let totalMuatanVolume = totalWmsVolume + totalVolumeTransit;

            // Sisa kapasitas
            let sisaBerat = kapasitasMaxBerat - totalMuatanBerat;
            let sisaVolume = kapasitasMaxVolume - totalMuatanVolume;

            // Format angka dengan ribuan
            $('#sisaBerat').text(sisaBerat.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#sisaVolume').text(sisaVolume.toFixed(2));

            // Update badge status berdasarkan sisa kapasitas
            if (sisaBerat < 0 || sisaVolume < 0) {
                $('#kapasitasStatusBadge').html('<i class="ti ti-alert-triangle me-1"></i>Overload');
                $('#kapasitasStatusBadge').removeClass('bg-danger bg-opacity-10 text-danger').addClass('bg-danger text-white');
            } else if (sisaBerat < 1000 || sisaVolume < 5) {
                $('#kapasitasStatusBadge').html('<i class="ti ti-alert-circle me-1"></i>Hampir penuh');
                $('#kapasitasStatusBadge').removeClass('bg-danger bg-opacity-10 text-danger').addClass('bg-warning text-dark');
            } else {
                $('#kapasitasStatusBadge').html('<i class="ti ti-check me-1"></i>Tersedia');
                $('#kapasitasStatusBadge').removeClass('bg-warning text-dark').addClass('bg-danger bg-opacity-10 text-danger');
            }
        }

        // Panggil fungsi saat input di transit berubah
        $('#rawBerat, #rawVolume, #polyboxVolume').on('input', function() {
            updateSisaKapasitas();
        });

        // Panggil juga saat toggle berubah
        $('#toggleRawMaterial, #togglePolybox').on('change', function() {
            // Delay sedikit biar collapse sempat update
            setTimeout(updateSisaKapasitas, 100);
        });

        // Panggil saat supplier berubah (karena total WMS bisa berubah)
        $(document).on('supplierListChanged', function() {
            // Hitung ulang total WMS dari supplier
            let totalWmsBerat = 0;
            let totalWmsVolume = 0;

            daftarSupplier.forEach(supplier => {
                totalWmsBerat += supplier.wms.berat || 0;
                totalWmsVolume += parseFloat(supplier.wms.volume) || 0;
            });

            $('#totalBerat').text(totalWmsBerat);
            $('#totalVolume').text(totalWmsVolume.toFixed(2));

            updateSisaKapasitas();
        });

        // Panggil initial
        setTimeout(function() {
            updateSisaKapasitas();
        }, 500);

    });
</script>