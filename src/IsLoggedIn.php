<?php
require_once(dirname(__FILE__).'/GetDB.php');
class IsLoggedIn extends GetDB {
    private $dbh;
    private $uuid;
    private $original_url;
    private $logged_flag = false;

    function __construct () {
        parent::__construct();
        if (isset($_SERVER["REQUEST_URI"])) $this->original_url = $_SERVER["REQUEST_URI"];
    }

    function getDbh () {
        if (!$this->logged_flag) $this->check_logged_in();
        return $this->dbh;
    }

    function getUuid () {
        if (!$this->logged_flag) $this->check_logged_in();
        return $this->uuid;
    }

    function setOriginalUrl ($original_url) {
        $this->original_url = $original_url;
        return $this;
    }

    function check_logged_in () {
        $this->logged_flag = true;
        $uuid;
        $this->dbh = parent::getDbh();
        $stmt = $this->dbh->prepare("SELECT id FROM sessions WHERE sessionid = :sessionid");
        if ($stmt) {
            $sid = $_COOKIE["PHPSESSID"];    // 参照渡しエラーのため
            $stmt->bindParam(":sessionid", $sid);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) $this->uuid = $row["id"];
            else {
                if (isset($this->original_url)) {
                    header("Location: /../../login/login?original_url={$this->original_url}");
                    exit();
                } else header("Location: /../../login/login");
            }
        }
    }
}

?>