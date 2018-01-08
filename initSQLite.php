<?php
    $dbName = "database.sqlite3";

    function openDatabase($name) {
        if (!$db = sqlite_open($name, 0666, $sqliteerror))
            die($sqliteerror);
        return $db;
    }

    function createDatabase($name) {
        $db = new SQLite3($name);
        $sql = file_get_contents("initDB.sql");
        return $db;
    }

    if (file_exists("$dbName"))
        $db = openDatabase($dbName);
    else
        $db = createDatabase($dbName);

?>

