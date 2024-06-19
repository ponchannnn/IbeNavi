<?php
require_once(dirname(__FILE__).'/GetDB.php');
class IsLoggedIn extends GetDB {
    private $dbh;
    private $uuid;
    private $original_url;
    private $logged_flag = false;
    private $logged;
    private $roleid;

    function __construct () {
        parent::__construct();
        $this->dbh = parent::getDbh();
        if (isset($_SERVER["REQUEST_URI"])) $this->original_url = $_SERVER["REQUEST_URI"];
    }

    function getDbh () {
        return $this->dbh;
    }

    function getUuid () {
        $this->check_logged_in();
        return $this->uuid;
    }

    function getUserId () {
        $this->check_logged_in();
        return parent::getUserIdFromUuid($this->getUuid());
    }

    function isParticipant() {
        if (!isset($this->roleid)) $this->roleid = parent::getRoleId($this->getUuid());
        return $this->roleid == 1;
    }

    function isOrganizer() {
        if (!isset($this->roleid)) $this->roleid = parent::getRoleId($this->getUuid());
        return $this->roleid == 2;
    }

    function isAdmin() {
        if (!isset($this->roleid)) $this->roleid = parent::getRoleId($this->getUuid());
        return $this->roleid == 3;
    }

    function setOriginalUrl ($original_url) {
        $this->original_url = $original_url;
        return $this;
    }

    function check_logged_in () {
        if ($this->logged_flag) return;
        if (!isset($_COOKIE["PHPSESSID"])) {
            $this->logged = false;
            return header("Location: /../../login/login");
        }
        $this->logged_flag = true;
        $stmt = $this->dbh->prepare("SELECT id FROM sessions WHERE sessionid = :sessionid");
        if ($stmt) {
            $sid = $_COOKIE["PHPSESSID"];    // 参照渡しエラーのため
            $stmt->bindParam(":sessionid", $sid);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $this->uuid = $row["id"];
                $this->logged = true;
            }
            else {
                $this->logged = false;
                if (isset($this->original_url)) {
                    if ($this->original_url != "/account_info/others/delete_account?accept=削除") {
                        header("Location: /../../login/login?original_url={$this->original_url}");
                        exit();
                    } else header("Location: /../../login/login");
                } else header("Location: /../../login/login");
            }
        }
    }

    function is_logged_in () {
        if ($this->logged_flag) return $this->logged;
        if (!isset($_COOKIE["PHPSESSID"])) {
            $this->logged = false;
            return false;
        }
        $this->logged_flag = true;
        $stmt = $this->dbh->prepare("SELECT id FROM sessions WHERE sessionid = :sessionid");
        if ($stmt) {
            $sid = $_COOKIE["PHPSESSID"];    // 参照渡しエラーのため
            $stmt->bindParam(":sessionid", $sid);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $this->uuid = $row["id"];
                $this->logged = true;
                return true;
            }
            else {
                $this->logged = false;
                return false;
            }
        }
    }
}

?>