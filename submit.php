<?php
require_once('function.php');
session_start();

$_SESSION['token'] = generate_token();

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>本アカウント登録</title>
    <style>
        input {
            display: block;
        }
    </style>
</head>

<body>
    <?php
    $flug = 0;
    $_SESSION['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (isset($_POST['confirm'])) {
        unset($_SESSION['error']);
        $_SESSION['name'] = $_POST['name'];
        
        $flug = 1;

    } elseif (isset($_POST['submit'])) {
        
        $name = $_SESSION['name'];
        $email = $_SESSION['id'];
        $password = $_SESSION['password'];
        $token = $_POST['token'];

        if ($token == $_SESSION['token']) {
            redirect_to_register();
        }

        $flug = 2;

        $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
        $query = "INSERT INTO user(name, email, password, token) VALUES ('$name', '$email', '$password', '$token')";
        $stmt = $pdo->query($query);
        
    } elseif (isset($_POST['back'])) {
        
        $flug = 0;
    }
    ?>

    <?php if ($flug == 2) : ?>
        <h2>アカウント作成しました。</h2>
        <a href="https://php-sql-practice.online/php_form_login/login.php">ログイン</a>

    <?php elseif ($flug == 1) : ?>
        <h2>本アカウント情報確認</h2>
        <form action="" method="post">
            <p><?php echo htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8"); ?></p>
            <p><?php echo htmlspecialchars($_SESSION['id'], ENT_QUOTES, "UTF-8"); ?></p>
            <p>パスワードはセキュリティ面の観点から表示しません。</p>
            <button type="submit" name="submit" value="submit">アカウント作成</button>
            <button type="submit" name="back" value="back">戻る</button>
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, "UTF-8"); ?>">
        </form>

    <?php else : ?>
        <h2>本アカウント登録</h2>
        <form action="" method="post">
            <input type="text" name="name" id="" placeholder="ユーザーネームを入力してください。" value="<?= $_SESSION['name']; ?>">
            <p><?php echo htmlspecialchars($_SESSION['id'], ENT_QUOTES, "UTF-8"); ?></p>
            <input type="password" name="password" id="" placeholder="パスワードを入力してください">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, "UTF-8"); ?>">
            <p style="color: red; font-size:12px;"><?= $_SESSION['error']; ?></p>
            <button type="submit" name="confirm" value="confirm">入力内容の確認</button>
        </form>
    <?php endif; ?>
</body>

</html>