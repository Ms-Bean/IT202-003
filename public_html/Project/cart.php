<?php
require(__DIR__ . "/../../../partials/nav.php");

if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: $BASE_PATH" . "login.php"));
}

$results = [];
$db = getDB();
$stmt = $db->prepare("SELECT product_id, cost from CartItems WHERE id = :id");
try {
    $stmt->execute([":id" => $_SESSION["user"]["id"]]);
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
require_once(__DIR__ . "/../../../partials/flash.php");
?>