<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <form action="<?php
    echo $_SERVER['PHP_SELF'];


    ?>" method="post">
        <dl>
            <dt>表題：</dt>
            <dd><input type="text" name="title" size="60" /></dd>
            <dt>本文：</dt>
            <dd>
                <textarea name="contents" rows="10" cols="60"></textarea>
            </dd>
            <dt>パスワード：</dt>
            <dd>
                <input type="password" name="password">
            </dd>
        </dl><input type="reset" value="リセット" />
        <input type="submit" value="送信" name="submit" />



    </form>

    <!-- タイトルと本文があったら入る -->
    <?php
    // タイトルと本文の入力をチェック
    if (empty($_POST["title"]) || empty($_POST["contents"])) {
        echo "<h3>タイトルと本文は必須です。</h3>";
    } elseif (!isset($_POST["password"]) || $_POST["password"] != 'correctPass') {
        echo "<h3>パスワードが違います。</h3>";
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

        } catch (PDOException $e) {

        }
    }
    ?>
</body>


</html>
