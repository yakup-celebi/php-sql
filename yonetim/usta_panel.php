<?php
session_start();
include("../baglanti.php");

if (!isset($_SESSION["usta_giris"])) {
    header("Location: usta_giris.php");
    exit();
}

$usta_id = $_SESSION["usta_id"];

$sorgu = mysqli_query($baglanti, "SELECT * FROM ustalar WHERE id = '$usta_id'");
$usta = mysqli_fetch_assoc($sorgu);

$mesaj_sayisi_sorgu = mysqli_query($baglanti, "SELECT COUNT(*) as toplam FROM mesajlar WHERE usta_id = '$usta_id'");
$mesaj_sayisi = mysqli_fetch_assoc($mesaj_sayisi_sorgu)['toplam'];

$is_sayisi_sorgu = mysqli_query($baglanti, "SELECT COUNT(*) as toplam FROM referanslar WHERE usta_id = '$usta_id'");
$is_sayisi = mysqli_fetch_assoc($is_sayisi_sorgu)['toplam'];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usta Kontrol Paneli - BulBul</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="panel-body">

    <!-- SOL MENÜ (SIDEBAR) -->
    <div class="sidebar">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: white;"><i class="fa-solid fa-screwdriver-wrench"></i> BulBul</h2>
            <small style="color: #e6ddc4; opacity: 0.8;">Usta Yönetim Paneli</small>
        </div>
        <nav>
            <a href="usta_panel.php" class="active"><i class="fa-solid fa-house"></i> Panel Özeti</a>
            <a href="profil_duzenle.php"><i class="fa-solid fa-user-gear"></i> Profilimi Düzenle</a>
            <a href="referanslar.php"><i class="fa-solid fa-images"></i> İşlerim (Referanslar)</a>
            <a href="mesajlar.php"><i class="fa-solid fa-envelope"></i> Gelen Mesajlar</a>
            <hr style="opacity: 0.1; margin: 20px 0;">
            <a href="../index.php" target="_blank"><i class="fa-solid fa-eye"></i> Siteyi Görüntüle</a>
            <a href="cikis.php" style="color: #ff4d4d; margin-top: 20px;"><i class="fa-solid fa-right-from-bracket"></i> Güvenli Çıkış</a>
        </nav>
    </div>

    <!-- ANA İÇERİK ALANI -->
    <div class="main-content">
        <div class="panel-header">
            <span>Hoş geldin, <?php echo $usta['isim_soyisim']; ?></span>
            <span style="font-size: 14px; opacity: 0.7; font-weight: normal;"><?php echo date("d.m.Y"); ?></span>
        </div>

        <main style="padding: 20px;">
            
            <!-- ÜST ÖZET KARTLARI -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #026638;">
                    <h4 style="margin: 0; color: #777;">Toplam İş Sayısı</h4>
                    <h2 style="margin: 10px 0 0 0; color: #013220;"><?php echo $is_sayisi; ?></h2>
                </div>
                <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #e6ddc4;">
                    <h4 style="margin: 0; color: #777;">Gelen Mesajlar</h4>
                    <h2 style="margin: 10px 0 0 0; color: #013220;"><?php echo $mesaj_sayisi; ?></h2>
                </div>
            </div>

            <!-- HOŞ GELDİN KARTI (Ekran görüntüsündeki gibi) -->
            <div style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 30px;">
                <div style="position: relative;">
                    <img src="../<?php echo $usta['profil_resmi']; ?>" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #e6ddc4;">
                    <div style="position: absolute; bottom: 5px; right: 5px; background: #026638; color: white; padding: 5px 10px; border-radius: 20px; font-size: 12px;">Aktif</div>
                </div>
                
                <div>
                    <h1 style="margin: 0; color: #013220;">Panelinize Hoş Geldiniz</h1>
                    <p style="color: #666; font-size: 1.1rem; margin: 10px 0 20px 0;">
                        Sayın <b><?php echo $usta['isim_soyisim']; ?></b>, buradan profil bilgilerinizi güncelleyebilir, 
                        müşterilere sunduğunuz işlerin görsellerini yönetebilir ve size gelen iş taleplerini takip edebilirsiniz.
                    </p>
                    <div style="display: flex; gap: 10px;">
                        <a href="profil_duzenle.php" style="background: #013220; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">Profilimi Düzenle</a>
                        <a href="referanslar.php" style="background: #e6ddc4; color: #013220; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">İş Yükle</a>
                    </div>
                </div>
            </div>

        </main>
    </div>

</body>
</html>