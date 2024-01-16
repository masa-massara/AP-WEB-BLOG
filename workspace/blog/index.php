<html>

<head>
   <meta charset="utf-8">
   <title>由川聖弥のブログサイト</title>
</head>

<body>
   <h1>由川聖弥のブログ</h1>
   <form action="post.php" method="post">
      <p>
         <input type="submit" value="作成">
      </p>
   </form>

   <hr />

   <?php
   try {
      $dbh = new PDO('sqlite:blog.db', '', '');   //PDOクラスのオブジェクトの作成
      $sth = $dbh->prepare("select * from posts order by date desc");   //prepareメソッドでSQL文の準備
      $sth->execute();   //準備したSQL文の実行
   
      while ($row = $sth->fetch()) {
         //テーブルの内容を１行ずつ処理
         $time = preg_split("/[\s.:-]+/", $row['date']);
         ?>
         <h3>
            <?php echo $row['title'] ?>
         </h3>

         <p>
            <?php echo $row['contents'] ?><br>
         <form action="edit.php" method="post">
            <p>
               <input type="submit" value="編集">
               <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
            </p>

         </form>
         <p>
            <input type="submit" value="削除">
            パスワード：<input type="password" name="password" size="20" />
            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
         </p>
         (
         <?php echo $time[0] . "年" . $time[1] . "月" . $time[2] . "日 " . $time[3] . ":" . $time[4] ?>)
         </p>
         <hr />
         <?php
      }
   } catch (PDOException $e) {
      print "エラー!: " . $e->getMessage() . "<br/>";
      die();
   }

   ?>

</body>

</html>
