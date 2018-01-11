<?php
require "database.php";

class User
{
    var $db;
    var $dbName = "database.sqlite3";
    var $userInfo;

    function __construct($email, $password) {
        $db = openOrCreateDB($this->dbName);
        $result = $db->query("SELECT * FROM main.users WHERE email = '$email' AND pwd = '$password'")->fetchArray();
        if ($result != null) {
            echo "Logged in\n";
            $this->db;
            $this->userInfo = $result;
        } else {
            $db->close();
            die("Can't find the user\n");
        }
    }

    function getHouses() {
        return $this->db->query("SELECT * FROM immovables WHERE ownerid == '$this->userInfo[0]'");
    }
}

?>
