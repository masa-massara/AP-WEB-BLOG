<?php
if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

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
        try {

            ini_set("date.timezone", "Asia/Tokyo");
            //$timeへ成形した年月日および時刻データを格納
            $time = date("Y.m.d-H:i");
            //PDOクラスのオブジェクトの作成（blog.dbに接続）
            $dbh = new PDO('sqlite:blog.db', '', '');
            //実行するSQL文を$sqlに格納
            $sql = 'insert into posts (title,contents,date) values (?, ?, ?)';
            //prepareメソッドでSQL文の準備
            $sth = $dbh->prepare($sql);
            //prepareした$sthを実行SQL文の？部に格納する変数を指定
            $sth->execute(array($_POST["title"], $_POST["contents"], $time));

            $_POST['title'] = null;
            $_POST["contents"] = null;
            $_POST["password"] = null;

            // 投稿が成功したらリダイレクト
            header('Location: ./successPost.php');
            exit();


        } catch (PDOException $e) {

        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿画面</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">


        <dl>
            <dt>表題：</dt>
            <dd><input type="text" name="title" size="60" value="<?php echo $title_value; ?>" /></dd>
            <dt>本文：</dt>
            <dd>
                <textarea name=" contents" rows="10" cols="60"><?php echo $contents_value; ?></textarea>
            </dd>
            <dt>パスワード：</dt>
            <dd>
                <input type="password" name="password">
            </dd>
        </dl><input type="reset" value="リセット" />
        <input type="submit" value="送信" name="submit" />

    </form>

</body>

</html>
