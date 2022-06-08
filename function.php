<?php
define('DNS', 'mysql:host=localhost;dbname=xs895197_login');
define('USER_NAME', 'xs895197_test');
define('PASSWORD', 'hdy6hebd72');
define('SENDER_EMAIL', 'example@php-sql-practice.online');

function get_pdo_options()
{
    return array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
        PDO::ATTR_EMULATE_PREPARES => false
    );
}

function generate_token()
{
    $token_legth = 16;
    $bytes = openssl_random_pseudo_bytes($token_legth);
    return bin2hex($bytes);
}

function redirect_to_welcome()
{
    header('HTTP/1.1 301 Moved Permanently');
    header('Location:welcome.php');
    exit();
}

function redirect_to_register()
{
    header('HTTP/1.1 301 Moved Permanently');
    header('Location:register.php');
    exit();
}

function redirect_to_confirm()
{
    header('HTTP/1.1 301 Moved Permanently');
    header('Location:confirm.php');
    exit();
}

function redirect_to_submit()
{
    header('HTTP/1.1 301 Moved Permanently');
    header('Location:submit.php');
    exit();
}

function check($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function return_error_message($data)
{
    $error_msg = array();
    if (preg_match('/[!#<>:;&~@%+$<>「」{}"\'\*\^\(\)\[\]\|\/\.,_-]/', $data)) {
        return $error_msg[] = "入力欄には\"ひらがな\"、\"カタカナ\"、\"英字\"のみをご入力ください。";
    }
}

function check_email($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    if(filter_var($data, FILTER_VALIDATE_EMAIL)){
        return $data;
    }else{
        return false;
    }
}