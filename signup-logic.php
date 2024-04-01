<?php

//echo "form from signup page";
require './config/database.php';

//get signup form data if signup button was clicked

    //$firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if(isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];
    //var_dump($avatar);
    //echo $firstname, $lastname, $username, $email, $createpassword, $confirmpassword;
    $uppercase = preg_match('@[A-Z]@', $createpassword);
    $lowercase = preg_match('@[a-z]@', $createpassword);
    $number    = preg_match('@[0-9]@', $createpassword);
    $specialChars = preg_match('@[^\w]@', $createpassword);
    //validate input values
    if(!$firstname ){
        $_SESSION['signup'] = "Please enter your first name";
    }elseif (!$lastname){
        $_SESSION['signup'] = "Please enter your last name";
    }elseif (!$username){
        $_SESSION['signup'] = "Please enter your user name";
    }elseif (!$email){
        $_SESSION['signup'] = "Please enter your email";
    }elseif(!$confirmpassword || !$createpassword){
        $_SESSION['signup'] = "Please enter your password";
    }elseif ($confirmpassword !== $createpassword){
        $_SESSION['signup'] = "Passwords dont match";
    }elseif (!$avatar['name']){
        $_SESSION['signup'] = "Please add your avatar";
    }else{
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($createpassword) < 8) {
            $_SESSION['signup'] = "Passwords must contain atleast one uppercase, one lowercase, one special character, one number and should have a minimum length of 8 ";}
        else{
            //hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
            //echo $createpassword . '</br>';
            //echo $hashed_password;

            // check if username or email already existss in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email = '$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result)>0){
                $_SESSION['signup'] = "Username or Email already exists";
            } else{
                //Work on AVATAR
                //rename avatar
                $time = time();
                $avatar_name = $time . $avatar['name'];
                //make each image name unique using current timestamp
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                //make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $avatar_name);
                $extension = end($extension);
                //$_SESSION['signup'] = '$extension';
                if(in_array($extension, $allowed_files)){
                    //make sure image is not too large(1mb+)
                    if($avatar['size']<1000000){
                        //upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    }else{
                        $_SESSION['signup'] = "File size is large, 1mb max limit.";
                    }
                }else{
                    $_SESSION['signup'] = "File must be a png, jpg, jpeg";
                }
            }
        }
    }
    //var_dump($avatar);

    //redirect back to signup page if there was any problem
    if (isset($_SESSION['signup'])){
        //pass form data back to signup page
        $_SESSION['signup-data'] = $_POST;
        header('location:' . ROOT_URL . 'signup.php');
        die();
    }else{
        //insert new user into users table
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_destination_path', 0)";
        $insert_user_result = mysqli_query($connection, $insert_user_query);

        if(!mysqli_errno($connection)){
            //redirect to login page with success message
            $_SESSION['signup-success']="Registration Successful. Please log in!";
            header('location: '. ROOT_URL . 'login.php');
            die();
        }
    }
}else{
    //if button wasnt  clicked, bounce back to signup page
    header('location: '. ROOT_URL .'signup.php');
    die();
}
?>