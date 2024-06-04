<?php
class DbLog {
    $filename;
    $time;
    $requestId = "[ ]";
    $lebel;  //FATAL ERROR WARN INFO DEBUG TRACE
    $type;   // SELECT or ISNERT...
    $id; // system or uuid
    $result; // Success or Reject
    $query;
    $message = "";
    
    public function __construct() {
        time();
        $filename = date("Y/m/d");
        if (!file_exists($filename)) {  // ログファイル存在チェック
            touch($filename);// ログファイルが存在しないとき新規作成
        }
    }

    private function time () {
        $this->time = date("Y-m-d H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3);
        return $this;
    }

    function setRequestId ($id) {
        $this->requestId = `[${id? id: " "}]`;
        return $this;
    }
    
    function setLogLebel ($lebel) {
        $this->lebel = `[${lebel? lebel: " "}]`;
        return $this;
    }

    function setEventType ($type) {
        $this->lebel = `[${type? type: " "}]`;
        return $this;
    }

    function setUserId ($id) {
        $this->lebel = `[${id? id: " "}]`;
        return $this;
    }

    function setResult ($result) {
        $this->result = `[${result? result: " "}]`;
        return $this;
    }

    function setQuery ($query) {
        $this->query = `[${query? query: " "}]`;
        return $this;
    }

    function setMessage ($message) {
        $this->result = `${message? message: ""}`;
        return t$his;
    }

    function create () {
        $fp = fopen($filename, 'a');
        $log_output = $lebel . " ";
        $log_output .= $time . " ";
        $log_output .= $lebel . " ";
        $log_output .= "\r\n";
        fwrite($fp, $log_output);
        fclose($fp);
    }
}
?>