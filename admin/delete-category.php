<?php
require 'config/database.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //update category_id of posts that belong to this category to id of uncategorized category
    //FOR LATER
    $update_query = "UPDATE posts SET post_category_id = (SELECT cat_id FROM categories WHERE cat_title = 'Uncategorized') WHERE post_category_id=$id";
    $update_result = mysqli_query($connection, $update_query);

    if(!mysqli_errno($connection)){
        //delete category
        $query = "DELETE FROM categories WHERE cat_id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
        $_SESSION['delete-category-success'] = "Category deleted succesfully";
    }
  
}
header('location: '.ROOT_URL.'admin/manage-categories.php');
die();
?>