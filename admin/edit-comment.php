<?php
include './partials/header.php';

// Fetch comments
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch comment data from the database
    $query = "SELECT * FROM comments WHERE comment_id=?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) == 1) {
        $comment = mysqli_fetch_assoc($result);
    } else {
        header('location: ' . ROOT_URL . 'admin/manage-comments.php');
        die();
    }
}

?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit comment</h2>
        <?php if (isset($_SESSION['edit-comment'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['edit-comment'];
                    unset($_SESSION['edit-comment']); ?>
                </p>
            </div>
        <?php endif ?>

        <form action="<?= ROOT_URL ?>admin/edit-comment-logic.php" method="POST">
            <input type="hidden" name="comment_id" value="<?= $id ?>">
            <!-- Include Quill editor -->
            <div id="editor" data-initial-content="<?= htmlentities($comment['comment_text']) ?>"></div>
            <script src="../js/rich-editor.js"></script>
            <textarea id="hidden-textarea" name="comment" style="display: none;"><?=$comment['comment_text']?></textarea>

            <?php if (isset($_SESSION['user_is_admin']) && ($_SESSION['user_is_admin'] == 1) || $_SESSION['user_is_admin'] == 2 ): ?>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" <?= (isset($comment['comment_featured']) && $comment['comment_featured'] == 1) ? 'checked' : '' ?>>
                    <label for="is_featured">Featured</label>
                </div>
            <?php endif ?>
            <?php if (isset($_SESSION['user_is_admin']) && ($_SESSION['user_is_admin'] == 1) || $_SESSION['user_is_admin'] == 2 ): ?>
                <div class="form__control inline">
                    <input type="checkbox" name="is_hidden" value="1" id="is_hidden" <?= (isset($comment['comment_hidden']) && $comment['comment_hidden'] == 1) ? 'checked' : '' ?>>
                    <label for="is_hidden">Hide the Comment</label>
                </div>
            <?php endif ?>

            <button type="submit" name="update" class="btn">Update comment</button>
        </form>
    </div>
</section>

<script src="<?= ROOT_URL ?>js/main.js"></script> <!-- Include the updated main.js -->
<?php
include '../partials/footer.php';
?>
