<?php
session_start();
session_destroy();
header("Location: usta_giris.php");
exit();
?>