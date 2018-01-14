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

    function dbExec($statment) {
        $db = openOrCreateDB();
        return $db->Exec($statment);
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

    function getUserEmail($id) {
        $db = openOrCreateDB();
        return $db->query("SELECT email FROM users WHERE id == '$id';")->fetchArray()[0];
    }

    function getUserName($email) {
        $db = openOrCreateDB();
        return $db->query("SELECT name FROM users WHERE email == '$email';")->fetchArray()['name'];
    }

    function getTableOfImmovableByID($id) {
        $statment = "SELECT * FROM main.immovables WHERE id == '$id'";
        $result = dbQuery($statment);
        $row = $result->fetchArray();
        $userid = getUserID($_SESSION['email']);
        $table = "<table>
            <tr><td>Title</td><td>".$row['title']."</td></tr>
            <tr><td>Address</td><td>".$row['address']."</td></tr>
            <tr><td>m2</td><td>".$row['m2']."</td></tr>
            <tr><td>Rooms</td><td>".$row['rooms']."</td></tr>
            <tr><td>Floors</td><td>".$row['floors']."</td></tr>
            <tr><td>Balconies</td><td>".$row['balconies']."</td></tr>
            <tr><td>Price</td><td>".$row['price']."</td></tr>
            <tr><td>Description</td><td>".$row['desc']."</td></tr>";

        if ($row['ownerid'] != $userid && !is_numeric($row['buyerid']))
            $table = $table . "<tr><td><a href='details.php?id=".$row['id']."&buyer=".$userid."'>Buy</a></td><td></td></tr>";

        $table = $table . "</table>";
        echo $table;
    }

    function getTableOfAllImmovables() {
        $result = queryImmovables();
        while ($row = $result->fetchArray()) {
            if ($row['buyerid'] != "-1") {
                $link = "<a href='details.php?id=" . $row['id'] . "'>";
                $linkend = "</a>";
                $echoRow = "<tr><td>" . $link . $row['title'] . $linkend . "</td><td>" . $row['address'] . "</td><td>" . $row['m2'] . "</td><td>" . $row['rooms'] . "</td><td>" . $row['floors'] . "</td><td>" . $row['balconies'] . "</td><td>" . $row['price'] . "</td>";
                if ($row['ownerid'] == getUserID($_SESSION['email']) && !is_numeric($row['buyerid']))
                    $echoRow = $echoRow . "<td>Delete</td>";
                else if (is_numeric($row['buyerid']))
                    $echoRow = $echoRow . "<td>Bought</td>";
                $echoRow = $echoRow . "</tr>";
                echo $echoRow;
            }
        }
    }

    function getTableOfImmovables($queryResult) {
        while ($row = $queryResult->fetchArray()) {
            $echorow = "<tr><td>".$row['title']."</td><td>".$row['address']."</td><td>".$row['m2']."</td><td>".$row['rooms']."</td><td>".$row['floors']."</td><td>".$row['balconies']."</td><td>".$row['price']."</td><td><a href='add.php?deleteid=".$row['id']."'>Delete</a>";
            if (is_numeric($row['buyerid'])) {
                $buyeremail = getUserEmail($row['buyerid']);

                $echorow = $echorow . " Bought by: $buyeremail";
            }
            $echorow = $echorow . "</td></tr>";
            echo $echorow;
        }
    }

    $db = openOrCreateDB();
    return $db;
?>

