<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aibui = $_POST['aibui'];
    $tolkn = $_POST['109n'];

    if ($tolkn !== $_SESSION['tolkn'] || $aibui !== $_SESSION['aibui']) {
        die('NG');
    }
}

$form_uuid = bin2hex(random_bytes(16));
$encryption_key = getenv('ENCRYPTION_KEY');
$iv = random_bytes(16);
$encrypted_uuid = openssl_encrypt($form_uuid, 'aes-256-cbc', $encryption_key, 0, $iv);
$iv_hex = bin2hex($iv);
$encoded_uuid = base64_encode($encrypted_uuid);

$_SESSION['aibui'] = $iv_hex;
$_SESSION['tolkn'] = $encoded_uuid;
?>
