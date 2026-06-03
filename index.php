<?php
include("baglanti.php");

$ara = "";
if (isset($_GET["uzmanlik"]) && !empty($_GET["uzmanlik"])) {
    $uzmanlik = mysqli_real_escape_string($baglanti, $_GET["uzmanlik"]);
    $sorgu = "SELECT * FROM ustalar WHERE uzmanlik_alani LIKE '%$uzmanlik%'";
    $ara = $uzmanlik;
} else {
    $sorgu = "SELECT * FROM ustalar";
}

$sonuc = mysqli_query($baglanti, $sorgu);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BulBul - Usta Filtreleme</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <!-- Hero Bölümü -->
    <section class="hero">
        <h1><i class="fa-solid fa-screwdriver-wrench"></i> BulBul</h1>
        <p>Hangi konuda uzman bir usta arıyorsunuz?</p>
    </section>

    <!-- Filtreleme (Arama) Çubuğu -->
    <div class="search-container">
        <form method="GET" action="index.php" style="display: flex; width: 100%;">
            <input type="text" name="uzmanlik" placeholder="Örn: Boyacı, Elektrikçi, Tesisatçı..." value="<?php echo htmlspecialchars($ara); ?>">
            <button type="submit">Usta Bul</button>
        </form>
    </div>

    <!-- Eğer arama yapılmışsa temizleme butonu göster -->
    <?php if($ara != ""): ?>
    <div style="text-align:center; margin-bottom: 20px;">
        <p>
            <b>"<?php echo htmlspecialchars($ara); ?>"</b> branşındaki ustalar listeleniyor. 
            <a href="index.php" style="color: #026638; font-weight: bold; text-decoration: none; margin-left: 10px;">
                <i class="fa-solid fa-rotate-left"></i> Filtreyi Temizle
            </a>
        </p>
    </div>
    <?php endif; ?>

    <!-- Usta Kartları Listesi -->
    <div class="usta-grid">
        <?php if(mysqli_num_rows($sonuc) > 0): ?>
            <?php while($usta = mysqli_fetch_assoc($sonuc)): ?>
                <div class="usta-card">
                    <!-- Profil Resmi -->
                    <img src="<?php echo $usta['profil_resmi']; ?>" class="usta-img" alt="Usta">
                    
                    <div class="usta-info">
                        <span class="uzmanlik"><?php echo $usta['uzmanlik_alani']; ?></span>
                        <h3><?php echo $usta['isim_soyisim']; ?></h3>
                        <p><?php echo (strlen($usta['hakkinda']) > 70) ? substr($usta['hakkinda'], 0, 70)."..." : $usta['hakkinda']; ?></p>
                        <a href="usta_detay.php?id=<?php echo $usta['id']; ?>" class="btn-profil">Profili İncele</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <!-- Aranan branşta kimse yoksa bu mesaj çıkar -->
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: white; border-radius: 15px;">
                <i class="fa-solid fa-magnifying-glass-blur fa-3x" style="color: #ccc;"></i>
                <p style="color: #666; margin-top: 15px; font-size: 18px;">Aradığınız branşta usta bulunamadı.</p>
                <a href="index.php" style="color: #013220; font-weight: bold;">Tüm ustalara göz at</a>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2026 BulBul Platformu | <a href="yonetim/usta_giris.php" style="color: white; text-decoration: underline;">Usta Girişi</a></p>
    </footer>

</body>
</html>