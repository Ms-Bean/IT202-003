<?php
require(__DIR__."/../../partials/nav.php");
?>
<style>
  .home_page{
        position: fixed;
        left: 50%;
        margin-left: -150px;
        border: 1px solid black;
        box-shadow: 5px 5px black;
        padding: 10px;
        background-color: #a2eda1;
        width: 300px;
        height: 200px;
    }
</style>
<div class = "home_page">
<h1>Home</h1>
<?php
if(is_logged_in()){
 echo "Welcome, " . $_SESSION["user"]["email"]; 
}
else{
  die(header("Location: login.php"));
}
?>
</div>