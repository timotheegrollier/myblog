<?php require __DIR__ . "./header.php";





?>



<form action="./tag.php" class="create-tag" method="GET">
    <label for="newTag">#</label>
    <input type="text" name="newTag" id="newTag" placeholder="newTag">
    <label for="enabled">Active
        <input type="checkbox" name="enabled" id="enabled">
    </label>

    <input type="submit">

</form>


<?php require __DIR__ . "./footer.php";