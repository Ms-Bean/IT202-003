<?php
require(__DIR__ . "/../../../partials/nav.php");
if(!is_logged_in()){
    flash("You must log in to add to cart.");
    die(header("Location: login.php"));
}
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: $BASE_PATH" . "home.php"));
}
if (isset($_POST["submit"])) {
    if (update_data("Products", $_GET["id"], $_POST)) {
        flash("Updated item", "success");
    }
}

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
    <h1>Edit Item</h1>
    <form method="POST">
        <?php foreach ($result as $column => $value) : ?>
            <?php ?>
            <?php if (!in_array($column, $ignore)) : ?>
                <div class="mb-4">
                    <label class="form-label" for="<?php se($column); ?>"><?php se($column); ?></label>
                    <input class="form-control" id="<?php se($column); ?>" type="<?php echo mapColumn($column); ?>" value="<?php se($value); ?>" name="<?php se($column); ?>" />
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <input class="btn btn-primary" type="submit" value="Update" name="submit" />
    </form>
</div>

<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>