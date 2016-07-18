<?php
# h()関数☆レシピ221☆（安全にブラウザで値を表示したい）を読み込みます☆レシピ041☆（他のファイルを取り込んで利用したい）。
require_once 'lib/h.php';
# checkInput()関数を読み込みます。
require_once 'lib/checkInput.php';

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

# 変数にPOSTされたデータを代入します。
$email   = isset($_POST['email'])   ? $_POST['email']   : '';

# エラーメッセージを保存する配列を初期化します。
$error = array();

# メールアドレス欄をチェック☆レシピ210☆（メールアドレスの形式をチェックしたい）します。
if (trim($email) == '') {
  $error[] = 'メールアドレスは必須項目です。';
} elseif (mb_strlen($email) > 256) {
  $error[] = 'メールアドレスは256文字以内でお願い致します。';
} else {
  $pattern = '/\A([a-z0-9_\-\+\/\?]+)(\.[a-z0-9_\-\+\/\?]+)*' .
             '@([a-z0-9\-]+\.)+[a-z]{2,6}\z/i';
  if (! preg_match($pattern, $email)) {
    $error[] = 'メールアドレスの形式が正しくありません。';
  }
}


# POSTされたデータとエラーメッセージをセッション変数に保存します。
$_SESSION['email']   = $email;
$_SESSION['error']   = $error;

# エラー数を確認します。
if (count($error) > 0) {
# エラーがある場合は、入力フォームに戻します☆レシピ238☆（別のページに飛ばしたい）。
  $dirname = dirname($_SERVER['SCRIPT_NAME']);
  // Windowsではdirname()関数の結果が'/'の場合は'\'になる
  $dirname = ($dirname == DIRECTORY_SEPARATOR) ? '' : $dirname;
  $uri = 'http://' . $_SERVER['SERVER_NAME'] . $dirname . '/presignup_index.php';
  header('HTTP/1.1 303 See Other');
  header('Location: ' . $uri);

# 確認画面を表示します。
} else {
?>

    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>新規会員登録 - 確認画面</title>
        <link rel="stylesheet" type="text/css" href="css/signup.css">
    </head>

    <body>
        <header>
            <h1>Local Life</h1>
        </header>
        <main>
            <h2>事前登録（確認画面）</h2>
            <p>以下の内容でよろしければ送信ボタンを押してください。</p>
            <dl>
                <dt>eメールアドレス：</dt>
                <dd>
                    <?php echo h($email);?>
                </dd>
            </dl>


            <form action="presignup_index.php" method="post">
                <input type="submit" name="back" value="入力画面に戻る">
            </form>
            <form action="presignup_thanks.php" method="post">
                <input type="hidden" name="token" value="<?php echo h($token);?>">
                <input type="submit" name="submit" value="登録する">
            </form>
        </main>
        <footer>
            Local life ©2016
        </footer>

    </body>

    </html>
    <?php
}
/* ?>終了タグ省略 ☆レシピ001☆（サーバーのPHP情報を知りたい） */