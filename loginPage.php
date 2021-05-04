<?php require __DIR__ . './header.php'; ?>

<div class="login">
    <form action="./connexion.php" method="POST" id="login">
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password"><br>
        <input type="submit">
    </form>
</div>





<?php require __DIR__ . "./footer.php";