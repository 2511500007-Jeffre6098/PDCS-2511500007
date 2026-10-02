<?php
require_once "../config.php";
require_once "../helpers/response.php";

$query = "SELECT m.id, m.nm_mahasiswa, m.nim, j.nm_jurusan AS jurusan FROM mahasiswa m LEFT JOIN jurusan j ON m.id_jurusan = j.id ORDER BY m.id DESC";

$result = mysqli_query($koneksi, $query);

if(!$result) sendResponse(false, "Query gagal: " . mysqli_error($koneksi), null, 500);

$data = [];
while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

sendResponse(true, "Data berhasil diambil", $data, 200);
