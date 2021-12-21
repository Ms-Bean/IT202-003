<?php
require(__DIR__ . "/../../partials/nav.php");

$result = [];
$PER_PAGE = 10;
$current_page = 0;
if(isset($_GET["current_page"])){
    $current_page = $_GET["current_page"];
}
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
        if($column === "name" or $column === "average_rating"){
            
        }
        else{
            $v = se($column) . ": " . se($value, null, "N/A", false) . "<br>";
            echo $v;
        }
    ?>
    <?php endforeach; ?>
    <h2 id = "avrating">Average Rating: </h2>
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
if(is_logged_in()){echo<<<A
    <h1>Rate Item</h1>
    <form method="POST">
        <div>
            <label for="rating_input">Rating</label>
            <input type="number" min="1" max="5" name="rating_input" placeholder="rating" required />
        </div>
        <div>
            <textarea name="comment_input" placeholder="Comment" maxlength="150" required></textarea>
        </div>
        <div>
        <input type="submit" value="Add rating" name="submit" />
        </div>
    </form>
A;}
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
                flash("Rating submitted");
            } catch (Exception $e) {
                echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
            }
            $stmt = $db->prepare("SELECT AVG(rating) FROM Ratings where product_id =:product_id");
            try {
                $stmt->execute([":product_id" => $id]);
                $r = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($r) {
                    $averages_result = $r;
                }
            } catch (PDOException $e) {
                flash("<pre>" . var_export($e, true) . "</pre>");
            }
            $stmt = $db->prepare("UPDATE Products SET average_rating = :average_rating WHERE id = :id");
            try {
                $stmt->execute([":average_rating" => $averages_result["AVG(rating)"], ":id" => $id]);
            } catch (Exception $e) {
                flash("<pre>" . var_export($e, true) . "</pre>");
            }
        }
    }
}

?>
<?php

//Get ratings
$sqlstr = "SELECT rating, comment, user_id FROM Ratings WHERE product_id =:id LIMIT 0,10";
$count_str = "SELECT COUNT(*) FROM " . explode('LIMIT', explode('FROM', $sqlstr)[1])[0]; //Circumcise the sql string in order to obtain count
flash($sqlstr);
$stmt = $db->prepare($sqlstr);
try {
    $stmt->execute([":id" => $id]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $rating_result = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
$stmt = $db->prepare($count_str);
try {
    $stmt->execute([":id" => $id]);
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($r) {
        $count_result = $r;
    }
} catch (PDOException $e) {
    flash("<pre>" . var_export($e, true) . "</pre>");
}
echo("<div class='page_traverser'");
if($current_page >= 1){
    echo("<a class='paginate_button' href = item_info.php?id=" . $id . "&current_page=" . $current_page-1 . ">Previous</a>");
}
if(($current_page+1)*$PER_PAGE < $count_result["COUNT(*)"]){
    echo("<a class='paginate_button' href = item_info.php?id=" . $id . "&current_page=" . $current_page+1 . ">Next</a>");
}
    echo("</div>");
//Add rating cards to page
if(isset($rating_result)){
    $average_rating = 0;
    $rating_count = 0;
    foreach($rating_result as $index => $record){
        $average_rating += $record["rating"];
        $rating_count++;
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
            echo("Private Email<br>");
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
    $average_rating /= $rating_count;
    echo("
    <script>
    document.getElementById('avrating').innerHTML = 'Average Rating: ". $average_rating . "'
    </script>
    ");
}
?>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>