<?php
session_start();
include("../baglanti.php");

$hata = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici_adi = mysqli_real_escape_string($baglanti, $_POST["kullanici_adi"]);
    $sifre = $_POST["sifre"]; 

    $sorgu = "SELECT * FROM ustalar WHERE kullanici_adi = '$kullanici_adi' AND sifre = '$sifre'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if (mysqli_num_rows($sonuc) == 1) {
        $usta_verisi = mysqli_fetch_assoc($sonuc);
     
        $_SESSION["usta_giris"] = true;
        $_SESSION["usta_id"] = $usta_verisi["id"];
        $_SESSION["usta_isim"] = $usta_verisi["isim_soyisim"];

        header("Location: usta_panel.php");
        exit();
    } else {
        $hata = "Kullanıcı adı veya şifre hatalı!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usta Girişi - BulBul</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; background-color: #f9f9f2;">

    <div style="width: 100%; max-width: 400px; background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center;">
        
        <div style="margin-bottom: 30px;">
            <i class="fa-solid fa-screwdriver-wrench fa-3x" style="color: #013220; margin-bottom: 15px;"></i>
            <h2 style="color: #013220; margin: 0;">Usta Giriş Paneli</h2>
            <p style="color: #666; font-size: 14px;">Bilgilerinizi girerek işlerinizi yönetmeye başlayın.</p>
        </div>
        
        <?php if ($hata): ?>
            <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #ffcdd2;">
                <i class="fa-solid fa-circle-exclamation"></i> <?= $hata ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 15px; text-align: left;">
                <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 600;">Kullanıcı Adı:</label>
                <input type="text" name="kullanici_adi" required 
                       style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; box-sizing: border-box; outline: none; font-size: 16px;">
            </div>
            
            <div style="margin-bottom: 25px; text-align: left;">
                <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 600;">Şifre:</label>
                <input type="password" name="sifre" required 
                       style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; box-sizing: border-box; outline: none; font-size: 16px;">
            </div>
            
            <button type="submit" 
                    style="background-color: #013220; color: white; padding: 14px; border: none; border-radius: 10px; cursor: pointer; width: 100%; font-size: 16px; font-weight: bold; transition: background 0.3s;">
                Giriş Yap
            </button>
        </form>

        <div style="margin-top: 25px; border-top: 1px solid #eee; padding-top: 20px;">
            <p style="font-size: 14px; color: #555;">
                Henüz bir hesabınız yok mu? <br>
                <a href="usta_kayit.php" style="color: #026638; font-weight: bold; text-decoration: none;">Hemen Usta Kaydı Oluştur</a>
            </p>
            
            <a href="../index.php" style="color: #777; text-decoration: none; font-size: 13px; display: inline-block; margin-top: 10px;">
                <i class="fa-solid fa-arrow-left"></i> Ana Sayfaya Dön
            </a>
        </div>
    </div>

</body>
</html>