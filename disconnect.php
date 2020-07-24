<?php
session_start();
include("config/settings.php");

$_SESSION['is_connected'] = null;
$_SESSION['account_id'] = null;

session_destroy();
header('Location: ' . $settings_php_page . 'auth/?e=3');
exit;
?>