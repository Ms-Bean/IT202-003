<?php
require(__DIR__."/../../partials/nav.php");?>

<form class="input_section" onsubmit="return validate(this)" method="POST">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" maxlength="30"/>
    </div><br>
    <div>
        <label for="pw">Password</label>
        <input type="password" id="pw" name="password" required minlength="8" />
    </div><br>
    <input type="submit" value="Login" />
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
 if(isset($_POST["email"]) && isset($_POST["password"])){
     //get the email key from $_POST, default to "" if not set, and return the value
     $email = se($_POST, "email","", false);
     //same as above but for password
     $password = se($_POST, "password", "", false);
     //TODO 3: validate/use
     $errors = [];
     $hasErrors = false;
     if(empty($email)){
         flash("Email must be set", "warning");
         $hasErrors = true;
     }
     //sanitize
     $email = filter_var($email, FILTER_SANITIZE_EMAIL);
     //validate
     if(!filter_var($email, FILTER_VALIDATE_EMAIL) || !isset($_POST["email"])){
         flash("Invalid email", "warning");
         $hasErrors = true;
     }
     if(empty($password)){
         flash("Password must be set", "warning");
         $hasErrors = true;
     }
     if(strlen($password) < 8){
         flash("Password must be at least 8 characters", "warning");
         $hasErrors = true;
     }
     if($hasErrors){ 
     }
     else{
        $db = getDB();
        if(isset($_POST["email"])){
            $stmt = $db->prepare("SELECT id, email, username, password from Users where email = :email or username = :email LIMIT 1");
        }
        try {
            $r = $stmt->execute([":email" => $email]);
            if ($r) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $hash = $user["password"];
                    unset($user["password"]);
                    if (password_verify($password, $hash)) {
                        flash("Welcome $email");
                        $_SESSION["user"] = $user;
                        $stmt = $db->prepare("SELECT Roles.name FROM Roles 
                        JOIN UserRoles on Roles.id = UserRoles.role_id 
                        where UserRoles.user_id = :user_id and Roles.is_active = 1 and UserRoles.is_active = 1");
                        $stmt->execute([":user_id" => $user["id"]]);
                        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if ($roles) {
                            $_SESSION["user"]["roles"] = $roles; 
                        } else {
                            $_SESSION["user"]["roles"] = [];
                        }
                        die(header("Location: home.php"));
                    } else {
                        flash("Incorrect password");
                    }
                } else {
                    flash("User not found", "danger");
                }
            }
        } catch (Exception $e) {
            flash("<pre>" . var_export($e, true) . "</pre>");
        }
     } 
 }
?>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>