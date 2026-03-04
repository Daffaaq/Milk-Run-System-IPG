<?php
session_start();
include '../../helper/connection.php';
header("Content-Type: application/json");

if ($connection === false) {
    echo json_encode(['status' => 'error', 'message' => 'Koneksi database gagal']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        handleGetData($connection);
        break;

    case 'POST':
        $action = $_POST['action'] ?? '';
        switch ($action) {
            case 'insert':
                handleInsertData($connection);
                break;
            case 'update':
                handleUpdateData($connection);
                break;
            case 'delete':
                handleDeleteData($connection);
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Aksi POST tidak valid']);
                break;
        }
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan']);
        break;
}

// ==========================
// Handle GET Data
// ==========================
function handleGetData($connection)
{
    $sql = "SELECT id, nama_supplier, alamat_supplier, jam_operasional_supplier, created_at 
            FROM tmssupplier 
            ORDER BY id DESC";

    $stmt = sqlsrv_prepare($connection, $sql);
    $rows = [];

    if ($stmt && sqlsrv_execute($stmt)) {
        $no = 1;
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $created_at = '';
            if (!empty($row['created_at'])) {
                $created_at = $row['created_at'] instanceof DateTime
                    ? $row['created_at']->format('Y-m-d H:i:s')
                    : $row['created_at'];
            }
            $rows[] = [
                'no' => $no++,
                'id' => $row['id'],
                'nama_supplier' => $row['nama_supplier'],
                'alamat_supplier' => $row['alamat_supplier'],
                'jam_operasional_supplier' => $row['jam_operasional_supplier'],
                'created_at' => $created_at
            ];
        }
        echo json_encode(['status' => 'success', 'data' => $rows]);
    } else {
        $errors = sqlsrv_errors();
        echo json_encode(['status' => 'error', 'message' => 'Query gagal', 'detail' => $errors]);
    }
    exit;
}

// ==========================
// Handle Insert Data with Lock
// ==========================
function handleInsertData($connection)
{
    $errors = [];

    $nama_supplier = trim($_POST['nama_supplier'] ?? '');
    $alamat_supplier = trim($_POST['alamat_supplier'] ?? '');
    $jam_operasional = trim($_POST['jam_operasional_supplier'] ?? '');

    if (empty($nama_supplier)) $errors['nama_supplier'] = 'Nama Supplier wajib diisi';
    if (empty($alamat_supplier)) $errors['alamat_supplier'] = 'Alamat Supplier wajib diisi';
    if (empty($jam_operasional)) $errors['jam_operasional_supplier'] = 'Jam Operasional wajib diisi';

    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'message' => 'Validasi gagal', 'errors' => $errors]);
        exit;
    }

    // Mulai Transaksi
    if (sqlsrv_begin_transaction($connection) === false) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal inisialisasi transaksi database']);
        exit;
    }

    try {
        // Check duplicate name (bisa di luar lock karena read-only, tapi tetap dalam transaksi)
        $sqlCheck = "SELECT COUNT(*) as total FROM tmssupplier WHERE nama_supplier = ?";
        $stmtCheck = sqlsrv_prepare($connection, $sqlCheck, [$nama_supplier]);
        if ($stmtCheck && sqlsrv_execute($stmtCheck)) {
            $rowCheck = sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC);
            if ($rowCheck['total'] > 0) {
                sqlsrv_rollback($connection);
                echo json_encode(['status' => 'error', 'message' => 'Nama Supplier sudah terdaftar', 'errors' => ['nama_supplier' => 'Nama Supplier sudah digunakan']]);
                exit;
            }
        }

        /**
         * GENERATE ID DENGAN LOCKING:
         * Pakai UPDLOCK & HOLDLOCK biar user lain gak bisa baca ID terakhir
         * selama proses transaksi kita belum selesai
         */
        $sqlGetId = "SELECT TOP 1 
                        CAST(SUBSTRING(id, 3, LEN(id)) AS INT) as last_num 
                     FROM tmssupplier WITH (UPDLOCK, HOLDLOCK) 
                     WHERE id LIKE 'VL%' 
                     ORDER BY last_num DESC";

        $stmtId = sqlsrv_query($connection, $sqlGetId);
        if ($stmtId === false) {
            throw new Exception("Gagal sinkronisasi ID terakhir");
        }

        $row = sqlsrv_fetch_array($stmtId, SQLSRV_FETCH_ASSOC);
        $nextNumber = ($row ? (int)$row['last_num'] : 0) + 1;
        $newId = "VL" . str_pad($nextNumber, 5, "0", STR_PAD_LEFT);

        // Insert data
        $sql = "INSERT INTO tmssupplier (id, nama_supplier, alamat_supplier, jam_operasional_supplier, created_at) 
                VALUES (?, ?, ?, ?, GETDATE())";
        $params = [$newId, $nama_supplier, $alamat_supplier, $jam_operasional];
        $stmt = sqlsrv_prepare($connection, $sql, $params);

        if (!$stmt || !sqlsrv_execute($stmt)) {
            throw new Exception("Gagal menyimpan data supplier");
        }

        // Commit transaksi
        sqlsrv_commit($connection);

        echo json_encode([
            'status' => 'success',
            'message' => 'Supplier berhasil ditambahkan',
            'data' => [
                'id' => $newId,
                'nama_supplier' => $nama_supplier,
                'alamat_supplier' => $alamat_supplier,
                'jam_operasional_supplier' => $jam_operasional
            ]
        ]);
    } catch (Exception $e) {
        // Rollback jika ada error
        sqlsrv_rollback($connection);

        // Log error untuk debugging
        error_log(print_r(sqlsrv_errors(), true));

        echo json_encode([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            'detail' => sqlsrv_errors()
        ]);
    }
    exit;
}

