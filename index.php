<?php
require __DIR__ . "./header.php";

try {
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);

    // echo "Connexion &eacute;tablie<br>";
} catch (\Throwable $th) {
    throw $th;
};








if (isset($_SESSION['prenom'])) {
    echo '<h3>Bonjour ' . $_SESSION['prenom'] . '</h3>';

    $sql2 = ("SELECT id FROM users WHERE email='$_SESSION[mail]'");
    $resultId = $PDO->query($sql2);
    while ($id = $resultId->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION["id"] = $id['id'];
    }
};


?>
<div class="logo-container">
    <div id="error" style="background:red; height:30%; display:none; justify-content:center;align-items:center;">
        <h5>Erreur dans les données !</h5>
    </div>
    <div id="connected">
    </div>
    <div id="signin">
        <form id="inscription" enctype="multipart/form-data">
            <i class='fas fa-times-circle' id='exitSign'></i>
            <label for="prenom">Prénom</label>
            <input type="text" for="prenom" name="prenom" id="prenom">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom">
            <label for="pseudo">Pseudo</label>
            <input type="text" for="pseudo" name="pseudo" id="pseudo">
            <label for="mail">Email</label>
            <input type="email" for="mail" name="mail" id="mail">
            <label for="mdp">Password</label>
            <input type="password" for="mdp" name=" password" id="mdp">
            <label for="mdpConfirm">Confirm password</label>
            <input type="password" for="mdpConfirm" name="mdpConfirm" id="mdpConfirm">
            <!-- <input type="file" name="avatar" id="avatar"> -->
            <input type="submit" value="Inscription">
        </form>
    </div>


    <div class="logo">

    </div>
</div>



<?php
$sql = ("SELECT id,name,article,enabled FROM article");
$result = $PDO->query($sql);


echo "<div class='articleList'><h4>Derniers articles:</h4>";
while ($a = $result->fetch(PDO::FETCH_ASSOC)) {

    echo "<a href='./article?id=$a[id]'>$a[name]</a>";
}
echo "</div>";



?>





<?php require __DIR__ . "./footer.php";