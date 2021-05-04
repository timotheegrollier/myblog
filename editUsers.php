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
$userId = ($_GET['id']);

$sql = "SELECT id,firstname,lastname,pseudo,email,avatar FROM users WHERE id=$userId";


$result = $PDO->query($sql);

if (isset($_GET) && !empty($_GET)) {






    while ($u = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<br> Bonjour :" . $u['firstname'] . "<br>";
        echo "Modifier le profil  : <br>"
?>
<div class="changeProfil">


    <form action="./changeProfil.php" method="POST" enctype="multipart/form-data">
        <label for=" changeFirstname">Prénom:</label>
        <input type='text' name='changeFirstname' placeholder='<?php echo $u['firstname'] ?>'>
        <label for="changeFirstname">Nom:</label>
        <input type='text' name='changeLastname' placeholder='<?php echo $u['lastname'] ?>'>
        <label for="changePseudo">Pseudo:</label>
        <input type='text' name='changePseudo' placeholder='<?php echo $u['pseudo'] ?>'>
        <label for="changeEmail">Email:</label>
        <input type='email' name='changeEmail' placeholder='<?php echo $u['email'] ?>'>
        <input type="hidden" name="id" value="<?php echo $userId ?>">
        <label for="changeAvatar">Choose a profile picture:</label>
        <img src='<?php echo $u['avatar'] ?>' alt="pics" class="editPics">
        <input type="file" id="changeAvatar" name="changeAvatar" accept="image/png, image/jpeg">
        <input type="submit">
    </form>
</div>
<?php

    }
} else {
    echo "<br> Erreur !";
}

?>
<a href="./editPass.php?id=<?php echo $userId ?>">Or just edit password</a>





<?php
require __DIR__ . "./footer.php";