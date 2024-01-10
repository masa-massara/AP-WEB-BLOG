<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];
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
    ?>" method="post">
        <dl>
            <dt>表題：</dt>
            <dd><input type="text" name="title" size="60" /></dd>
            <dt>本文：</dt>
            <dd>
                <textarea name="contents" rows="10" cols="60"></textarea>
            </dd>
        </dl><input type="reset" value="リセット" />
        <input type="submit" value="送信" />

    </form>

</body>


</html>
