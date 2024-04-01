<?php
include 'partials/header.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM posts WHERE post_id = $id LIMIT 1";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
    $user_id = $post['post_author_id'];
    $user_query = "SELECT * FROM users WHERE id = $user_id LIMIT 1";
    $cat_query = "SELECT * FROM categories WHERE cat_id = $id LIMIT 1";
    $user_result = mysqli_query($connection, $user_query);
    $user = mysqli_fetch_assoc($user_result);
    $cat_result = mysqli_query($connection, $cat_query);
    $category = mysqli_fetch_assoc($cat_result);
}
?>

    <section class="singlepost">
        <div class="container singlepost__container">
            <h2><?=$post['post_title']?></h2>
            <div class="post__author">
                <div class="post__author-avatar">
                    <img src="./images/<?=$user['avatar']?>" alt="">
                </div>
                <div class="post__author-info">
                    <h5>By: <?="{$user['firstname']} {$user['lastname']}"?></h5>
                    <small><?=date("M d, Y - H:i", strtotime($post['post_date_time']))?></small>
                </div>
            </div>

            <div class="singlepost__thumbnail">
                <img src="./images/<?=$post['post_thumbnail']?>" alt="">
            </div>
            <p>
                <?=$post['post_body']?>
            </p>
        </div>
    </section>

    <?php
    include './comment-section.php';
    include 'partials/footer.php';
    ?>