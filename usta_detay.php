<?php
include("baglanti.php");

if (isset($_GET["id"])) {
    $id = mysqli_real_escape_string($baglanti, $_GET["id"]);
    
    $sorgu = "SELECT * FROM ustalar WHERE id = '$id'";
    $sonuc = mysqli_query($baglanti, $sorgu);
    $usta = mysqli_fetch_assoc($sonuc);

    $ref_sorgu = "SELECT * FROM referanslar WHERE usta_id = '$id'";
    $referanslar = mysqli_query($baglanti, $ref_sorgu);
} else {
    header("Location: index.php");
    exit();
}

$mesaj_durum = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = mysqli_real_escape_string($baglanti, $_POST["ad"]);
    $tel = mysqli_real_escape_string($baglanti, $_POST["tel"]);
    $mesaj = mysqli_real_escape_string($baglanti, $_POST["mesaj"]);

    $ekle = "INSERT INTO mesajlar (usta_id, musteri_ad, musteri_tel, mesaj_icerigi) VALUES ('$id', '$ad', '$tel', '$mesaj')";
    if (mysqli_query($baglanti, $ekle)) {
        $mesaj_durum = "<p style='color:green; font-weight:bold;'>Mesajınız ustaya iletildi!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $usta['isim_soyisim']; ?> - BulBul</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body style="display: block;">

    <div style="max-width: 1000px; margin: 20px auto; padding: 20px;">
        <a href="index.php" style="text-decoration:none; color:#013220;"><i class="fa-solid fa-arrow-left"></i> Geri Dön</a>
        
        <div style="background: white; padding: 30px; border-radius: 15px; margin-top: 20px; display: flex; gap: 30px; align-items: center;">
            <img src="<?php echo $usta['profil_resmi']; ?>" style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; border: 5px solid #e6ddc4;">
            <div>
                <h1 style="margin:0; color:#013220;"><?php echo $usta['isim_soyisim']; ?></h1>
                <h3 style="color:#026638; margin: 10px 0;"><?php echo $usta['uzmanlik_alani']; ?></h3>
                <p><strong>Telefon:</strong> <?php echo $usta['telefon']; ?></p>
                <p><?php echo $usta['hakkinda']; ?></p>
            </div>
        </div>

        <h2 style="margin-top: 40px; color:#013220;">Yaptığım İşler (Referanslar)</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
            <?php while($ref = mysqli_fetch_assoc($referanslar)): ?>
                <img src="img/<?php echo basename($ref['resim_yolu']); ?>" style="width:100%; height:150px; object-fit:cover; border-radius:10px; border: 2px solid #ddd;">
            <?php endwhile; ?>
        </div>

        <div style="background: #e6ddc4; padding: 30px; border-radius: 15px; margin-top: 40px;">
            <h3>Ustaya İş Talebi Gönder</h3>
            <?php echo $mesaj_durum; ?>
            <form method="POST">
                <input type="text" name="ad" placeholder="Adınız Soyadınız" required style="width:100%; padding:10px; margin-bottom:10px; border-radius:5px; border:none;">
                <input type="text" name="tel" placeholder="Telefon Numaranız" required style="width:100%; padding:10px; margin-bottom:10px; border-radius:5px; border:none;">
                <textarea name="mesaj" placeholder="İhtiyacınız olan hizmeti kısaca anlatın..." rows="4" required style="width:100%; padding:10px; margin-bottom:10px; border-radius:5px; border:none;"></textarea>
                <button type="submit" style="background:#013220; color:white; padding:12px 30px; border:none; border-radius:8px; cursor:pointer;">Gönder</button>
            </form>
        </div>
    </div>

</body>
</html>