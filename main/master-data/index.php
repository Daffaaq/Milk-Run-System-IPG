<?php
require_once '../../helper/auth.php';

isLogin();
?>

<?php
include '../layout/head.php';
?>

<?php include '../layout/sidebar.php'; ?>
<?php include '../layout/header.php'; ?>

<style>
    .tab-content .card {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    /* Styling untuk SEMUA modal (form dan delete) dengan tampilan modern */
    .modal-modern .modal-content {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-modern .modal-header {
        background: linear-gradient(45deg, #5f76e8, #5f76e8);
        color: white;
        border-bottom: none;
        padding: 1.5rem;
    }

    .modal-modern .modal-header.bg-danger {
        background: linear-gradient(45deg, #dc3545, #c82333) !important;
    }

    .modal-modern .modal-header .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-modern .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        transition: all 0.3s;
    }

    .modal-modern .modal-header .btn-close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    .modal-modern .modal-body {
        padding: 2rem 1.5rem;
    }

    .modal-modern .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid #dee2e6;
        background: #f8f9fa;
    }

    .modal-modern .btn {
        border-radius: 50px;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .modal-modern .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .modal-modern .btn-primary {
        background: linear-gradient(45deg, #5f76e8, #5f76e8);
        border: none;
    }

    .modal-modern .btn-danger {
        background: linear-gradient(45deg, #dc3545, #c82333);
        border: none;
    }

    .modal-modern .btn-secondary {
        background: #6c757d;
        border: none;
    }

    .modal-modern .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .modal-modern .form-control,
    .modal-modern .form-select {
        border-radius: 10px;
        border: 1px solid #dee2e6;
        padding: 0.75rem 1rem;
        transition: all 0.3s;
    }

    .modal-modern .form-control:focus,
    .modal-modern .form-select:focus {
        border-color: #5f76e8;
        box-shadow: 0 0 0 0.2rem rgba(95, 118, 232, 0.25);
    }

    .modal-modern .form-control.is-invalid {
        border-color: #dc3545;
        background-image: none;
    }

    .modal-modern .invalid-feedback {
        font-size: 0.875rem;
        color: #dc3545;
        margin-top: 0.25rem;
    }

    /* Animasi icon trash */
    .modal-modern .ti-trash {
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {

        0%,
        100% {
            transform: rotate(0);
        }

        25% {
            transform: rotate(-10deg);
        }

        75% {
            transform: rotate(10deg);
        }
    }

    /* Alert detail untuk delete modal */
    .modal-modern .alert-detail {
        background: #f8f9fa;
        border-left: 4px solid #dc3545;
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .modal-modern .alert-detail small {
        display: block;
        line-height: 1.8;
    }

    .modal-modern .alert-detail strong {
        color: #495057;
        min-width: 80px;
        display: inline-block;
    }

    /* --- Tabs Modern & Menyatu dengan Card --- */
    .tabs-modern-container .nav-tabs {
        border-bottom: none;
        padding-left: 10px;
    }

    .tabs-modern-container .nav-tabs .nav-link {
        border: none;
        padding: 12px 24px;
        margin-right: 8px;
        color: #6c757d;
        font-weight: 500;
        background-color: #f8f9fa;
        border-radius: 20px 20px 0 0;
        transition: all 0.2s ease-in-out;
        position: relative;
        bottom: -1px;
        z-index: 1;
    }

    .tabs-modern-container .nav-tabs .nav-link:hover {
        background-color: #e9ecef;
        color: #495057;
        border-color: transparent;
    }

    .tabs-modern-container .nav-tabs .nav-link.active {
        background-color: #ffffff;
        color: #5f76e8;
        border: 1px solid #dee2e6;
        border-bottom-color: white;
        font-weight: 600;
        box-shadow: 3px -3px 8px rgba(0, 0, 0, 0.03);
        z-index: 3;
    }

    .tabs-modern-container .card.tab-content-card {
        border-top-left-radius: 0;
        border: 1px solid #dee2e6;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        margin-top: -1px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .dataTables_filter input {
            min-width: 150px;
        }

        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_filter {
            text-align: left;
        }

        .tabs-modern-container .nav-tabs {
            flex-wrap: wrap;
            padding-left: 5px;
        }

        .tabs-modern-container .nav-tabs .nav-link {
            margin-bottom: 5px;
            border-radius: 20px;
            bottom: 0;
        }

        .tabs-modern-container .nav-tabs .nav-link.active {
            border-bottom-color: #dee2e6;
        }

        .tabs-modern-container .card.tab-content-card {
            border-top-left-radius: 16px;
            margin-top: 0;
        }
    }
</style>

<div class="container-fluid">

    <!-- Header -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-semibold mb-0">Master Data</h4>
                <ol class="breadcrumb border border-info px-3 py-2 rounded">
                    <li class="breadcrumb-item">
                        <a href="../dashboard/index.php" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="active text-primary fw-semibold">Master Data</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Tabs dengan Desain Modern & Menyatu -->
    <div class="tabs-modern-container mt-3">
        <ul class="nav nav-tabs" id="masterTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="suppliers-tab" data-bs-toggle="tab" data-bs-target="#suppliers" type="button" role="tab" aria-controls="suppliers" aria-selected="true">
                    <i class="ti ti-building me-2"></i>Suppliers
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="vehicles-tab" data-bs-toggle="tab" data-bs-target="#vehicles" type="button" role="tab" aria-controls="vehicles" aria-selected="false">
                    <i class="ti ti-truck me-2"></i>Vehicles
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="drivers-tab" data-bs-toggle="tab" data-bs-target="#drivers" type="button" role="tab" aria-controls="drivers" aria-selected="false">
                    <i class="ti ti-users me-2"></i>Drivers
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="plants-tab" data-bs-toggle="tab" data-bs-target="#plants" type="button" role="tab" aria-controls="plants" aria-selected="false">
                    <i class="ti ti-map-pin me-2"></i>Plants
                </button>
            </li>
        </ul>

        <!-- Container Card yang Membungkus Semua Tab Content -->
        <div class="card tab-content-card">
            <div class="card-body">
                <div class="tab-content" id="masterTabContent">
                    <!-- ================= SUPPLIERS ================= -->
                    <div class="tab-pane fade show active" id="suppliers" role="tabpanel" aria-labelledby="suppliers-tab">
                        <div class="d-flex justify-content-end mb-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSupplier">
                                <i class="ti ti-plus"></i> Tambah Supplier
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table id="suppliersTable" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Operasional</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ================= VEHICLES ================= -->
                    <div class="tab-pane fade" id="vehicles" role="tabpanel" aria-labelledby="vehicles-tab">
                        <div class="d-flex justify-content-end mb-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalVehicle">
                                <i class="ti ti-plus"></i> Tambah Vehicle
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table id="vehiclesTable" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Plat Nomer</th>
                                        <th>Tipe</th>
                                        <th>Kapasitas</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ================= DRIVERS ================= -->
                    <div class="tab-pane fade" id="drivers" role="tabpanel" aria-labelledby="drivers-tab">
                        <div class="d-flex justify-content-end mb-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDriver">
                                <i class="ti ti-plus"></i> Tambah Driver
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table id="driversTable" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Driver</th>
                                        <th>No Telephone Driver</th>
                                        <th>License Driver</th>
                                        <th>Status Driver</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ================= PLANTS ================= -->
                    <div class="tab-pane fade" id="plants" role="tabpanel" aria-labelledby="plants-tab">
                        <div class="d-flex justify-content-end mb-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPlant">
                                <i class="ti ti-plus"></i> Tambah Plant
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table id="plantsTable" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Plant</th>
                                        <th>Lokasi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Supplier (Create/Edit) -->
<div class="modal fade modal-modern" id="modalSupplier" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-building"></i>
                    <span>Tambah Supplier</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formSupplier">
                    <input type="hidden" name="id">

                    <div class="mb-3">
                        <label class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                        <input type="text" name="nama_supplier" class="form-control" placeholder="Masukkan nama supplier">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat_supplier" class="form-control" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Operasional</label>
                        <input type="text" name="jam_operasional_supplier" class="form-control" placeholder="08:00 - 17:00">
                        <div class="invalid-feedback"></div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ti ti-x"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="saveSupplier">
                    <i class="ti ti-check"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Supplier -->
<div class="modal fade modal-modern" id="modalDeleteSupplier" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">
                    <i class="ti ti-alert-triangle"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="ti ti-trash" style="font-size: 64px; color: #dc3545;"></i>
                <h5 class="mt-3">Yakin ingin menghapus supplier ini?</h5>
                <p class="text-muted mb-3" id="deleteSupplierInfo">Data supplier akan dihapus permanen</p>

                <input type="hidden" id="deleteSupplierId">

                <div class="alert-detail text-start" id="deleteSupplierDetail" style="display: none;">
                    <small>
                        <strong>ID:</strong> <span id="deleteSupplierIdDetail"></span><br>
                        <strong>Nama:</strong> <span id="deleteSupplierName"></span><br>
                        <strong>Alamat:</strong> <span id="deleteSupplierAddress"></span>
                    </small>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="ti ti-x"></i> Batal
                </button>
                <button type="button" class="btn btn-danger px-4" id="confirmDeleteSupplier">
                    <i class="ti ti-trash"></i> Ya, Hapus!
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Vehicle (Create/Edit) -->
<div class="modal fade modal-modern" id="modalVehicle" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-truck"></i>
                    <span>Tambah Vehicle</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formVehicle">
                    <input type="hidden" name="id">

                    <div class="mb-3">
                        <label class="form-label">Plat Nomor Truk <span class="text-danger">*</span></label>
                        <input type="text" name="plat_nomer_truk" class="form-control" placeholder="Contoh: B 1234 ABC">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipe Truk <span class="text-danger">*</span></label>
                        <input type="text" name="tipe_truk" class="form-control" placeholder="Contoh: Mitsubishi Fuso">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kapasitas (Ton) <span class="text-danger">*</span></label>
                        <input type="text" name="kapasitas_truk" class="form-control" placeholder="19000 KG">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Truk <span class="text-danger">*</span></label>
                        <select name="status_truk" class="form-select">
                            <option value="">-- Pilih Status --</option>
                            <option value="Active">✅ Active (Siap Pakai)</option>
                            <option value="On Trip">🛣️ On Trip (Sedang Jalan)</option>
                            <option value="Inactive">⛔ Inactive (Rusak/Service)</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ti ti-x"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="saveVehicle">
                    <i class="ti ti-check"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Vehicle -->
<div class="modal fade modal-modern" id="modalDeleteVehicle" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">
                    <i class="ti ti-alert-triangle"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="ti ti-trash" style="font-size: 64px; color: #dc3545;"></i>
                <h5 class="mt-3">Yakin ingin menghapus vehicle ini?</h5>
                <p class="text-muted mb-3" id="deleteVehicleInfo">Data vehicle akan dihapus permanen</p>

                <input type="hidden" id="deleteVehicleId">

                <div class="alert-detail text-start" id="deleteVehicleDetail" style="display: none;">
                    <small>
                        <strong>Plat Nomor:</strong> <span id="deleteVehiclePlat"></span><br>
                        <strong>Tipe:</strong> <span id="deleteVehicleTipe"></span><br>
                        <strong>Kapasitas:</strong> <span id="deleteVehicleKapasitas"></span><br>
                        <strong>Status:</strong> <span id="deleteVehicleStatus"></span>
                    </small>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="ti ti-x"></i> Batal
                </button>
                <button type="button" class="btn btn-danger px-4" id="confirmDeleteVehicle">
                    <i class="ti ti-trash"></i> Ya, Hapus!
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Driver (Create/Edit) -->
<div class="modal fade modal-modern" id="modalDriver" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-user"></i>
                    <span>Tambah Driver</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formDriver">
                    <input type="hidden" name="id">

                    <div class="mb-3">
                        <label class="form-label">Nama Driver <span class="text-danger">*</span></label>
                        <input type="text" name="nama_sopir" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_telefon_sopir" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No SIM</label>
                        <input type="text" name="lisense_sopir" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status_sopir" class="form-control">
                            <option value="Available">Available</option>
                            <option value="On Duty">On Duty</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ti ti-x"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="saveDriver">
                    <i class="ti ti-check"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Driver -->
<div class="modal fade modal-modern" id="modalDeleteDriver" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">
                    <i class="ti ti-alert-triangle"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="ti ti-trash" style="font-size: 64px; color: #dc3545;"></i>
                <h5 class="mt-3">Yakin ingin menghapus driver ini?</h5>
                <p class="text-muted mb-3" id="deleteDriverInfo">Data driver akan dihapus permanen</p>

                <input type="hidden" id="deleteDriverId">

                <div class="alert-detail text-start" id="deleteDriverDetail" style="display: none;">
                    <small>
                        <strong>Nama:</strong> <span id="deleteDriverName"></span><br>
                        <strong>No SIM:</strong> <span id="deleteDriverNoSIM"></span><br>
                        <strong>No HP:</strong> <span id="deleteDriverNoHP"></span>
                    </small>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ti ti-x"></i> Batal
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteDriver">
                    <i class="ti ti-trash"></i> Ya, Hapus!
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Plant (Create/Edit) -->
<div class="modal fade modal-modern" id="modalPlant" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-map-pin"></i>
                    <span>Tambah Plant</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPlant">
                    <input type="hidden" name="id">

                    <div class="mb-3">
                        <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_perusahaan" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Perusahaan</label>
                        <textarea name="alamat_perusahaan" class="form-control" rows="2"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ti ti-x"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="savePlant">
                    <i class="ti ti-check"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Plant -->
<div class="modal fade modal-modern" id="modalDeletePlant" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">
                    <i class="ti ti-alert-triangle"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="ti ti-trash" style="font-size: 64px; color: #dc3545;"></i>
                <h5 class="mt-3">Yakin ingin menghapus plant ini?</h5>
                <p class="text-muted mb-3" id="deletePlantInfo">Data plant akan dihapus permanen</p>

                <input type="hidden" id="deletePlantId">

                <div class="alert-detail text-start" id="deletePlantDetail" style="display: none;">
                    <small>
                        <strong>Nama:</strong> <span id="deletePlantName"></span><br>
                        <strong>Lokasi:</strong> <span id="deletePlantLokasi"></span><br>
                        <strong>Keterangan:</strong> <span id="deletePlantKeterangan"></span>
                    </small>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ti ti-x"></i> Batal
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeletePlant">
                    <i class="ti ti-trash"></i> Ya, Hapus!
                </button>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>
<?php include '../layout/scripts.php'; ?>

<script>
    $(document).ready(function() {

        // ================= SUPPLIERS =================
        // Inisialisasi DataTables untuk setiap tabel
        var suppliersTable = $('#suppliersTable').DataTable({
            responsive: true,
            ajax: {
                url: 'SupplierController.php',
                type: 'GET',
                dataSrc: function(json) {
                    if (json.status === 'success') {
                        return json.data;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: json.message
                        });
                        return [];
                    }
                }
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'nama_supplier'
                },
                {
                    data: 'alamat_supplier'
                },
                {
                    data: 'jam_operasional_supplier'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                <button class="btn btn-sm btn-warning editSupplier" data-id="${row.id}"><i class="ti ti-edit"></i> Edit</button>
                <button class="btn btn-sm btn-danger deleteSupplier" data-id="${row.id}"><i class="ti ti-trash"></i> Hapus</button>
                `;
                    },
                    orderable: false
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            order: [
                [0, 'asc']
            ],
            pageLength: 10,
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Semua"]
            ]
        });

        // Edit Supplier
        $('#suppliersTable').on('click', '.editSupplier', function() {
            var data = suppliersTable.row($(this).parents('tr')).data();

            $('#modalSupplier .modal-title span').text('Edit Supplier');
            $('#modalSupplier input[name="id"]').val(data.id);
            $('#modalSupplier input[name="nama_supplier"]').val(data.nama_supplier);
            $('#modalSupplier textarea[name="alamat_supplier"]').val(data.alamat_supplier);
            $('#modalSupplier input[name="jam_operasional_supplier"]').val(data.jam_operasional_supplier);

            $('#modalSupplier').modal('show');
        });

        // Save / Update Supplier
        $('#saveSupplier').click(function() {
            var form = $('#formSupplier');
            var formData = form.serializeArray();
            var dataObj = {};
            formData.forEach(function(item) {
                dataObj[item.name] = item.value;
            });

            var action = dataObj.id ? 'update' : 'insert';
            dataObj.action = action;

            // Reset previous error styling
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            // Disable button to prevent double submit
            var $btn = $(this);
            $btn.prop('disabled', true).html('<i class="ti ti-loader"></i> Menyimpan...');

            $.post('SupplierController.php', dataObj, function(response) {
                if (response.status === 'success') {
                    suppliersTable.ajax.reload();
                    $('#modalSupplier').modal('hide');

                    // Reset form
                    form[0].reset();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    // Cek apakah ada errors per field
                    if (response.errors) {
                        // Tampilkan error untuk masing-masing field
                        $.each(response.errors, function(field, message) {
                            var input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            input.next('.invalid-feedback').text(message);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message
                        });
                    }
                }
            }, 'json').fail(function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan komunikasi dengan server'
                });
            }).always(function() {
                // Enable button kembali
                $btn.prop('disabled', false).html('<i class="ti ti-check"></i> Simpan');
            });
        });

        // Delete Supplier dengan Modal Custom
        $('#suppliersTable').on('click', '.deleteSupplier', function() {

            var id = $(this).data('id');

            var data = suppliersTable
                .rows()
                .data()
                .toArray()
                .find(row => row.id == id);

            if (!data) {
                Swal.fire('Error', 'Data tidak ditemukan', 'error');
                return;
            }

            $('#deleteSupplierId').val(data.id);
            $('#deleteSupplierIdDetail').text(data.id);
            $('#deleteSupplierName').text(data.nama_supplier);
            $('#deleteSupplierAddress').text(data.alamat_supplier);

            $('#deleteSupplierDetail').show();
            $('#deleteSupplierInfo').text(`Supplier "${data.nama_supplier}" akan dihapus permanen`);

            $('#modalDeleteSupplier').modal('show');
        });

        // Confirm Delete Supplier
        $('#confirmDeleteSupplier').click(function() {
            var id = $('#deleteSupplierId').val();
            var $btn = $(this);
            var $modal = $('#modalDeleteSupplier');

            // Disable button dan show loading
            $btn.prop('disabled', true).html('<i class="ti ti-loader"></i> Menghapus...');

            $.post('SupplierController.php', {
                action: 'delete',
                id: id
            }, function(response) {
                if (response.status === 'success') {
                    // Tutup modal delete
                    $modal.modal('hide');

                    // Reload tabel
                    suppliersTable.ajax.reload(null, false);

                    // Tampilkan notifikasi sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false,
                        position: 'top-end',
                        toast: true
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message,
                        confirmButtonColor: '#dc3545'
                    });
                }
            }, 'json').fail(function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan komunikasi dengan server'
                });
            }).always(function() {
                // Enable button kembali
                $btn.prop('disabled', false).html('<i class="ti ti-trash"></i> Ya, Hapus!');
            });
        });

        // Reset modal delete ketika ditutup
        $('#modalDeleteSupplier').on('hidden.bs.modal', function() {
            $(this).find('#deleteSupplierId').val('');
            $(this).find('#deleteSupplierDetail').hide();
            $(this).find('#deleteSupplierInfo').text('Data supplier akan dihapus permanen');
            $('#confirmDeleteSupplier').prop('disabled', false).html('<i class="ti ti-trash"></i> Ya, Hapus!');
        });

        // Reset form ketika modal supplier ditutup
        $('#modalSupplier').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $(this).find('input[name="id"]').val('');
            $(this).find('.modal-title span').text('Tambah Supplier');
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();
        });

        // Validasi realtime saat user mengetik
        $('#modalSupplier input, #modalSupplier textarea').on('input', function() {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').empty();
        });

        // ================= END SUPPLIERS =================

        // ================= VEHICLES =================
        // Inisialisasi DataTable untuk vehicles
        var vehiclesTable = $('#vehiclesTable').DataTable({
            responsive: true,
            ajax: {
                url: 'VehicleController.php',
                type: 'GET',
                dataSrc: function(json) {
                    if (json.status === 'success') {
                        return json.data;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: json.message
                        });
                        return [];
                    }
                }
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'plat_nomer_truk'
                },
                {
                    data: 'tipe_truk'
                },
                {
                    data: 'kapasitas_truk',
                },
                {
                    data: 'status_truk',
                    render: function(data) {
                        var badgeClass = 'secondary';
                        var icon = '';

                        switch (data) {
                            case 'Active':
                                badgeClass = 'success';
                                icon = '✅ ';
                                break;
                            case 'On Trip':
                                badgeClass = 'warning';
                                icon = '🛣️ ';
                                break;
                            case 'Inactive':
                                badgeClass = 'danger';
                                icon = '⛔ ';
                                break;
                        }

                        // Translate ke Bahasa Indonesia untuk tampilan
                        var displayText = data;
                        if (data === 'Active') displayText = 'Aktif';
                        else if (data === 'On Trip') displayText = 'Dalam Perjalanan';
                        else if (data === 'Inactive') displayText = 'Tidak Aktif';

                        return '<span class="badge bg-' + badgeClass + '">' + icon + displayText + '</span>';
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                    <button class="btn btn-sm btn-warning editVehicle" data-id="${row.id}">
                        <i class="ti ti-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger deleteVehicle" data-id="${row.id}">
                        <i class="ti ti-trash"></i> Hapus
                    </button>
                `;
                    },
                    orderable: false
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            order: [
                [0, 'asc']
            ],
            pageLength: 10,
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Semua"]
            ]
        });

        // Reset form modal vehicle
        function resetVehicleModal() {
            $('#modalVehicle .modal-title span').text('Tambah Vehicle');
            $('#formVehicle')[0].reset();
            $('#formVehicle input[name="id"]').val('');
            $('#formVehicle select[name="status_truk"]').val(''); // Reset ke default
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();
        }

        // Edit Vehicle
        $('#vehiclesTable').on('click', '.editVehicle', function() {
            var data = vehiclesTable.row($(this).parents('tr')).data();

            $('#modalVehicle .modal-title span').text('Edit Vehicle');
            $('#formVehicle input[name="id"]').val(data.id);
            $('#formVehicle input[name="plat_nomer_truk"]').val(data.plat_nomer_truk);
            $('#formVehicle input[name="tipe_truk"]').val(data.tipe_truk);
            $('#formVehicle input[name="kapasitas_truk"]').val(data.kapasitas_truk);
            $('#formVehicle select[name="status_truk"]').val(data.status_truk); // Ganti ke select

            $('#modalVehicle').modal('show');
        });

        // Save / Update Vehicle
        $('#saveVehicle').click(function() {
            var form = $('#formVehicle');
            var formData = new FormData(form[0]);

            var id = form.find('input[name="id"]').val();
            var action = id ? 'update' : 'insert';
            formData.append('action', action);

            // Reset previous error styling
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            // Disable button
            var $btn = $(this);
            $btn.prop('disabled', true).html('<i class="ti ti-loader"></i> Menyimpan...');

            $.ajax({
                url: 'VehicleController.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        vehiclesTable.ajax.reload();
                        $('#modalVehicle').modal('hide');
                        resetVehicleModal();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        if (response.errors) {
                            $.each(response.errors, function(field, message) {
                                var input = $('[name="' + field + '"]');
                                input.addClass('is-invalid');

                                // Untuk select, next element nya beda
                                if (input.is('select')) {
                                    input.next('.invalid-feedback').text(message);
                                } else {
                                    input.next('.invalid-feedback').text(message);
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan komunikasi dengan server'
                    });
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="ti ti-check"></i> Simpan');
                }
            });
        });

        // Delete Vehicle dengan Modal Custom
        $('#vehiclesTable').on('click', '.deleteVehicle', function() {

            var id = $(this).data('id');

            var data = vehiclesTable
                .rows()
                .data()
                .toArray()
                .find(row => row.id == id);

            if (!data) {
                Swal.fire('Error', 'Data tidak ditemukan', 'error');
                return;
            }

            $('#deleteVehicleId').val(data.id);
            $('#deleteVehiclePlat').text(data.plat_nomer_truk);
            $('#deleteVehicleTipe').text(data.tipe_truk);
            $('#deleteVehicleKapasitas').text(data.kapasitas_truk);
            $('#deleteVehicleStatus').text(data.status_truk);

            $('#deleteVehicleDetail').show();
            $('#deleteVehicleInfo').text(`Vehicle "${data.plat_nomer_truk}" akan dihapus permanen`);

            $('#modalDeleteVehicle').modal('show');
        });

        // Confirm Delete Vehicle
        $('#confirmDeleteVehicle').click(function() {
            var id = $('#deleteVehicleId').val();
            var $btn = $(this);
            var $modal = $('#modalDeleteVehicle');

            $btn.prop('disabled', true).html('<i class="ti ti-loader"></i> Menghapus...');

            $.ajax({
                url: 'VehicleController.php',
                type: 'POST',
                data: {
                    action: 'delete',
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $modal.modal('hide');
                        vehiclesTable.ajax.reload(null, false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false,
                            position: 'top-end',
                            toast: true
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            confirmButtonColor: '#dc3545'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan komunikasi dengan server'
                    });
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="ti ti-trash"></i> Ya, Hapus!');
                }
            });
        });

        // Reset modal delete vehicle
        $('#modalDeleteVehicle').on('hidden.bs.modal', function() {
            $(this).find('#deleteVehicleId').val('');
            $(this).find('#deleteVehicleDetail').hide();
            $(this).find('#deleteVehicleInfo').text('Data vehicle akan dihapus permanen');
            $('#confirmDeleteVehicle').prop('disabled', false).html('<i class="ti ti-trash"></i> Ya, Hapus!');
        });

        // Reset modal vehicle ketika ditutup
        $('#modalVehicle').on('hidden.bs.modal', function() {
            resetVehicleModal();
        });

        // Validasi realtime
        $('#modalVehicle input, #modalVehicle select').on('input change', function() {
            $(this).removeClass('is-invalid');
            if ($(this).is('select')) {
                $(this).next('.invalid-feedback').empty();
            } else {
                $(this).next('.invalid-feedback').empty();
            }
        });

        // ================= END VEHICLES =================

        // ================= DRIVERS =================
        var driversTable = $('#driversTable').DataTable({
            responsive: true,
            ajax: {
                url: 'DriverController.php',
                type: 'GET',
                dataSrc: function(json) {
                    if (json.status === 'success') {
                        return json.data;
                    } else {
                        Swal.fire('Error', json.message, 'error');
                        return [];
                    }
                }
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'nama_sopir'
                },
                {
                    data: 'no_telefon_sopir'
                },
                {
                    data: 'lisense_sopir'
                },
                {
                    data: 'status_sopir',
                    render: function(data) {
                        var badgeClass = 'secondary';
                        var icon = '';

                        switch (data) {
                            case 'Available':
                                badgeClass = 'success';
                                icon = '✅ ';
                                break;
                            case 'On Duty':
                                badgeClass = 'warning';
                                icon = '🛣️ ';
                                break;
                        }
                        return '<span class="badge bg-' + badgeClass + '">' + icon + data + '</span>';
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
        <button class="btn btn-sm btn-warning editDriver" data-id="${row.id}">
            <i class="ti ti-edit"></i> Edit
        </button>
        <button class="btn btn-sm btn-danger deleteDriver" data-id="${row.id}">
            <i class="ti ti-trash"></i> Hapus
        </button>
        `;
                    },
                    orderable: false
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            order: [
                [0, 'asc']
            ]
        });

        // Fungsi untuk mereset form driver
        function resetDriverForm() {
            $('#formDriver')[0].reset();
            $('#formDriver input[name="id"]').val('');
            $('#modalDriver .modal-title span').text('Tambah Driver');
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();
        }

        // Reset form saat modal ditutup
        $('#modalDriver').on('hidden.bs.modal', function() {
            resetDriverForm();
        });

        // Reset form saat tombol batal diklik
        $('#modalDriver .btn-secondary').click(function() {
            resetDriverForm();
        });

        $('#driversTable').on('click', '.editDriver', function() {
            var id = $(this).data('id');

            var data = driversTable
                .rows()
                .data()
                .toArray()
                .find(row => row.id == id);

            if (!data) return;

            $('#modalDriver .modal-title span').text('Edit Driver');
            $('#formDriver input[name="id"]').val(data.id);
            $('#formDriver input[name="nama_sopir"]').val(data.nama_sopir);
            $('#formDriver input[name="lisense_sopir"]').val(data.lisense_sopir);
            $('#formDriver input[name="no_telefon_sopir"]').val(data.no_telefon_sopir);
            $('#formDriver select[name="status_sopir"]').val(data.status_sopir);

            $('#modalDriver').modal('show');
        });

        $('#saveDriver').click(function() {
            var form = $('#formDriver');
            var formData = new FormData(form[0]);

            var id = form.find('input[name="id"]').val();
            var action = id ? 'update' : 'insert';
            formData.append('action', action);

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            var $btn = $(this);
            $btn.prop('disabled', true).html('<i class="ti ti-loader"></i> Menyimpan...');

            $.ajax({
                url: 'DriverController.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        driversTable.ajax.reload();
                        $('#modalDriver').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        if (response.errors) {
                            $.each(response.errors, function(field, message) {
                                var input = $('[name="' + field + '"]');
                                input.addClass('is-invalid');
                                input.next('.invalid-feedback').text(message);
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    }
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="ti ti-check"></i> Simpan');
                }
            });
        });

        $('#driversTable').on('click', '.deleteDriver', function() {
            var id = $(this).data('id');

            var data = driversTable
                .rows()
                .data()
                .toArray()
                .find(row => row.id == id);

            if (!data) return;

            $('#deleteDriverId').val(data.id);
            $('#deleteDriverName').text(data.nama_sopir);
            $('#deleteDriverNoSIM').text(data.lisense_sopir);
            $('#deleteDriverNoHP').text(data.no_telefon_sopir);

            $('#deleteDriverDetail').show();
            $('#deleteDriverInfo').text(`Driver "${data.nama_sopir}" akan dihapus permanen`);

            $('#modalDeleteDriver').modal('show');
        });

        $('#confirmDeleteDriver').click(function() {
            var id = $('#deleteDriverId').val();
            var $btn = $(this);

            $btn.prop('disabled', true).html('<i class="ti ti-loader"></i> Menghapus...');

            $.post('DriverController.php', {
                action: 'delete',
                id: id
            }, function(response) {
                if (response.status === 'success') {
                    $('#modalDeleteDriver').modal('hide');
                    driversTable.ajax.reload(null, false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }, 'json').always(function() {
                $btn.prop('disabled', false).html('<i class="ti ti-trash"></i> Ya, Hapus!');
            });
        });

        // ================= END DRIVERS =================

        // ================= PLANTS =================
        var plantsTable = $('#plantsTable').DataTable({
            responsive: true,
            ajax: {
                url: 'PlantController.php',
                type: 'GET',
                dataSrc: function(json) {
                    if (json.status === 'success') {
                        return json.data;
                    } else {
                        Swal.fire('Error', json.message, 'error');
                        return [];
                    }
                }
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'nama_perusahaan'
                },
                {
                    data: 'alamat_perusahaan'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                    <button class="btn btn-sm btn-warning editPlant" data-id="${row.id}">
                        <i class="ti ti-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger deletePlant" data-id="${row.id}">
                        <i class="ti ti-trash"></i> Hapus
                    </button>
                `;
                    },
                    orderable: false
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            order: [
                [0, 'asc']
            ]
        });


        // RESET MODAL
        function resetPlantModal() {
            $('#modalPlant .modal-title span').text('Tambah Plant');
            $('#formPlant')[0].reset();
            $('#formPlant input[name="id"]').val('');
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();
        }

        $('#modalPlant').on('hidden.bs.modal', function() {
            resetPlantModal();
        });


        // EDIT
        $('#plantsTable').on('click', '.editPlant', function() {

            var id = $(this).data('id');

            var data = plantsTable
                .rows()
                .data()
                .toArray()
                .find(row => row.id == id);

            if (!data) return;

            $('#modalPlant .modal-title span').text('Edit Plant');
            $('#formPlant input[name="id"]').val(data.id);
            $('#formPlant input[name="nama_perusahaan"]').val(data.nama_perusahaan);
            $('#formPlant textarea[name="alamat_perusahaan"]').val(data.alamat_perusahaan);

            $('#modalPlant').modal('show');
        });


        // SAVE
        $('#savePlant').click(function() {

            var form = $('#formPlant');
            var formData = new FormData(form[0]);

            var id = form.find('input[name="id"]').val();
            var action = id ? 'update' : 'insert';
            formData.append('action', action);

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            var $btn = $(this);
            $btn.prop('disabled', true).html('<i class="ti ti-loader"></i> Menyimpan...');

            $.ajax({
                url: 'PlantController.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status === 'success') {

                        plantsTable.ajax.reload();
                        $('#modalPlant').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                    } else {

                        if (response.errors) {
                            $.each(response.errors, function(field, message) {
                                var input = $('[name="' + field + '"]');
                                input.addClass('is-invalid');
                                input.next('.invalid-feedback').text(message);
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    }
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="ti ti-check"></i> Simpan');
                }
            });
        });


        // DELETE CLICK
        $('#plantsTable').on('click', '.deletePlant', function() {

            var id = $(this).data('id');

            var data = plantsTable
                .rows()
                .data()
                .toArray()
                .find(row => row.id == id);

            if (!data) return;

            $('#deletePlantId').val(data.id);
            $('#deletePlantName').text(data.nama_perusahaan);
            $('#deletePlantLokasi').text(data.alamat_perusahaan);
            $('#deletePlantKeterangan').text(data.kapasitas_perusahaan);

            $('#deletePlantDetail').show();
            $('#deletePlantInfo').text(`Plant "${data.nama_perusahaan}" akan dihapus permanen`);

            $('#modalDeletePlant').modal('show');
        });


        // CONFIRM DELETE
        $('#confirmDeletePlant').click(function() {

            var id = $('#deletePlantId').val();
            var $btn = $(this);

            $btn.prop('disabled', true).html('<i class="ti ti-loader"></i> Menghapus...');

            $.post('PlantController.php', {
                action: 'delete',
                id: id
            }, function(response) {

                if (response.status === 'success') {

                    $('#modalDeletePlant').modal('hide');
                    plantsTable.ajax.reload(null, false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });

                } else {
                    Swal.fire('Error', response.message, 'error');
                }

            }, 'json').always(function() {
                $btn.prop('disabled', false).html('<i class="ti ti-trash"></i> Ya, Hapus!');
            });
        });


        // ================= END PLANTS =================

        // Handle saat tab berubah
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).data('bs-target');

            switch (target) {
                case '#suppliers':
                    suppliersTable.columns.adjust();
                    break;
                case '#vehicles':
                    vehiclesTable.columns.adjust();
                    break;
                case '#drivers':
                    driversTable.columns.adjust();
                    break;
                case '#plants':
                    plantsTable.columns.adjust();
                    break;
            }
        });

        // Handle resize window untuk responsif
        $(window).on('resize', function() {
            suppliersTable.columns.adjust();
            vehiclesTable.columns.adjust();
            driversTable.columns.adjust();
            plantsTable.columns.adjust();
        });

    });
</script>