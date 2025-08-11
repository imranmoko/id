<?php
$dataFile = "links.json";
$data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

$key = $_GET["to"] ?? "";

if (isset($data[$key])) {
    header("Location: " . $data[$key]);
    exit;
} else {
    http_response_code(404);
    echo "<h1>404 - Shortlink Tidak Ditemukan</h1>";
}
