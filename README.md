# MoonLight_Secure_Project

MoonLight_Secure_Project is an innovative approach to web security that aims to provide simple yet effective methods for authenticating user requests and preventing unauthorized access. This project focuses on using dynamic tokens and encryption to enhance the security of web forms and data transmission without relying on external authentication services. Join us in creating a safer and more accessible digital environment!

## 109n Secure Trick

The "109n Secure Trick" project introduces a new and innovative approach to web security. This approach protects web form submissions by generating unique tokens and initialization vectors (IVs) for each request, ensuring that every form submission is legitimate and originates from a valid source.

### Code Explanation

The following PHP code is a basic implementation to secure form submissions.

```php
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
$iv = random_bytes(16);
$encrypted_uuid = openssl_encrypt($form_uuid, 'aes-256-cbc', $encryption_key, 0, $iv);
$iv_hex = bin2hex($iv);
$encoded_uuid = base64_encode($encrypted_uuid);

$_SESSION['aibui'] = $iv_hex;
$_SESSION['token'] = $encoded_uuid;
?>
```
Session Initialization:

The code starts with session_start() to initiate a session. This allows the server to store and manage data across multiple page requests for each user session.
Token and IV Generation:

A random UUID ($form_uuid) is generated using bin2hex(random_bytes(16)). This unique identifier helps ensure that every form request is unique.
An encryption key is retrieved from the environment variables ($encryption_key). This key is used to encrypt the UUID.
An initialization vector ($iv) is generated with random_bytes(16). It is required for the AES-256-CBC encryption method to ensure that even if the same data is encrypted multiple times, the output will be different.
The UUID is then encrypted with the AES-256-CBC encryption algorithm, using the encryption key and IV (openssl_encrypt()).
The encrypted UUID is encoded in Base64 ($encoded_uuid) for safe transmission.
Form Submission Handling:

When the form is submitted ($_SERVER['REQUEST_METHOD'] === 'POST'), the code retrieves the values submitted in the form, including the encrypted UUID (109n) and IV (aibui).
It then decodes the received encrypted UUID and decrypts it to verify that it matches the original session-stored UUID ($_SESSION['tolkn']).
If the decrypted UUID or IV does not match the session-stored values, the submission is considered invalid, and an "NG" (No Good) message is displayed.
Session Variable Updates:

Before the form is displayed, new tokens ($encoded_uuid) and IV ($iv_hex) are generated and stored in the session. This ensures that every form display has fresh tokens and IV, preventing replay attacks or form duplication.
HTML Form with Hidden Fields:

The form includes hidden fields (109n and aibui) that hold the encrypted UUID and IV values. These hidden fields are sent with the form when the user submits it. Upon submission, these values are validated against the session data to ensure authenticity.
Summary
This approach ensures that each form submission is unique and validated using dynamically generated tokens and IVs, providing robust protection against CSRF (Cross-Site Request Forgery) attacks and other unauthorized access attempts. The session data is continually updated to keep all communications secure and valid.

By understanding this method, developers can enhance the security of their web forms and protect against various forms of web attacks.
