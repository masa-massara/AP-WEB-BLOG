<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>由川聖弥のブログサイト</title>
   <link rel="stylesheet" href="./css/button.css">
   <link rel="stylesheet" href="./css/header.css">
   <link rel="stylesheet" href="./css/index.css">
</head>

<body>
   <header>
      <h1>応プロ(WEB)・最終レポート</h1>
   </header>

   <form action="post.php" method="post">
      <button class="bn30" type="submit">Create</button>
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

            <button class="bn30" type="submit">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button>
            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">


         </form>
         <p>
         <form action="delete.php" method="post">
            <button class="bn30" type="submit">Delete</button>
            パスワード：<input type="password" name="password" size="20" />
            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
         </form>
         <p>
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
