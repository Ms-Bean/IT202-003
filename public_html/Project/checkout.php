<?php
require(__DIR__ . "/../../partials/nav.php");
if(!is_logged_in()){
    flash("You must log in to checkout.");
    die(header("Location: login.php"));
}
$user_id = $_SESSION["user"]["id"];
$results = [];
$db = getDB();
//Get each cost of each item in user's cart
$stmt = $db->prepare("SELECT product_id, desired_quantity from CartItems WHERE user_id = :user_id");
try {
    $stmt->execute([":user_id" => $_SESSION["user"]["id"]]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $results = $r;
    }
    else{
        flash("You must add something to your cart to checkout.");
        die(header("Location: shop.php"));
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
//Get arrays for quantities and ids of products in user's cart
$incart_product_ids = [];
$incart_desired_quantities = [];
foreach($results as $index => $record){
    array_push($incart_product_ids, $record["product_id"]);
    array_push($incart_desired_quantities, $record["desired_quantity"]);
}

//Get arrays for names, costs, and stocks of items in user's cart from products table
$inproducts_stocks = [];
$inproducts_costs = [];
$inproducts_names = [];
for($i = 0; $i < count($incart_product_ids); $i++){
    $stmt = $db->prepare("SELECT stock, cost, name from Products WHERE id = :id");
    try {
        $stmt->execute([":id" => $incart_product_ids[$i]]);
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $results = $r;
        }
    } catch (PDOException $e) {
        flash("<pre>" . var_export($e, true) . "</pre>");
    }
    foreach($results as $index => $record){
        array_push($inproducts_stocks, $record["stock"]);
        array_push($inproducts_costs, $record["cost"]);
        array_push($inproducts_names, $record["name"]);
    }
}
$grand_sum = 0;
//For each entry in the users cart...
for($i = 0; $i < count($incart_product_ids); $i++){
    //Reject if desired quantity is more than quantity in stock
    if($incart_desired_quantities[$i] > $inproducts_stocks[$i]){
        flash("Quantity of " . $inproducts_names[$i] . " exceeds stock. Please reduce to " . $inproducts_stocks[$i] . " or less.");
        die(header("Location: cart.php"));
    }
    //Add product of quantity from cart, and price from products table, to grand sum
    $grand_sum += $incart_desired_quantities[$i] * $inproducts_costs[$i];
}

//On submit
if (isset($_POST['submit'])) {
    //Reject if user lacks sufficient funds
    if($grand_sum > $_POST['users_money']){
        flash("Insufficient funds");
        die(header("Location: cart.php"));
    }
    

    //Address validation
    $errors = [];
    $has_error = false;
    if(isset($_POST['zip']) and $_POST['zip'] !== '' and (!is_numeric($_POST['zip']) or strlen($_POST['zip']) !== 5)){
        $has_error = true;
        array_push($errors, "Please enter a valid zip code");
    }
    if(strpos($_POST['fname'] . $_POST['lname'] . $_POST['city'] . $_POST['state'] . $_POST['country'] . $_POST['zip'] . $_POST['apart'] . $_POST['address'], ', ' ) !== false){
        $has_error = true;
        array_push($errors, "Please don't have a comma and a space like ', ' in to your address info");
    }
    if($has_error){
        foreach($errors as $error){
            flash($error);
        }
    }
    else {
    //Get information from form and insert into Orders
    $address_string = $_POST['fname'] . ', ' . $_POST['lname'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] . ', ' . $_POST['zip'] . ', ' . $_POST['apart'] . ', ' . $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $stmt = $db->prepare("INSERT INTO Orders (user_id, total_price, payment_method, address) VALUES(:user_id, :total_price, :payment_method, :address)");
    try {
        $stmt->execute([":user_id" => $user_id, ":total_price" => $grand_sum, ":payment_method" => $payment_method, ":address" => $address_string]);
    } catch (Exception $e) {
        flash("<pre>" . var_export($e, true) . "</pre>");
    } 
    //Get order id of order that was just inserted
    $new_order_id = 0;
    $stmt = $db->prepare("SELECT id from Orders ORDER BY id DESC LIMIT 1");
    try {
        $stmt->execute([]);
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $results = $r;
        }
    } catch (PDOException $e) {
        flash("<pre>" . var_export($e, true) . "</pre>");
    }
    foreach($results as $index => $record){
        $new_order_id = $record["id"];
    }
    for($i = 0; $i < count($incart_product_ids); $i++){
        //Insert purchased items into OrderItems table using new order id and arrays from cart table
        $stmt = $db->prepare("INSERT INTO OrderItems (order_id, product_id, quantity, unit_price) VALUES(:order_id, :product_id, :quantity, :unit_price)");
        try {
            $stmt->execute([":order_id" => $new_order_id, ":product_id" => $incart_product_ids[$i], ":quantity" => $incart_desired_quantities[$i], ":unit_price" => $inproducts_costs[$i]]);
        } catch (Exception $e) {
            flash("<pre>" . var_export($e, true) . "</pre>");
        } 
        //Subtract from Products table
        $stmt = $db->prepare("UPDATE Products SET stock = :stock WHERE id = :id");
        try {
            $stmt->execute([":stock" => $inproducts_stocks[$i]-$incart_desired_quantities[$i], ":id" => $incart_product_ids[$i]]);
        } catch (Exception $e) {
            flash("<pre>" . var_export($e, true) . "</pre>");
        }
    }
    //Clear user's cart
    $stmt = $db->prepare("DELETE FROM CartItems WHERE user_id = :user_id");
    try {
        $stmt->execute([":user_id" => $_SESSION["user"]["id"]]);
    } catch (Exception $e) {
        flash("<pre>" . var_export($e, true) . "</pre>");
    }
    flash("Order placed");
    die(header("Location: order_confirmation.php?id=" . $new_order_id));
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
        width: 450px;
        height: 500px;
    }

</style>
<div class="container-fluid">
    <h1>Total: $<?php echo($grand_sum)?></h1>
    <form method="POST">
        <div>
            <label>Required Address Information</label><br>
            <input type="text" placeholder="First name" name="fname" required/><br>
            <input type="text" placeholder="Last name" name="lname" required/><br>
            <input type="text" placeholder="City" name="city"required /><br>
            <input type="text" placeholder="State/Province" name="state"required/><br>
            <input type="text" placeholder="Country" name="country" required/><br>
            <input type="text" placeholder="Street address" name="address" required/><br>
            <label>Optional Address Information</label><br>
            <input type="text" placeholder="Zip/Postal code" name="zip" value=""/><br>
            <input type="text" placeholder="Apartment, suite, etc" name="apart" value=""/><br>
        </div>
        <div>
            <label>Payment Method</label><br>
            <select name="payment_method" value="Visa"><br>
                <option value="Visa">Visa</option>
                <option value="Master Card">Master card</option>
                <option value="American Express">American Express</option>
                <option value="Discover">Discover</option>
                <option value="Amex">Amex</option>
                <option value="Cash">Cash</option>
            </select>
        </div>
        <div>
        <input type="number" placeholder="Money" name="users_money"/>
        <input type="submit" value="Purchase" name="submit" />
        </div>
    </form>

</div>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>