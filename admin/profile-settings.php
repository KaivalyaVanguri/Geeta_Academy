<?php
include 'partials/header.php';

//fetch users from database
$current_id = $_SESSION['user-id'];
$query = "SELECT * FROM users WHERE id=$current_id";
$users = mysqli_query($connection, $query);
?>


    <section class="dashboard">
        <?php if (isset($_SESSION['add-user-success'])):?>
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['add-user-success'];
                        unset($_SESSION['add-user-success']);
                        ?>
                    </p>
                </div>
        <?php elseif (isset($_SESSION['edit-profile-success'])):// shows if edit profile was successful?>
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['edit-profile-success'];
                        unset($_SESSION['edit-profile-success']);
                        ?>
                    </p>
                </div>
        <?php elseif (isset($_SESSION['edit-profile'])):// shows if edit profile was not successful?>
                <div class="alert__message error container">
                    <p>
                        <?= $_SESSION['edit-profile'];
                        unset($_SESSION['edit-profile']);
                        ?>
                    </p>
                </div>
        <?php endif?>
        <div class="container dashboard__container">
            
            <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-double-right"></i></button>
            <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-double-left"></i></button>
            <aside>
                <ul>
                    <li><a href="add-post.php" class="active"><i class="uil uil-setting"></i><h5>Profile Settings</h5></a></li>
                    <li><a href="manage-comments.php"><i class="uil uil-edit"></i><h5>Manage Comments</h5></a></li>
                    <li><a href="add-post.php"><i class="uil uil-file-plus"></i><h5>Add Post</h5></a></li>
                    <li><a href="index.php"><i class="uil uil-dashboard"></i><h5>Manage Posts</h5></a></li>
                    <?php if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']==1):
                    ?>
                    <li><a href="add-user.php"><i class="uil uil-user-plus"></i><h5>Add User</h5></a></li>
                    <li><a href="manage-users.php"><i class="uil uil-user-arrows"></i><h5>Manage Users</h5></a></li>
                    <li><a href="add-category.php"><i class="uil uil-lightbulb-alt"></i><h5>Add Category</h5></a></li>
                    <li><a href="manage-categories.php"><i class="uil uil-list-ui-alt"></i><h5>Manage Categories</h5></a></li>
                    <?php elseif(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']==2) :?>
                        <li><a href="add-category.php"><i class="uil uil-lightbulb-alt"></i><h5>Add Category</h5></a></li>
                        <li><a href="manage-categories.php"><i class="uil uil-list-ui-alt"></i><h5>Manage Categories</h5></a></li>
                    <?php endif?>
                </ul>
            </aside>
            <main>
                <h2> Edit Your Profile </h2>
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Avatar</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($user = mysqli_fetch_assoc($users)) : ?>
                        <tr>
                            <td><?= "{$user['firstname']}"?> <a href="<?= ROOT_URL?>admin/edit-profile.php?update=fname" class="btn sm" method="GET">Edit</a></td>
                            <td><?= "{$user['lastname']}"?> <a href="<?= ROOT_URL?>admin/edit-profile.php?update=lname" class="btn sm" method="GET">Edit</a></td>
                            <td><?= "{$user['avatar']}"?> <a href="<?= ROOT_URL?>admin/edit-profile.php?update=avatar" class="btn sm" method="GET"><center>Edit Avatar</center></a></td>
                            <td><a href="<?= ROOT_URL?>admin/edit-profile.php?update=pswd" class="btn sm" method="GET"><center>Update Password</center></a></td>
                        </tr>
                        <?php endwhile?>
                    </tbody>
                </table>
            </main>
        </div>
    </section>


    <?php
include '../partials/footer.php';
?>