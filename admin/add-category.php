<?php
include 'partials/header.php';

// get back form data
$title = $_SESSION['add-category-data']['cat_title'] ?? null;
$description = $_SESSION['add-category-data']['cat_description'] ?? null;

//unsetting category
unset($_SERVER['add-category-data'])
?>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add Category</h2>
            <?php if(isset($_SESSION['add-category'])):?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['add-category'];
                        unset($_SESSION['add-category']);?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="POST">
                <input type="text" value="<?=$title?>" name = "title" placeholder="Title">
                <textarea rows="4" name = "description" placeholder="Description"><?=$description?></textarea>
                <button type="submit" name = "submit" class="btn">Add Category</button>
                <small>Category already present? <a href="add-post.php">Add Post</a></small>
           </form>
        </div>
    </section>

<?php
include '../partials/footer.php'
?>