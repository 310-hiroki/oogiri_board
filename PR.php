<?php

$pdo = new PDO('mysql:データベース名', 'ユーザー名', 'パスワード');
session_start();

$errorMessage ="";
$signUpMessage = "";

// 新規登録ボタンが押された場合
if (isset($_POST["new"])) {
  /// 1. 名前の入力チェック
  if (empty($_POST["name"])) {  // 値が空のとき
    $errorMessage = '名前が未入力です。';
  } else if (empty($_POST["password"])) {
    $errorMessage = 'パスワードが未入力です。';
  } else if (empty($_POST["password2"])) {
    $errorMessage = '確認用パスワードが未入力です。';
  }  else if (empty($_POST["mailadr"])) {
    $errorMessage = 'メールアドレスが未入力です。';
  }

  $mailadr = $_POST["mailadr"];
  $mail = 1;
  
  if(!empty($_POST["mailadr"]) && !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mailadr)){
    $errorMessage = 'メールアドレスの形式が正しくありません。';
    $mail = 0;
  }
    

  if (!empty($_POST["name"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && !empty($_POST["mailadr"]) && $_POST["password"] === $_POST["password2"] && $mail === 1) {
    //ユニークIDを生成する。
    $user_id = uniqid();
    
    // 入力した名前、パスワードを格納
    $name = $_POST["name"];
    $password = $_POST["password"];
    $mailadr = $_POST["mailadr"];

    // 名前の重複を調べ、同じ名前があった場合にエラーを返す
    $sql = "SELECT COUNT(*) FROM account WHERE name = :name;";
    $stmt = $pdo->prepare($sql); 
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();

    $count = $stmt->fetchColumn();

    if ($count > 0){
      $errorMessage = 'その名前は既に登録されています。';
    } else {
      $sql = "INSERT INTO account (user_id, name, password, mailadr, pr) VALUES (:user_id, :name, :password, :mailadr, 1)";
      $result = $pdo->prepare($sql);
      $result->bindParam(':user_id', $user_id, PDO::PARAM_STR);
      $result->bindParam(':name', $name, PDO::PARAM_STR);
      $result->bindParam(':password', $password, PDO::PARAM_STR);
      $result->bindParam(':mailadr', $mailadr, PDO::PARAM_STR);
      $result->execute();
      $to = $mailadr;
      $subject = "仮登録が完了しました。";
      $message = $name."様へ、"
                 ."仮登録が完了しました。以下のURLからメール認証を行ってください。"
                 ."http://co-994.it.99sv-coco.com/confirm.php?user_id=$user_id"
                 ."\n※このメールが心当たりがない場合、当メールを破棄ください。";
      $headers = "From: gahara.summers@gmail.com";
      mail($to, $subject, $message, $headers);

      $signUpMessage = $mailadr."宛に確認メールを送信しました。\n確認をしてください。";
    }
  } else if(!empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] != $_POST["password2"]) {
    $errorMessage = 'パスワードに誤りがあります。';
  }
}

?>
<!DOCTYPE html>
<html lang = "ja">
<head>
	<meta charset="UTF-8">
	<title>仮登録</title>
</head>
<body>
<h1>大喜利掲示板</h1>

<div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
<div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
<a href="http://co-994.it.99sv-coco.com/SignUp.php">戻る</a><br/>

</body>
</html>