<?php
require 'config/constants.php';

$uname_mail = $_SESSION['login-data']['username_email'] ?? null;
$pwd = $_SESSION['login-data']['password'] ?? null;

unset($_SESSION['login-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Mutlipage Blog Website Using PHP and MySQL</title>
    <!--Custom style sheet-->
    <link rel="stylesheet" href="./css/style.css">
    <!--ICONSCOUT CDN-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!--GOOGLE FONT MONTSERRAT-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Log In</h2>
            <?php if (isset($_SESSION['signup-success'])) : ?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['signup-success'];
                        unset($_SESSION['signup-success']);
                        ?>
                    </p>
                </div>
            <?php elseif(isset($_SESSION['login'])): ?>
            <div class="alert__message error">
                    <p>
                        <?= $_SESSION['login'];
                        unset($_SESSION['login']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>login-logic.php" method="POST">
                <input type="text" name="username_email" value="<?= $uname_mail ?>" placeholder="UserName or Email">
                <input type="password" name="password" value="<?= $pwd ?>" placeholder="Password">
                <button type="submit" name="submit" class="btn">Login</button>
                <small>Dont have an account? <a href="signup.php">Sign Up</a></small>
           </form>
        </div>
    </section>
    <?php
    include 'partials/footer.php';
    ?>