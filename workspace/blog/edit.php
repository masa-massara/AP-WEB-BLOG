<html>
  <head>
    <meta charset="utf-8">
    <title>ブログ記事の編集</title>
  </head>
  <body>
    <h1>ブログ記事の編集</h1>
    <?php
	  try {

  	     //PDOクラスのオブジェクトの作成
           $dbh = new PDO('sqlite:blog.db','','');
         
         if (isset($_POST["id"]) && !isset($_POST["title"]) && !isset($_POST["contents"])) {
	   
             //実行するSQL文を$sqlに格納
             //index.phpから転送されたidを元に対象記事を抽出する
           $sql='xxxxxxxxxxxxxxxxxxxxxxxxxxxx';
             //prepareメソッドでSQL文の準備
           $sth = $dbh->prepare($sql);
             //prepareした$sthを実行　SQL文の？部に格納する変数を指定
           $sth->execute(array(xxxxxxxxxxx));

           if ($row = $sth->fetch()) {       
               $_POST["title"] = $row['title'];
               $_POST["contents"] = $row['contents'];
           }

         } elseif (isset($_POST["id"]) && isset($_POST["title"]) && isset($_POST["contents"])) {
           if (!isset($_POST["password"]) || $_POST["password"] != 'abcdef') {
             echo '<p>パスワードが違います</p>';
           }
           else {
         
               //実行するSQL文を$sqlに格納
             $sql='xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
               //prepareメソッドでSQL文の準備
             $sth = $dbh->prepare($sql);
               //prepareした$sthを実行　SQL文の？部に格納する変数を指定
             $sth->execute(array(xxxxxxxxx, xxxxxxxxxx, xxxxxxxxxx));

	     if ($sth) {
	       echo "記事１件を更新しました";
	     } else {
	       echo "記事１件の更新に失敗しました";
	     }

           }
         }
       
         $dbh = null;
       
	} Catch (PDOException $e) {
	  print "エラー!: " . $e->getMessage() . "<br/>";
	  die();
	}

   ?>
       
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
      <input type="reset" value="リセット" />
      <input type="submit" value="送信" />
    </form>
  </body>
</html>
