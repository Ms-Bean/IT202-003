<?php
require(__DIR__ . "/../../partials/nav.php");
if(!is_logged_in()){
    flash("You must log in to view this page.");
    die(header("Location: login.php"));
}
?>
<form method="POST">
    <div>
        <input type="radio" name="sorter" value="value_by_date"/>
        <label>Sort by date</label><br>
        <input type="radio" name="sorter" value="value_by_total"/>
        <label>Sort by total</label<br><br>
        <input type="text" name="by_category" placeholder="category"/><br><br>
        <input type="date" name="start_date_range" placeholder="start date"/><br>
        <input type="date" name="end_date_range" placeholder="end date"/><br>
        <input type="submit" name="submit" value="submit"/><br>
    </div>
</form>
<?php
$orders_results = [];
$orderitems_results = [];
$db = getDB();
$sql_str = "";
if(has_role("Owner")){
    $sql_str = "SELECT id, user_id, total_price, created, payment_method, address FROM Orders WHERE user_id = :user_id OR NOT user_id = :user_id LIMIT 10 ";
}
else{
    $sql_str = "SELECT id, user_id, total_price, created, payment_method, address FROM Orders WHERE user_id = :user_id LIMIT 10 ";
}
if(isset($_POST["submit"])){
    if(isset($_POST["sorter"])){
        if($_POST["sorter"] === 'value_by_total'){
            $sql_str .= "ORDER BY total_price ";
        }
        else{
            $sql_str .= "ORDER BY created ";
        }
    }
}
$stmt = $db->prepare($sql_str);
try {
    $stmt->execute([":user_id" => $_SESSION["user"]["id"]]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $orders_results = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
?>
<h1>Order History</h1>
<?php
foreach($orders_results as $index => $record){
    echo("<div class='order_info'>");
    echo("<br>Order " . $record["id"] . " placed on " . $record["created"]);
    echo("<br>User ID: " . $record["user_id"]);
    echo("<br>Total price: " . $record["total_price"]);
    echo("<br>Payment Method: " . $record["payment_method"]);
    echo("<br>Address: " . $record["address"]);
    echo("<br><a href='order_details.php?id=" . $record["id"] . "'>Order Info</a>");
    echo("</div><br>");
}
?>
