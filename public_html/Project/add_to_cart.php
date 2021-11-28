<?php
if (!is_logged_in()) {
    flash("You must be logged in to view your cart", "warning");
    die(header("Location: $BASE_PATH" . "home.php"));
}
require(__DIR__ . "/../../partials/nav.php");

$user_id = $_SESSION["user"]["id"];
echo($user_id);

if (isset($_POST["submit"])) {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO CartItems (product_id, user_id, desired_quantity, unit_cost) VALUES(:product_id, :user_id, :desired_quantity, :unit_cost)");
    try {
        $stmt->execute([":product_id" => $product_id, ":user_id" => $user_id, ":desired_quantity" => $desired_quantity, ":unit_cost" => $unit_cost]);
        flash("Added to cart");
    } catch (Exception $e) {
            
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
            <input type="number" name="desired_quantity" required />
        </div>
        <div>
            <input type="submit" value="Add to cart" />
        </div>
    </form>

</div>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>