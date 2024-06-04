<?php
require_once(dirname(__FILE__)."/../MakeSession.php");
$session = new MakeSession(null);
session_destroy();
header("Location: ../show_event/show_event.php"); // ホームページへ遷移
?>