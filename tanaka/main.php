<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0">
    <title>Local Life - ローカルライフ</title>
    <link rel="stylesheet" type="text/css" href="css/signup.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="https://code.jquery.com/jquery-2.1.4.min.js">
    </script>
    <script src="https://cdn.mlkcca.com/v0.6.0/milkcocoa.js">
    </script>

    <script>
        $(function () {
            //1.ミルクココアインスタンスを作成
            var milkcocoa = new MilkCocoa("flagiqs2dulo.mlkcca.com");

            //2."lol"データストアを作成
            var ds = milkcocoa.dataStore("lol");

            //3."lol"データストアからメッセージを取ってくる
            ds.stream().sort("desc").next(function (err, datas) {
                datas.forEach(function (data) {
                    renderMessage(data);
                });
            });

            //4."lol"データストアのプッシュイベントを監視
            ds.on("push", function (e) {
                renderMessage(e);
            });

            var last_message = "dummy";

            function renderMessage(message) {
                var message_html = '<p class="post-text">' + escapeHTML(message.value.content) + '</p>';
                var date_html = '';
                if (message.value.date) {
                    date_html = '<p class="post-date">' + escapeHTML(new Date(message.value.date).toLocaleString()) + '</p>';
                }
                $("#" + last_message).before('<div id="' + message.id + '" class="post">' + message_html + date_html + '</div>');
                last_message = message.id;
            }

            function post() {
            //5."lol"データストアにメッセージをプッシュする
                var content = escapeHTML($("#content").val());
                if (content && content !== "") {
                    ds.push({
                        title: "タイトル",
                        content: content,
                        date: new Date().getTime()
                    }, function (e) {});
                }
                $("#content").val("");
            }

            $('#post').click(function () {
                post();
            })
            $('#content').keydown(function (e) {
                if (e.which == 13) {
                    post();
                    return false;
                }
            });
        });
        //インジェクション対策
        function escapeHTML(val) {
            return $('<div>').text(val).html();
        };
    </script>


</head>

<body>
    <header>
        <h1>Local Life</h1>
        <p>

        </p>
        <p>
            <a href="signup_logout.php">ログアウト</a>
        </p>
    </header>

    <main>

        <div class="container">
            <div class="postarea cf">
                <div class="postarea-text">
                    <textarea name="" id="content" cols="50" rows="3
                " placeholder="投稿する"></textarea>
                </div>
                <button id="post" class="postarea-button">投稿する</button>
            </div>
        </div>
        <div id="messages" class="content">
            <div id="dummy">

            </div>
        </div>
    </main>

    <footer>
        Local life ©2016
    </footer>
</body>

</html>