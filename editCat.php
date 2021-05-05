<?php require __DIR__ . "./header.php";
?>

<div class="container">

    <form action="./changeCat.php" method="POST">

        <label for="newCat">Nouvelle catégorie :</label>
        <input type="text" name="newCat" placeholder=<?php echo $_GET['name'] ?>>
        <label for="active">Activé ?</label>
        <input type="checkbox" name="active">
        <input type="hidden" name="id" value=<?php echo $_GET['id'] ?>>
        <input type="hidden" name="oldCat" value=<?php echo $_GET['name'] ?>>
        <input type="submit">


    </form>
</div>





<?php
require __DIR__ . './footer.php';