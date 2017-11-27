<?php
session_start();

$pdo = new PDO('mysql:データベース名', 'ユーザー名', 'パスワード');

  if(isset($_GET["target"]) && $_GET["target"] !== ""){
      $target = $_GET["target"];
  }
  else{
      header("Location: index.php");
  }

  $MIMETypes = array(
    'png' => 'image/png',
    'jpeg' => 'image/jpeg',
    'gif' => 'image/gif',
    'mp4' => 'video/mp4'
  );
echo "AAA";
  $sql = "SELECT * FROM media WHERE id = :target;";
  $stmt = $pdo->prepare($sql);
  $stmt -> bindValue(":target", $target, PDO::PARAM_STR);
  $stmt -> execute();
  $row = $stmt -> fetch(PDO::FETCH_ASSOC);
  header("Content-Type: ".$MIMETypes[$row["extension"]]);
  echo ($row["raw_data"]);
?>