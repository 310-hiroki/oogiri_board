<?php

$pdo = new PDO('mysql:データベース名', 'ユーザー名', 'パスワード');
$Message = "";

$user_id = $_GET["user_id"];

$sql = "SELECT COUNT(*) FROM account WHERE user_id = :user_id;";
$stmt = $pdo->prepare($sql); 
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$stmt->execute();

$count = $stmt->fetchColumn();

  if ($count == 0){
    echo "キーが一致しません";
  }else{
    $sql = "UPDATE account SET pr = :pr WHERE user_id = :user_id;";
    $stmt = $pdo -> prepare($sql); 
    $stmt->bindValue(':pr', 0, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();
    $Message = "登録が完了しました。\n"
              ."IDは".$user_id."です。メモしておいてください。";
  }

?>

<html lang = "ja">
<head>
	<meta charset="UTF-8">
	<title>大喜利掲示板</title>
</head>
<body>
  <h1>大喜利掲示板</h1>
  <div><font color="#0000ff"><?php echo htmlspecialchars($Message, ENT_QUOTES); ?></font></div>
  <br>
  <a href="http://co-994.it.99sv-coco.com/main.php">戻る</a><br/>
</body>
</html>