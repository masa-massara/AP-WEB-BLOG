<?php
try {
    // PDOクラスのオブジェクトの作成（データベースに接続）
    $dbh = new PDO('sqlite:blog.db', '', '');

    // フォームから送信された値に対する処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 入力値の検証
        if (!isset($_POST["pid"]) || !isset($_POST["contents"])) {
            // エラーメッセージを表示するか、適切な処理を行う
            echo "投稿IDとコメント内容は必須です。";
        } else {
            // 現在時刻の取得（コメント投稿時刻）
            ini_set("date.timezone", "Asia/Tokyo");
            $time = date("Y.m.d-H:i");

            // comments表に対する書き込み（SQL文の実行）
            $sql = 'INSERT INTO comments (pid, contents, date) VALUES (?, ?, ?)';
            $sthMessage = $dbh->prepare($sql);
            $sthMessage->execute(array($_POST["pid"], $_POST["contents"], $time));

            header('Location: ./messages/successComment.php');
            exit();
        }
    }
} catch (PDOException $e) {
    // エラー処理
    echo "データベースエラー: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>コメント投稿ページ</title>
</head>

<body>

</body>

</html>
