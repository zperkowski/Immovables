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
        $pwd = password_hash("admin", PASSWORD_BCRYPT);
        $db->exec("INSERT INTO users VALUES (0, 'admin@example.com', '$pwd', 'Administrator');");
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

    function queryImmovables() {
        $db = openOrCreateDB();
        return $db->query("SELECT * FROM immovables");
    }

    function getUserID($email) {
        $db = openOrCreateDB();
        return $db->query("SELECT id FROM users WHERE email == '.$email.';")->fetchArray()[0];
    }

    $db = openOrCreateDB();
    return $db;
?>

