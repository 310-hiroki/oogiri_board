<?php

$pdo = new PDO('mysql:データベース名', 'ユーザー名', 'パスワード');
session_start();

?>

<!DOCTYPE html>
<html lang = "ja">
<head>
	<meta charset="UTF-8">
	<title>大喜利お題リスト</title>
</head>
  <body>
  <h1>大喜利掲示板</h1>
    <?php
      $sql = "SELECT * FROM theme ORDER BY id DESC;";
      $stmt = $pdo->prepare($sql);
      $stmt -> execute();
    ?>
    <fieldset>
      <legend>全て文章題お題</legend>
      <?php while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) : ?>
        <li>
          No<?php  echo $row["id"];  ?>.
          <a href="http://co-994.it.99sv-coco.com/odai.php?id=<?php  echo $row['id'];  ?>"><?php  echo $row['odai'];  ?></a>
        </li>
      <?php endwhile; ?>
    </fieldset>
    <br>
    <a href="http://co-994.it.99sv-coco.com/odai_list.php">戻る</a>
  </body>
</html>

  