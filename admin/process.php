<?php

session_start();

$user = $_SESSION['blog_user'];
$user_id = $_SESSION['blog_id'];
include_once "../class/database.php";
include_once "../class/Auth.php";
include_once "functions.php";


$auth = new Authentication;

// image update
if (isset($_POST['profile_update'])) {
    $image = $_FILES['picture'];
    // print_r($image);
    if ($img = upload($image, "admin_images/", true)) {
        if ($auth->updatePic($user_id, $img)) {
            header("Location: profile.php?profile_updated");
        } else {
            echo "Something went wrong <a href='settings.php'>Go back to fix this</a>";
        }
    }
}

// update password
if (isset($_POST['password_update'])) {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    if (trim($new) !== "") {
        $password = password_hash($new, PASSWORD_BCRYPT);
        if ($auth->updatePassword($user_id, $old, $password)) {
            header("Location: profile.php?password_updated");
        } else {
            echo "Something went wrong <a href='settings.php'>Go back to fix this</a>";
        }
    } else {
        echo "All fields are required <a href='settings.php'>Go back to fix this</a>";
    }
}

// setup profile
function setup()
{
    global $auth;
    global $user;
    $user_id = $_SESSION['blog_id'];

    if (isset($_POST['user_detail'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $desc = $_POST['description'];
        $fb = $_POST['facebook'];
        $github = $_POST['github'];
        $ytb = $_POST['youtube'];

        $error = "";

        if ($username == "" || $email == "" || $desc == "") {
            $error = "All required fields are needed <a href='profile.php'>Go back to fix this</a>";
        } else {
            $data = [$username, $email, $desc, $fb, $github, $ytb, $user_id];
            $_SESSION['blog_user'] = $username;
            if ($auth->setupProfile($data, $user)) {
                header("Location: profile.php");
            } else {
                $error = "Something went wrong <a href='profile.php'>Go back to fix this</a>";
            }
        }
        echo $error;
    }
}

setup();
