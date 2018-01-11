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
        $pwd = password_hash("user1", PASSWORD_BCRYPT);
        $db->exec("INSERT INTO users VALUES (NULL, 'user1@example.com', '$pwd', 'First user');");
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
    function queryUsersImmovables($id) {
        $db = openOrCreateDB();
        return $db->query("SELECT * FROM immovables WHERE ownerid == '$id';");
    }

    function getUserID($email) {
        $db = openOrCreateDB();
        return $db->query("SELECT id FROM users WHERE email == '$email';")->fetchArray()[0];
    }

    function getUserName($email) {
        $db = openOrCreateDB();
        return $db->query("SELECT name FROM users WHERE email == '$email';")->fetchArray()['name'];
    }

    function getTableOfAllImmovables() {
        $result = queryImmovables();
        while ($row = $result->fetchArray()) {
            $echoRow = "<tr><td>".$row['title']."</td><td>".$row['address']."</td><td>".$row['m2']."</td><td>".$row['rooms']."</td><td>".$row['floors']."</td><td>".$row['balconies']."</td><td>".$row['price']."</td>";
            if ($row['ownerid'] == getUserID($_SESSION['email']))
                $echoRow = $echoRow."<td>Delete</td>";
            $echoRow = $echoRow."</tr>";
            echo $echoRow;
        }
    }

    function getTableOfImmovables($queryResult) {
        while ($row = $queryResult->fetchArray()) {
            echo "<tr><td>".$row['title']."</td><td>".$row['address']."</td><td>".$row['m2']."</td><td>".$row['rooms']."</td><td>".$row['floors']."</td><td>".$row['balconies']."</td><td>".$row['price']."</td><td>Delete</td></tr>";
        }
    }

    $db = openOrCreateDB();
    return $db;
?>

