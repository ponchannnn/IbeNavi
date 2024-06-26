<?php
require_once(dirname(__FILE__).'/../IsLoggedIn.php');
$logged = new IsloggedIn();
$dbh = $logged->getDbh();
$uuid = $logged->getUuid();
if (!$logged->isOrganizer()) {
    echo $_COOKIE["PHPSESSID"];
    exit();
};
$accountid = $logged->getUserIdFromUuid($uuid);
$event_num = 0;
// キーワード検索
if(!isset($_GET["q"])) {
    $stmt = $dbh->prepare("SELECT eventid, eventname, category, runtime, location FROM events WHERE accountid = :uuid ORDER BY created_at DESC, eventid ASC LIMIT 5 OFFSET 0");
    if($stmt) {
        $stmt->bindParam(":uuid", $uuid);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} else {
    $q = $_GET["q"];
    $sql = "SELECT eventid, eventname, category, runtime, location FROM events WHERE accountid = :uuid AND eventname LIKE '%{$q}%' ORDER BY created_at DESC, eventid ASC LIMIT 5 OFFSET 0";
    $stmt = $dbh->prepare($sql);
    if($stmt) {
        $stmt->bindParam(":uuid", $uuid);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>イベント検索</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <?php include("../header/header.php"); ?>
    <div class="container">
        <div class="title-container">
            <h1>マイイベント</h1>
        </div>
        <div class="search-container">
            <form method="GET">
                <input type="text" name="q" placeholder="キーワードを入力" value= <?php if(!empty($q)) echo $q; ?>>
                <input type="submit" value="検索">
            </form>
            <div class="sort-container">
                <label for="sort">ソート：</label>
                <select name="sort" id="sort">
                    <option value="run_date">開催日時</option>
                    <option value="created_date">作成日時</option>
                    <!-- 他のソートオプションを追加 -->
                </select>
            </div>
        </div>
        <div class="event-container">
            <!-- 無限スクロールで読み込む -->
            <!-- jQuery読み込み -->
            <script>const q = "<?php if(!empty($_GET["q"])) echo $_GET["q"]; else echo "null"; ?>";</script>
            <script type="text/javascript">accountId = "<?php echo $accountid; ?>"</script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script type="text/javascript" src="infScroll.js"></script>
            <script type="text/javascript" src="toggleEventHidden.js"></script>
            <div id="infinite-content"></div>
                <!-- 追加ここまで -->
            <input type="hidden" id="count" value=<?php echo $event_num ?>>
            <div id ="loading"></div>
        </div>
    </div>
</body>
</html>