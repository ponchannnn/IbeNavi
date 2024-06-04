<?php
class MakeSession {
    function __construct($uuid){
        require_once(dirname(__FILE__).'/./MySessionHandler.php');
        $session_handler = new MySessionHandler($uuid);
        session_set_save_handler($session_handler, true);

        // セッションを開始する
        session_start([
        'cookie_secure' => true,
        'cookie_httponly' => true,
        'cookie_samesite' => 'lax',   // 同じサイトダメ
        'cookie_lifetime' => 1440, // これで一時間セッションが継続される
        ]);
        echo session_id();
    }
    
}
?>