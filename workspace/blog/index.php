<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>由川聖弥のブログサイト</title>
   <link rel="stylesheet" href="./css/button.css">
   <link rel="stylesheet" href="./css/header.css">
   <link rel="stylesheet" href="./css/index.css">
   <link rel="stylesheet" href="./css/post.css">
</head>

<body>
   <header>
      <h1>応プロ(WEB)・最終レポート</h1>
   </header>

   <div class="container">
      <div class="buttons">
         <form action="post.php" method="post">
            <button class="bn30" type="submit">Create</button>
         </form>
         <form action="index.php" method="post" class="order-button">
            <button class="bn30" type="submit" name="asc">新しい順</button>
            <button class="bn30" type="submit" name="desc">&nbsp;&nbsp;古い順&nbsp;&nbsp;</button>
         </form>
      </div>

      <hr />

      <?php
      try {
         $dbh = new PDO('sqlite:blog.db', '', '');   //PDOクラスのオブジェクトの作成
      
         if (isset($_POST['desc']) == true) {
            $sth = $dbh->prepare("select * from posts order by date desc");
         } elseif (isset($_POST['asc']) == true) {
            $sth = $dbh->prepare("select * from posts order by date asc");
         }
         //prepareメソッドでSQL文の準備
      
         $sth->execute();   //準備したSQL文の実行
      
         while ($row = $sth->fetch()) {
            //テーブルの内容を１行ずつ処理
            $time = preg_split("/[\s.:-]+/", $row['date']);
            ?>
            <h3>
               <?php echo $row['title'] ?>
            </h3>

            <div class="message-box">
               <p>
                  <?php echo $row['contents'] ?><br>
               <p>
            </div>

            <div class="buttons">
               <div class="edit-button">
                  <form action="edit.php" method="post">
                     <button class="bn30" type="submit">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button>
                     <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                  </form>
               </div>

               <div class="delete-button">
                  <form action="delete.php" method="post">
                     <button class="bn30" type="submit">Delete</button>
                     <input type="password" name="password" size="20" placeholder="パスワードを入力" required />
                     <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                  </form>
               </div>
            </div>

            <div class="timestamp">
               <p>
                  <?php echo $time[0] . "年" . $time[1] . "月" . $time[2] . "日 " . $time[3] . ":" . $time[4] ?>
               </p>
            </div>
            <hr />
            <?php
         }
      } catch (PDOException $e) {
         print "エラー!: " . $e->getMessage() . "<br/>";
         die();
      }

      ?>
   </div>
</body>

</html>
