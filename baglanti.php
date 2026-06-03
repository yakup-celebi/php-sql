<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "bulbul_db";

$baglanti = mysqli_connect($host, $user, $pass, $db);

if (!$baglanti) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

mysqli_set_charset($baglanti, "utf8");
?>