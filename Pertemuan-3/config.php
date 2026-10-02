<?php
require_once __DIR__ . '/helpers/response.php';

mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$password = "";
$database = "pdcs";

$koneksi = @mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    sendResponse(
        false,
        "Koneksi database gagal",
        null,
        500
    );
}