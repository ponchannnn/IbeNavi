<?php
if(!property_exists('IsloggedIn', 'logged_flag')) {
    require_once(dirname(__FILE__).'/../IsLoggedIn.php');
    $logged = new IsLoggedIn();
}
$is_logged_in = $logged->is_logged_in();
?>
<link rel="stylesheet" href="/header/header.css">
<div class="header">
        <a href="/show_event/show_event"><img src="/header/blob.png" alt="Logo"></a>
        <div class="nav">
            <?php
            if ($is_logged_in){ // ログイン中
                if ($logged->isOrganizer()) {
                    echo <<< EOF
                    <a href="/../show_event/my_event">マイイベント</a>
                    <a href="/../event_form/form">フォーム作成</a>
                    EOF;
                }
            }
            ?>
        </div>
        <div class="search-container">
            <form action="" method="GET">
                <input type="text" placeholder="キーワードを入力">
                <input type="submit" value="検索">
                <?php
                if ($is_logged_in){ // ログイン中
                    echo <<< EOF
                    <a href='/logout/logout'>ログアウト</a>
                    EOF;
                } else {    // ログアウト中
                    echo <<< EOF
                    <a href='/login/login'>ログイン</a>
                    EOF;
                }
                ?>
            </form>
        </div>
    </div>