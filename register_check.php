<?php
require('function.php');
session_start();

$email = check_email($_POST['email']);
$token = $_POST['token'];

$pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());

$mail_query = "SELECT email FROM pre_login";
$stmtMail = $pdo -> query($mail_query);

if ($_SESSION['token'] != $token) {
    redirect_to_register();
}

if (empty($_POST['email'])) {
    $_SESSION['error'] = "未入力です。";
    redirect_to_register();
}

if(!$email){
    $_SESSION['error'] = "有効なメールアドレスを入力してください。";
    redirect_to_register();
}

$cnt = 0;
while ($row = $stmtMail->fetch()){
    if($row['email'] == $email){
        $cnt = $cnt + 1;
    }
}

if($cnt > 0){
    $_SESSION['error'] = 'このメールアドレスはすでに登録されています。';
    redirect_to_register();
}

if($_SESSION['token'] == $token && !empty($_POST['email']) && $email != false && $cnt == 0){
    unset($_SESSION['error']);
    $_SESSION['email'] = $email;
    redirect_to_confirm();
}


