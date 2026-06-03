<?php
session_start();
include("../baglanti.php");

if (!isset($_SESSION["usta_giris"])) {
    header("Location: usta_giris.php");
    exit();
}

$usta_id = $_SESSION["usta_id"];
$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["resim"])) {
    $baslik = mysqli_real_escape_string($baglanti, $_POST["is_basligi"]);
    
    $dosya_adi = $_FILES["resim"]["name"];
    $gecici_yol = $_FILES["resim"]["tmp_name"];
    $hedef_klasor = "../img/" . time() . "_" . $dosya_adi; 

    if (move_uploaded_file($gecici_yol, $hedef_klasor)) {
        $kaydet = "INSERT INTO referanslar (usta_id, is_basligi, resim_yolu) VALUES ('$usta_id', '$baslik', '$hedef_klasor')";
        mysqli_query($baglanti, $kaydet);
        $mesaj = "<p style='color:green;'>İş başarıyla eklendi!</p>";
    } else {
        $mesaj = "<p style='color:red;'>Resim yüklenirken hata oluştu.</p>";
    }
}

$sorgu = "SELECT * FROM referanslar WHERE usta_id = '$usta_id'";
$referanslar = mysqli_query($baglanti, $sorgu);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İşlerim (Referanslar) - BulBul</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <h2><i class="fa-solid fa-screwdriver-wrench"></i> BulBul</h2>
        <nav>
            <a href="usta_panel.php"><i class="fa-solid fa-user"></i> Profilim</a>
            <a href="referanslar.php"><i class="fa-solid fa-images"></i> İşlerim</a>
            <a href="mesajlar.php"><i class="fa-solid fa-envelope"></i> Mesajlar</a>
            <a href="cikis.php" style="margin-top: 50px; color: #ff4d4d;"><i class="fa-solid fa-right-from-bracket"></i> Çıkış Yap</a>
        </nav>
    </div>

    <div class="main-content">
        <header><i class="fa-solid fa-camera"></i> Yaptığım İşler</header>
        <main>
            <!-- Yeni İş Ekleme Formu -->
            <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 30px;">
                <h4>Yeni İş Ekle</h4>
                <?php echo $mesaj; ?>
                <form method="POST" enctype="multipart/form-data"> <!-- Dosya yükleme için gerekli -->
                    <input type="text" name="is_basligi" placeholder="İşin Başlığı (Örn: Mutfak Tadilatı)" required style="width:70%; padding:8px;">
                    <input type="file" name="resim" accept="image/*" required style="margin: 10px 0;">
                    <br>
                    <button type="submit" style="background:#026638; color:white; border:none; padding:10px 20px; border-radius:6px; cursor:pointer;">Yükle</button>
                </form>
            </div>

            <!-- Listeleme Alanı (Örnek 1 Tablo Mantığı) -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                <?php while($is = mysqli_fetch_assoc($referanslar)): ?>
                    <div style="background: white; padding: 10px; border-radius: 8px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        <img src="<?php echo $is['resim_yolu']; ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 5px;">
                        <h5 style="margin: 10px 0;"><?php echo $is['is_basligi']; ?></h5>
                        <a href="referans_sil.php?id=<?php echo $is['id']; ?>" onclick="return confirm('Bu işi silmek istediğinize emin misiniz?')" style="color:red; text-decoration:none; font-size:14px;">
                            <i class="fa-solid fa-trash"></i> Sil
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        </main>
    </div>
</body>
</html>