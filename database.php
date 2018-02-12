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
        createUser(0, 'admin@example.com', '0000', 'admin', "Administrator");
        createUser(NULL, 'user1@example.com', '1111', 'user1', 'First user');
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

    function getUserNumber($email) {
        $db = openOrCreateDB();
        return $db->query("SELECT number FROM users WHERE email == '$email';")->fetchArray()['number'];
    }

    function getUserPassword($email) {
        $db = openOrCreateDB();
        $id = getUserID($email);
        return $db->query("SELECT pwd FROM users WHERE id == '$id';")->fetchArray()[0];
    }

    function createUser($id, $email, $number, $password, $name) {
        $db = openOrCreateDB();
        $pwd = password_hash($password, PASSWORD_BCRYPT);
        if ($id != NULL)
            $db->exec("INSERT INTO users VALUES ('$id', '$email', '$pwd', '$name', '$number');");
        else
            $db->exec("INSERT INTO users VALUES (NULL, '$email', '$pwd', '$name', '$number');");
    }

    function changePassword($email, $oldpassword, $newpassword) {
        $db = openOrCreateDB();
        if (password_verify($oldpassword, getUserPassword($email))) {
            $newpassword = password_hash($newpassword, PASSWORD_BCRYPT);
            $id = getUserID($email);
            if ($db->exec("UPDATE users SET pwd = '$newpassword' WHERE id == '$id';"))
                return true;
        }
        return false;
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

        if ($row['picture'] != NULL) {
            echo '<img src="data:image/jpeg;base64,'. $row['picture'] .'"/>';
        }
    }

    function getTableOfAllImmovables() {
        $result = queryImmovables();
        getTableOfImmovables($result);
    }

    function getTableOfImmovables($result) {
        while ($row = $result->fetchArray()) {
            if ($row['buyerid'] != "-1") {
                $link = "<a href='details.php?id=" . $row['id'] . "'>";
                $linkend = "</a>";
                $echoRow = "<tr><td>" . $link . $row['title'] . $linkend . "</td><td>" . $row['address'] . "</td><td>" . $row['m2'] . "</td><td>" . $row['rooms'] . "</td><td>" . $row['floors'] . "</td><td>" . $row['balconies'] . "</td><td>" . $row['price'] . "</td>";
                if ($row['ownerid'] == getUserID($_SESSION['email'])) {
                    $echoRow = $echoRow . "<td><a href='add.php?deleteid=" . $row['id'] . "'>Delete</a></td>";
                    if (is_numeric($row['buyerid'])) {
                        $buyeremail = getUserEmail($row['buyerid']);
                        $echoRow = $echoRow . "<td>Bought by: $buyeremail</td>";
                    }
                } else {
                    if (is_numeric($row['buyerid']))
                        $echoRow = $echoRow . "<td>Bought</td>";
                }
                $echoRow = $echoRow . "</tr>";
                echo $echoRow;
            }
        }
    }
//$2y$10$eVUZXyf9n3keCA7x8sPOy.c6yrf.93IDBvDSb3ziQYBBJoutHfzkC
    $db = openOrCreateDB();
    return $db;
?>

