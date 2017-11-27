<!DOCTYPE html>
<html lang = "ja">
<head>
	<meta charset="UTF-8">
	<title>新規登録</title>
</head>
<body>
  <h1>大喜利掲示板</h1>
  <h2>新規登録画面</h2>
    <form id="new" name="new" action="http://co-994.it.99sv-coco.com/PR.php" method="POST">
      <fieldset>
        <legend>ログインフォーム</legend>
          <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
          <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
          <label for="name">名前：</label><input type="text" id="name" name="name" placeholder="名前を入力" value="<?php if (!empty($_POST["name"])) {echo htmlspecialchars($_POST["name"], ENT_QUOTES);} ?>">
          <br>
          <label for="password">パスワード：</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
          <br>
          <label for="password2">パスワード(確認用)：</label><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
          <br>
          <label for="mailadr">メールアドレス:<input type="text" name="mailadr"><br>
          <button type="submit" name="new" value="new">仮登録</bottun>
        </fieldset>
    </form>
    <br>
    <a href="http://co-994.it.99sv-coco.com/login.php">戻る</a>
  </body>
</html>

  