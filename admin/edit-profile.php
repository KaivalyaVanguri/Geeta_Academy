<?php
require 'partials/header.php'; 


// Get back form data if there was a registration error
$fname = $_SESSION['edit-profile']['firstname'] ?? null;
$lname = $_SESSION['edit-profile']['lastname'] ?? null;
$id = $_SESSION['user-id'];
//echo "Checkpoint 1";
// Get back user data from the database
$query = "SELECT * FROM users WHERE id=?";
$stmt = mysqli_prepare($connection, $query);
//echo "Checkpoint 2";
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    //echo "Checkpoint 3";
    if ($user) {
        //echo "Checkpoint 4";
        if (isset($_GET['update'])) {
            $update = $_GET['update'];
            $portion = '';
            echo "Checkpoint 5";
            if ($update == 'fname') {
                $lname = $user['lastname'];
                $portion = 'First Name';
            } elseif ($update == 'lname') {
                $fname = $user['firstname'];
                $portion = 'Last Name';
            } elseif ($update == 'pswd') {
                $fname = $user['firstname'];
                $lname = $user['lastname'];
                $portion = 'Password';
            } elseif ($update == 'avatar') {
                $fname = $user['firstname'];
                $lname = $user['lastname'];
                $portion = 'Avatar';
            }
        } else {
            header('location: '.ROOT_URL.'admin/edit-profile.php');
            die();
            //echo "Checkpoint 6";
        }
    } else {
        header('location: '.ROOT_URL.'admin/edit-profile.php');
        die();
        //echo "Checkpoint 7";
    }
    //echo "Checkpoint 8";
    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    header('location: '.ROOT_URL.'admin/profile-settings.php');
    die();
    //echo "Checkpoint 9";
}

// Delete profile data session
unset($_SESSION['edit-profile']);
?>
<section class="form__section">
    <div class="container form__section-container">
        <h2> Update Your <?php echo $portion?> </h2>
        <form action="<?= ROOT_URL ?>admin/edit-profile-logic.php?update=<?= $update ?>" enctype="multipart/form-data" method="POST">
            <input type="hidden" value="<?= $id?>" name="id">
            <input type="text" name="firstname" value="<?= $fname?>" placeholder="First Name">
            <input type="text" name="lastname" value="<?= $lname?>" placeholder="Last Name">
            <?php if($update !== 'pswd'):?>
            <input type="password" name="password1" placeholder="Password">
            <?php endif?>
            <?php if($update == 'pswd'):?>
            <input type="password" name="password1" placeholder="Old Password">
            <input type="password" name="password2" placeholder="New Password">
            <?php endif?>
            <?php if($update == 'avatar'): ?>
            <div class="form__control" name="avatar-container">
                <label for="avatar">
                    User Avatar
                </label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <?php endif?>
            <button type="submit" name="update" class="btn">Update User</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>