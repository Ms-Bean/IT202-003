<?php
require(__DIR__ . "/../../partials/nav.php");


$results = [];
if (isset($_POST["itemName"]) or isset($_POST["itemCategory"])) {
    $itemCategory = se($_POST, "itemCategory", "", false);
    $itemName = se($_POST, "itemName", "", false);
    $params = [];
    $sqlstr = "SELECT * FROM Products WHERE 1=1 AND stock > 0 AND NOT visibility = 'false' ";
    if(!empty($itemCategory)){
        $sqlstr = $sqlstr . " AND category = :itemCategory";
        $params[":itemCategory"] = $itemCategory;
    }
    if(!empty($itemName)){
        $sqlstr = $sqlstr . " AND name like :itemName";
        $params[":itemName"] = "%" . $itemName . "%";
    }
    $db = getDB();
    $stmt = $db->prepare($sqlstr);
    try {
        $stmt->execute($params);
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
            <input class="form-control" type="search" name="itemCategory" placeholder="Category Filter" />
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
                            echo $v;
                            ?></td>
                    <?php endforeach; ?>


                    <td>
                        <?php
                            if(has_role("Admin")){
                                $id = se($record, "id");
                                echo('<a href="admin/edit_item.php?id=' . $id . '">Edit</a>');
                            }
                        ?>
                        <a href="admin/edit_item.php?id=<?php se($record, "id"); ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>