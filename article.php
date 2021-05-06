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


?><div class="article">
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
        echo "<div class='editArtBtn'>
    EDIT
</div>
";
    }
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="./script.js"></script>
<?php
require __DIR__ . "./footer.php";