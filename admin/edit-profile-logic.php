
<?php
require './config/database.php';


if (isset($_POST['update'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
    $password1 = filter_var($_POST['password1'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $update = $_GET['update'];
    $password = $password1;
    if ($update == 'pswd'){
        $password2 = filter_var($_POST['password2'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? null;
    }

    $query = "SELECT * FROM users WHERE id=?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if (isset($password2)) {
        $update = 'pswd';
        $uppercase = preg_match('@[A-Z]@', $password2);
        $lowercase = preg_match('@[a-z]@', $password2);
        $number = preg_match('@[0-9]@', $password2);
        $specialChars = preg_match('@[^\w]@', $password2);
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password2) < 8) {
            $_SESSION['edit-profile'] = "Invalid new password";
        } else {
            $password = $password2;
        }

    } elseif (isset($_FILES['avatar'])) {
        $update = 'avatar';
        $avatar = $_FILES['avatar'] ?? null;
    }

    if (!$firstname || !$lastname || !$password1) {
        $_SESSION['edit-profile'] = "Invalid Form Input on Edit Profile Page";
    } elseif (!password_verify($password1, $user['password'])) {
        $_SESSION['edit-profile'] = "Incorrect Password";
    } else {
        if ($update == 'avatar' && !$avatar['name']) {
            $_SESSION['edit-profile'] = "Please upload your new avatar";
        } else {
            $avatar_destination_path = $user['avatar'];
            if (mysqli_num_rows($result)==1){
                $old_avatar_name = $user['avatar'];
                $old_avatar_path = '../images/' .$old_avatar_name;
                //delete image if available
                if($old_avatar_path){
                    unlink($old_avatar_path);
                }
            }
            if (isset($avatar['name']) && $update == 'avatar') {
                $time = time();
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);

                if (in_array($extension, $allowed_files) && $avatar['size'] < 1000000) {
                    move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                } else {
                    $_SESSION['edit-profile'] = "Invalid file size or type for avatar";
                }
            }

            if (!isset($_SESSION['edit-profile'])) {

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $update_user_query = "UPDATE users SET firstname=?, lastname=?, password=?, avatar=? WHERE id=?";
                $stmt = mysqli_prepare($connection, $update_user_query);
                mysqli_stmt_bind_param($stmt, "ssssi", $firstname, $lastname, $hashed_password, $avatar_destination_path, $id);
                mysqli_stmt_execute($stmt);

                if (!mysqli_errno($connection)) {
                    $portion = ($update == 'fname') ? 'First Name' : (($update == 'lname') ? 'Last Name' : (($update == 'pswd') ? 'Password' : 'Avatar'));

                    $_SESSION['edit-profile-success'] = "$portion updated successfully";
                    header('location: ' . ROOT_URL . 'admin/profile-settings.php');
                    die();
                } else {
                    $_SESSION['edit-profile'] = "Failed to update user.";
                }
            }
        }
    }
    header('location: ' . ROOT_URL . 'admin/profile-settings.php');
    die();
} else {
    header('location: ' . ROOT_URL . 'admin/edit-profile.php');
    die();
}
?>