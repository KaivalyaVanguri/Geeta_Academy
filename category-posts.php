<?php
include 'partials/header.php';

if(isset($_GET['id'])){
    $cat_id = $_GET['id'];
    //var_dump($cat_id);
    //echo $cat_id;
    $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
    $result = mysqli_query($connection, $query);
    $category = mysqli_fetch_assoc($result);
    //echo $category;
    $post_query = "SELECT * FROM posts WHERE post_category_id = $cat_id";
    $posts= mysqli_query($connection, $post_query);
    //if($category = mysqli_fetch_assoc($categories)):
        //<?php endif
}
?>


    <header class="category__title">
        <h2><?= $category['cat_title']?></h2>
    </header>  
    <?php if(mysqli_num_rows($posts)==0 ):// shows if delete post was successful?>
                <div class="alert__message error lg">
                    <p>
                        No posts found in this category
                    </p>
                </div>
        <?php endif?>  
    <section class="posts">
        <div class="container posts__container">
            <?php
                while($post = mysqli_fetch_assoc($posts)):
                    $user_id = $post['post_author_id'];
                    $user_query = "SELECT * FROM users WHERE id = $user_id";
                    $user_result = mysqli_query($connection, $user_query);
                    $user = mysqli_fetch_assoc($user_result);
            ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?=$post['post_thumbnail']?>" alt="">
                </div>
                <div class="post__info">
                    <a href="category-posts.php?id=<?=$category['cat_id']?>" class="category__button"><?=$category['cat_title']?></a>
                    <h3 class="post__title">
                        <a href="post.php?id=<?=$post['post_id']?>"><?=$post['post_title']?></a>
                    </h3>
                </div>
                <p class="post__body">
                    <?=substr($post['post_body'], 0, 300)?>
                </p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="./images/<?=$user['avatar']?>" alt="">
                    </div>
                    <div class="post__author-info">
                        <h5>By: <?="{$user['firstname']} {$user['lastname']}"?></h5>
                        <small><?=date("M d, Y-H:i",strtotime($post['post_date_time']))?></small>
                    </div>
                </div>
            </article>
            <?php endwhile ?>
            
            
            
            
              
            
              
                     
        </div>
    </section>
    <!--=========================End Of Posts=========================-->
    <?php
    $query = "SELECT * FROM categories";
    $categories = mysqli_query($connection, $query);
    ?>
    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php while($category = mysqli_fetch_assoc($categories)):
                ?>
            <a href="<?=ROOT_URL?>category-posts.php?id=<?=$category['cat_id']?>" class="category__button"><?=$category['cat_title']?></a>
            <?php endwhile?>
        </div>
    </section>

<?php
    include 'partials/footer.php';
?>