<?php

$pdo = new PDO('mysql:データベース名', 'ユーザー名', 'パスワード');
session_start();


$id = $_GET["id"];

$sql = "SELECT * FROM media WHERE id = :id;";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_STR);
$stmt->execute(); 
$row = $stmt -> fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang = "ja">
<head>
	<meta charset="UTF-8">
	<title>大喜利お題</title>
</head>
  <body>
    <h1>大喜利掲示板</h1>
      <fieldset>
        <legend>大喜利お題</legend>
        <?php echo $row["odai"]; ?> <br>
        <?php
          $target = $row["raw_data"];
          if($row["extension"] == "mp4"){
            echo ("<video src=$target</video>");
          }
          elseif($row["extension"] == "jpeg" || $row["extension"] == "png" || $row["extension"] == "gif"){
            echo ("<img src=$target>");
          }
        ?>
      </fieldset>
  　<?php if (!isset($_SESSION["NAME"])) : ?>
      お題の作成・回答をするにはログインが必要です。
      <a href="http://co-994.it.99sv-coco.com/login.php">ログイン</a>
    <?php else : ?>
      <p>ようこそ<u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u>さん</p>  <!-- ユーザー名をechoで表示 -->
      <ul>
        <li><a href="logout.php">ログアウト</a></li>
      </ul>
      <ul>
        <li><a href="media_answer.php?odai_id=<?php echo $row['id']; ?>">このお題に回答する</a></li>
      </ul>
    <?php endif ; ?>
    <br>
    <?php
      $sql = "SELECT * FROM media_answer WHERE odai_id = :id;";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt -> execute();
      $count = $stmt->rowCount();
    ?>
    回答<?php echo $count; ?>件
    <?php while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) : ?>
      <li>
        No<?php  echo $row["id"];  ?>.
        <?php  echo $row['kaitou'];  ?>
      </li>
    <?php endwhile; ?>
    <br>
    <a href="http://co-994.it.99sv-coco.com/odai_list.php">お題一覧に戻る</a>
  </body>
</html>
  