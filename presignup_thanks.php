<?php
# h()関数☆レシピ221☆（安全にブラウザで値を表示したい）を読み込みます☆レシピ041☆（他のファイルを取り込んで利用したい）。
require_once 'lib/h.php';
# checkInput()関数を読み込みます。
require_once 'lib/checkInput.php';
# メール送信用のsendmail()関数を読み込みます。
require_once 'lib/sendmail.php';

// メールの宛先
$mailTo  = 'newuser@example.jp';
// メールのタイトル
$subject = '事前会員登録が入りました';
// Return-Pathに指定するメールアドレス
$returnMail = $mailTo;

# クリックジャッキング対策☆レシピ290☆（クリックジャッキングとは？）をします。
header('X-FRAME-OPTIONS: SAMEORIGIN');

# セッションを開始します。
session_start();

# POSTされたデータをチェックします。
$_POST = checkInput($_POST);

# トークンを確認します。
if (isset($_POST['token']) && isset($_SESSION['token'])) {
  $token = $_POST['token'];
  if ($token != $_SESSION['token']) {
    die('不正アクセスの疑いがあります。');
  }
} else {
  die('不正アクセスの疑いがあります。');
}

# 変数にセッション変数を代入します。
$email   = $_SESSION['email'];

# mbstringの日本語設定を行ないます。
mb_language('ja');
mb_internal_encoding('UTF-8');

# 送信結果をお知らせする変数を初期化します。
$message = '';

# メールの送信と結果の判定をします。
$result = sendmail($email, $mailTo, $subject, $returnMail);
if ($result) {
  $message =  '登録完了
  ご登録ありがとうございます。';
# セッション変数を破棄☆レシピ230☆（セッション変数を破棄したい）します。
  $_SESSION = array();
  session_destroy();
} else {
  $message = '送信失敗しました';
}
?>
    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Local Life - 事前登録</title>
        <link rel="stylesheet" type="text/css" href="css/signup.css">
    </head>

    <body>
        <header>
            <h1>Local Life</h1>
        </header>
        <main>
            <h2>事前登録</h2>
            <p>
                <?php echo h($message); ?>
            </p>
        </main>
        <footer>
            Local life ©2016
        </footer>
    </body>

    </html>