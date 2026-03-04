<?php
session_start();
include '../../helper/connection.php';
header("Content-Type: application/json");

function sendResponse($status, $message, $extra = [])
{
    $response = ['status' => $status, 'message' => $message];
    echo json_encode(array_merge($response, $extra));
    exit;
}

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
                echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid']);
                break;
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan']);
        break;
}
exit;

// ==========================
// Handle GET Data
// ==========================
function handleGetData($connection)
{
    $sql = "SELECT id, nama_perusahaan, alamat_perusahaan, created_at FROM tmsplants ORDER BY id DESC";
    $stmt = sqlsrv_prepare($connection, $sql);
    $rows = [];
    if ($stmt && sqlsrv_execute($stmt)) {
        $no = 1;
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $created_at = '';
            if (!empty($row['created_at'])) $created_at = $row['created_at'] instanceof DateTime ? $row['created_at']->format('Y-m-d H:i:s') : $row['created_at'];
            $rows[] = ['no' => $no++, 'id' => $row['id'], 'nama_perusahaan' => $row['nama_perusahaan'], 'alamat_perusahaan' => $row['alamat_perusahaan'], 'created_at' => $created_at];
        }
        echo json_encode(['status' => 'success', 'data' => $rows]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Query gagal', 'detail' => sqlsrv_errors()]);
    }
    exit;
}

// ==========================
// Handle Insert Data
// ==========================
function handleInsertData($connection)
{
    $nama = trim($_POST['nama_perusahaan'] ?? '');
    $alamat = trim($_POST['alamat_perusahaan'] ?? '');

    // Validasi dasar
    if (empty($nama) || empty($alamat)) {
        sendResponse('error', 'Nama dan Alamat perusahaan wajib diisi');
    }

    // Mulai Transaksi
    if (sqlsrv_begin_transaction($connection) === false) {
        sendResponse('error', 'Gagal inisialisasi transaksi database');
    }

    try {
        /**
         * LOGIC GENERATE ID:
         * 1. Pakai UPDLOCK & HOLDLOCK agar user lain tidak bisa baca baris terakhir SAAT kita proses.
         * 2. CAST string ID ke INT supaya urutan 1, 2, 10 bener (bukan 1, 10, 2).
         */
        $sqlGetId = "SELECT TOP 1 CAST(SUBSTRING(id, 5, LEN(id)) AS INT) as last_num 
                     FROM tmsplants WITH (UPDLOCK, HOLDLOCK) 
                     WHERE id LIKE 'PLT-%' 
                     ORDER BY last_num DESC";

        $stmtId = sqlsrv_query($connection, $sqlGetId);
        if ($stmtId === false) throw new Exception("Gagal sinkronisasi ID terakhir");

        $row = sqlsrv_fetch_array($stmtId, SQLSRV_FETCH_ASSOC);
        $nextNumber = ($row ? (int)$row['last_num'] : 0) + 1;
        $newId = "PLT-" . str_pad($nextNumber, 3, "0", STR_PAD_LEFT);

        // Insert data
        $sqlInsert = "INSERT INTO tmsplants (id, nama_perusahaan, alamat_perusahaan, created_at) 
                      VALUES (?, ?, ?, GETDATE())";
        $stmtInsert = sqlsrv_prepare($connection, $sqlInsert, [$newId, $nama, $alamat]);

        if (!$stmtInsert || !sqlsrv_execute($stmtInsert)) {
            throw new Exception("Gagal menyimpan data ke database");
        }

        sqlsrv_commit($connection);
        sendResponse('success', 'Plant berhasil ditambahkan', ['data' => ['id' => $newId]]);
    } catch (Exception $e) {
        sqlsrv_rollback($connection);
        // Simpan error asli di log server, jangan kasih ke user luar
        error_log(print_r(sqlsrv_errors(), true));
        sendResponse('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

// ==========================
// Handle Update Data
// ==========================
function handleUpdateData($connection)
{
    $id = trim($_POST['id'] ?? '');
    $nama = trim($_POST['nama_perusahaan'] ?? '');
    $alamat = trim($_POST['alamat_perusahaan'] ?? '');
    if (empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        exit;
    }

    $sql = "UPDATE tmsplants SET nama_perusahaan=?, alamat_perusahaan=? WHERE id=?";
    $stmt = sqlsrv_prepare($connection, $sql, [$nama, $alamat, $id]);

    if ($stmt && sqlsrv_execute($stmt)) echo json_encode(['status' => 'success', 'message' => 'Plant berhasil diupdate']);
    else echo json_encode(['status' => 'error', 'message' => 'Gagal update plant', 'detail' => sqlsrv_errors()]);
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

    $stmt = sqlsrv_prepare($connection, "DELETE FROM tmsplants WHERE id=?", [$id]);
    if ($stmt && sqlsrv_execute($stmt)) echo json_encode(['status' => 'success', 'message' => 'Plant berhasil dihapus']);
    else echo json_encode(['status' => 'error', 'message' => 'Gagal hapus plant', 'detail' => sqlsrv_errors()]);
    exit;
}
