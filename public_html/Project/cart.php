<?php
require(__DIR__ . "/../../partials/nav.php");

$results = [];
$db = getDB();
$stmt = $db->prepare("SELECT product_id, unit_cost from CartItems WHERE user_id = :user_id");
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
</style>
<div class="container-fluid">
    <h1>Cart</h1>
    <?php
        foreach($results as $index => $record){
            foreach($record as $column => $value){
                echo($column . ": " . $value . "<br>");
            }
        }
    ?>
</div>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>