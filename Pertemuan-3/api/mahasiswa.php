<?php
require_once "../config.php";
require_once "../helpers/response.php";


//GET ID
if(isset($_GET['id'])) {
    $id = $_GET['id'];


$query = "SELECT 
            m.id, 
            m.nm_mahasiswa,
            m.nim,
            j.nm_jurusan AS jurusan
        FROM mahasiswa m 
        LEFT JOIN jurusan j ON m.id_jurusan = j.id 
        WHERE m.id = '$id'";

$result = mysqli_query($koneksi, $query);

if(!$result) {
     sendResponse(
        false, "Query gagal: " . mysqli_error($koneksi), 
        null,
         500
         );
}

$data = mysqli_fetch_assoc($result);

if(!$data) {
    sendResponse(false, "Data Mahasiswa tidak ditemukan", 
    null, 404);
}

sendResponse(true, "Data berhasil diambil", $data, 200);

}

//SEARCH
if(isset($_GET['search'])) {
    
    $search = $_GET['search'];

    $query = "SELECT 
                m.id, 
                m.nm_mahasiswa,
                m.nim,
                j.nm_jurusan AS jurusan
            FROM mahasiswa m 
            LEFT JOIN jurusan j 
            ON m.id_jurusan = j.id 
            WHERE m.nm_mahasiswa LIKE '%$search%'
            OR m.nim LIKE '%$search%'
            ORDER BY m.id DESC";

    $result = mysqli_query($koneksi, $query);

    if(!$result) {
        sendResponse(false, "Query gagal: " . mysqli_error($koneksi), null, 500);
    }

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if(empty($data)) {
        sendResponse(false, "Data Mahasiswa tidak ditemukan", null, 404);
    }

    sendResponse(true, "Data berhasil diambil", $data, 200);
}

//Page/Limit

if(isset($_GET['page']) || isset($_GET['limit'])) {

    $page = isset($_GET['page']) 
    ? (int)$_GET['page'] 
    : 1;

    $limit = isset($_GET['limit']) 
    ? (int)$_GET['limit'] 
    : 10;

    if($page < 1 ){
        $page = 1;
    }

    if($limit < 1) {
        $limit = 10;
    }

    $offset = ($page - 1) * $limit;

    $query = "SELECT 
                m.id, 
                m.nm_mahasiswa,
                m.nim,
                j.nm_jurusan AS jurusan
            FROM mahasiswa m 
            LEFT JOIN jurusan j 
            ON m.id_jurusan = j.id 
            ORDER BY m.id DESC
            LIMIT $limit OFFSET $offset";

    $result = mysqli_query($koneksi, $query);

    if(!$result) {
        sendResponse(
        false,
         "Query gagal: " . mysqli_error($koneksi), 
         null, 
         500
         );
    }

    $data = [];

    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    sendResponse(
        true, 
        "Data berhasil diambil",
        $data, 
        200
        );         ;
}