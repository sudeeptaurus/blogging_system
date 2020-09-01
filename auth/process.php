<?php 
include_once "../class/database.php";
include_once "../class/Auth.php";

$auth = new Authentication;

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $error = "";

    
}