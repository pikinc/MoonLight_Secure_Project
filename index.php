<?php include_once('auth.php'); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
</head>
<body>
  <main>
    <div class="inner">
      <form method="POST">
      <input type="hidden" name="109n" value="<?=$encoded_uuid?>" />
      <input type="hidden" name="aibui" value="<?=$iv_hex?>" />
        <div class="form-group">
          <label for="somthing">somthing</label>
          <input type="text" id="somthing" name="somthing" value=""/>
        </div>
      <button>SEND</button>
      </form>
    </div>
  </main>
</body>
</html>
