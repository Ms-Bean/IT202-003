<?php
require(__DIR__ . "/../../../partials/nav.php");

$results = [];
if (isset($_POST["itemName"])) {
    $db = getDB();
    $stmt = $db->prepare("SELECT id, name, description, stock, cost, image from Products WHERE name like :name AND visibility=1 LIMIT 50");
    try {
        $stmt->execute([":name" => "%" . $_POST["itemName"] . "%"]);
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $results = $r;
        }
    } catch (PDOException $e) {
        flash("<pre>" . var_export($e, true) . "</pre>");
    }
}
?>
<style>
    table, tr, th, td{
        border: 1px solid black;
    }
    td{
        width: 14%;
    }
    .image{
        border: 1px solid black;
        height: 100px;
        width: 100px;
    }
    td{

    }
</style>
<div class="container-fluid">
    <h1>List Items</h1>
    <form method="POST" class="row row-cols-lg-auto g-3 align-items-center">
        <div class="input-group mb-3">
            <input class="form-control" type="search" name="itemName" placeholder="Item Filter" />
            <input type="search" name="category" placeholder="Category" />
            <input class="btn btn-primary" type="submit" value="Search" />
        </div>
    </form>
    <?php if (count($results) == 0) : ?>
        <p>No results to show</p>
    <?php else : ?>
        <table class="table">
            <?php foreach ($results as $index => $record) : ?>
                <?php if ($index == 0) : ?>
                    <thead>
                        <?php foreach ($record as $column => $value) : ?>
                            <th><?php se($column); ?></th>
                        <?php endforeach; ?>
                        <th>Actions</th>
                    </thead>
                <?php endif; ?>
                <tr>
                    <?php foreach ($record as $column => $value) : ?>
                        <td><?php 
                            $v = se($value, null, "N/A", false);
                            $searched = 'http';
                            if(strpos($v, $searched) === 0){
                                echo '<img src = "' . $v . '" class = "image">';
                            }
                            else {
                                echo $v;
                            }
                            ?></td>
                    <?php endforeach; ?>


                    <td>
                        <?php
                        if(has_role("Admin")){
                            echo '<a href="edit_item.php?id=<?php se($record, "id"); ?>">Edit</a>';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>