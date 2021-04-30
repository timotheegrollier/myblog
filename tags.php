<?php require __DIR__ . "./header.php";
require __DIR__ . "./dbConfig.php";
?>


<table>
    <thead>
        <tr>
            <td>ID</td>
            <td>Tag</td>
            <td>Active</td>
        </tr>
    </thead>
    <tbody>
        <?php

        try {
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);

            echo "Connexion &eacute;tablie";
        } catch (\Throwable $th) {
            throw $th;
        };

        $sql = "SELECT id,name,enabled FROM tags";
        $result = $PDO->query($sql);

        while ($t = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            foreach ($t as $key => $tag) {
                echo '<td>' . $tag . '</td>';
            }
        }