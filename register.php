<?php
require("function.php");
session_start();

$_SESSION['token'] = generate_token();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>仮アカウント作成</title>
    <style>
        input, span {
            display: block;
        }
        span{
            font-size: 0.75em;
            color: red;
        }
    </style>
</head>

<body>
    <h2>仮アカウント作成</h2>
    <form action="register_check.php" method="POST">
        <input type="email" name="email" id="email" placeholder="Input Your Email" value="<?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES, "UTF-8");?>">
        <span class="alert email-alert"><?php echo $_SESSION['error'];?></span>
        <button type="submit" name="submit" value="submit">メールアドレスの確認</button>
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, "UTF-8");?>">
    </form>
</body>

</html>