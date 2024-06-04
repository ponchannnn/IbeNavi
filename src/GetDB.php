<?php
class GetDB {
    private $dbh;
    function __construct () {
        
        //dbjson内にある内容を変換
        $dbjson = file_get_contents(dirname(__FILE__)."/../db.json");
        $jsonEncorded = mb_convert_encoding($dbjson, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $arrJson = json_decode($jsonEncorded);

        $dsn = $arrJson->dsn;
        $user = $arrJson->user;
        $password = $arrJson->password;

        try{
            $this->dbh = new PDO($dsn, $user, $password);
            
        }catch (PDOException $e){
            header('Content-Type: text/plain; charset=UTF-8', true, 500);
            print('Error:'.$e->getMessage());
            die();
        }
    }

    function getDbh() {
        return $this->dbh;
    }

    function getUsernameFromUuid ($id) {
        $stmt = $this->dbh->prepare("SELECT username FROM users WHERE id = :id");
        if($stmt) {
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row["username"];
        } return null;
    }
    
    function getUsernameFromUserId ($id) {
        $stmt = $this->dbh->prepare("SELECT username FROM users WHERE userid = :id");
        if($stmt) {
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row["username"];
        } return null;
    }

    function getUserIdFromUuid ($id) {
        $stmt = $this->dbh->prepare("SELECT userid FROM users WHERE id = :id");
        if($stmt) {
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row["userid"];
        } return null;
    }

    function getUuidFromUserId ($id) {
        $stmt = $this->dbh->prepare("SELECT id FROM users WHERE userid = :id");
        if($stmt) {
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row["id"];
        } return null;
    }
}
?>