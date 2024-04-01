<?php

include 'partials/header.php';

// Fetch user data
$current_user_id = $_SESSION['user-id'];
$q = "SELECT * FROM users WHERE id = $current_user_id LIMIT 1";
$r = mysqli_query($connection, $q);
$u = mysqli_fetch_assoc($r);

// Check if the user is an admin
$is_admin = $u['is_admin'];

// Define variables for query
$selectColumns = "post_id, post_title, post_category_id, post_author_id";
$orderClause = "ORDER BY post_id DESC";
$is_privileged = false;

// If the user is an admin, fetch all posts
if ($is_admin == 1 || $is_admin == 2) {
    $query = "SELECT $selectColumns FROM posts $orderClause";
    $is_privileged = true;
}
// If the user is not an admin, fetch only their posts
else {
    $query = "SELECT $selectColumns FROM posts WHERE post_author_id = $current_user_id $orderClause";
}

// Fetch posts
$posts = mysqli_query($connection, $query);
?>

<section class="dashboard">
        <?php if (isset($_SESSION['add-post-success'])):// shows if add post was successful?>
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['add-post-success'];
                        unset($_SESSION['add-post-success']);
                        ?>
                    </p>
                </div>
        <?php elseif (isset($_SESSION['edit-post-success'])):// shows if edit post was successful?>
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['edit-post-success'];
                        unset($_SESSION['edit-post-success']);
                        ?>
                    </p>
                </div>
        <?php elseif (isset($_SESSION['delete-post'])):// shows if delete post was not successful?>
                <div class="alert__message error container">
                    <p>
                        <?= $_SESSION['delete-post'];
                        unset($_SESSION['delete-post']);
                        ?>
                    </p>
                </div>
        <?php elseif (isset($_SESSION['delete-post-success'])):// shows if delete post was successful?>
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['delete-post-success'];
                        unset($_SESSION['delete-post-success']);
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
                    <li><a href="index.php" class="active"><i class="uil uil-dashboard"  class="active"></i><h5>Manage Posts</h5></a></li>
                    <?php if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']==1):?>
                    <li><a href="add-user.php"><i class="uil uil-user-plus"></i><h5>Add User</h5></a></li>
                    <li><a href="manage-users.php" ><i class="uil uil-user-arrows"></i><h5>Manage Users</h5></a></li>
                    <li><a href="add-category.php"><i class="uil uil-lightbulb-alt"></i><h5>Add Category</h5></a></li>
                    <li><a href="manage-categories.php"><i class="uil uil-list-ui-alt"></i><h5>Manage Categories</h5></a></li>
                    <?php endif?>
                    <?php if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']==2) :?>
                        <li><a href="add-category.php"><i class="uil uil-lightbulb-alt"></i><h5>Add Category</h5></a></li>
                        <li><a href="manage-categories.php"><i class="uil uil-list-ui-alt"></i><h5>Manage Categories</h5></a></li>
                    <?php endif?>
                </ul>
            </aside>

        <main>
            <h2>Manage Posts</h2>

            <?php if (mysqli_num_rows($posts) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                            <?php
                            // Fetch category title
                            $cat_id = $post['post_category_id'];
                            $cat_query = "SELECT cat_title FROM categories WHERE cat_id = $cat_id";
                            $cat_result = mysqli_query($connection, $cat_query);
                            $category = mysqli_fetch_assoc($cat_result);

                            // Fetch author name
                            $post_author_id = $post['post_author_id'];
                            $auth_query = "SELECT firstname,lastname FROM users WHERE id = $post_author_id";
                            $auth_result = mysqli_query($connection, $auth_query);
                            $author = mysqli_fetch_assoc($auth_result);
                            ?>
                            <tr>
                                <td><?= $post['post_title'] ?></td>
                                <td><?= $category['cat_title'] ?></td>
                                <td><?= "{$author['firstname']} {$author['lastname']}" ?></td>
                                <td><a href="<?=ROOT_URL?>admin/edit-post.php?id=<?=$post['post_id']?>" class="btn sm">Edit</a></td>
                                <?php if((isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']==1) || $current_user_id == $post_author_id):?>
                                    <td><a href="<?=ROOT_URL?>admin/delete-post.php?id=<?=$post['post_id']?>" class="btn sm danger">Delete</a></td>
                                <?php endif?>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error">
                    <?= "Start Posting!! You dont have any posts yet" ?>
                </div>
            <?php endif ?>
        </main>
    </div>
</section>

<?php
include '../partials/footer.php';
?>

