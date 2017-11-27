<?php

$pdo = new PDO('mysql:データベース名', 'ユーザー名', 'パスワード');
session_start();
$Message = "";

$odai_id = $_GET["odai_id"];

$sql = "SELECT * FROM theme WHERE id = :id;";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $odai_id, PDO::PARAM_STR);
$stmt->execute(); 
$row = $stmt -> fetch(PDO::FETCH_ASSOC);


if (isset($_POST["answer"])) {
  $kaitou = $_POST["kaitou"];
  $account_id = $_SESSION["USER_ID"];

  if(empty($kaitou)){
    $Message = "回答を入力してください。";
  } else {
  $sql = "INSERT INTO answer (kaitou, odai_id, account_id, kaitou_time, kaitou_point) VALUES (:kaitou, :odai_id, :account_id, now(), 0);";
  $result = $pdo->prepare($sql);
  $result->bindParam(':kaitou', $kaitou, PDO::PARAM_STR);
  $result->bindVALUE(':odai_id', $odai_id, PDO::PARAM_INT);
  $result->bindVALUE(':account_id', $userid, PDO::PARAM_INT);
  $result->execute();

  $Message = "回答されました。";
  }
}
?>

<!DOCTYPE html>
<html lang = "ja">
<head>
	<meta charset="UTF-8">
	<title>大喜利回答</title>
</head>
  <body>
    <h1>大喜利掲示板</h1>
      <fieldset>
        <legend>大喜利お題</legend>
        <?php echo $row["odai"]; ?> 
      </fieldset>
      <div><font color="#ff0000"><?php echo htmlspecialchars($Message, ENT_QUOTES); ?></font></div>
      <br>
      <form name="answer" action="" method="POST">
        <label>回答：<input type="text" name="kaitou" value="" placeholder="回答を入力"></label>
        <br>
        <button type="submit" name="answer">送信</button>
      </form>
      <br>
      <a href="http://co-994.it.99sv-coco.com/odai.php?id=<?php  echo $row['id'];  ?>">お題に戻る</a>
  </body>
</html>

  