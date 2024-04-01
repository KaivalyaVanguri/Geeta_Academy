<?php
require 'config/database.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch post from the database

    //delete category
    $query = "SELECT * FROM posts WHERE post_id=$id";
    $result = mysqli_query($connection, $query);
    //make sure only 1 record/post was fetched
    if (mysqli_num_rows($result) == 1){
        $post = mysqli_fetch_assoc($result);
        $thumbnail_name = $post['post_thumbnail'];
        $thumbnail_path = '../images/'.$thumbnail_name;

        if($thumbnail_path){
            unlink($thumbnail_path);

            //delete post from database
            $delete_post_query ="DELETE FROM posts WHERE post_id=$id LIMIT 1";
            $delete_post_result = mysqli_query($connection, $delete_post_query);

            if(!mysqli_errno($connection)){
                $_SESSION['delete-post-success'] = "Post deleted successfully";
            }else{
                $_SESSION['delete-post'] = "Post not deleted ";
            }
        }
    }
    
}
header('location: '.ROOT_URL.'admin/index.php');
die();
?>