<?php
require(__DIR__ . "/../../partials/nav.php");

$result = [];
$columns = get_columns("Products");
$ignore = ["id", "modified", "created"];
$db = getDB();
$id = se($_GET, "id", -1, false);
$stmt = $db->prepare("SELECT * FROM Products where id =:id");
try {
    $stmt->execute([":id" => $id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        $result = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
function mapColumn($col)
{
    global $columns;
    foreach ($columns as $c) {
        if ($c["Field"] === $col) {
            return inputMap($c["Type"]);
        }
    }
    return "text";
}
?>
<div class="container-fluid">
    <?php foreach ($result as $column => $value) : ?>
    <?php 
        $v = se($value, null, "N/A", false);
        echo $v;
    ?>
    <?php endforeach; ?>
</div>

<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>