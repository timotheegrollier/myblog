<?php require __DIR__ . './header.php'; ?>

<div class="container">




    <form action="./category.php" method="POST" class="createCat">
        <label for="category">Nouvelle catégorie :</label>
        <input type="text" name="category">
        <label for="active">Activé?</label>
        <input type="checkbox" name="active" id="active">
        <input type="submit">
    </form>
</div>








<?php require __DIR__ . './footer.php';