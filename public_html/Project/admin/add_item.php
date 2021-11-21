<?php
require(__DIR__. "/../../../partials/nav.php");
if(!has_role("Admin")){
    die(header("Location: $BASE_PATH" . "home.php"));
}
if($isset($_POST["submit"])) {
    $id = save_data("ITEMS", $_POST);
    if($id > 0) {
        flash("Item created, id $id", "success");
    }
}
$columns = get_columns("Items");
$ignore = ["id", "modified", "created"];
?>
<div class="container-fluid">
    <h1>Add Item</h1>
    <form method="POST">
        <?php foreach ($columns as $index => $column) : ?>
            <?php /* Lazily ignoring fields via hardcoded array*/ ?>
            <?php if (!in_array($column["Field"], $ignore)) : ?>
                <div class="mb-4">
                    <label class="form-label" for="<?php se($column, "Field"); ?>"><?php se($column, "Field"); ?></label>
                    <input class="form-control" id="<?php se($column, "Field"); ?>" type="<?php echo inputMap(se($column, "Type", "", false)); ?>" name="<?php se($column, "Field"); ?>" />
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <input class="btn btn-primary" type="submit" value="Create" name="submit" />
    </form>
</div>
<?php __DIR__. "/../../../partials/flash.php"?>