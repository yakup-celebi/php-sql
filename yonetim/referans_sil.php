<?php
session_start();
include("../baglanti.php");

if (!isset($_SESSION["usta_giris"])) {
    header("Location: usta_giris.php");
    exit();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $usta_id = $_SESSION["usta_id"];

    // Önce dosya yolunu alalım (Klasörden silmek için)
    $sorgu = "SELECT resim_yolu FROM referanslar WHERE id = '$id' AND usta_id = '$usta_id'";
    $sonuc = mysqli_query($baglanti, $sorgu);
    $is = mysqli_fetch_assoc($sonuc);

    if ($is) {
        unlink($is['resim_yolu']); // Dosyayı klasörden siler
        
        // Şimdi veritabanından sil
        mysqli_query($baglanti, "DELETE FROM referanslar WHERE id = '$id'");
    }
}

header("Location: referanslar.php");
exit();
?>