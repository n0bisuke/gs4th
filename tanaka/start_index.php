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