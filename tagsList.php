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


?>




<div class="tagsList">
    <h2>Tags</h2>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Tag</td>
                <td>Active</td>
            </tr>
        </thead>
        <tbody>
            <?php


            $sql = "SELECT id,name,enabled FROM tags";
            $result = $PDO->query($sql);

            while ($t = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                foreach ($t as $key => $tag) {
                    echo '<td>' . $tag . '</td>';
                }
                echo "<td><a href='editTag.php?id=$t[id]'>EDIT</a></td><td class='delCase'><a class='delTag' href='./delTag.php?id=$t[id]'><i class='fas fa-times-circle'></i></a></td>";
            }
            echo "</tr><br></tbody></table><div class='list-btn'> <a href=createTag.php>Create new tag</a></div><br><div class='del-btn'><a href='deleteAllTags.php' class='delete'>Delete all tags ! </a></div>"; ?>
</div>


<div class="categories">
    <h2>Catégories</h2>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Category</td>
                <td>Active</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT id,name,enabled FROM category";
            $catResult = $PDO->query($sql2);
            while ($c = $catResult->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                foreach ($c as $key => $category) {
                    echo "<td>$category</td>";
                }
                echo "<td><a href=./editCat.php?id=$c[id]&name=$c[name]>EDIT</a><td class='delCase'><a class='delTag' href='./delCat.php?id=$c[id]'><i class='fas fa-times-circle'></i></a></td>";
            }
            ?>
        </tbody>
    </table>
    <a href="./createCat.php">
        <div class="list-btn">Create Category</div>
    </a>

</div>







<?php require __DIR__ . "./footer.php";