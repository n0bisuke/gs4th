<?php
# h()関数☆レシピ221☆（安全にブラウザで値を表示したい）を読み込みます☆レシピ041☆（他のファイルを取り込んで利用したい）。
require_once 'lib/h.php';

# クリックジャッキング対策☆レシピ290☆（クリックジャッキングとは？）をします。
header('X-FRAME-OPTIONS: SAMEORIGIN');

# セッションを開始します。
session_start();

# 固定トークン☆レシピ289☆（CSRFとは？）を生成してセッション変数に保存します。フォームに
# 隠しフィールドで出力します。
if (! isset($_SESSION['token'])) {
  $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
}
$token = $_SESSION['token'];
?>

    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Local life - ローカルライフ - 事前登録</title>
        <link rel="stylesheet" type="text/css" href="css/signup.css">
    </head>

    <body>
        <header>
            <h1>Local Life</h1>
        </header>
        <main>
        <h2>事前登録</h2>
        <p>ご近所コミュニティーを創ろう</p>
        
        <?php
        # エラーがあったら表示します。
        if (isset($_SESSION['error'])) {
            foreach ($_SESSION['error'] as $value) {
            echo '  <span style="color:red;">' . h($value) . '</span><br>' . "\n";
        }
        }
        # 三項演算子☆レシピ025☆（「条件式 ? 式1 : 式2」って何ですか？）を使用して、セッションに保存されたデータ
        # がある場合、変数に代入します。
        $email = isset($_SESSION['email'])   ? $_SESSION['email']: '';
        ?>

            <form action="presignup_check.php" method="post">
                <dl>
                    <dt>
                        <label for="email">メールアドレス：</label>
                    </dt>
                    <dd>
                        <input type="email" name="email" id="email" value="<?php echo h($email); ?>" maxlength="256" required>
                    </dd>
                </dl>
                <input type="hidden" name="token" value="<?php echo h($token); ?>">
                <input type="submit" name="submit" value="登録する">
            </form>
        </main>

            <footer>
                Local life ©2016
            </footer>

    </body>

    </html>