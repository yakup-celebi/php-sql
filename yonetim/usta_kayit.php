<?php
include("../baglanti.php");
$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici = mysqli_real_escape_string($baglanti, $_POST["kullanici_adi"]);
    $sifre = mysqli_real_escape_string($baglanti, $_POST["sifre"]);
    $isim = mysqli_real_escape_string($baglanti, $_POST["isim_soyisim"]);
    $uzmanlik = mysqli_real_escape_string($baglanti, $_POST["uzmanlik_alani"]);
    $tel = mysqli_real_escape_string($baglanti, $_POST["telefon"]);

    $kontrol = mysqli_query($baglanti, "SELECT * FROM ustalar WHERE kullanici_adi = '$kullanici'");
    
    if (mysqli_num_rows($kontrol) > 0) {
        $mesaj = "<p style='color:red;'>Bu kullanıcı adı zaten alınmış!</p>";
    } else {
        $ekle = "INSERT INTO ustalar (kullanici_adi, sifre, isim_soyisim, uzmanlik_alani, telefon) 
                 VALUES ('$kullanici', '$sifre', '$isim', '$uzmanlik', '$tel')";
        
        if (mysqli_query($baglanti, $ekle)) {
            $mesaj = "<p style='color:green;'>Kaydınız başarıyla oluşturuldu! Giriş yapabilirsiniz.</p>";
            header("Refresh: 2; url=usta_giris.php");
        } else {
            $mesaj = "<p style='color:red;'>Hata oluştu: " . mysqli_error($baglanti) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Usta Kayıt Ol - BulBul</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .kayit-form { max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .kayit-form input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .kayit-form button { width: 100%; background: #013220; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body style="background: #f9f9f2;">
    <div class="kayit-form">
        <h2 style="text-align: center; color: #013220;">Usta Kayıt Formu</h2>
        <?php echo $mesaj; ?>
        <form method="POST">
            <input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı" required>
            <input type="password" name="sifre" placeholder="Şifre" required>
            <input type="text" name="isim_soyisim" placeholder="Adınız Soyadınız" required>
            <input type="text" name="uzmanlik_alani" placeholder="Uzmanlık Alanı (Örn: Elektrikçi)" required>
            <input type="text" name="telefon" placeholder="Telefon Numaranız" required>
            <button type="submit">Kayıt Ol</button>
        </form>
        <p style="text-align: center; margin-top: 15px;">
            Zaten hesabın var mı? <a href="usta_giris.php" style="color: #026638;">Giriş Yap</a>
        </p>
    </div>
</body>
</html>