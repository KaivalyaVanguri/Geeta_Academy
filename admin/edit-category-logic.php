<?php
require 'config/database.php';

if (isset($_POST['update'])) {
    $id = filter_var($_POST['cat_id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['cat_title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['cat_description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate input
    if (!$title || !$description) {
        $_SESSION['edit-category'] = "Invalid form input on edit category page";
    } else {
        $query = "UPDATE categories SET cat_title = ?, cat_description = ? WHERE cat_id = ? LIMIT 1";
        $stmt = mysqli_prepare($connection, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $id);
            mysqli_stmt_execute($stmt);

            if (mysqli_errno($connection)) {
                $_SESSION['edit-category'] = "Couldn't update category";
            } else {
                $_SESSION['edit-category-success'] = "Category $title updated successfully";
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['edit-category'] = "Error preparing statement";
        }
    }
}
if(isset($_SESSION['edit-category-success'])){
    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    die();
}else{
    header('location: ' . ROOT_URL . 'admin/edit-category.php?id='. $id);
    die();
}
?>
