<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aibui = $_POST['aibui'];
    $token = $_POST['109n'];

    if ($token !== $_SESSION['token'] || $aibui !== $_SESSION['aibui']) {
        die('NG');
    }
}

$form_uuid = bin2hex(random_bytes(16));
$encryption_key = getenv('ENCRYPTION_KEY');

// The following check displays an error if the encryption key is not set.
// Uncomment it as needed.
// if (!$encryption_key) {
//     die('Encryption key not found. Please set the ENCRYPTION_KEY environment variable.');
// }

$iv = random_bytes(16);
$encrypted_uuid = openssl_encrypt($form_uuid, 'aes-256-cbc', $encryption_key, 0, $iv);
$iv_hex = bin2hex($iv);
$encoded_uuid = base64_encode($encrypted_uuid);

$_SESSION['aibui'] = $iv_hex;
$_SESSION['token'] = $encoded_uuid;
?>
