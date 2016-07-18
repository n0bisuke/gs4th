<?php
# セッションを開始します。
session_start();
# セッションを破棄☆レシピ232☆（セッションを破棄したい）します。
$_SESSION = array();
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>ログアウト</title>
</head>
<body>
<div>
  <p>ログアウトしました。</p>
  <p><a href="easyloginform_content.php">戻る</a></p>
</div>
</body>
</html>
