# MoonLight_Secure_Project

**MoonLight_Secure_Project** offers a new idea for web security that aims to provide a simple yet effective method for authenticating user requests and preventing unauthorized access. **With just under 20 lines of code**, this project focuses on enhancing the security of web forms and data transmission using dynamic tokens and encryption, without relying on external authentication services. Why not join us in creating a safer and more user-friendly digital environment?


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

## Detailed Code Explanation
1. **Session Initialization**

```php
session_start();
```

The code starts with session_start() to initiate a session. This allows the server to store and manage data across multiple page requests for each user session.
Token and IV Generation:

A random UUID ($form_uuid) is generated using bin2hex(random_bytes(16)). This unique identifier helps ensure that every form request is unique.
An encryption key is retrieved from the environment variables ($encryption_key). This key is used to encrypt the UUID.
An initialization vector ($iv) is generated with random_bytes(16). It is required for the AES-256-CBC encryption method to ensure that even if the same data is encrypted multiple times, the output will be different.
The UUID is then encrypted with the AES-256-CBC encryption algorithm, using the encryption key and IV (openssl_encrypt()).
The encrypted UUID is encoded in Base64 ($encoded_uuid) for safe transmission.

2. **Form Submission Handling**

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aibui = $_POST['aibui'];
    $token = $_POST['109n'];

    if ($token !== $_SESSION['token'] || $aibui !== $_SESSION['aibui']) {
        die('NG');
    }
}
```

When the form is submitted via the POST method, it retrieves aibui (initialization vector) and 109n (token) from $_POST. If the submitted token does not match the token stored in the session, or if the submitted IV does not match the IV stored in the session, the script terminates and displays "NG" (No Good). This blocks any unauthorized requests.


3 **Token and IV Generation**
```php
$form_uuid = bin2hex(random_bytes(16));
$encryption_key = getenv('ENCRYPTION_KEY');
$iv = random_bytes(16);
$encrypted_uuid = openssl_encrypt($form_uuid, 'aes-256-cbc', $encryption_key, 0, $iv);
$iv_hex = bin2hex($iv);
$encoded_uuid = base64_encode($encrypted_uuid);
```

- Generates a random UUID (Unique Identifier) using `bin2hex(random_bytes(16))`. This UUID ensures that each form request is unique.
- Retrieves the encryption key (`$encryption_key`) from environment variables, which is used to encrypt the UUID.
- Generates an Initialization Vector (`$iv`) with random bytes. The IV is required for the AES-256-CBC encryption method, ensuring that even if the same data is encrypted multiple times, the output will be different.
- Uses `openssl_encrypt()` to encrypt the UUID with the AES-256-CBC algorithm. The encryption key and IV are used in this process.
- The encrypted UUID is encoded in Base64 (`$encoded_uuid`) for safe transmission.


4 **Session Variable Updates**
```php
$_SESSION['aibui'] = $iv_hex;
$_SESSION['token'] = $encoded_uuid;
```

Before the form is displayed, new tokens ($encoded_uuid) and IV ($iv_hex) are generated and stored in the session. This ensures that every form display has fresh tokens and IV, preventing replay attacks or form duplication.

### HTML Form with Hidden Fields

The form includes hidden fields (`109n` and `aibui`) that hold the encrypted UUID and IV values. These hidden fields are sent with the form when the user submits it. Upon submission, these values are validated against the session data to ensure authenticity.

Here's an example of how the HTML form is structured:

```html
<form method="POST">
    <input type="hidden" name="109n" value="<?=$encoded_uuid?>" />
    <input type="hidden" name="aibui" value="<?=$iv_hex?>" />
    <div class="form-group">
        <label for="somthing">somthing</label>
        <input type="text" id="somthing" name="somthing" value=""/>
    </div>
    <button>SEND</button>
</form>
```

## Summary

This approach ensures that each form submission is unique and validated using dynamically generated tokens and IVs, providing robust protection against CSRF (Cross-Site Request Forgery) attacks and other unauthorized access attempts. The session data is continually updated to keep all communications secure and valid.
