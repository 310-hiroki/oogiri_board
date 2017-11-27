<?php

$pdo = new PDO('mysql:データベース名', 'ユーザー名', 'パスワード');
session_start();

$errorMessage ="";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
  // idの入力チェック
  if (empty($_POST["user_id"])) {  // emptyは値が空のとき
    $errorMessage = 'idが未入力です。';
  } else if (empty($_POST["password"])) {
    $errorMessage = 'パスワードが未入力です。';
  }
  
  if (!empty($_POST["user_id"]) && !empty($_POST["password"])) {
    // 入力したユーザIDを格納
    $user_id = $_POST["user_id"];
    $sql = "SELECT * FROM account WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
    $stmt->execute();

    $password = $_POST["password"];

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      if ($row["pr"] == 0) {
        if ($password == $row['password']) {
          session_regenerate_id(true);
          $name = $row['name'];
          $id = $row['id'];
          echo $user_id;
          echo $name;

          $_SESSION["NAME"] = $name;
          $_SESSION["USER_ID"] = $id;
          header('Location: http://co-994.it.99sv-coco.com/main.php', true, 303);  // 最初の画面へ遷移
          exit();  // 処理終了
        } else {
        // 認証失敗
          $errorMessage = '名前あるいはパスワードに誤りがあります。';
          echo "AAA";
          echo $user_id;
        }
      } else {
        $errorMessage = "このアカウントはメール認証されていません。";
      }
    } else {
      // 4. 認証成功なら、セッションIDを新規に発行する
      // 該当データなし
      $errorMessage = '名前あるいはパスワードに誤りがあります。';
    }
  }
}

?>

<!DOCTYPE html>
<html lang = "ja">
<head>
	<meta charset="UTF-8">
	<title>ログイン</title>
</head>
<body>
  <h1>大喜利掲示板</h1>
  <h2>ログイン画面</h2>
    <form name="loginForm" action="" method="POST">
      <fieldset>
        <legend>ログインフォーム</legend>
          <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
          <label>ID：<input type="text" name="user_id" value="" placeholder="IDを入力"></label>
          <br>
          <label>パスワード：<input type="password" name="password" value="" placeholder="パスワードを入力"></label>
          <br>
          <button type="submit" id="login" name="login">ログイン</bottun>
        </fieldset>
    </form>
    <br>
    <a href="http://co-994.it.99sv-coco.com/SignUp.php">新規登録</a>
  </body>
</html>

  