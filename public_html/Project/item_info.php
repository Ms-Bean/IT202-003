<?php
require(__DIR__ . "/../../partials/nav.php");

$result = [];
$columns = get_columns("Products");
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
?>
<style>

</style>
<div class="item_info">
    <h1><?php echo($result["name"])?></h1>
    <?php foreach ($result as $column => $value) : ?>
    <?php 
        if($column === "name"){
            
        }
        else{
            $v = se($column) . ": " . se($value, null, "N/A", false) . "<br>";
            echo $v;
        }
    ?>
    <?php endforeach; ?>
    <?php
        if(has_role("Admin")){
            echo('<a href="admin/edit_item.php?id=');
            echo($id);
            echo('">Edit</a><br>');
        }
        if(is_logged_in()){
            echo('<a href="add_to_cart.php?id=');
            echo($id);
            echo('">Add to cart</a><br>');
        }
        
    ?>
</div>
<br>
<div class="add_rating">
<?php
if(is_logged_in()){echo<<<KEIYOUDOUSHI
    <h1>Rate Item</h1>
    <form method="POST">
        <div>
            <input type="number" min="1" max="5" name="rating_input" placeholder="Rating" required />
        </div>
        <div>
            <textarea name="comment_input" placeholder="Comment" maxlength="150" required></textarea>
        </div>
        <div>
        <input type="submit" value="Add to cart" name="submit" />
        </div>
    </form>
KEIYOUDOUSHI;}
else{
    echo<<<A
    <h1>Log in to rate item</h1>
    A;
}
?>
</div>
<?php
if(is_logged_in()){
    if(isset($_POST["submit"])){
        $errors = [];
        if(isset($_POST["rating_input"]) and isset($_POST["comment_input"])){
            if($_POST["rating_input"] < 1 or $_POST["rating_input"] > 5){
                array_push($errors, "Invalid rating");
            }
            if(strlen($_POST["comment_input"]) > 150){
                array_push($errors, "Comment is over 150 characters");
            }
        }
        else{
            array_push($errors, "One or more fields are blank");
        }
        if(!empty($errors)){
            foreach($errors as $error){
                flash($error);
            }
        }
        else{
            $comment = $_POST["comment_input"];
            $rating = $_POST["rating_input"];
            $stmt = $db->prepare("INSERT INTO Ratings (product_id, user_id, rating, comment) VALUES(:product_id, :user_id, :rating, :comment)");
            try {
                $stmt->execute([":product_id" => $id, ":user_id" => $_SESSION["user"]["id"], ":rating" => $rating, "comment" => $comment]);
                flash("You've registered");
            } catch (Exception $e) {
                echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
            }
        }
    }
}

?>
<?php
//Get ratings
$stmt = $db->prepare("SELECT rating, comment, user_id FROM Ratings WHERE product_id =:id");
try {
    $stmt->execute([":id" => $id]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $result = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
//Add rating cards to page
foreach($result as $index => $record){
    //Get user info for each rating
    $stmt = $db->prepare("SELECT email, visibility, username FROM Users WHERE id =:id");
    try {
        $stmt->execute([":id" => $record["user_id"]]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $user_result = $r;
        }
    } catch (PDOException $e) {
        flash("<pre>" . var_export($e, true) . "</pre>");
    }
    echo("<div class='rating_card'>");
    if($user_result["visibility"] !== 'false'){
        echo("Email: " . $user_result["email"] . "<br>");
    }
    else{
        echo("Private Email");
    }
    echo("Rating: ");
    for($x = 0; $x < $record["rating"]; $x++){
        echo("⭐");
    }
    echo("<br><br>
    <i>". $record["comment"] . "</i><br>
    - ". $user_result["username"] . "<br>
    </div><br>
    ");
}
?>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>