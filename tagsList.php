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
    <table>
        <h2>TAGS</h2>
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
                echo "<td><a href='editTag.php?id=$t[id]'>EDIT</a></td>";
            }
            echo "</tr><br></tbody></table> <a href=createTag.php>Create new tag</a><br><a href='deleteAllTags.php' class='delete'>Delete all tags ! </a>"; ?>
</div>
<div class="categories">
    <h2>Catégories</h2>


</div>




<?php require __DIR__ . "./footer.php";