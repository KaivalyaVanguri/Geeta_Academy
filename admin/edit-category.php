<?php
include 'partials/header.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch category data from database
    $query = "SELECT * FROM categories WHERE cat_id=?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result)==1){
        $category = mysqli_fetch_assoc($result);
    }

}//else{
    //header('location: '. ROOT_URL . 'admin/edit-category.php');
    //die();
//}
?>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Edit Category</h2>
            <?php if(isset($_SESSION['edit-category'])):?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['edit-category'];
                        unset($_SESSION['edit-category']);?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?=ROOT_URL?>admin/edit-category-logic.php" method="POST">
                <input type="hidden" name="cat_id" value="<?= $category['cat_id']?>">
                <input type="text" name="cat_title" value="<?= $category['cat_title']?>" placeholder="Title">
                <textarea rows="4" name="cat_description" placeholder="Description"><?=$category['cat_description']?></textarea>
                <button type="submit" name="update" class="btn">Update Category</button>
           </form>
        </div>
    </section>
    <?php
include '../partials/footer.php';
?>