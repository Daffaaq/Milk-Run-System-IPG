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
    $sql = "SELECT id, plat_nomer_truk, tipe_truk, kapasitas_truk, status_truk, created_at 
            FROM tmsvehicle 
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
                'plat_nomer_truk' => $row['plat_nomer_truk'],
                'tipe_truk' => $row['tipe_truk'],
                'kapasitas_truk' => $row['kapasitas_truk'],
                'status_truk' => $row['status_truk'],
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

    $plat = trim($_POST['plat_nomer_truk'] ?? '');
    $tipe = trim($_POST['tipe_truk'] ?? '');
    $kapasitas = trim($_POST['kapasitas_truk'] ?? '');
    $status = trim($_POST['status_truk'] ?? '');

    if (empty($plat)) $errors['plat_nomer_truk'] = 'Plat nomor wajib diisi';
    if (empty($tipe)) $errors['tipe_truk'] = 'Tipe truk wajib diisi';
    if (empty($kapasitas)) $errors['kapasitas_truk'] = 'Kapasitas wajib diisi';
    if (empty($status)) $errors['status_truk'] = 'Status wajib diisi';

    if (!empty($errors)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Validasi gagal',
            'errors' => $errors
        ]);
        exit;
    }

    // Cek duplikat plat nomor (read-only, bisa sebelum transaksi)
    $sqlCheckPlat = "SELECT COUNT(*) as total FROM tmsvehicle WHERE plat_nomer_truk = ?";
    $stmtCheck = sqlsrv_prepare($connection, $sqlCheckPlat, [$plat]);
    if ($stmtCheck && sqlsrv_execute($stmtCheck)) {
        $rowCheck = sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC);
        if ($rowCheck['total'] > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Plat nomor sudah terdaftar',
                'errors' => ['plat_nomer_truk' => 'Plat nomor sudah digunakan']
            ]);
            exit;
        }
    }

    // Mulai Transaksi
    if (sqlsrv_begin_transaction($connection) === false) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal inisialisasi transaksi database'
        ]);
        exit;
    }

    try {
        /**
         * GENERATE ID DENGAN LOCKING:
         * - UPDLOCK: Kunci baris yang akan diupdate
         * - HOLDLOCK: Pertahankan lock sampai transaksi selesai
         * - CAST ke INT: Biar sorting numeriknya bener (TRK-001, TRK-002, ... TRK-010)
         */
        $sqlGetId = "SELECT TOP 1 
                        CAST(SUBSTRING(id, 5, LEN(id)) AS INT) as last_num 
                     FROM tmsvehicle WITH (UPDLOCK, HOLDLOCK) 
                     WHERE id LIKE 'TRK-%' 
                     ORDER BY last_num DESC";

        $stmtId = sqlsrv_query($connection, $sqlGetId);
        if ($stmtId === false) {
            throw new Exception("Gagal sinkronisasi ID terakhir");
        }

        $row = sqlsrv_fetch_array($stmtId, SQLSRV_FETCH_ASSOC);
        $nextNumber = ($row ? (int)$row['last_num'] : 0) + 1;
        $newId = "TRK-" . str_pad($nextNumber, 3, "0", STR_PAD_LEFT);

        // Insert data truk
        $sql = "INSERT INTO tmsvehicle 
                (id, plat_nomer_truk, tipe_truk, kapasitas_truk, status_truk, created_at)
                VALUES (?, ?, ?, ?, ?, GETDATE())";

        $params = [$newId, $plat, $tipe, $kapasitas, $status];
        $stmt = sqlsrv_prepare($connection, $sql, $params);

        if (!$stmt || !sqlsrv_execute($stmt)) {
            throw new Exception("Gagal menyimpan data truk");
        }

        // Commit transaksi
        sqlsrv_commit($connection);

        echo json_encode([
            'status' => 'success',
            'message' => 'Data truk berhasil ditambahkan',
            'data' => [
                'id' => $newId,
                'plat_nomer_truk' => $plat,
                'tipe_truk' => $tipe,
                'kapasitas_truk' => $kapasitas,
                'status_truk' => $status
            ]
        ]);
    } catch (Exception $e) {
        // Rollback jika ada error
        sqlsrv_rollback($connection);

        // Log error untuk debugging
        error_log("Error insert truk: " . print_r(sqlsrv_errors(), true));

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
    $plat = trim($_POST['plat_nomer_truk'] ?? '');
    $tipe = trim($_POST['tipe_truk'] ?? '');
    $kapasitas = trim($_POST['kapasitas_truk'] ?? '');
    $status = trim($_POST['status_truk'] ?? '');

    if (empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        exit;
    }

    $sql = "UPDATE tmsvehicle 
            SET plat_nomer_truk=?, tipe_truk=?, kapasitas_truk=?, status_truk=? 
            WHERE id=?";

    $params = [$plat, $tipe, $kapasitas, $status, $id];
    $stmt = sqlsrv_prepare($connection, $sql, $params);

    if ($stmt && sqlsrv_execute($stmt)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Data truk berhasil diupdate'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal update data',
            'detail' => sqlsrv_errors()
        ]);
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

    $sql = "DELETE FROM tmsvehicle WHERE id=?";
    $params = [$id];
    $stmt = sqlsrv_prepare($connection, $sql, $params);

    if ($stmt && sqlsrv_execute($stmt)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Data truk berhasil dihapus'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal hapus data',
            'detail' => sqlsrv_errors()
        ]);
    }
    exit;
}
