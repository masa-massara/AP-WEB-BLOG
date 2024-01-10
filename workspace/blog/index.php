<html>

<head>
   <meta charset="utf-8">
   <title>○○のブログサイト</title>
</head>

<body>
   <h1>○○のブログ</h1>
   <button><a href="http://localhost:8080/blog/post.php">作成</a></button>

   <hr />

   <?php
   try {
      $dbh = new PDO('sqlite:blog.db', '', '');   //PDOクラスのオブジェクトの作成
      $sth = $dbh->prepare("select * from posts order by date");   //prepareメソッドでSQL文の準備
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
