<?php
require(__DIR__ . "/../../partials/nav.php");
if(!is_logged_in()){
    flash("You must log in to view this page.");
    die(header("Location: login.php"));
}
$order_id = se($_GET, "id", -1, false);
$results = [];
$db = getDB();
$stmt = $db->prepare("SELECT id, product_id, unit_price, quantity from OrderItems WHERE order_id = :order_id AND user_id = :user_id");
try {
    $stmt->execute([":order_id" => $order_id, ":user_id" => $_SESSION["user"]["id"]]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $orderitems_results = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
$stmt = $db->prepare("SELECT id, user_id, total_price, created, payment_method from Orders WHERE id = :order_id AND user_id = :user_id");
try {
    $stmt->execute([":order_id" => $order_id, ":user_id" => $_SESSION["user"]["id"]]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $orders_results = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
?>

<div class="container-fluid">
    <?php
        foreach($orders_results as $index => $record){
            echo("<div class='cart_item'>");
            echo("<h1>Order Info</h1>");
            foreach ($result as $column => $value){
                echo($coluimn . ": " . $value . "<br>");
            }
            echo("</div><br>");
        }
    ?>
    <?php
        foreach($order_itemsresults as $index => $record){
            echo("<div class='cart_item'>");
            echo("<h1>Item info</h1>");
            foreach ($result as $column => $value){
                echo($column . ": " . $value . "<br>");
            }
            echo("</div><br>");
        }
    ?>
</div>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>