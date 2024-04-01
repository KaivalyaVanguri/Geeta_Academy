<?php
include 'partials/header.php';

//fetch categories from database but not uncategorized category
$current_admin_id = $_SESSION['user-id'];
$query = "SELECT * FROM categories ORDER BY cat_id";
$categories = mysqli_query($connection, $query);
?>


    <section class="dashboard">
        <?php if (isset($_SESSION['add-category-success'])):// shows if add category was successful?>
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['add-category-success'];
                        unset($_SESSION['add-category-success']);
                        ?>
                    </p>
                </div>
        <?php elseif (isset($_SESSION['edit-category-success'])):// shows if edit category was successful?>
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['edit-category-success'];
                        unset($_SESSION['edit-category-success']);
                        ?>
                    </p>
                </div>
        <?php elseif (isset($_SESSION['delete-category'])):// shows if delete category was not successful?>
                <div class="alert__message error container">
                    <p>
                        <?= $_SESSION['delete-category'];
                        unset($_SESSION['delete-category']);
                        ?>
                    </p>
                </div>
        <?php elseif (isset($_SESSION['delete-category-success'])):// shows if delete category was successful?>
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['delete-category-success'];
                        unset($_SESSION['delete-category-success']);
                        ?>
                    </p>
                </div>
        <?php endif?>
        <div class="container dashboard__container">
            <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-double-right"></i></button>
            <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-double-left"></i></button>
            <aside>
                <ul>
                    <li><a href="profile-settings.php"><i class="uil uil-setting"></i><h5>Profile Settings</h5></a></li>
                    <li><a href="manage-comments.php"><i class="uil uil-edit"></i><h5>Manage Comments</h5></a></li>
                    <li><a href="add-post.php"><i class="uil uil-file-plus"></i><h5>Add Post</h5></a></li>
                    <li><a href="index.php"><i class="uil uil-dashboard"></i><h5>Manage Posts</h5></a></li>
                    <?php if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']==1):
                    ?>
                    <li><a href="add-user.php"><i class="uil uil-user-plus"></i><h5>Add User</h5></a></li>
                    <li><a href="manage-users.php"><i class="uil uil-user-arrows"></i><h5>Manage Users</h5></a></li>
                    <li><a href="add-category.php"><i class="uil uil-lightbulb-alt"></i><h5>Add Category</h5></a></li>
                    <li><a href="manage-categories.php"  class="active"><i class="uil uil-list-ui-alt"></i><h5>Manage Categories</h5></a></li>
                    <?php elseif(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']==2) :?>
                        <li><a href="add-category.php"><i class="uil uil-lightbulb-alt"></i><h5>Add Category</h5></a></li>
                        <li><a href="manage-categories.php" class="active"><i class="uil uil-list-ui-alt"></i><h5>Manage Categories</h5></a></li>
                    <?php endif?>
                </ul>
            </aside>
            <main>
                <h2> Manage Categories </h2>
                <?php if(mysqli_num_rows($categories)> 0)  :?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($category = mysqli_fetch_assoc($categories) ):?>
                        <tr>
                            <?php if($category['cat_title'] !== 'Uncategorized'):?>
                            <td><?="{$category['cat_title']}" ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?=$category['cat_id']?>" class="btn sm">Edit</a></td>
                            <td><a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?=$category['cat_id']?>" class="btn sm danger">Delete</a></td>
                            <?php endif?>
                        </tr>
                        <?php endwhile?>
                    </tbody>
                </table>
                <?php else:?>
                    <div class="alert__message error">
                        <?= "No categories found"?>
                    </div>
                <?php endif?>
            </main>
        </div>
    </section>

    <?php
include '../partials/footer.php';
?>