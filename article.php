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


var_dump($_GET['id']);

$articleId = $_GET['id'];


$sql = "SELECT name,article FROM article WHERE id=$articleId";
$result = $PDO->query($sql);

while ($a = $result->fetch(PDO::FETCH_ASSOC)) {


?><div class="article">
    <h5><?php echo $a['name'] ?></h5>

    <div class="article-container">

        <p><?php echo $a['article'] ?></p>
    </div>
</div>

<div class="modify-form">
    <form action="./changeArticle" method="POST" id="newArticle">
        <label for="articleName">Name :</label>
        <input type="text" id="articleName" name="articleName">
        <label for="article"></label>
        <textarea name="newArticle" id="article" cols="30" rows="10"></textarea>
        <input type="submit">
    </form>
</div>



<?php
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="./script.js"></script>
<?php
require __DIR__ . "./footer.php";