// ==========================
// Handle Update Data
// ==========================
function handleUpdateData($connection)
{
    $id = trim($_POST['id'] ?? '');
    $nama_supplier = trim($_POST['nama_supplier'] ?? '');
    $alamat_supplier = trim($_POST['alamat_supplier'] ?? '');
    $jam_operasional = trim($_POST['jam_operasional_supplier'] ?? '');

    $errors = [];
    if (empty($id)) $errors['id'] = 'ID Supplier tidak valid';
    if (empty($nama_supplier)) $errors['nama_supplier'] = 'Nama Supplier wajib diisi';
    if (empty($alamat_supplier)) $errors['alamat_supplier'] = 'Alamat Supplier wajib diisi';
    if (empty($jam_operasional)) $errors['jam_operasional_supplier'] = 'Jam Operasional wajib diisi';

    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'message' => 'Validasi gagal', 'errors' => $errors]);
        exit;
    }

    // Check if ID exists
    $stmtCheck = sqlsrv_prepare($connection, "SELECT COUNT(*) as total FROM tmssupplier WHERE id = ?", [$id]);
    if ($stmtCheck && sqlsrv_execute($stmtCheck)) {
        $rowCheck = sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC);
        if ($rowCheck['total'] == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Data supplier tidak ditemukan', 'errors' => ['id' => 'ID Supplier tidak terdaftar']]);
            exit;
        }
    }

    // Check duplicate name
    $stmtCheck = sqlsrv_prepare($connection, "SELECT COUNT(*) as total FROM tmssupplier WHERE nama_supplier = ? AND id != ?", [$nama_supplier, $id]);
    if ($stmtCheck && sqlsrv_execute($stmtCheck)) {
        $rowCheck = sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC);
        if ($rowCheck['total'] > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Nama Supplier sudah digunakan oleh supplier lain', 'errors' => ['nama_supplier' => 'Nama Supplier sudah terdaftar']]);
            exit;
        }
    }

    $sql = "UPDATE tmssupplier SET nama_supplier=?, alamat_supplier=?, jam_operasional_supplier=? WHERE id=?";
    $params = [$nama_supplier, $alamat_supplier, $jam_operasional, $id];
    $stmt = sqlsrv_prepare($connection, $sql, $params);

    if ($stmt && sqlsrv_execute($stmt)) {
        echo json_encode(['status' => 'success', 'message' => 'Supplier berhasil diupdate', 'data' => ['id' => $id, 'nama_supplier' => $nama_supplier, 'alamat_supplier' => $alamat_supplier, 'jam_operasional_supplier' => $jam_operasional]]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate supplier', 'detail' => sqlsrv_errors()]);
    }
    exit;
}

// ==========================
// Handle Delete Data
// ==========================
function handleDeleteData($connection)
{
    $id = trim($_POST['id'] ?? '');
    if (empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'ID wajib diisi']);
        exit;
    }

    $stmt = sqlsrv_prepare($connection, "DELETE FROM tmssupplier WHERE id=?", [$id]);
    if ($stmt && sqlsrv_execute($stmt)) {
        echo json_encode(['status' => 'success', 'message' => 'Supplier berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus supplier', 'detail' => sqlsrv_errors()]);
    }
    exit;
}
