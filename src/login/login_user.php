<?php
require_once(dirname(__FILE__).'/../GetDB.php');
$dbh = (new GetDB())->getDbh();

// POSTデータを取得
$userId = $_POST["userId"];
$password = $_POST["password"];
//$hashedPassword = password_hash($password, \PASSWORD_BCRYPT);echo($hashedPassword);
try{
    $stmt = $dbh->prepare('SELECT id, password FROM users WHERE userId = :userId');  // 準備
    $stmt->bindvalue(":userId", $userId); // 変数をバインド
    $stmt->execute(); //実行
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($result)) {
        $dbh = null; // db切断
        header("Location: ./loginfailed");  // idがなかったら画面遷移
        exit(); // 処理終了
    } else if (!password_verify($password, $result["password"])) {
        $dbh = null; // db切断
        header("Location: ./loginfailed");  // passが違ったら画面遷移
        exit(); // 処理終了
    } else {    // あってるのでセッション
        require_once(dirname(__FILE__).'/../MakeSession.php');
        new MakeSession($result["id"]);
        $dbh = null; // db切断
        $url = isset($_GET["original_url"])? $_GET["original_url"]: "/show_event/show_event";
        header("Location: {$url}"); //ホームページ
        exit();
    }
}catch (PDOException $e){
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    print('Error:'.$e->getMessage());
    die();
}
?>