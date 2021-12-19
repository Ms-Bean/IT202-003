<?php
require(__DIR__ . "/../../partials/nav.php");
if(!is_logged_in()){
    flash("You must log in to view this page.");
    die(header("Location: login.php"));
}
?>
<form method="POST">
    <label>Sort by total</label>
    <input type='checkbox' name='by_total'/><br>
    <label>Since</label>
    <input type='date' name='by_since'/><br>
    <label>Before</label>
    <input type='date' name='by_before'/><br>
    <input type='submit' name='submit' value='submit'/><br>
</form>
<?php
$PER_PAGE = 5;
$current_page = 0;
$by_total = false;
$by_since = '';
$by_before = '';
//Use values from link if available
if(isset($_GET["current_page"])){
    $current_page = $_GET["current_page"];
}
if(isset($_GET["by_since"])){
    $by_since = $_GET["by_since"];
}
if(isset($_GET["by_before"])){
    $by_before = $_GET["by_before"];
}
if(isset($_GET["by_total"])){
    $by_total = $_GET["by_total"];
}
//Update or wipe values with submit
if(isset($_POST['submit'])){
    if(isset($_POST["by_total"])){
        $by_total = true;
    }
    else{
        $by_total = false;
    }
    if($_POST["by_since"] !== ''){
        $by_since = date($_POST["by_since"] . " 00:00:00");
    }
    else{
        $by_since = '';
    }
    if($_POST["by_before"] !== ''){
        $by_before = date($_POST["by_before"] . " 23:59:59");
    }
    else{
        $by_before = '';
    }
}
$orders_results = [];
$orderitems_results = [];
$db = getDB();
$sql_str = "";
if(has_role("Owner")){
    $sql_str = "SELECT id, user_id, total_price, created, payment_method, address FROM Orders WHERE :user_id = :user_id ";
}
else{
    $sql_str = "SELECT id, user_id, total_price, created, payment_method, address FROM Orders WHERE user_id = :user_id ";
}
if($by_since !== ''){
    $sql_str = $sql_str . "AND created >= '" . $by_since . "' ";
}
if($by_before !== ''){
    $sql_str = $sql_str . "AND created <= '" . $by_before . "' ";
}
if($by_total){
    $sql_str = $sql_str . "ORDER BY total_price ";
}
$sql_str = $sql_str . " LIMIT "  . $current_page*$PER_PAGE . "," . $PER_PAGE . " ";
$count_str = "SELECT COUNT(*) FROM " . explode('LIMIT', explode('FROM', $sql_str)[1])[0]; //Circumcise the sql string in order to obtain count
echo($sql_str);
echo("Count: " . $count_str);
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
$stmt = $db->prepare($count_str);
try {
    $stmt->execute([":user_id" => $_SESSION["user"]["id"]]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        $count_results = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
?>
<h1>Order History</h1>
<?php
echo("<a href = purchase_history.php?by_total=" . $by_total . "&current_page=" . $current_page + 1 . "&by_since=" . $by_since . "&by_before=" . $by_before . ">Next</a>");
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