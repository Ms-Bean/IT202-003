<?php
require(__DIR__ . "/../../partials/nav.php");
if(!is_logged_in()){
    flash("You must log in to view this page.");
    die(header("Location: login.php"));
}
?>
<form method="POST">
    <label> Sort by total
    <input type='checkbox' name='by_total'/><br>
    <input type='submit' name='submit' value='submit'/><br>
</form>
<?php
$PER_PAGE = 5;
$current_page = 0;
$by_total = false;
//Use values from link if available
if(isset($_GET["current_page"])){
    $current_page = $_GET["current_page"];
}
if(isset($_GET["by_total"])){
    $by_total = $_GET["by_total"];
}
//Override with values from submit if available
if(isset($_POST['submit'])){
    if(isset($_POST["by_total"])){
        $by_total = true;
    }
}
$orders_results = [];
$orderitems_results = [];
$db = getDB();
$sql_str = "";
if(has_role("Owner")){
    $sql_str = "SELECT id, user_id, total_price, created, payment_method, address FROM Orders WHERE user_id = :user_id OR NOT user_id = :user_id ";
}
else{
    $sql_str = "SELECT id, user_id, total_price, created, payment_method, address FROM Orders WHERE user_id = :user_id ";
}
if($by_total){
    $sql_str = $sql_str . "ORDER BY total_price ";
}
$sql_str = $sql_str . "LIMIT "  . $current_page*$PER_PAGE . "," . $PER_PAGE . " ";
echo($sql_str);
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
echo("<a href = purchase_history.php?by_total=" . $by_total . "&current_page=" . $current_page + 1);
?>