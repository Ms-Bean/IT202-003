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
<head>
<link rel="stylesheet" href=<?php echo __DIR__ . "/../../Project/style.css"; ?>>
</head>
<nav class="nav_bar">
<ul>
        <?php if (is_logged_in()) : ?>
            <li><a href="<?php echo __DIR__ . "/../../Project/home.php"; ?>">Home</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/profile.php"; ?>">Profile</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/shop.php"; ?>">Shop</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/cart.php"; ?>">Cart</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/checkout.php"; ?>">Checkout</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/purchase_history.php"; ?>">History</a></li>
            <li><a href="<?php echo __DIR__ . "/../../Project/logout.php"; ?>">Logout</a></li>
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
    </ul>
</nav>
