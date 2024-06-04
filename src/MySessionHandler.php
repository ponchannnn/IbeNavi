<?php
    class MySessionHandler implements SessionHandlerInterface {
        private $dbh;

        private $uuid;
    
        function __construct($uid) {
            require_once(dirname(__FILE__).'/./GetDB.php');
            $this->dbh = (new GetDB())->getDbh();
            if ($uid) $this->uuid = $uid;
        }
    
        public function open($save_path, $name) {
            return true;
        }
    
        public function read($sessionId) {
            $sessionToken = '';
            $stmt = $this->dbh->prepare("SELECT sessionToken FROM sessions WHERE sessionId = :Id");
            if ($stmt) {
                $stmt->bindParam(":Id", $sessionId);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) $sessionToken = $row["sessiontoken"];
            }
            return $sessionToken;
        }
    
        public function write($sessionId, $sessionToken) {
            if(!$this->uuid) {
                $stmt = $this->dbh->prepare("SELECT id FROM sessions WHERE sessionid = :Id");
                if ($stmt) {
                    $stmt->bindParam(":Id", $sessionId);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row) $this->uuid = $row["id"];
                    else header("Location: ../../login/login.html");
                }
            }

            date_default_timezone_set("UTC");
            $createdDate = date('Y-m-d H:i:s');
            $stmt = $this->dbh->prepare(
                "INSERT INTO sessions (sessionId, id, sessionToken, createdDate)
                VALUES (:sessionId, :uuid, :token, :cdate) ON CONFLICT ON CONSTRAINT sessions_pkey DO UPDATE SET id = :uuid, sessionToken = :token, createdDate = :cdate"
            );
            if ($stmt) {
                $stmt->bindParam(':sessionId', $sessionId);
                $stmt->bindParam(':uuid', $this->uuid);
                $stmt->bindParam(':token', $sessionToken);
                $stmt->bindParam(':cdate', $createdDate);
                $stmt->execute();
            }
            return true;
        }
    
        public function destroy($sessionId) {
            $stmt = $this->dbh->prepare("DELETE FROM sessions WHERE sessionid = :id");
            if ($stmt) {
                $stmt->bindParam(":id", $sessionId);
                $stmt->execute();
            }
            return true;
        }
    
        public function close() {
            return true;
        }
    
        public function gc($max_lifetime) {  // ガーベージコレクタ (php.iniのgc_maxlifetime = 1440)
            $stmt = $this->dbh->prepare("DELETE FROM sessions WHERE createdDate < :old");
            if ($stmt) {
                date_default_timezone_set("UTC");
                $old = date('Y-m-d H:i:s', time() - $max_lifetime);
                $stmt->bindParam(":old", $old);
                $stmt->execute();
            }
            return true;
        }
    }
?>
