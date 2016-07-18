<?php
# メールを送信する関数です。
function sendmail($fromName, $from, $to, $subject, $body, $returnPath = null)
{
# メールアドレスや件名に改行コードが含まれないことをチェックします。
  if (preg_match('/[\r\n]/', $fromName) !== 0
      || preg_match('/[\r\n]/', $from) !== 0
      || preg_match('/[\r\n]/', $to) !== 0
      || preg_match('/[\r\n]/', $subject) !== 0) {
    die('不正な入力が検出されました。');
  }

  if (is_null($returnPath)) {
    $returnPath = $from;
  }

# Fromヘッダーを作成します。
  $header = 'From: ' . mb_encode_mimeheader($fromName) . ' <' . $from . '>';

# メールを送信し、結果を返します。
# セーフモード☆レシピ283☆（セーフモードとは？）がOnの場合は第5引数が使えません。
  if (ini_get('safe_mode')) {
    $result = mb_send_mail($to, $subject, $body, $header);
  } else {
    $result = mb_send_mail($to, $subject, $body, $header, '-f' . $returnPath);
  }
  return $result;
}
/* ?>終了タグ省略 ☆レシピ001☆（サーバーのPHP情報を知りたい） */
