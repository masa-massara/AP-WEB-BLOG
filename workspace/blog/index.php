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
      
         //prepareメソッドでSQL文の準備
         if (isset($_POST['desc']) == true) {
            $sth = $dbh->prepare("select * from posts order by date asc");
         } else {
            $sth = $dbh->prepare("select * from posts order by date desc");
         }


         $sth->execute();   //準備したSQL文の実行
      
         while ($row = $sth->fetch()) {
            //テーブルの内容を１行ずつ処理
            $time = preg_split("/[\s.:-]+/", $row['date']);
            ?>

            <div class="buttons">
               <p class="post-title">
                  <?php echo $row['title'] ?>
               </p>
               <div class="edit-button">
                  <form action="edit.php" method="post">
                     <button class="bn30" type="submit">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button>
                     <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
                  </form>
               </div>

               <div class="delete-button">
                  <form action="delete.php" method="post">
                     <button class="bn30" type="submit">Delete</button>
                     <input type="password" name="password" size="20" placeholder="パスワードを入力" required />
                     <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
                  </form>
               </div>


            </div>

            <div class="message-box">
               <p>
                  <?php echo $row['contents'] ?><br>
               </p>
               <div class="timestamp">
                  <p>
                     <?php echo $time[0] . "年" . $time[1] . "月" . $time[2] . "日 " . $time[3] . ":" . $time[4] ?>
                  </p>
               </div>
            </div>

            <?php
            // コメントの表示
            $comment_sql = 'SELECT * FROM comments WHERE pid = ? ORDER BY date asc';
            $comment_sth = $dbh->prepare($comment_sql);
            $comment_sth->execute(array($row['id']));
            while ($comment = $comment_sth->fetch()) {
               echo '<div class="comment-box">';
               echo '<p>' . htmlspecialchars($comment['contents']) . '</p>';
               $comment_date = preg_split("/[\s.:-]+/", $comment['date']);
               echo '<div class="timestamp"><p>' .
                  htmlspecialchars($comment_date[0]) . "年" .
                  htmlspecialchars($comment_date[1]) . "月" .
                  htmlspecialchars($comment_date[2]) . "日 " .
                  htmlspecialchars($comment_date[3]) . ":" .
                  htmlspecialchars($comment_date[4]) .
                  '</p></div>';
               echo '</div>';
            }
            ?>


            <div>
               <form action="comment.php" method="post" class="reply-button">
                  <button class="bn30" type="submit">Reply&nbsp;</button>
                  <textarea name="contents" cols="30" rows="1" required></textarea>
                  <input type="hidden" name="pid" value="<?php echo $row['id'] ?>" />
               </form>
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
