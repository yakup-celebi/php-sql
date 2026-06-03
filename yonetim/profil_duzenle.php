<?php
session_start();
include("../baglanti.php");

if (!isset($_SESSION["usta_giris"])) {
    header("Location: usta_giris.php");
    exit();
}

$usta_id = $_SESSION["usta_id"];
$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isim = mysqli_real_escape_string($baglanti, $_POST["isim_soyisim"]);
    $uzmanlik = mysqli_real_escape_string($baglanti, $_POST["uzmanlik_alani"]);
    $tel = mysqli_real_escape_string($baglanti, $_POST["telefon"]);
    $hakkinda = mysqli_real_escape_string($baglanti, $_POST["hakkinda"]);

    if (!empty($_FILES["profil_resmi"]["name"])) {
        $dosya_adi = time() . "_" . $_FILES["profil_resmi"]["name"];
        $hedef = "../img/" . $dosya_adi;
        $veritabani_yolu = "img/" . $dosya_adi;

        if (move_uploaded_file($_FILES["profil_resmi"]["tmp_name"], $hedef)) {
            mysqli_query($baglanti, "UPDATE ustalar SET profil_resmi = '$veritabani_yolu' WHERE id = '$usta_id'");
        }
    }

    $guncelle = "UPDATE ustalar SET 
                isim_soyisim = '$isim', 
                uzmanlik_alani = '$uzmanlik', 
                telefon = '$tel', 
                hakkinda = '$hakkinda' 
                WHERE id = '$usta_id'";

    if (mysqli_query($baglanti, $guncelle)) {
        $mesaj = "<p style='color:green; font-weight:bold;'>Profiliniz başarıyla güncellendi!</p>";
        $_SESSION["usta_isim"] = $isim;
    }
}

// 2. ADIM: GÜNCEL BİLGİLERİ VERİTABANINDAN ÇEKİP FORMA YAZDIRMA
$sorgu = "SELECT * FROM ustalar WHERE id = '$usta_id'";
$sonuc = mysqli_query($baglanti, $sorgu);
$usta = mysqli_fetch_assoc($sonuc);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Profilimi Düzenle - BulBul</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="panel-body">
    <div class="sidebar">
        <h2><i class="fa-solid fa-screwdriver-wrench"></i> BulBul</h2>
        <nav>
            <!-- Linkleri güncelledik ki panel ve düzenleme arası geçiş kolay olsun -->
            <a href="usta_panel.php"><i class="fa-solid fa-user"></i> Panel Özeti</a>
            <a href="profil_duzenle.php"><i class="fa-solid fa-user-gear"></i> Profilimi Düzenle</a>
            <a href="referanslar.php"><i class="fa-solid fa-images"></i> İşlerim</a>
            <a href="mesajlar.php"><i class="fa-solid fa-envelope"></i> Mesajlar</a>
            <a href="cikis.php" style="margin-top: 50px; color: #ff4d4d;"><i class="fa-solid fa-right-from-bracket"></i> Çıkış Yap</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="panel-header">Profil Ayarları</div>
        
        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <?php echo $mesaj; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div style="display: flex; gap: 30px; align-items: flex-start; flex-wrap: wrap;">
                    
                    <div style="text-align: center; width: 200px;">
                        <!-- Veritabanındaki güncel resmi gösterir -->
                        <img src="../<?php echo $usta['profil_resmi']; ?>" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 3px solid #e6ddc4;">
                        <label style="display:block; margin-top:10px; cursor:pointer; color:#026638; font-weight:bold;">
                            <i class="fa-solid fa-camera"></i> Fotoğraf Değiştir
                            <input type="file" name="profil_resmi" style="display:none;" accept="image/*">
                        </label>
                    </div>

                    <div style="flex: 1; min-width: 300px;">
                        <div style="margin-bottom: 15px;">
                            <label>İsim Soyisim:</label>
                            <input type="text" name="isim_soyisim" value="<?php echo $usta['isim_soyisim']; ?>" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label>Uzmanlık Alanı:</label>
                            <input type="text" name="uzmanlik_alani" value="<?php echo $usta['uzmanlik_alani']; ?>" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label>Telefon:</label>
                            <input type="text" name="telefon" value="<?php echo $usta['telefon']; ?>" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label>Hakkında (Kısa Tanıtım):</label>
                            <textarea name="hakkinda" rows="4" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;"><?php echo $usta['hakkinda']; ?></textarea>
                        </div>
                        <button type="submit" style="background:#013220; color:white; border:none; padding:12px 30px; border-radius:8px; cursor:pointer; font-weight:bold;">
                            Bilgileri Kaydet
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>