<?php
require(__DIR__ . "/../../partials/nav.php");

$result = [];
$columns = get_columns("Products");
$db = getDB();
$id = se($_GET, "id", -1, false);
$stmt = $db->prepare("SELECT * FROM Products where id =:id");
try {
    $stmt->execute([":id" => $id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        $result = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
?>
<style>

</style>
<div class="item_info">
    <h1><?php echo($result["name"])?></h1>
    <?php foreach ($result as $column => $value) : ?>
    <?php 
        if($column === "name"){
            
        }
        else{
            $v = se($column) . ": " . se($value, null, "N/A", false) . "<br>";
            echo $v;
        }
    ?>
    <?php endforeach; ?>
    <?php
        if(has_role("Admin")){
            echo('<a href="admin/edit_item.php?id=');
            echo($id);
            echo('">Edit</a><br>');
        }
        if(is_logged_in()){
            echo('<a href="add_to_cart.php?id=');
            echo($id);
            echo('">Add to cart</a><br>');
        }
        
    ?>
</div>
<br>
<?php
$stmt = $db->prepare("SELECT rating, comment FROM Ratings where product_id =:id");
try {
    $stmt->execute([":id" => $id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        $result = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
foreach($result as $index => $record){
    echo("
    <div>
    ". $record . "
    </div><br>
    ");
}
?>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>