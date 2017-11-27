<?php

session_start();

$pdo = new PDO('mysql:データベース名', 'ユーザー名', 'パスワード');
$errorMessage = "";
$themeMessage = "";

// 送信ボタンが押された場合
if (isset($_POST["theme"])) {
  //お題の入力チェック
  if (empty($_POST["odai"])) { //値が空のとき
    $errorMessage = 'お題を入力してください。';
  }

  if (!empty($_POST["odai"])) {
    $userid = $_SESSION["USER_ID"];
    $odai = $_POST["odai"];
    
    $sql = "INSERT INTO theme (odai, account_id, odai_time) VALUES (:odai, :account_id, now());";
    $result = $pdo->prepare($sql);
    $result->bindParam(':odai', $odai, PDO::PARAM_STR);
    $result->bindVALUE(':account_id', $userid, PDO::PARAM_INT);
    $result->execute();  

    $themeMessage = "大喜利お題が作成されました。";
  }
}

//画像・動画用のアップロードボタンが押されたとき

//ファイルアップロードがあったとき
  //エラーチェック
if(isset($_POST['media'])){
  if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== ""){
    switch ($_FILES['upfile']['error']) {
      case UPLOAD_ERR_OK: // OK
        break;
      case UPLOAD_ERR_NO_FILE:   // 未選択
        throw new RuntimeException('ファイルが選択されていません', 400);
      case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
        throw new RuntimeException('ファイルサイズが大きすぎます', 400);
      default:
        throw new RuntimeException('その他のエラーが発生しました', 500);
    }

    //画像・動画をバイナリデータにする．
    $file_name = $_FILES["upfile"]["name"];
    $file = $_FILES["upfile"]["tmp_name"];

    move_uploaded_file($_FILES["upfile"]["tmp_name"],"$file_name");
    $raw_data = "./$file_name";

    //拡張子を見る
    $tmp = pathinfo($_FILES["upfile"]["name"]);
    $extension = $tmp["extension"];
    if($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG"){
      $extension = "jpeg";
    }
    elseif($extension === "png" || $extension === "PNG"){
      $extension = "png";
    }
      elseif($extension === "gif" || $extension === "GIF"){
    $extension = "gif";
    }
      elseif($extension === "mp4" || $extension === "MP4"){
    $extension = "mp4";
    }
    else{
      echo "非対応ファイルです．<br/>";
      echo ("<a href=\"main.php\">戻る</a><br/>");
      exit(1);
    }

    //DBに格納するファイルネーム設定
    //サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
    $date = getdate();
    $fname = $_FILES["upfile"]["tmp_name"].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];
    $fname = hash("sha256", $fname);
    
    $user_id = $_SESSION["USER_ID"];
    $odai = $_POST["odai"];

    //画像・動画をDBに格納．
    $sql = "INSERT INTO media (fname, odai, extension, raw_data, account_id, media_time) VALUES (:fname, :odai, :extension, :raw_data, :account_id, now());";     
    $stmt = $pdo->prepare($sql);     
    $stmt -> bindValue(":fname",$fname, PDO::PARAM_STR);
    $stmt -> bindValue(":odai",$odai, PDO::PARAM_STR);
    $stmt -> bindValue(":extension",$extension, PDO::PARAM_STR);
    $stmt -> bindValue(":raw_data",$raw_data, PDO::PARAM_STR);
    $stmt -> bindValue(":account_id",$user_id, PDO::PARAM_STR);
    $stmt -> execute();

  }

}
?>

<!DOCTYPE html>
<html lang = "ja">
<head>
	<meta charset="UTF-8">
	<title>大喜利掲示板</title>
</head>
<body>
  <h1>大喜利掲示板</h1>
  大喜利の出題ページです。<br>
  <?php if (!isset($_SESSION["NAME"])) : ?>
    お題の作成・回答をするにはログインが必要です。
    <a href="http://co-994.it.99sv-coco.com/login.php">ログイン</a>
  <?php else : ?>
    <p>ようこそ<u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u>さん</p>  <!-- ユーザー名をechoで表示 -->
      <ul>
        <li><a href="logout.php">ログアウト</a></li>
      </ul>
    <form name="theme" action="" method="POST">
      <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
      <div><font color="#0000ff"><?php echo htmlspecialchars($themeMessage, ENT_QUOTES); ?></font></div>
      文章題の大喜利お題の場合はこちらに入力してください。<br>
      大喜利のお題：<br><textarea name="odai" rows="4" cols="40" placeholder="大喜利お題を入力してください。"></textarea><br>
    <button type="submit" name="theme">送信</button>
    </form>
    <br>
    画像・映像大喜利のお題の場合はこちらで送信してください。
    <form action="" enctype="multipart/form-data" method="post">
    <label>画像/動画アップロード</label>
       <input type="file" name="upfile">
        <br>画像・映像お題の説明：<input type="text" name="odai" placeholder="お題を入力" value="">
        <br>
        ※画像はjpeg方式、png方式、gif方式に対応しています。動画はmp4方式のみ対応しています。<br>
    <button type="submit" name="media">送信</button>
    </form>
  <?php endif ; ?>
  <a href="http://co-994.it.99sv-coco.com/main.php">戻る</a><br/>

</body>
</html>