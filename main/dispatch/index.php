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

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<?php include '../layout/sidebar.php'; ?>
<?php include '../layout/header.php'; ?>

<div class="container-fluid">

    <!-- Header -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-semibold mb-0">Dispatch Data</h4>
                <ol class="breadcrumb border border-info px-3 py-2 rounded">
                    <li class="breadcrumb-item">
                        <a href="../dashboard/index.php" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="active text-primary fw-semibold">Dispatch Data</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="row">
        <!-- Card Pending Assignment -->
        <div class="col-lg-4">
            <div class="card overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <p class="mb-1 fs-4 text-muted">Pending Assignment</p>
                            <h2 class="mb-0 fw-semibold">24</h2>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i class="ti ti-clock-hour-4 fs-7 text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Ready to Dispatch -->
        <div class="col-lg-4">
            <div class="card overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <p class="mb-1 fs-4 text-muted">Ready to Dispatch</p>
                            <h2 class="mb-0 fw-semibold">18</h2>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="ti ti-circle-check fs-7 text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Dispatched -->
        <div class="col-lg-4">
            <div class="card overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <p class="mb-1 fs-4 text-muted">Dispatched</p>
                            <h2 class="mb-0 fw-semibold">156</h2>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i class="ti ti-truck-delivery fs-7 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dispatch List Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Routes for Dispatch</h5>

                    <div class="table-responsive">
                        <table id="dispatchTable" class="table table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th>Route ID</th>
                                    <th>Route Details</th>
                                    <th>Vehicle</th>
                                    <th>Driver</th>
                                    <th>Departure</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>R-001</td>
                                    <td>Jakarta - Bandung</td>
                                    <td>B 1234 ABC</td>
                                    <td>Budi Santoso</td>
                                    <td>08:00</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-primary view-btn" title="View Details"><i class="ti ti-eye"></i></button>
                                        <button class="btn btn-sm btn-info edit-btn" title="Edit Assignment"><i class="ti ti-edit"></i></button>
                                        <button class="btn btn-sm btn-success start-btn" title="Start Dispatch" disabled><i class="ti ti-player-play"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>R-002</td>
                                    <td>Surabaya - Malang</td>
                                    <td>-</td>
                                    <td>Agus Wijaya</td>
                                    <td>09:30</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-primary view-btn" title="View Details"><i class="ti ti-eye"></i></button>
                                        <button class="btn btn-sm btn-info assign-btn" title="Assign Vehicle" data-assign-type="vehicle"><i class="ti ti-truck"></i></button>
                                        <button class="btn btn-sm btn-success start-btn" title="Start Dispatch" disabled><i class="ti ti-player-play"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>R-003</td>
                                    <td>Bandung - Yogyakarta</td>
                                    <td>D 9012 GHI</td>
                                    <td>-</td>
                                    <td>07:15</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-primary view-btn" title="View Details"><i class="ti ti-eye"></i></button>
                                        <button class="btn btn-sm btn-info assign-btn" title="Assign Driver" data-assign-type="driver"><i class="ti ti-user"></i></button>
                                        <button class="btn btn-sm btn-success start-btn" title="Start Dispatch" disabled><i class="ti ti-player-play"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>R-004</td>
                                    <td>Jakarta - Surabaya</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>10:45</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-primary view-btn" title="View Details"><i class="ti ti-eye"></i></button>
                                        <button class="btn btn-sm btn-warning assign-all-btn" title="Assign Both"><i class="ti ti-user-plus"></i> Assign</button>
                                        <button class="btn btn-sm btn-success start-btn" title="Start Dispatch" disabled><i class="ti ti-player-play"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>R-005</td>
                                    <td>Medan - Pekanbaru</td>
                                    <td>BK 7890 MNO</td>
                                    <td>Fitri Handayani</td>
                                    <td>11:20</td>
                                    <td><span class="badge bg-success">Ready</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-primary view-btn" title="View Details"><i class="ti ti-eye"></i></button>
                                        <button class="btn btn-sm btn-info edit-btn" title="Edit Assignment"><i class="ti ti-edit"></i></button>
                                        <button class="btn btn-sm btn-success start-btn" title="Start Dispatch"><i class="ti ti-player-play"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>R-006</td>
                                    <td>Makassar - Pare-pare</td>
                                    <td>DD 1234 PQR</td>
                                    <td>Hasan Ismail</td>
                                    <td>08:30</td>
                                    <td><span class="badge bg-primary">Dispatched</span></td>
                                    <td class="action-buttons">
                                        <button class="btn btn-sm btn-primary view-btn" title="View Details"><i class="ti ti-eye"></i></button>
                                        <button class="btn btn-sm btn-secondary" disabled><i class="ti ti-lock"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Assign Driver & Vehicle -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Assign Driver & Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignForm">
                    <input type="hidden" id="routeId" name="route_id">
                    <input type="hidden" id="assignType" name="assign_type">

                    <div class="mb-3" id="vehicleField">
                        <label for="vehicleSelect" class="form-label">Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select select2-modal" id="vehicleSelectModal" name="vehicle_id">
                            <option value="">Select Vehicle</option>
                            <option value="1">B 1234 ABC - Truck</option>
                            <option value="2">L 5678 DEF - Truck</option>
                            <option value="3">D 9012 GHI - Truck</option>
                            <option value="4">B 3456 JKL - Truck</option>
                            <option value="5">BK 7890 MNO - Truck</option>
                        </select>
                    </div>

                    <div class="mb-3" id="driverField">
                        <label for="driverSelect" class="form-label">Driver <span class="text-danger">*</span></label>
                        <select class="form-select select2-modal" id="driverSelectModal" name="driver_id">
                            <option value="">Select Driver</option>
                            <option value="1">Budi Santoso</option>
                            <option value="2">Agus Wijaya</option>
                            <option value="3">Citra Dewi</option>
                            <option value="4">Eko Prasetyo</option>
                            <option value="5">Fitri Handayani</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveAssignment">Save Assignment</button>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>
