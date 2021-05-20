<?php require __DIR__ . "./header.php";


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



$articleId = $_GET['id'];


$sql = "SELECT name,article,image FROM article WHERE id=$articleId";
$result = $PDO->query($sql);

while ($a = $result->fetch(PDO::FETCH_ASSOC)) {


?><div class="article" id="art">
    <h4 class="title"><?php echo $a['name'] ?></h4>


    <div class="article-container">

        <p><?php echo $a['article'] ?></p>
        <div class="article-img">

            <img src=<?php echo $a['image'] ?> alt="art-img" onerror="this.style.display='none'">
        </div>
    </div>
</div>
<div class="modify-form">
    <form action="./changeArticle.php" method="POST" id="newArticle" enctype="multipart/form-data">
        <i class='fas fa-times-circle' id='exitArt'></i>
        <label for="articleName">Name :</label>
        <input type="text" id="articleName" name="articleName" placeholder="<?php echo $a['name'] ?>">
        <label for="article">Article:</label>
        <textarea name="newArticle" id="article" cols="30" rows="10"
            placeholder="<?php echo $a['article'] ?>"></textarea>
        <input type="hidden" name="id" value=<?php echo $articleId ?>>
        <label for="image">Insérer une image :</label>
        <input type="file" name="image" id="image">
        <input type="submit">
    </form>
</div>





<?php if (isset($_SESSION['id'])) {
        echo "<div class='editArtBtn' id='art-btn'>
    EDIT
</div>
";
    }
}
?>

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
        <!-- <input type="file" name="avatar"> -->

        <input type="submit" value="Inscription">

    </form>
</div>





<?php
require __DIR__ . "./footer.php";