<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<?php //Prevent username and password from being erased on error
$confirm = ''; $password = '';
if(isset($_POST['confirm'])){
    $confirm = $_POST['confirm'];
}
if(isset($_POST['password'])){
    $password = $_POST['password'];
}
?>
<form class="input_section" onsubmit="return validate(this)" method="POST">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" required />
    </div>
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" required maxlength="30" />
    </div>
    <div>
        <label for="pw">Password</label>
        <input value = "<?php echo $password;?>"type="password" id="pw" name="password" required minlength="8" />
    </div>
    <div>
        <label for="confirm">Confirm</label>
        <input value = "<?php echo $confirm;?>"type="password" name="confirm" required minlength="8" />
    </div>
    <div>
        <label for="visibility">Public</label>
        <input type="checkbox" value="visible" name="visibility"/>
    </div>
    <input type="submit" value="Register" />
</form>
<script>
    function validate(form) {
        //TODO 1: implement JavaScript validation
        //ensure it returns false for an error and true for success

        return true;
    }
</script>
<?php
 //TODO 2: add PHP Code
 if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm"])){
    $email = se($_POST, "email", "", false);
    $username = se($_POST, "username", "", false);
    $password = se($_POST, "password", "", false);
    $confirm = se($_POST, "confirm", "", false);
    if(isset($_POST["visibility"])){
        $visibility = "true";
    }
    else{
        $visibility = "false";
    }
    $hasErrors = false;
    if(empty($email)){
        $hasErrors = true;
        flash("Email must be set");
    }
    $email = sanitize_email($email);
    if(!is_valid_email($email)){
        $hasErrors = true;
        flash("Email is invalid");
     }
    if(!preg_match('/^[a-z0-9_-]{3,30}$/', strtolower($username))){
        $hasErrors = true;
        flash("Invalid username, must be alphanumeric");
    }
    if(empty($password)){
        $hasErrors = true;
        flash("Password must be set");
    }
    if(empty($confirm)){
        $hasErrors = true;
        flash("Confirm password must be set");
    }
    if(strlen($password) < 8){
        $hasErrors = true;
        flash("Password must be 8 or more characters");
    }
    if(strlen($password) > 0 && $password !== $confirm){
        $hasErrors = true;
        flash("Passwords must be equal");
    }
    if($hasErrors){
    }
    else {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (email, password, username, visibility) VALUES(:email, :password, :username, :visibility)");
        try {
            $stmt->execute([":email" => $email, ":password" => $hash, ":username" => $username, "visibility" => $visibility]);
            flash("You've registered");
        } catch (Exception $e) {
            $error = var_export($e, true);
            if ($e->errorInfo[1] === 1062) {
                preg_match("/Users.(\w+)/", $e->errorInfo[2], $matches);
                if (isset($matches[1])) {
                    flash("The chosen " . $matches[1] . " is not available.");
                } else {
                    flash("Duplicate information was found.");
                }
            } 
            else {
                flash("There was a problem registering");
                flash("<pre>" . $error . "</pre>");
            }
        }
    }
 }
?>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>