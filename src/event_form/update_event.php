<?php
if (empty($_GET["eventid"])) {
    header("Location: input_event");
    exit();
}
$get_eventid = $_GET["eventid"];
require_once(dirname(__FILE__)."/../IsLoggedIn.php");
$logged = new IsLoggedIn();
$logged->setOriginalUrl("/show_event/my_event");
$dbh = $logged->getDbh();
$uuid = $logged->getUuid();
$stmt = $dbh->prepare("SELECT * FROM events WHERE eventid = :eventid");
if($stmt) {
    $stmt->bindParam(":eventid", $get_eventid);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
if (!$row) {
    header("Location: input_event");
    exit();
} else if ($row["accountid"] != $uuid) {
    header("Location: not_your_event");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>イベント編集フォーム</title>
    <style type="text/css">
        #event-image-preview img {
        width: 800px;
        margin: 10px;
        border: solid 1px silver;
        }
    </style>
</head>
<body>
    <h1>イベント編集フォーム</h1>
    <h2>変更箇所のみ書き加えて下さい</h2>
    <form action="./submit_event" method="post">
        <input type="hidden" name="eventid" value="<?php echo $post_eventid ?>" />
        <div>
            <label for="eventname">イベント名</label>
            <input type="text" id="eventname" name="eventname" value="<?php echo $row["eventname"] ?>" required>
        </div>
        <div>
            <label for="runtime">実施日時</label>
            <input type="datetime-local" id="runtime" name="runtime" value="<?php echo $row["runtime"] ?>" required>
        </div>
        <div>
            <label for="location">実施場所</label>
            <input type="text" id="location" name="location" value="<?php echo $row["location"] ?>" required>
        </div>
        <div>
            <label for="category">カテゴリー</label>
            <select id="category" name="category" value="<?php echo $row["category"] ?>" required>
                <option value="">選択してください</option>
                <option value="スポーツ">スポーツ</option>
                <option value="ショッピング">ショッピング</option>
                <option value="祭事">祭事</option>
            </select>
        </div>
        <div>
            <label for="tags">タグ</label>
            <input type="text" id="tags" name="tags" value="<?php echo $row["tags"] ?>" placeholder="例: フェスティバル, 音楽, 屋外">
        </div>
        <div>
            <label for="description">概要</label>
            <textarea id="description" name="description" rows="5"\ required><?php echo $row["description"] ?></textarea>
        </div>
        <div>
            <label for="image">画像</label>
            <input type="file" id="image" name="image" accept="image/jpeg, image/png">
            <div id="event-image-preview"></div>
        </div>
        <div>
            <label for="email">メールアドレス</label>
            <input type="text" id="email" name="email" value="<?php echo $row["email"] ?>" placeholder="asdfa@asdfa">
        </div>
        <div>
            <label for="phonenumber">電話番号</label>
            <input type="text" id="phonenumber" name="phonenumber" value="<?php echo $row["phonenumber"] ?>" placeholder="080xxxxxxx">
        </div>
        <div>
            <button type="submit">送信</button>
        </div>
        <script>
            function previewFile(file) {
                // プレビュー画像を追加する要素
                const preview = document.getElementById('event-image-preview');

                // FileReaderオブジェクトを作成
                const reader = new FileReader();

                // URLとして読み込まれたときに実行する処理
                reader.onload = function (e) {
                    const imageUrl = e.target.result; 
                    const img = document.createElement("img"); // img要素を作成
                    img.src = imageUrl; // URLをimg要素にセット
                    preview.appendChild(img); // #previewの中に追加
                }

                // ファイルをURLとして読み込む
                reader.readAsDataURL(file);
            }
            // <input>でファイルが選択されたときの処理
            const fileInput = document.getElementById('event-image');
            const handleFileSelect = () => {
            previewFile(fileInput.files[0]);
            }
            fileInput.addEventListener('change', handleFileSelect);
        </script>
    </form>
</body>
</html>
