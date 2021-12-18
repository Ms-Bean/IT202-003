<?php
require(__DIR__ . "/../../partials/nav.php");
if(!is_logged_in()){
    flash("You must log in to view this page.");
    die(header("Location: login.php"));
}
if(empty($_GET)){
    $page = 1;
}
else {
    $page = $_GET['page'];
}
$PER_PAGE = 5;
?>
<form method="POST">
    <div>
        <input type="radio" name="sorter" value="value_by_date" <?php if(isset($_GET["sorter"])){if($_GET["sorter"] === 'value_by_date'){echo("checked='checked'");}}?>/>
        <label>Sort by date</label><br>
        <input type="radio" name="sorter" value="value_by_total" <?php if(isset($_GET["sorter"])){if($_GET["sorter"] === 'value_by_total'){echo("checked='checked'");}}?>/>
        <label>Sort by total</label<br><br>
        <input type="text" name="by_category" placeholder="category" <?php if(isset($_GET["by_category"])){echo("value=" . $_GET["by_category"]);}else{echo("value=''");}?>/><br><br>
        <label>Start date</label>
        <input type="date" name="start_date_range" <?php if(isset($_GET["start_date_range"])){echo("value=" . $_GET["start_date_range"]);}else{echo("value=''");}?>/><br>
        <label>End date</label>
        <input type="date" name="end_date_range" <?php if(isset($_GET["end_date_range"])){echo("value=" . $_GET["end_date_range"]);}else{echo("value=''");}?>/><br>
        <input type="submit" name="submit" value="submit"/><br>
    </div>
</form>
<?php
$orders_results = [];
$orderitems_results = [];
$db = getDB();
$sql_str = "";
if(has_role("Owner")){
    $sql_str = "SELECT id, user_id, total_price, created, payment_method, address FROM Orders WHERE (1=1 AND user_id = :user_id OR NOT user_id = :user_id) ";
}
else{
    $sql_str = "SELECT id, user_id, total_price, created, payment_method, address FROM Orders WHERE (1=1 AND user_id = :user_id) ";
}
if(isset($_POST["submit"])){
    
    if(isset($_POST["sorter"])){
        if($_POST["sorter"] === 'value_by_total'){
            $sql_str = $sql_str . "ORDER BY total_price DESC ";
        }
        else{
            $sql_str = $sql_str . "ORDER BY created ASC ";
        }
    }
    if($_POST["by_category"] !== ''){
        $categories_results = [];
        $stmt = $db->prepare("SELECT id FROM Products WHERE category = :category");
        try {
            $stmt->execute([":category" => $_POST["by_category"]]);
            $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($r) {
                $categories_results = $r;
            }
        } catch (PDOException $e) {
            flash("<pre>" . var_export($e, true) . "</pre>");
        }

        $sql_str = $sql_str . "AND id in (-1,";
        foreach($categories_results as $index => $record){
            $stmt = $db->prepare("SELECT order_id FROM OrderItems WHERE product_id = :product_id");
            try {
                $stmt->execute([":product_id" => $record["id"]]);
                $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($r) {
                    $deep_results = $r;
                }
            } catch (PDOException $e) {
                flash("<pre>" . var_export($e, true) . "</pre>");
            }
            foreach($deep_results as $deep_index => $deep_record){
                $sql_str = $sql_str . $deep_record["order_id"] . ",";
            }
        }
        $sql_str = substr($sql_str, 0, -1) . ") ";
    }
    if($_POST["start_date_range"] !== ''){
        $start_timestamp = date($_POST["start_date_range"] . " 00:00:00");
        $sql_str = $sql_str . "AND created >= '" . $start_timestamp . "' ";
    }
    if($_POST["end_date_range"] !== ''){
        $end_timestamp = date($_POST["end_date_range"] . " 23:59:59");
        $sql_str = $sql_str . "AND created <= '" . $end_timestamp . "' ";
    }
    $sql_str = $sql_str . "LIMIT " . $page*$PER_PAGE . "," . $PER_PAGE;
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
}

?>
<h1>Order History</h1>
<?php
$total = 0;
foreach($orders_results as $index => $record){
    $total += $record["total_price"];
    echo("<div class='order_info'>");
    echo("<br>Order " . $record["id"] . " placed on " . $record["created"]);
    echo("<br>User ID: " . $record["user_id"]);
    echo("<br>Total price: " . $record["total_price"]);
    echo("<br>Payment Method: " . $record["payment_method"]);
    echo("<br>Address: " . $record["address"]);
    echo("<br><a href='order_details.php?id=" . $record["id"] . "'>Order Info</a>");
    echo("</div><br>");
}
if(has_role("Owner")){
    echo("<h1>Total: " . $total . "</h1>");
}
echo('<a href="purchase_history.php?page=1">aaa</a>'); 

?>
<?php require(__DIR__ . "/../../partials/flash.php");
?>
