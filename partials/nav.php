<?php
//Note: this is to resolve cookie issues with port numbers
$domain = $_SERVER["HTTP_HOST"];
if (strpos($domain, ":")) {
    $domain = explode(":", $domain)[0];
}
$localWorks = true; //some people have issues with localhost for the cookie params
//if you're one of those people make this false

//this is an extra condition added to "resolve" the localhost issue for the session cookie
if (($localWorks && $domain == "localhost") || $domain != "localhost") {
    session_set_cookie_params([
        "lifetime" => 60 * 60,
        "path" => "/Project",
        //"domain" => $_SERVER["HTTP_HOST"] || "localhost",
        "domain" => $domain,
        "secure" => true,
        "httponly" => true,
        "samesite" => "lax"
    ]);
}
session_start();
require_once(__DIR__ . "/../lib/functions.php");

?>
<style>
    li{
        display: inline;
        margin-right: 10px;
    }
    .nav_bar{
        border: 1px solid black;
        box-shadow: 5px 5px black;
        padding: 10px;
        background-color: #a2eda1;
        width: 100%;
        margin-bottom: 30px;
    }
    html{
        font-family: verdana;
    }
    .item_info{
        position: fixed;
        left: 50%;
        margin-left: -150px;
        position: relative;
        margin-bottom: 50px;
        border: 1px solid black;
        box-shadow: 5px 5px black;
        padding: 10px;
        background-color: #a2eda1;
        width: 400px;
        height: 600px;
        text-align: left;
    }
    .rating_card{
        position: fixed;
        left: 50%;
        margin-left: -150px;
        position: relative;
        margin-bottom: 50px;
        border: 1px solid black;
        box-shadow: 5px 5px black;
        padding: 10px;
        background-color: #a2eda1;
        width: 400px;
        height: 200px;
        text-align: left;
    }
    .info_card{
        position: fixed;
        left: 50%;
        margin-left: -150px;
        position: relative;
        margin-bottom: 50px;
        border: 1px solid black;
        box-shadow: 5px 5px black;
        padding: 10px;
        background-color: #a2eda1;
        width: 400px;
        height: 300px;
        text-align: left;
    }
    .add_rating{
        position: fixed;
        left: 50%;
        margin-left: -150px;
        position: relative;
        margin-bottom: 50px;
        border: 1px solid black;
        box-shadow: 5px 5px black;
        padding: 10px;
        background-color: #a2eda1;
        width: 400px;
        height: 300px;
        text-align: left;
    }
    
    .cart_item{
        position: fixed;
        left: 50%;
        margin-left: -150px;
        position: relative;
        margin-bottom: 50px;
        border: 1px solid black;
        box-shadow: 5px 5px black;
        padding: 10px;
        background-color: #a2eda1;
        width: 300px;
        height: 200px;
        text-align: left;
    }
    .order_info{
        position: fixed;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        margin-bottom: 50px;
        border: 1px solid black;
        box-shadow: 5px 5px black;
        padding: 10px;
        background-color: #a2eda1;
        width: 800px;
        height: 300px;
        text-align: left;
    }
    .delete_button{
        position: center;
        text-align: center;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 10px;
        padding-top: 5px;
        margin-bottom: 50px;
        background-color:rgba(255, 85, 107, 0.867);
        border: 2px solid black;
       
    }
    .page_label{
        display: inline-block;
    }
    .paginate_button{
        position: center;
        text-align: center;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 10px;
        padding-top: 5px;
        margin-bottom: 50px;
        background-color:floralwhite;
        border: 2px solid black;
        display: inline-block;
    }
    .form{
        text-align: center;
    }
    .input_section{
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
<nav class="nav_bar">
<ul>
        <?php if (is_logged_in()) : ?>
            <li><a href="<?php echo __DIR__ . "/../../Project/home.php"; ?>">Home</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/profile.php"; ?>">Profile</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/shop.php"; ?>">Shop</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/cart.php"; ?>">Cart</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/checkout.php"; ?>">Checkout</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/purchase_history.php"; ?>">History</a></li>
        <?php endif; ?>
        <?php if (!is_logged_in()) : ?>
            <li><a href="<?php echo __DIR__ . "/../../Project/login.php"; ?>">Login</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/register.php"; ?>">Register</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/shop.php"; ?>">Shop</a></li>
        <?php endif; ?>
        <?php if (has_role("Admin")) : ?>
            <li><a href="<?php echo __DIR__ . "/../../Project/admin/create_role.php"; ?>">Create Role</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/admin/list_roles.php"; ?>">List Roles</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/admin/assign_roles.php"; ?>">Assign Roles</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/admin/add_item.php"; ?>">Add Items</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/admin/list_items.php"; ?>">List Items</a></li>
        <?php endif; ?>
        <?php if (is_logged_in()) : ?>
            <li><a href="<?php echo __DIR__ . "/../../Project/logout.php"; ?>">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>