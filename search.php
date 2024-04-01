<?php
require 'partials/header.php';

if(isset($_GET['search']) && isset($_GET['submit'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "
    SELECT 
        p.post_id,
        p.post_title,
        p.post_body,
        p.post_date_time,
        p.post_thumbnail,
        c.cat_title,
        u.avatar,
        CONCAT(u.firstname, ' ', u.lastname) AS author_name
    FROM 
        posts p
    LEFT JOIN 
        categories c ON p.post_category_id = c.cat_id
    LEFT JOIN 
        users u ON p.post_author_id = u.id
    WHERE 
        p.post_title LIKE '%$search%' 
        OR p.post_body LIKE '%$search%' 
        OR c.cat_title LIKE '%$search%' 
        OR u.firstname LIKE '%$search%' 
        OR u.lastname LIKE '%$search%'
    ORDER BY 
        p.post_date_time DESC;
";
    
    $posts = mysqli_query($connection, $query);
}else{
    header('location: '. ROOT_URL . 'blog.php');
    die();
}
?>


<?php if(mysqli_num_rows($posts)>0): ?>
    <section class="posts <?= isset($posts) ? 'section__extra-margin':''?>">
        <div class="container posts__container">
            <?php while($post = mysqli_fetch_assoc($posts)):
                $thumbnail = $post['post_thumbnail'];
                $id = $post['post_id'];
                $title = $post['post_title'];
                $body = $post['post_body'];
                $date_time = $post['post_date_time'];
                //$post_author_id = $post['post_author_id'];
                //$query = "SELECT firstname, lastname, avatar FROM users WHERE id=$post_author_id";
                //$result = mysqli_query($connection,$query);
                //$user = mysqli_fetch_assoc($result);
                $author = $post['author_name'];
                $avatar = $post['avatar'];
                //$post_category_id = $post['post_category_id'];
                //$query = "SELECT cat_title FROM categories WHERE cat_id = $post_category_id";
                //$result = mysqli_query($connection,$query);
                //$category = mysqli_fetch_assoc($result);
                $cat_title = $post['cat_title'];
            ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="./images/<?=$thumbnail?>" alt="">
                    </div>
                    <div class="post__info">
                        <a href="<?=ROOT_URL?>category-posts.php?id=<?=$post_category_id ?>" class="category__button"><?=$cat_title?></a>
                        <h3 class="post__title">
                            <a href="post.php?id=<?=$id?>"><?=$title?></a>
                        </h3>
                    </div>
                    <p class="post__body">
                    <?=substr($body, 0 , 150)?>...
                    </p>
                    <div class="post__author">
                        <div class="post__author-avatar">
                            <img src="./images/<?=$avatar?>" alt="">
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?=$author?></h5>
                            <small><?=date("M d, Y - H:i", strtotime($date_time))?></small>
                        </div>
                    </div>
                </article>
            <?php endwhile?>
        </div>
    </section>
    <?php else:?>
        <div class="alert__message error lg section__extra-margin">
            <p>No Posts found for this search</p>
        </div>
    <?php endif ?>
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