<?php

require(__DIR__ . "/../../partials/nav.php");
$product_id = se($_GET, "id", -1, false);
$user_id = $_SESSION["user"]["id"];
$desired_quantity = 4;
if(isset($_POST['desired_quantity'])){
    $desired_quantity = $_POST['desired_quantity'];
}
$result = [];
$db = getDB();
$stmt = $db->prepare("SELECT * FROM Products where id =:id");
try {
    $stmt->execute([":id" => $product_id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        $result = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
$unit_cost = $result["cost"];
echo($product_id . $user_id . $desired_quantity . $unit_cost);
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