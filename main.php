<?php

session_start();

$pdo = new PDO('mysql:データベース名', 'ユーザー名', 'パスワード');

?>

<!DOCTYPE html>
<html lang = "ja">
<head>
	<meta charset="UTF-8">
	<title>大喜利掲示板</title>
</head>
<body>
  <h1>大喜利掲示板</h1>
  ご自由に出題、回答してください。<br>
  <?php if (!isset($_SESSION["NAME"])) : ?>
    <a href="http://co-994.it.99sv-coco.com/login.php">ログイン</a>
  <?php else : ?>
    <p>ようこそ<u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u>さん</p>  <!-- ユーザー名をechoで表示 -->
      <ul>
        <li><a href="logout.php">ログアウト</a></li>
      </ul>
  <?php endif ; ?>
  <a href="http://co-994.it.99sv-coco.com/make_odai.php">お題を出題する</a>
  <a href="http://co-994.it.99sv-coco.com/odai_list.php">お題一覧</a>
</body>
</html>


  