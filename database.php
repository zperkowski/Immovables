<?php
    $dbName = "database.sqlite3";

    function openDatabase($name) {
        if (!$db = new SQLite3($name))
            die("Couldn't open a database");
        return $db;
    }

    function createDatabase($name) {
        $db = new SQLite3($name);
        $sql = file_get_contents("initDB.sql");
        if (!$db->exec($sql))
            die("Couldn't init an empty database");
        return $db;
    }

    function openOrCreateDB() {
        global $dbName;
        if (file_exists("$dbName"))
            $db = openDatabase($dbName);
        else
            $db = createDatabase($dbName);
        return $db;
    }

    function dbQuery($statment) {
        $db = openOrCreateDB();
        return $db->query($statment);
    }

    $db = openOrCreateDB();
    return $db;
?>

