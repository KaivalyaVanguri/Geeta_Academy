<?php
include 'partials/header.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // Close the statement
    mysqli_stmt_close($stmt);
}else{
    header('location: '.ROOT_URL.'admin/manage-users.php');
    die();
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit User Credentials</h2>
        <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="POST">
            <input type="hidden" value="<?= $user['id']?>" name="id">
            <input type="text" value="<?= $user['firstname']?>" name="firstname" placeholder="First Name">
            <input type="text" value="<?= $user['lastname']?>" name="lastname" placeholder="Last Name">
            <select name="userrole">
                <option value="-1">Select Privilege</option>
                <option value="0">Creator</option>
                <option value="1">Admin</option>
                <option value="2">Editor</option>
            </select>
            <button type="submit" name="submit" class="btn">Update User</button>
       </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
