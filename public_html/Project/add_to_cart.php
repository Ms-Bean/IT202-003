<?php

require(__DIR__ . "/../../partials/nav.php");
$product_id = se($_GET, "id", -1, false);
$user_id = $_SESSION["user"]["id"];
if(isset($_POST['desired_quantity'])){
    $desired_quantity = $_POST['desired_quantity'];
}
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
$unit_cost = $result["cost"];
if (isset($_POST["submit"])) {   
    if(empty($desired_quantity)){
        flash("Please enter quantity");
    }
    else {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO CartItems (product_id, user_id, desired_quantity, unit_cost) VALUES(:product_id, :user_id, :desired_quantity, :unit_cost)");
        try {
            $stmt->execute([":product_id" => $product_id, ":user_id" => $user_id, ":desired_quantity" => $desired_quantity, ":unit_cost" => $unit_cost]);
            flash("Added to cart");
        } catch (Exception $e) {
            flash("<pre>" . var_export($e, true) . "</pre>");
        } 
    }
}
?>
<style>
    .container-fluid{
        position: fixed;
        left: 50%;
        margin-left: -150px;
        border: 1px solid black;
        box-shadow: 5px 5px black;
        padding: 10px;
        background-color: #a2eda1;
        width: 300px;
        height: 300px;
    }

</style>
<div class="container-fluid">
    <h1>Add To Cart</h1>
    <form method="POST">
        <div>
            <label for="desired_quantity">Quantity</label>
            <input type="number" min="0" name="desired_quantity" required />
        </div>
        <div>
            <input type="submit" value="Add to cart" />
        </div>
    </form>

</div>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>