<?php
include './partials/header.php';

// Fetch categories
error_reporting(E_ALL);
ini_set('display_errors', 1);

$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch post data from the database
    $query = "SELECT * FROM posts WHERE post_id=?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_assoc($result);
    } else {
        header('location: ' . ROOT_URL . 'admin/index.php');
        die();
    }
}

?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        <?php if (isset($_SESSION['edit-post'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['edit-post'];
                    unset($_SESSION['edit-post']); ?>
                </p>
            </div>
        <?php endif ?>

        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $id ?>">
            <input type="text" name="title" placeholder="Title" value="<?= $post['post_title'] ?>">
            <select name="category">
                <option value="0">Select Category</option>
                <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                    <?php if ($category['cat_title'] !== 'Uncategorized') : ?>
                        <option value="<?= $category['cat_id'] ?>" <?= ($category['cat_id'] == $post['post_category_id']) ? 'selected' : '' ?>>
                            <?= $category['cat_title'] ?>
                        </option>
                    <?php endif ?>
                <?php endwhile ?>
            </select>

            <!-- Include Quill editor -->
            <div id="editor" data-initial-content="<?= htmlentities($post['post_body']) ?>"></div>
            <script src="../js/rich-editor.js"></script>
            <textarea id="hidden-textarea" name="body" style="display: none;"><?=$post['post_body']?></textarea>

            <?php if (isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin'] == 1) : ?>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" <?= (isset($post['is_featured']) && $post['is_featured'] == 1) ? 'checked' : '' ?>>
                    <label for="is_featured">Featured</label>
                </div>
            <?php endif ?>

            <div class="form__control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>

            <button type="submit" name="update" class="btn">Update Post</button>
        </form>
    </div>
</section>

<script src="<?= ROOT_URL ?>js/main.js"></script> <!-- Include the updated main.js -->
<?php
include '../partials/footer.php';
?>
