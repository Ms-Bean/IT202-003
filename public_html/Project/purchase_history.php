<?php
require(__DIR__ . "/../../partials/nav.php");
if(!is_logged_in()){
    flash("You must log in to view this page.");
    die(header("Location: login.php"));
}
$orders_results = [];
$orderitems_results = [];
$db = getDB();
$stmt = $db->prepare("SELECT id, total_price, created, payment_method, address from Orders WHERE user_id = :user_id");
try {
    $stmt->execute([":user_id" => $_SESSION["user"]["id"]]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $orders_results = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
foreach($orders_results as $index => $record){
    echo("<div class='order_info'>");
    echo("<br>Order . " . $record["id"] . "placed on " . $record["created"]);
    echo("<br>Total price: " . $record["total_price"]);
    echo("<br>Payment Method: " . $record["payment_method"]);
    echo("<br>Address: " . $record["address"]);
    echo("</div><br>");
}
?>
