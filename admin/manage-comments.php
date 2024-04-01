<?php
include 'partials/header.php';

//fetch users from database but not current user
$current_user_id = $_SESSION['user-id'];
$query = "SELECT * FROM users WHERE id=$current_user_id";
$row = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($row);
$is_admin = $user['is_admin'];
if ($is_admin == 1 || $is_admin == 2){
    $query = "SELECT * FROM comments";
}else{
    $query = "SELECT * FROM comments WHERE comment_user_id=$current_user_id";
}
$comments = mysqli_query($connection, $query);
?>
    <section class="dashboard">
        <?php if (isset($_SESSION['edit-comment-success'])):// shows if edit commentles was successful?>
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['edit-comment-success'];
                        unset($_SESSION['edit-comment-success']);
                        ?>
                    </p>
                </div>
        <?php elseif (isset($_SESSION['delete-comment'])):// shows if delete comment was not successful?>
                <div class="alert__message error container">
                    <p>
                        <?= $_SESSION['delete-comment'];
                        unset($_SESSION['delete-comment']);
                        ?>
                    </p>
                </div>
        <?php elseif (isset($_SESSION['delete-comment-success'])):// shows if delete comment was successful?>
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['delete-comment-success'];
                        unset($_SESSION['delete-comment-success']);
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
                    <li><a href="manage-comments.php" class="active"><i class="uil uil-edit"></i><h5>Manage Comments</h5></a></li>
                    <li><a href="add-post.php"><i class="uil uil-file-plus"></i><h5>Add Post</h5></a></li>
                    <li><a href="index.php"><i class="uil uil-dashboard"></i><h5>Manage Posts</h5></a></li>
                    <?php if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']==1):
                    ?>
                    <li><a href="add-user.php"><i class="uil uil-user-plus"></i><h5>Add User</h5></a></li>
                    <li><a href="manage-users.php" ><i class="uil uil-user-arrows"></i><h5>Manage Users</h5></a></li>
                    <li><a href="add-category.php"><i class="uil uil-lightbulb-alt"></i><h5>Add Category</h5></a></li>
                    <li><a href="manage-categories.php"><i class="uil uil-list-ui-alt"></i><h5>Manage Categories</h5></a></li>
                    <?php elseif(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']==2) :?>
                        <li><a href="add-category.php"><i class="uil uil-lightbulb-alt"></i><h5>Add Category</h5></a></li>
                        <li><a href="manage-categories.php"><i class="uil uil-list-ui-alt"></i><h5>Manage Categories</h5></a></li>
                    <?php endif?>
                </ul>
            </aside>
            <main>
                <h2> Manage Comments </h2>
                <?php if(mysqli_num_rows($comments)> 0)  :?>
                <table>
                    <thead>
                        <tr>
                            <th>Post</th>
                            <th>Comment</th>
                            <?php 
                            if($is_admin == 2 || $is_admin == 1):?>
                                <th>Author</th>
                                <th>Featured</th>
                                <th>Hidden</th>
                            <?php endif?>
                            <th>Likes</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($comment = mysqli_fetch_assoc($comments)) : ?>
                        <tr>
                            <?php 
                            $query = "SELECT * FROM posts WHERE post_id=$comment[comment_post_id]";
                            $result = mysqli_query($connection, $query);
                            $post = mysqli_fetch_assoc($result);
                            $post_title = $post['post_title'];
                            $query = "SELECT * FROM users WHERE id=$comment[comment_user_id]";
                            $result = mysqli_query($connection, $query);
                            $user = mysqli_fetch_assoc($result);
                            $username = "{$user['firstname']} {$user['lastname']}";
                            ?>
                            <td><?= "{$post_title}"?></td>
                            <td><?= "{$comment['comment_text']}"?></td>
                            <?php if($is_admin == 1 || $is_admin == 2):?>
                                <td><?=$username?></td>
                            <?php endif?>
                            <?php if($is_admin == 1 || $is_admin == 2):?>
                                <td><?php $feature = ($comment["comment_featured"] == 1) ? "YES" : "NO"; echo $feature;?></td>
                                <td><?php $hidden = ($comment["comment_hide"] == 1) ? "YES" : "NO"; echo $hidden; ?></td>
                            <?php endif?>
                            <td><?= $comment['comment_likes'] ?></td>
                            <?php if ($comment['comment_user_id'] != $current_user_id && $is_admin == (1 || 2)):?>
                                    <td><a href="<?= ROOT_URL?>admin/edit-comment.php?id=<?= $comment['comment_id'] ?>" class="btn sm">Update</a></td>
                                    <td></td>
                                <?php elseif($comment['comment_user_id'] == $current_user_id):?>
                                    <td><a href="<?= ROOT_URL?>admin/edit-comment.php?id=<?= $comment['comment_id'] ?>" class="btn sm">Update</a></td>
                                    <td><a href="<?= ROOT_URL?>admin/delete-comment.php?id=<?= $comment['comment_id'] ?>" class="btn sm danger">Delete</a></td>
                            <?php endif?>
                        </tr>
                        <?php endwhile?>
                    </tbody>
                </table>
                <?php else:?>
                    <div class="alert__message error">
                        <?= "No comments found"?>
                    </div>
                <?php endif?>
            </main>
        </div>
    </section>
<?php
include '../partials/footer.php';
?>
