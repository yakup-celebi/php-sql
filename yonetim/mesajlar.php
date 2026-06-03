<?php
session_start();
include("../baglanti.php");

if (!isset($_SESSION["usta_giris"])) {
    header("Location: usta_giris.php");
    exit();
}

$usta_id = $_SESSION["usta_id"];
$uyari = "";

if (isset($_GET["sil"])) {
    $sil_id = mysqli_real_escape_string($baglanti, $_GET["sil"]);
    $sil_sorgu = "DELETE FROM mesajlar WHERE id = '$sil_id' AND usta_id = '$usta_id'";
    if (mysqli_query($baglanti, $sil_sorgu)) {
        $uyari = "<p style='color:red; font-weight:bold;'>Mesaj başarıyla silindi.</p>";
    }
}

$sorgu = "SELECT * FROM mesajlar WHERE usta_id = '$usta_id' ORDER BY tarih DESC";
$mesajlar = mysqli_query($baglanti, $sorgu);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Gelen Mesajlar - BulBul</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="panel-body">

    <div class="sidebar">
        <h2><i class="fa-solid fa-screwdriver-wrench"></i> BulBul</h2>
        <nav>
            <a href="usta_panel.php"><i class="fa-solid fa-house"></i> Panel Özeti</a>
            <a href="profil_duzenle.php"><i class="fa-solid fa-user-gear"></i> Profilimi Düzenle</a>
            <a href="referanslar.php"><i class="fa-solid fa-images"></i> İşlerim</a>
            <a href="mesajlar.php" class="active"><i class="fa-solid fa-envelope"></i> Mesajlar</a>
            <a href="cikis.php" style="margin-top: 50px; color: #ff4d4d;"><i class="fa-solid fa-right-from-bracket"></i> Çıkış Yap</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="panel-header">Gelen İş Talepleri</div>
        
        <div style="padding: 20px;">
            <?php echo $uyari; ?>

            <?php if(mysqli_num_rows($mesajlar) > 0): ?>
                <div style="display: grid; gap: 20px;">
                    <?php while($m = mysqli_fetch_assoc($mesajlar)): ?>
                        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #013220;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                                <div>
                                    <h3 style="margin: 0; color: #013220;"><?php echo $m['musteri_ad']; ?></h3>
                                    <small style="color: #888;"><?php echo date("d.m.Y H:i", strtotime($m['tarih'])); ?></small>
                                </div>
                                <div style="display: flex; gap: 10px;">
                                    <!-- WhatsApp Cevap Butonu  -->
                                    <a href="https://wa.me/90<?php echo $m['musteri_tel']; ?>?text=Merhaba, BulBul üzerinden gönderdiğiniz mesaj için ulaşıyorum." 
                                       target="_blank" 
                                       style="background: #25D366; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 13px;">
                                        <i class="fa-brands fa-whatsapp"></i> WhatsApp'tan Yaz
                                    </a>

                                    <!-- Silme Butonu -->
                                    <a href="mesajlar.php?sil=<?php echo $m['id']; ?>" 
                                       onclick="return confirm('Bu mesajı silmek istediğinize emin misiniz?')"
                                       style="background: #ff4d4d; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 13px;">
                                        <i class="fa-solid fa-trash"></i> Sil
                                    </a>
                                </div>
                            </div>
                            
                            <p style="background: #f9f9f2; padding: 15px; border-radius: 8px; color: #444; line-height: 1.5; margin: 10px 0;">
                                <b>Mesaj:</b><br>
                                <?php echo nl2br($m['mesaj_icerigi']); ?>
                            </p>
                            
                            <div style="color: #026638; font-weight: bold;">
                                <i class="fa-solid fa-phone"></i> Müşteri Tel: <?php echo $m['musteri_tel']; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 50px; background: white; border-radius: 12px;">
                    <i class="fa-solid fa-inbox fa-3x" style="color: #ccc;"></i>
                    <p style="color: #888; margin-top: 15px;">Henüz bir mesajınız bulunmuyor.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>