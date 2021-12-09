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
    foreach($record as $column => $value){
        if($grand_sum == 0){
            $grand_sum += $value;
        }
        else{
            $grand_sum *= $value;
        }
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
        width: 300px;
        height: 300px;
    }

</style>
<div class="container-fluid">
    <h1><?php echo($grand_sum)?></h1>
    

</div>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>