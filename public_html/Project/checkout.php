<?php
require(__DIR__ . "/../../partials/nav.php");
if(!is_logged_in()){
    flash("You must log in to checkout.");
    die(header("Location: login.php"));
}
$user_id = $_SESSION["user"]["id"];
$results = [];
$db = getDB();
$stmt = $db->prepare("SELECT unit_cost, desired_quantity from CartItems WHERE user_id = :user_id");
try {
    $stmt->execute([":user_id" => $_SESSION["user"]["id"]]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $results = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
$grand_sum = 0;

foreach($results as $index => $record){
    $grand_sum += $record["desired_quantity"] * $record["unit_cost"];
}

if (isset($_POST['submit'])) {
    $address_string = $_POST['fname'] . ', ' . $_POST['lname'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] . ', ' . $_POST['zip'] . ', ' . $_POST['apart'] . ', ' . $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $stmt = $db->prepare("INSERT INTO Orders (user_id, total_price, payment_method, address) VALUES(:user_id, :total_price, :payment_method, :address)");
    try {
        $stmt->execute([":user_id" => $user_id, ":total_price" => $grand_sum, ":payment_method" => $payment_method, ":address" => $address_string]);
    } catch (Exception $e) {
        flash("<pre>" . var_export($e, true) . "</pre>");
    } 
    //Get id of order that was just inserted
    $stmt = $db->prepare("SELECT id from Orders ORDER BY id LIMIT 1");
    try {
        $stmt->execute([]);
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $results = $r;
        }
    } catch (PDOException $e) {
        flash("<pre>" . var_export($e, true) . "</pre>");
    }
    $order_id = 0;
    foreach($results as $index => $record){
        $order_id = $record["id"];
    }
    //Get information from cart items
    $stmt = $db->prepare("SELECT * FROM CartItems WHERE id = :id");
    try {
        $stmt->execute([":user_id" => $_SESSION["user"]["id"]]);
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $results = $r;
        }
    } catch (PDOException $e) {
        flash("<pre>" . var_export($e, true) . "</pre>");
    }
    foreach($results as $index => $record){
        $stmt = $db->prepare("INSERT INTO OrderItems (order_id, product_id, quantity, unit_price) VALUES(:order_id, :product_id, :quantity, :unit_price)");
        try {
            $stmt->execute([":order_id" => $order_id, ":product_id" => $record['product_id'], ":quantity" => $record['desired_quantity'], ":unit_price" => $record['unit_cost']]);
        } catch (Exception $e) {
            flash("<pre>" . var_export($e, true) . "</pre>");
        } 
    }
    $stmt = $db->prepare("DELETE FROM CartItems WHERE user_id = :user_id");
    try {
        $stmt->execute([":user_id" => $_SESSION["user"]["id"]]);
    } catch (Exception $e) {
        flash("<pre>" . var_export($e, true) . "</pre>");
    }
    flash("Order placed");
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
            <label>Required Address Information</label>
            <input type="text" placeholder="First name" name="fname" required/>
            <input type="text" placeholder="Last name" name="lname" required/>
            <input type="text" placeholder="City" name="city"required />
            <input type="text" placeholder="State/Province" name="state"required/>
            <input type="text" placeholder="Country" name="country" required/>
            <input type="text" placeholder="Street address" name="address" required/>
            <label>Optional Address Information</label>
            <input type="text" placeholder="Zip/Postal code" name="zip" value=""/>
            <input type="text" placeholder="Apartment, suite, etc" name="apart" value=""/>
        </div>
        <div>
            <label>Payment Method</label>
            <select name="payment_method" value="Visa">
                <option value="Visa">Visa</option>
                <option value="Master Card">Master card</option>
                <option value="American Express">American Express</option>
                <option value="Discover">Discover</option>
                <option value="Amex">Amex</option>
                <option value="Cash">Cash</option>
            </select>
        </div>
        <div>
        <input type="submit" value="Purchase" name="submit" />
        </div>
    </form>

</div>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>