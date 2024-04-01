<?php
include 'partials/header.php';

// Fetch featured post from the database
$featured_query = "SELECT * FROM posts WHERE post_featured = 1";
$featured_result = mysqli_query($connection, $featured_query);

// Check if there is a featured post
if (mysqli_num_rows($featured_result) > 0) :
?>

<body>

    <div id="carousel" class="carousel">
        <div class="carousel__slides">
            <?php while ($featured = mysqli_fetch_assoc($featured_result)) :
                $featured_post_author_id = $featured['post_author_id'];
                $query = "SELECT * FROM users WHERE id=$featured_post_author_id LIMIT 1";
                $featured_author_result = mysqli_query($connection, $query);
                $featured_author = mysqli_fetch_assoc($featured_author_result);
                $post_category_id = $featured['post_category_id'];
                $query = "SELECT * FROM categories WHERE cat_id=$post_category_id LIMIT 1";
                $featured_category_result = mysqli_query($connection, $query);
                $featured_category = mysqli_fetch_assoc($featured_category_result);
            ?>
                <div class="carousel__slide">
                    <div class="carousel__content">
                      <div class="carousel__post__thumbnail">
                        <img src="./images/<?= $featured['post_thumbnail'] ?>" alt="Slide 1">
                      </div>
                        <div class="carousel__post__info">
                            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $featured_category['cat_id'] ?>" class="category__button"><?= $featured_category['cat_title'] ?></a>
                            <h2 class="post__title"><a href="post.php?id=<?= $featured['post_id'] ?>"><?= $featured['post_title'] ?></a></h2>
                            <p class="post__body">
                                <?= substr($featured['post_body'], 0, 300) ?>...
                            </p>
                            <div class="post__author">
                                <div class="post__author-avatar">
                                    <img src="./images/<?= $featured_author['avatar'] ?>" alt="">
                                </div>
                                <div class="post__author-info">
                                    <h5><?= "{$featured_author['firstname']} {$featured_author['lastname']}" ?></h5>
                                    <small><?= date("M d, Y - H:i", strtotime($featured['post_date_time'])) ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile ?>
        </div>
        <button id="prevBtn" type="button">❮</button>
        <button id="nextBtn"type="button">❯</button>
    </div>
<?php endif; ?>
    <!--==================End Of Featured Section=========================-->
    <?php 
    if (mysqli_num_rows($featured_result) == 1){
        $featured_query = "SELECT * FROM posts WHERE post_featured = 1";
        $featured_result = mysqli_query($connection, $featured_query);
        $featured = mysqli_fetch_assoc($featured_result);
        $featured_post_id = $featured['post_id'];
        $post_query = "SELECT * FROM posts WHERE post_id != $featured_post_id LIMIT 3";
        $posts = mysqli_query($connection, $post_query);
    }else{
        $post_query = "SELECT * FROM posts";
        $posts = mysqli_query($connection, $post_query);
    }
    ?>
    <section class="posts <?= isset($featured) ? '' : 'section__extra-margin'?>">
        <div class="container posts__container">
            <?php while($post = mysqli_fetch_assoc($posts)):
                $post_author_id = $post['post_author_id'];
                $query = "SELECT * FROM users WHERE id=$post_author_id";
                $post_author_result = mysqli_query($connection, $query);
                $post_author = mysqli_fetch_assoc($post_author_result);
                $post_category_id = $post['post_category_id'];
                $query = "SELECT * FROM categories WHERE cat_id=$post_category_id";
                $post_category_result = mysqli_query($connection, $query);
                $post_category = mysqli_fetch_assoc($post_category_result);
            ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="./images/<?=$post['post_thumbnail']?>" alt="">
                    </div>
                    <div class="post__info">
                        <a href="<?=ROOT_URL?>category-posts.php?id=<?=$post_category['cat_id']?>" class="category__button"><?=$post_category['cat_title']?></a>
                        <h3 class="post__title">
                            <a href="post.php?id=<?=$post['post_id']?>"><?=$post['post_title']?></a>
                        </h3>
                    </div>
                    <p class="post__body">
                    <?=substr($post['post_body'], 0 , 150)?>...
                    </p>
                    <div class="post__author">
                        <div class="post__author-avatar">
                            <img src="./images/<?=$post_author['avatar'] ?>" alt="">
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?="{$post_author['firstname']} {$post_author['lastname']}" ?></h5>
                            <small><?=date("M d, Y - H:i", strtotime($post['post_date_time']))?></small>
                        </div>
                    </div>
                </article>
            <?php endwhile?>
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
    <!--=======================End Of Category Buttons============================-->
    <?php
    include 'partials/footer.php';
    ?>