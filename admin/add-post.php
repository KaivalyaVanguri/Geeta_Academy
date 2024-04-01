<?php
include 'partials/header.php';

// Get back form data if there was a posting error
$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;
$category_id = $_SESSION['add-post-data']['category_id'] ?? null;

//fetch categories
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

// Delete profile data session
unset($_SESSION['add-post-data']);
?>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add Post</h2>
            <?php if (isset($_SESSION['add-post'])) : ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['add-post'];
                        unset($_SESSION['add-post']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?=ROOT_URL?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="title" value="<?=$title?>" placeholder="Title">
                
                <select name="category">
                    <option value="0">Select Category</option>
                    <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                        <?php if($category['cat_title'] !== 'Uncategorized'):?>
                        <option value="<?= $category['cat_id']?>" <?= ($category['cat_id'] == $category_id) ? 'selected' : '' ?>>
                        <?=$category['cat_title']?>
                        <?php endif?>
                    </option>
                        <?php endwhile ?>
                </select> 
                
                <!-- Include Quill editor -->
                <div id="editor" data-initial-content="<?= $body ?>"></div>
                <script src="../js/rich-editor.js"></script>
                <textarea id="hidden-textarea" name="body" style="display: none;"><?=$body?></textarea>
                
                <!--<textarea rows="10" name="body" placeholder="Body"></textarea>-->
                <?php if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']==1):?>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured" value=1 id="is_featured" checked>
                    <label for="is_featured">Featured</label>
                </div>
                <?php endif?>
                <div class="form__control">
                    <label for="thumbnail">Add Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Add Post</button>
                <?php if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']==1):?>
                    <small>Cannot Find Your Category? <a href="add-category.php">Add Category</a></small>
                <?php endif?>
           </form>
        </div>
    </section>
    <?php
include '../partials/footer.php'
?>