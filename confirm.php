<?php
require_once("function.php");
session_start();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>仮アカウント作成</title>
</head>

<body>
    <?php
    $flug = 0;

    $_SESSION['id'] = $_SESSION['email'];
    $token = $_POST['token'];


    if ($token == $_SESSION['token']) {          
        if (isset($_POST['submit'])) {
            $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
            $query = "INSERT INTO pre_login(email, token) VALUES ('$_SESSION[email]', '$token')";
            $stmt = $pdo->query($query);

            mb_language("Japanese");
            mb_internal_encoding("UTF-8");

            $to = $_SESSION['email'];
            $subject = '本アカウント登録用ページ';
            $message = 'https://php-sql-practice.online/php_form_login/submit.php?urltoken=' . $token . "\r\n";
            $headers = 'From: example@php-sql-practice.online';

            $flug = 1;

            mb_send_mail($to, $subject, $message, $headers);
            unset($_SESSION['email']);
            unset($_SESSION['token']);
        } elseif (isset($_POST['back'])) {
            redirect_to_register();
        }
    } 
    ?>

    <?php if ($flug == 1) : ?>
        <h2>メールをご確認ください。</h2>

    <?php elseif ($flug == 0) : ?>
        <h2>メールアドレスの確認</h2>
        <form action="" method="POST">
            <h3><?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES, "UTF-8"); ?></h3>
            <button type="submit" name="submit" value="submit">本アカウント作成用のページを送信(メールが送信されます。)</button>
            <button type="submit" name="back" value="back">戻る</button>
            <input type="hidden" name="token" value=<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, "UTF-8"); ?>>
        </form>

    <?php endif; ?>

</body>

</html>