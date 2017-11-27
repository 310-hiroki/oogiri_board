<?php

$pdo = new PDO('mysql:データベース名', 'ユーザー名', 'パスワード');
session_start();

if (isset($_SESSION["NAME"]) || isset($_SESSION["USER_ID"])) {
    $errorMessage = "ログアウトしました。";
} else {
    $errorMessage = "セッションがタイムアウトしました。";
}

// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();
?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ログアウト</title>
  </head>
  <body>
    <h1>大喜利掲示板</h1>
    <h2>ログアウト画面</h2>
        <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
        <ul>
            <li><a href="main.php">メイン画面に戻る</a></li>
        </ul>
    </body>
</html>