<?php
require('../model/database.php');
require('../model/customer_db.php');
require('../model/product_db.php');
require('../model/registration_db.php');

//Start session
$lifetime = 60 * 60 * 24 * 14;
session_set_cookie_params($lifetime, '/');
session_start();

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if (isset($_SESSION['customer_id'])) {
        $action = 'get_customer';
    }
    else if ($action === NULL) {
        $action = 'login_customer';
    }
}

//instantiate variable(s)
$email = '';
$customer_id = 0;

switch ($action) {
case 'login_customer' :
    include('customer_login.php');
    break;
case 'get_customer' :
    $email = filter_input(INPUT_POST, 'email');
    $customer = get_customer_by_email($email);
    $products = get_products();
    $_SESSION['customer_id'] = $customer_id;
    $_SESSION['email'] = $email;

    $logged_message = "You are logged in as $email";
    
    $name = 'customer_id';
    $value = $customer_id;
    $expire = strtotime('+1 year');
    $path = '/';
    setcookie($name, $value, $expire, $path);
    
    include('product_register.php');
    break;
case 'register_product' :
    //$customer_id = filter_input(INPUT_POST, 'customer_id');
    $customer_id = filter_input(INPUT_COOKIE, 'customer_id', FILTER_VALIDATE_INT);
    $product_code = filter_input(INPUT_POST, 'product_code');
    add_registration($customer_id, $product_code);
    $message = "Product ($product_code) was registered successfully.";
    include('product_register.php');
    break;
case 'log_out' :
    $_SESSION = array();
    session_destroy();
    
    $name = session_name();
    $expire = strtotime('-1 year');
    $params = session_get_cookie_params();
    $path = $params['path'];
    $domain = $params['domain'];

    setcookie($name, '', $expire, $path, $domain);
    include('customer_login.php');
    break;
}
?>