<?php
# h()関数☆レシピ221☆（安全にブラウザで値を表示したい）を読み込みます☆レシピ041☆（他のファイルを取り込んで利用したい）。
require_once 'lib/h.php';
# password_verify()関数☆レシピ220☆（パスワードをハッシュ化したい）を読み込みます。
require_once 'lib/password_compat/password.php';

# クリックジャッキング対策☆レシピ290☆（クリックジャッキングとは？）をします。
header('X-FRAME-OPTIONS: SAMEORIGIN');

# セッションを開始します。
session_start();

# ユーザー名とパスワードを設定します。複数名分の設定ができます。
$userid[]   = 'admin';   // ユーザーID
$username[] = '管理者';  // お名前
// パスワード「pass1」をpassword_hash()関数でハッシュ化した文字列
$hash[] = '$2y$10$7llM8TDTW3cxrMPzwd1ydOky3FP7yYOzn/d4bEWWbeFDiQ.tTbM3O';

$userid[]   = 'test';
$username[] = 'テスト';
// パスワード「pass2」をpassword_hash()関数でハッシュ化した文字列
$hash[] = '$2y$10$qNxqM4UP79klxfqV9cIwcO6LBJI44Z34k76m9w9teN.PLpfTe8lxG';

# エラーメッセージの変数を初期化します。
$error = '';

# 認証済みかどうかのセッション変数を初期化します。
if (! isset($_SESSION['auth'])) {
  $_SESSION['auth'] = false;
}

if (isset($_POST['userid']) && isset($_POST['password'])) {
  foreach ($userid as $key => $value) {
    if ($_POST['userid'] === $userid[$key] &&
# 入力されたパスワード文字列とハッシュ化済みパスワードを照合します。
        password_verify($_POST['password'], $hash[$key])) {
# セッション固定化攻撃☆レシピ301☆（セッション固定化攻撃を防ぎたい）を防ぐため、セッションIDを変更します。
      session_regenerate_id(true);
      $_SESSION['auth'] = true;
      $_SESSION['username'] = $username[$key];
      break;
    }
  }
  if ($_SESSION['auth'] === false) {
    $error = 'ユーザーIDかパスワードに誤りがあります。';
  }
}

if ($_SESSION['auth'] !== true) {
?>
    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Local Life - ローカルライフ</title>
        <link rel="stylesheet" type="text/css" href="css/signup.css">
    </head>

    <body>
       <header>
        <h1>Local Life</h1>
        </header>
        <main>
        <p>ご近所コミュニティーを創ろう</p>
        
            <?php
  if ($error) {  // エラー文がセットされていれば赤色で表示
    echo '<p style="color:red;">' . h($error) . '</p>';
  }
  ?>
                <form action="<?php echo h($_SERVER['SCRIPT_NAME']); ?>" method="post">
                    <dl>
                        <dt><label for="userid">ユーザーID：</label></dt>
                        <dd>
                            <input type="text" name="userid" id="userid" value="">
                        </dd>
                    </dl>
                    <dl>
                        <dt><label for="password">パスワード：</label></dt>
                        <dd>
                            <input type="password" name="password" id="password" value="">
                        </dd>
                    </dl>
                    <input type="submit" name="submit" value="ログイン">
                </form>
                <p>パスワードを忘れた場合はこちら</p>
                <input type="button" name="button" onclick="location.href='signup_1.php
                '" value="新規登録">
        </main>
    
    <footer>
        Local life ©2016
    </footer>
    </body>

    </html>
    <?php
# スクリプトを終了し、認証が必要なページが表示されないようにします。
  exit();
}
/* ?>終了タグ省略 ☆レシピ001☆（サーバーのPHP情報を知りたい） */