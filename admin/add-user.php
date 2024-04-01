<?php
include 'partials/header.php';

//get back form data if there was a registration error
$fname = $_SESSION['add-user-data']['firstname'] ?? null;
$lname = $_SESSION['add-user-data']['lastname'] ?? null;
$uname = $_SESSION['add-user-data']['username'] ?? null;
$mail = $_SESSION['add-user-data']['email'] ?? null;
$cpassword = $_SESSION['add-user-data']['createpassword'] ?? null;

//delete add-user data session
unset($_SESSION['add-user-data']);
?>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add User</h2>
            <?php if (isset($_SESSION['add-user'])) : ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['add-user'];
                        unset($_SESSION['add-user']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL?>admin/add-user-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" value="<?= $fname ?>" name="firstname" placeholder="First Name">
                <input type="text" value="<?= $lname ?>" name="lastname" placeholder="Last Name">
                <input type="text" value="<?= $uname ?>" name="username" placeholder="UserName">
                <input type="email" value="<?= $mail ?>" name="email" placeholder="Email">
                <input type="password" value="<?= $cpassword ?>" name="createpassword" placeholder="Create Password">
                <input type="password" name="confirmpassword" placeholder="Confirm Password">
                <select name="userrole" >
                    <option value="-1">Select Privilege</option>
                    <option value="0">Content Creator</option>
                    <option value="1">Administrator</option>
                    <option value="2">Editor</option>
                </select>
                <div class="form__control">
                    <label for="avatar">User Avatar</label>
                    <input type="file" name="avatar" id="avatar">
                </div>
                <button type="submit" name="submit" class="btn">Add User</button>
           </form>
        </div>
    </section>
    <?php
include '../partials/footer.php'
?>