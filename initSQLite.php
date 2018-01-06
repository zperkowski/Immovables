<?php
    $dbName = "database.sqlite3";

    function openDatabase($name) {
        if (!$db = sqlite_open($name, 0666, $sqliteerror))
            die($sqliteerror);
        return $db;
    }

    function createDatabase($name) {
        return new SQLite3($name);
        // TODO: Initialize empty database
    }

    if (file_exists("$dbName"))
        $db = openDatabase($dbName);
    else
        $db = createDatabase($dbName);

?>

