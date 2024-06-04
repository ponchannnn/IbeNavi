<?php
require_once(dirname(__FILE__).'/../GetDB.php');
$uuid;
$dbh = (new GetDB())->getDbh();

// キーワード検索
if(!isset($_GET["q"])) {
    $stmt = $dbh->prepare("SELECT eventid, eventname, category, runtime, location FROM events ORDER BY created_at DESC, eventid ASC LIMIT 5 OFFSET 0");
    if($stmt) {
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} else {
    $q = $_GET["q"];
    $sql = "SELECT eventid, eventname, category, runtime, location FROM events WHERE eventname LIKE '%{$q}%' ORDER BY created_at DESC, eventid ASC LIMIT 5 OFFSET 0";
    $stmt = $dbh->prepare($sql);
    if($stmt) {
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
            <h1><a href="#">イベント検索</a></h1>
        </div>
        <div class="search-container">
            <form method="GET">
                <input type="text" name="q" placeholder="キーワードを入力" value= <?php if(!empty($q)) echo $q; ?>>
                <input type="submit" value="検索">
            </form>
            <div class="sort-container">
                <label for="sort">ソート：</label>
                <select name="sort" id="sort">
                    <option value="date">開催日時</option>
                    <option value="location">場所</option>
                    <!-- 他のソートオプションを追加 -->
                </select>
            </div>
        </div>
        <div class="event-container">
            <?php
            $event_num = 0;
            if (empty($rows)) {
                echo("<h2> イベントがありません </h2>");
                exit();
            }
                foreach($rows as $row) {
                    $event_num += 1;
                    $eventname = $row["eventname"];
                    $category = $row["category"];
                    $datetime = $row["runtime"];
                    $location = $row["location"];
                    $eventid = $row["eventid"];
                    echo <<<EVENT
                    <div class="event-container">
                        <div class="event">
                            <a href="/event_detail/event_prof?eventid={$eventid}"><h2>{$eventname}</h2></a>
                            <p>開催日時: <span id="date-time">{$datetime}</span></p>
                            <p>場所: <span id="location">{$location}</span></p>
                            <p>カテゴリ: <span id="category">{$category}</span></p>
                            <!-- 追加 -->
                            <div class="like-switch">
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="like-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    EVENT;
                }
            ?>
            <!-- 無限スクロールで読み込む -->
            <!-- jQuery読み込み -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script type="text/javascript" src="infScroll.js"></script>
            <div id="infinite-content"></div>
                <!-- 追加ここまで -->
            <input type="hidden" id="count" value=<?php echo $event_num ?>>
            <div id ="loading"></div>
        </div>
    </div>
</body>
</html>