<?php include '../layout/scripts.php'; ?>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 untuk modal
        $('.select2-modal').select2({
            theme: 'bootstrap-5',
            width: '100%',
            dropdownParent: $('#assignModal')
        });

        // Initialize DataTable
        var table = $('#dispatchTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                targets: 5, // Status column
                render: function(data, type, row) {
                    if (type === 'display') {
                        return data;
                    }
                    return $(data).text();
                }
            }],
            order: [
                [4, 'asc']
            ]
        });

        // Handle View button
        $('#dispatchTable').on('click', '.view-btn', function() {
            var data = table.row($(this).parents('tr')).data();
            alert('View details for Route: ' + data[0]);
        });

        // Handle Edit button (for fully assigned)
        $('#dispatchTable').on('click', '.edit-btn', function() {
            var data = table.row($(this).parents('tr')).data();
            $('#routeId').val(data[0]);
            $('#assignType').val('edit');
            $('#assignModalLabel').text('Edit Assignment - ' + data[0]);
            $('#vehicleField').show();
            $('#driverField').show();
            $('#assignModal').modal('show');

            // Set selected values (in real app, you'd fetch current values)
            $('#vehicleSelectModal').val('1').trigger('change');
            $('#driverSelectModal').val('1').trigger('change');
        });

        // Handle Assign button (for specific missing item)
        $('#dispatchTable').on('click', '.assign-btn', function() {
            var data = table.row($(this).parents('tr')).data();
            var assignType = $(this).data('assign-type');

            $('#routeId').val(data[0]);
            $('#assignType').val(assignType);

            if (assignType === 'vehicle') {
                $('#assignModalLabel').text('Assign Vehicle - ' + data[0]);
                $('#vehicleField').show();
                $('#driverField').hide();
            } else if (assignType === 'driver') {
                $('#assignModalLabel').text('Assign Driver - ' + data[0]);
                $('#vehicleField').hide();
                $('#driverField').show();
            }

            $('#assignModal').modal('show');
        });

        // Handle Assign All button (both missing)
        $('#dispatchTable').on('click', '.assign-all-btn', function() {
            var data = table.row($(this).parents('tr')).data();
            $('#routeId').val(data[0]);
            $('#assignType').val('both');
            $('#assignModalLabel').text('Assign Driver & Vehicle - ' + data[0]);
            $('#vehicleField').show();
            $('#driverField').show();
            $('#assignModal').modal('show');
        });

        // Handle Start button
        $('#dispatchTable').on('click', '.start-btn:not(:disabled)', function() {
            var data = table.row($(this).parents('tr')).data();
            if (confirm('Start dispatch for Route ' + data[0] + '?')) {
                alert('Dispatch started for ' + data[0]);
                // In real app, you'd update status via AJAX
                $(this).closest('tr').find('td:eq(5)').html('<span class="badge bg-primary">Dispatched</span>');
                $(this).closest('.action-buttons').html(`
                    <button class="btn btn-sm btn-primary view-btn" title="View Details"><i class="ti ti-eye"></i></button>
                    <button class="btn btn-sm btn-secondary" disabled><i class="ti ti-lock"></i></button>
                `);
            }
        });

        // Save Assignment
        $('#saveAssignment').click(function() {
            var routeId = $('#routeId').val();
            var assignType = $('#assignType').val();
            var vehicleId = $('#vehicleSelectModal').val();
            var driverId = $('#driverSelectModal').val();

            // Validation
            if (assignType === 'vehicle' || assignType === 'both' || assignType === 'edit') {
                if (!vehicleId) {
                    alert('Please select a vehicle');
                    return;
                }
            }

            if (assignType === 'driver' || assignType === 'both' || assignType === 'edit') {
                if (!driverId) {
                    alert('Please select a driver');
                    return;
                }
            }

            // In real app, you'd send AJAX request here
            alert('Assignment saved for Route ' + routeId);

            // Update table row (demo)
            var row = $('#dispatchTable').find('td:first-child:contains("' + routeId + '")').closest('tr');

            if (assignType === 'vehicle' || assignType === 'both') {
                var vehicleText = $('#vehicleSelectModal option:selected').text();
                row.find('td:eq(2)').text(vehicleText.split(' - ')[0]);
            }

            if (assignType === 'driver' || assignType === 'both') {
                var driverText = $('#driverSelectModal option:selected').text();
                row.find('td:eq(3)').text(driverText);
            }

            // Update action buttons based on current state
            var vehicle = row.find('td:eq(2)').text();
            var driver = row.find('td:eq(3)').text();
            var actionsCell = row.find('td:eq(6)');

            if (vehicle !== '-' && driver !== '-') {
                actionsCell.html(`
                    <button class="btn btn-sm btn-primary view-btn" title="View Details"><i class="ti ti-eye"></i></button>
                    <button class="btn btn-sm btn-info edit-btn" title="Edit Assignment"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-sm btn-success start-btn" title="Start Dispatch"><i class="ti ti-player-play"></i></button>
                `);
            }

            $('#assignModal').modal('hide');
            $('#assignForm')[0].reset();
            $('#vehicleSelectModal').val('').trigger('change');
            $('#driverSelectModal').val('').trigger('change');
        });

        // Reset modal when hidden
        $('#assignModal').on('hidden.bs.modal', function() {
            $('#assignForm')[0].reset();
            $('#vehicleSelectModal').val('').trigger('change');
            $('#driverSelectModal').val('').trigger('change');
            $('#vehicleField').show();
            $('#driverField').show();
        });
    });
</script>

<style>
    /* Styling tambahan untuk card */
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }

    .fs-7 {
        font-size: 2rem;
    }

    .card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .rounded-circle {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Styling untuk badges */
    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #212529;
    }

    .badge.bg-success {
        background-color: #198754 !important;
        color: white;
    }

    .badge.bg-primary {
        background-color: #0d6efd !important;
        color: white;
    }

    /* Styling untuk action buttons */
    .action-buttons {
        white-space: nowrap;
        min-width: 120px;
    }

    .btn-sm {
        margin: 0 2px;
        padding: 0.25rem 0.5rem;
    }

    .btn-sm i {
        font-size: 14px;
    }

    /* Button variants */
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .col-lg-4 {
            margin-bottom: 20px;
        }

        .btn-sm {
            padding: 0.15rem 0.3rem;
        }
    }
</style>