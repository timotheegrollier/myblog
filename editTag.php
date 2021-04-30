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

$userId = $_GET['id'];
var_dump($userId);

$sql = "SELECT name,enabled FROM tags WHERE id=$userId";
$result = $PDO->query($sql);


while ($t = $result->fetch(PDO::FETCH_ASSOC)) {
?>
<form action="./changeTag.php" class="create-tag" method="GET">
    <label for="newTag">#</label>
    <input type="text" name="newTag" id="newTag" placeholder="<?php echo $t['name'] ?>">
    <label for="enabled">Active</label>
    <input type="hidden" name="id" value="<?php echo $userId ?>">
    <?php
        if ($t['enabled']) {
            echo "<input type='checkbox' name='enabled' id='enabled'checked>";
        } else {
            echo "<input type='checkbox' name='enabled' id='enabled'>";
        }
        ?>


    <input type="submit">

</form>

<?php

}

require __DIR__ . "./footer.php";