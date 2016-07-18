<?php
# 認証を要求したいページの先頭に以下を記述します。
require_once './signup_index.php';
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
            <p>
                <?php echo h($_SESSION['username']); ?>
            </p>
            <p>
            <a href="signup_logout.php">ログアウト</a>
            </p>
        </header>
        <main>
        
        </main>
        <footer>
            Local life ©2016
        </footer>
    </body>

    </html>