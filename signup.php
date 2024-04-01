<?php
require './config/constants.php';

//get back form data if there was a registration error
$fname = $_SESSION['signup-data']['firstname'] ?? null;
$lname = $_SESSION['signup-data']['lastname'] ?? null;
$uname = $_SESSION['signup-data']['username'] ?? null;
$mail = $_SESSION['signup-data']['email'] ?? null;
$cpassword = $_SESSION['signup-data']['createpassword'] ?? null;

//delete signup data session
unset($_SESSION['signup-data']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Mutlipage Blog Website Using PHP and MYSQL</title>
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
            <h2> Sign Up </h2>
            <?php if (isset($_SESSION['signup'])) : ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['signup'];
                        unset($_SESSION['signup']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL?>signup-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="firstname" value="<?= $fname ?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?= $lname ?>" placeholder="Last Name">
                <input type="text" name="username" value="<?= $uname ?>" placeholder="UserName">
                <input type="email" name="email" value="<?= $mail ?>" placeholder="Email">
                <input type="password" name="createpassword" value="<?= $cpassword ?>" placeholder="Create Password">
                <input type="password" name="confirmpassword" placeholder="Confirm Password">
                <div class="form__control">
                    <label for="avatar">
                        User Avatar
                    </label>
                    <input type="file" name="avatar" id="avatar">
                </div>
                <button type="submit" name="submit" class="btn">Sign Up</button>
                <small>Already have an account? <a href="login.php">Log In</a></small>
           </form>
        </div>
    </section>
    <?php
    include 'partials/footer.php';
    ?>