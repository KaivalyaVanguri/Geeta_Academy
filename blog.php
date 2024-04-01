<?php
include 'partials/header.php';

$post_query = "SELECT * FROM posts ORDER BY post_date_time DESC LIMIT 6";
$posts = mysqli_query($connection, $post_query);
?>

    <section class="search__bar">
        <form class="container search__bar-container" action="<?=ROOT_URL?>search.php" method="GET">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name = "search" placeholder="Search">
            </div>
            <button type="submit" name="submit" class="btn">Go</button>
        </form>
    </section>

    <!--=============================End Of SEARCH=================================-->
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
                        <img src="./images/<?=$post['post_thumbnail']?>" alt="ALT TEXT">
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
                            <img src="./images/<?=$post_author['avatar'] ?>" alt="<?=$post_author['username'] ?>">
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
    <?php
    include 'partials/footer.php';
    ?>