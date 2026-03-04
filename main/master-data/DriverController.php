<?php
session_start();
include '../../helper/connection.php';
header("Content-Type: application/json");

if ($connection === false) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Koneksi database gagal'
    ]);
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
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Aksi POST tidak valid'
                ]);
                break;
        }
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode([
            'status' => 'error',
            'message' => 'Metode tidak diizinkan'
        ]);
        break;
}

exit;



// ======================================================
// ================= HANDLE GET DATA ====================
// ======================================================
function handleGetData($connection)
{
    $sql = "SELECT 
                id,
                nama_sopir,
                no_telefon_sopir,
                lisense_sopir,
                status_sopir,
                created_at
            FROM tmsdriver
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
                'nama_sopir' => $row['nama_sopir'],
                'no_telefon_sopir' => $row['no_telefon_sopir'],
                'lisense_sopir' => $row['lisense_sopir'],
                'status_sopir' => $row['status_sopir'],
                'created_at' => $created_at
            ];
        }

        echo json_encode([
            'status' => 'success',
            'data' => $rows
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Query gagal',
            'detail' => sqlsrv_errors()
        ]);
    }

    exit;
}



// ======================================================
// ================= HANDLE INSERT ======================
// ======================================================
function handleInsertData($connection)
{
    $errors = [];

    $nama     = trim($_POST['nama_sopir'] ?? '');
    $telp     = trim($_POST['no_telefon_sopir'] ?? '');
    $lisense  = trim($_POST['lisense_sopir'] ?? '');
    $status   = trim($_POST['status_sopir'] ?? '');

    if (empty($nama))     $errors['nama_sopir'] = 'Nama sopir wajib diisi';
    if (empty($telp))     $errors['no_telefon_sopir'] = 'Nomor telefon wajib diisi';
    if (empty($lisense))  $errors['lisense_sopir'] = 'Lisense wajib diisi';
    if (empty($status))   $errors['status_sopir'] = 'Status wajib diisi';

    if (!empty($errors)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Validasi gagal',
            'errors' => $errors
        ]);
        exit;
    }

    // Cek duplikat no telefon (read-only, bisa sebelum transaksi)
    $sqlCheckTelp = "SELECT COUNT(*) as total FROM tmsdriver WHERE no_telefon_sopir = ?";
    $stmtCheck = sqlsrv_prepare($connection, $sqlCheckTelp, [$telp]);
    if ($stmtCheck && sqlsrv_execute($stmtCheck)) {
        $rowCheck = sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC);
        if ($rowCheck['total'] > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Nomor telefon sudah terdaftar',
                'errors' => ['no_telefon_sopir' => 'Nomor telefon sudah digunakan']
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
         * - CAST ke INT: Biar sorting numeriknya bener (DRV-001, DRV-002, ... DRV-010)
         */
        $sqlGetId = "SELECT TOP 1 
                        CAST(SUBSTRING(id, 5, LEN(id)) AS INT) as last_num 
                     FROM tmsdriver WITH (UPDLOCK, HOLDLOCK) 
                     WHERE id LIKE 'DRV-%' 
                     ORDER BY last_num DESC";

        $stmtId = sqlsrv_query($connection, $sqlGetId);
        if ($stmtId === false) {
            throw new Exception("Gagal sinkronisasi ID terakhir");
        }

        $row = sqlsrv_fetch_array($stmtId, SQLSRV_FETCH_ASSOC);
        $nextNumber = ($row ? (int)$row['last_num'] : 0) + 1;
        $newId = "DRV-" . str_pad($nextNumber, 3, "0", STR_PAD_LEFT);

        // Insert data driver
        $sql = "INSERT INTO tmsdriver 
                (id, nama_sopir, no_telefon_sopir, lisense_sopir, status_sopir, created_at)
                VALUES (?, ?, ?, ?, ?, GETDATE())";

        $params = [$newId, $nama, $telp, $lisense, $status];
        $stmt = sqlsrv_prepare($connection, $sql, $params);

        if (!$stmt || !sqlsrv_execute($stmt)) {
            throw new Exception("Gagal menyimpan data driver");
        }

        // Commit transaksi
        sqlsrv_commit($connection);

        echo json_encode([
            'status' => 'success',
            'message' => 'Driver berhasil ditambahkan',
            'data' => [
                'id' => $newId,
                'nama_sopir' => $nama,
                'no_telefon_sopir' => $telp,
                'lisense_sopir' => $lisense,
                'status_sopir' => $status
            ]
        ]);
    } catch (Exception $e) {
        // Rollback jika ada error
        sqlsrv_rollback($connection);

        // Log error untuk debugging
        error_log("Error insert driver: " . print_r(sqlsrv_errors(), true));

        echo json_encode([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            'detail' => sqlsrv_errors()
        ]);
    }

    exit;
}



// ======================================================
// ================= HANDLE UPDATE ======================
// ======================================================
function handleUpdateData($connection)
{
    $id       = trim($_POST['id'] ?? '');
    $nama     = trim($_POST['nama_sopir'] ?? '');
    $telp     = trim($_POST['no_telefon_sopir'] ?? '');
    $lisense  = trim($_POST['lisense_sopir'] ?? '');
    $status   = trim($_POST['status_sopir'] ?? '');

    if (empty($id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID tidak valid'
        ]);
        exit;
    }

    $sql = "UPDATE tmsdriver
            SET nama_sopir = ?,
                no_telefon_sopir = ?,
                lisense_sopir = ?,
                status_sopir = ?
            WHERE id = ?";

    $params = [$nama, $telp, $lisense, $status, $id];
    $stmt = sqlsrv_prepare($connection, $sql, $params);

    if ($stmt && sqlsrv_execute($stmt)) {

        echo json_encode([
            'status' => 'success',
            'message' => 'Driver berhasil diupdate'
        ]);
    } else {

        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal update driver',
            'detail' => sqlsrv_errors()
        ]);
    }

    exit;
}



// ======================================================
// ================= HANDLE DELETE ======================
// ======================================================
function handleDeleteData($connection)
{
    $id = trim($_POST['id'] ?? '');

    if (empty($id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID wajib diisi'
        ]);
        exit;
    }

    $sql = "DELETE FROM tmsdriver WHERE id = ?";
    $params = [$id];
    $stmt = sqlsrv_prepare($connection, $sql, $params);

    if ($stmt && sqlsrv_execute($stmt)) {

        echo json_encode([
            'status' => 'success',
            'message' => 'Driver berhasil dihapus'
        ]);
    } else {

        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal hapus driver',
            'detail' => sqlsrv_errors()
        ]);
    }

    exit;
}
