<?php
if(!property_exists('IsloggedIn', 'logged_flag')) {
    require_once(dirname(__FILE__).'/../IsLoggedIn.php');
    $logged = new IsLoggedIn();
}
$is_logged_in = $logged->is_logged_in();
?>
<link rel="stylesheet" href="/header/header.css">
<div class="sHeader">
    <a href="/show_event/show_event"><img src="/header/blob.png" alt="Logo"></a>
    <div class="sNav">
        <?php
        if ($is_logged_in){ // ログイン中
            if ($logged->isOrganizer()) {
                echo <<< EOF
                <a id="sHeader-myevent" href="/../show_event/my_event">マイイベント</a>
                <a id="sHeader-form" href="/../event_form/form">イベント登録</a>
                EOF;
            }
            echo "<a id='sHeader-accountInfo' href='/../account_info/account_info'>アカウント設定</a>";
        }
        ?>
    </div>
    <div class="sHeader-right-container">
        <form action="" method="GET">
            <input type="text" placeholder="キーワードを入力">
            <input type="submit" value="検索">
        </form>
        <?php
        if ($is_logged_in){ // ログイン中
            echo <<< EOF
            <button id="sHeader-logout">ログアウト</button>
            EOF;
        } else {    // ログアウト中
            echo <<< EOF
            <button type="button" id="sHeader-signup">サインアップ</button>
            <button type="button" id="sHeader-login">ログイン</button>
            EOF;
        }
        ?>
        
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/header/header.js"></script>