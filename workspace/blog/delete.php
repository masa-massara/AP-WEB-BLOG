<?php if (isset($_POST["id"])) {
    if (!isset($_POST["password"]) || $_POST["password"] != 'correctPass') {
        // 削除が成功したらリダイレクト
        header('Location: ./messages/failedDelete.php');
        exit();
    } else {
        //PDOクラスのオブジェクトの作成
        $dbh = new PDO('sqlite:blog.db', '', '');
        //実行するSQL文を$sqlに格納
        $sql = 'delete from posts where id=?';
        //prepareメソッドでSQL文の準備
        $sth = $dbh->prepare($sql);
        //prepareした$sthを実行SQL文の？部に格納する変数を指定
        $sth->execute(array($_POST["id"]));

        // 削除が成功したらリダイレクト
        header('Location: ./messages/successDelete.php');
        exit();
    }
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/index.css">

</head>

<body>
    <header>
        <h1>応プロ(WEB)・最終レポート</h1>
    </header>
</body>

</html>
