<?php
require 'config/database.php';

if(isset($_POST['submit'])){
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body']);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    //var_dump($is_featured);
    //set is_featured to 0 if unchecked
    $is_featured = $is_featured == 1?: 0;

    //validate form data
    if(!$title){
        $_SESSION['add-post'] = 'Enter post title';
    }elseif(!$category_id){
        $_SESSION['add-post'] = 'Select post category';
    }elseif(!$body){
        $_SESSION['add-post'] = 'Enter post body';
    }elseif(!$thumbnail['name']){
        $_SESSION['add-post'] = 'Choose post thumbnail';
    }else{
        //WORK ON Thumbnail
        //rename the image
        $time = time();//make each image name unique
        $thumbnail_name = $time . $thumbnail['name'];
        //var_dump($thumbnail);
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/'. $thumbnail_name;

        //make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);
        if(in_array($extension, $allowed_files)){
            //make sure image is not too large(2mb+)
            if($thumbnail['size']<2_000_000){
                //upload avatar
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            }else{
                $_SESSION['add-post'] = "File size is large, 2mb max limit.";
            }
        }else{
            $_SESSION['add-post'] = "File must be a png, jpg, jpeg";
        }
    }
    //redirect back (with form data) to add-post page if there is any problem
    if(isset($_SESSION['add-post'])){
        $_SESSION['add-post-data'] = $_POST;
        header('location: '.ROOT_URL.'admin/add-post.php');
        die();
    }else{
        //set is_featured of all posts to 0 if is_featured for this post is 1
        if($is_featured == 1){
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        //insert post into database
        $query = "INSERT INTO posts (post_title, post_body, post_thumbnail, post_category_id, post_author_id, post_featured) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sssiii", $title, $body, $thumbnail_destination_path, $category_id, $author_id, $is_featured);
        mysqli_stmt_execute($stmt);

        if(mysqli_errno($connection)){
            $_SESSION['add-post'] = "Failed to add post.";
        }else{
            $_SESSION['add-post-success'] = "Post $title added successfully";
            header('location: '.ROOT_URL .'admin/');
            die();
        }
    }
}
header('location: '. ROOT_URL . 'admin/add-post.php');
die();
?>