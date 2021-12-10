<?php
require(__DIR__ . "/../../partials/nav.php");
if(!is_logged_in()){
    flash("You must log in to view this page.");
    die(header("Location: login.php"));
}
$order_id = se($_GET, "id", -1, false);
$orders_results = [];
$orderitems_results = [];
$db = getDB();
$stmt = $db->prepare("SELECT id, user_id, total_price, created, payment_method, address from Orders WHERE id = :order_id");
try {
    $stmt->execute([":order_id" => $order_id]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $orders_results = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}

if($orders_results[0]["user_id"] !== $_SESSION["user"]["id"]){
    flash("This is not your order!");
    die(header("Location: home.php"));
}

$stmt = $db->prepare("SELECT id, product_id, unit_price, quantity from OrderItems WHERE order_id = :order_id");
try {
    $stmt->execute([":order_id" => $order_id]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $orderitems_results = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}

?>

<div class="container-fluid">
    <?php
        foreach($orders_results as $index => $record){
            echo("<div class='order_info'>");
            echo("<h1>Order Info</h1>");
            foreach ($record as $column => $value){
                echo($column . ": " . $value . "<br>");
            }
            echo("</div><br>");
        }
    ?>
    <?php
        foreach($orderitems_results as $index => $record){
            echo("<div class='cart_item'>");
            echo("<h1>Item info</h1>");
            foreach ($record as $column => $value){
                echo($column . ": " . $value . "<br>");
            }
            echo("</div><br>");
        }
    ?>
</div>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>