<?php require __DIR__ . "./header.php";
require __DIR__ . "./dbConfig.php";
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


$sql = "SELECT id,firstname,lastname,pseudo,email FROM users";

$result = $PDO->query($sql);

?>



<div class="userTab">

    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Prénom</td>
                <td>Nom</td>
                <td>Pseudo</td>
                <td>Email</td>
            </tr>
        </thead>
        <tbody>


            <?php
            while ($u = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                foreach ($u as $key => $value) {
                    echo '<td>' . $value . '</td>';
                }
                echo "<td><a href='/editUsers.php?id=" . $u['id'] . "'>EDIT</a></td>
            </tr>";
            }
            ?>



        </tbody>
        <tfoot>
    </table>
</div>










<?php require __DIR__ . "./footer.php"; ?>