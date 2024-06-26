<?php
try {

  //PDOクラスのオブジェクトの作成
  $dbh = new PDO('sqlite:blog.db', '', '');

  if (isset($_POST["id"]) && !isset($_POST["title"]) && !isset($_POST["contents"])) {

    //実行するSQL文を$sqlに格納
    //index.phpから転送されたidを元に対象記事を抽出する
    $sql = 'select * from posts where id=?';
    //prepareメソッドでSQL文の準備
    $sth = $dbh->prepare($sql);
    //prepareした$sthを実行　SQL文の？部に格納する変数を指定
    $sth->execute(array($_POST["id"]));

    if ($row = $sth->fetch()) {
      $_POST["title"] = $row['title'];
      $_POST["contents"] = $row['contents'];
    }

  } elseif (isset($_POST["id"]) && isset($_POST["title"]) && isset($_POST["contents"])) {
    if (empty($_POST["title"]) || empty($_POST["contents"])) {
      $title_value = $_POST['title'];
      $contents_value = $_POST['contents'];
      $test_alert = "<script type='text/javascript'>alert('タイトルと本文は必須です。');</script>";
      echo $test_alert;
    } elseif (!isset($_POST["password"]) || $_POST["password"] != 'correctPass') {
      $title_value = $_POST['title'];
      $contents_value = $_POST['contents'];
      $test_alert = "<script type='text/javascript'>alert('パスワードが違います。');</script>";
      echo $test_alert;
    } else {

      //実行するSQL文を$sqlに格納
      $sql = 'update posts set title=?, contents=? where id=?';
      //prepareメソッドでSQL文の準備
      $sth = $dbh->prepare($sql);
      //prepareした$sthを実行　SQL文の？部に格納する変数を指定
      $sth->execute(array($_POST["title"], $_POST["contents"], $_POST["id"]));

      if ($sth) {
        // 編集が成功したらリダイレクト
        header('Location: ./messages/successEdit.php');
        exit();
      } else {
        // 編集が失敗したらリダイレクト
        header('Location: ./messages/failedEdit.php');
        exit();
      }

    }
  }

  $dbh = null;

} catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/>";
  die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>ブログ記事の編集</title>
  <link rel="stylesheet" href="./css/button.css">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/index.css">
  <link rel="stylesheet" href="./css/post.css">

</head>

<body>
  <div class="container">
  <header>
    <h1>応プロ(WEB)・最終レポート</h1>
  </header>
    <p><a href="index.php">blog閲覧ページはこちら</a></p>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <dl>
        <dt>表題：</dt>
        <dd><input type="text" name="title" value="<?php echo $_POST["title"] ?>" size="60" /></dd>
        <dt>本文：</dt>
        <dd><textarea name="contents" rows="10" cols="60"><?php echo $_POST["contents"] ?></textarea></dd>
        <dt>パスワード：</dt>
        <dd><input type="password" name="password" size="20" /></dd>
      </dl>
      <input type="hidden" name="id" value="<?php echo $_POST["id"] ?>" />
      <button class="bn30" type="reset">&nbsp;Reset&nbsp;</button>
      <button class="bn30" type="submit" name="submit">Submit</button>
    </form>
  </div>
</body>

</html>
