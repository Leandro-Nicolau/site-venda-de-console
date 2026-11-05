
<?php
session_start();

if (!isset($_SESSION["cod_cliente"])) {
    header("Location: login.php");
    exit;
}
?>
