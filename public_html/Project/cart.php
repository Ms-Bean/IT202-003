<?php
require(__DIR__ . "/../../partials/nav.php");

$results = [];
$db = getDB();
$stmt = $db->prepare("SELECT id, product_id, unit_cost, desired_quantity from CartItems WHERE user_id = :user_id");
try {
    $stmt->execute([":user_id" => $_SESSION["user"]["id"]]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $results = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}

?>
<style>
    .cart_item{
        position: fixed;
        left: 50%;
        margin-left: -150px;
        position: relative;
        margin-bottom: 50px;
        border: 1px solid black;
        box-shadow: 5px 5px black;
        padding: 10px;
        background-color: #a2eda1;
        width: 300px;
        height: 100px;
    }
</style>
<div class="container-fluid">
    <h1>Cart</h1>
    <?php
        foreach($results as $index => $record){
            echo("<div class='cart_item'>");
            foreach($record as $column => $value){
                if($column === 'id'){
                    $id = $value;
                }
                else if($column === 'product_id'){
                    $results_products = [];
                    $stmt = $db->prepare("SELECT name from Products WHERE id = :product_id");
                    try {
                        $stmt->execute([":product_id" => $value]);
                        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if ($r) {
                            $results_products = $r;
                            echo("Product: " . $results_products[0]["name"] . "<br>");
                        }
                    } catch (PDOException $e) {
                        flash("<pre>" . var_export($e, true) . "</pre>");
                    }
                }
                else if($column === 'unit_cost'){
                    echo("Cost: " . $value . "<br>");
                }
                else if($column === 'desired_quantity'){
                    echo("Quantity: " . $value . "<br>");
                }
                else{
                    echo($value);
                }
            }
            echo("<a href='admin/edit_item.php?id='");
            echo($id);
            echo('">Edit</a><br>');
            echo("</div><br>");
        }
    ?>
</div>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>