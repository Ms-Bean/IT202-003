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
//Get ratings
$stmt = $db->prepare("SELECT rating, comment, user_id FROM Ratings WHERE product_id =:id");
try {
    $stmt->execute([":id" => $id]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $result = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
//Add rating cards to page
foreach($result as $index => $record){
    //Get user info for each rating
    $stmt = $db->prepare("SELECT email, visibility, username FROM Users WHERE id =:id");
    try {
        $stmt->execute([":id" => $record["user_id"]]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $user_result = $r;
        }
    } catch (PDOException $e) {
        flash("<pre>" . var_export($e, true) . "</pre>");
    }
    echo("<div class='cart_item'>");
    if($user_result["visibility"] !== 'false'){
        echo("Email: " . $user_result["email"]);
    }
    echo("
    Rating: ". $record["rating"] . "<br><br>
    <i>". $record["comment"] . "</i><br>
    - ". $user_result["username"] . "<br>
    </div><br>
    ");
}
?>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>