# MoonLight_Secure_Project

MoonLight_Secure_Projectは、ユーザーリクエストの認証と不正アクセスの防止を簡潔かつ効果的な方法で提供することを目的とした、新しい革新的なWebセキュリティのアプローチです。このプロジェクトでは、動的トークンと暗号化を使用してWebフォームとデータ送信のセキュリティを強化し、外部の認証サービスに依存せずにセキュアな環境を作り出すことを目指しています。より安全でアクセスしやすいデジタル環境の構築に参加しましょう！

## 109n Secure Trick

このプロジェクト「109n Secure Trick」では、Webセキュリティに対する新しく革新的なアプローチを紹介します。このアプローチは、各リクエストのためにユニークなトークンと初期化ベクトル（IV）を生成することで、Webフォームの送信を保護し、すべてのフォーム送信が正当で正しいソースからのものであることを保証するものです。

### コードの説明

以下のPHPコードは、フォームの送信をセキュアにするための基本的な実装です。

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
#### コードの詳細解説

1. **セッションの開始**
```php
session_start();
```
   `session_start()`関数でセッションを開始します。これにより、サーバーは各ユーザーセッションごとにデータを保存し、管理することができます。

2. **フォーム送信の検証**

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aibui = $_POST['aibui'];
    $token = $_POST['109n'];

    if ($token !== $_SESSION['token'] || $aibui !== $_SESSION['aibui']) {
        die('NG');
    }
}
```

   フォームがPOSTメソッドで送信された場合、`$_POST`から`aibui`（初期化ベクトル）と`109n`（トークン）を取得します。フォームから送信されたトークンとセッションに保存されたトークン、または送信されたIVとセッションに保存されたIVが一致しない場合、スクリプトを終了し、「NG」（No Good）を表示します。これにより、不正なリクエストがブロックされます。

3. **トークンとIVの生成**
```php
$form_uuid = bin2hex(random_bytes(16));
$encryption_key = getenv('ENCRYPTION_KEY');
$iv = random_bytes(16);
$encrypted_uuid = openssl_encrypt($form_uuid, 'aes-256-cbc', $encryption_key, 0, $iv);
$iv_hex = bin2hex($iv);
$encoded_uuid = base64_encode($encrypted_uuid);
```

   - `bin2hex(random_bytes(16))`でランダムなUUID（ユニークな識別子）を生成します。このUUIDは、各フォームリクエストが一意であることを保証するために使用されます。
   - 環境変数から暗号化キー（`$encryption_key`）を取得し、UUIDの暗号化に使用します。
   - 初期化ベクトル（`$iv`）をランダムなバイトで生成します。このIVは、AES-256-CBC暗号化方式に必要で、同じデータを複数回暗号化しても異なる出力が得られるようにします。
   - `openssl_encrypt()`を使用して、UUIDをAES-256-CBC暗号化アルゴリズムで暗号化します。暗号化キーとIVが使われます。
   - 暗号化されたUUIDはBase64でエンコードされ（`$encoded_uuid`）、安全に送信されるようになります。

4. **セッション変数の更新**
```php
$_SESSION['aibui'] = $iv_hex;
$_SESSION['token'] = $encoded_uuid;
```
   新しいトークンとIVをセッション変数として保存します。これにより、次のフォーム表示時に新しいトークンとIVが生成され、リプレイ攻撃やフォームの複製を防ぎます。

### まとめ

このアプローチにより、各フォーム送信が一意であり、動的に生成されたトークンとIVを使用して検証されることで、CSRF（クロスサイトリクエストフォージェリ）攻撃やその他の不正アクセスの試みから強力に保護されます。セッションデータはすべての通信が安全で有効であることを保つために継続的に更新されます。
