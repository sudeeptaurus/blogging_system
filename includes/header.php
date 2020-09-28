<?php

ob_start();
include_once "class/database.php";
include_once "class/Posts.php";
include_once "class/Category.php";

if (isset($_GET['page']) && $_GET['page'] != "" && $_GET['page'] >= 1) {
  Posts::$pageno = $_GET['page'];
} else {
  Posts::$pageno = 1;
}

$post_obj = new Posts();
$category_obj = new Category();

?>

<!doctype html>
<html lang="en">

<head>
  <title>Blogging System &mdash; Minimal Blog Template</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300, 400,700|Inconsolata:400,700" rel="stylesheet">

  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">

  <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

  <!-- Theme Style -->
  <link rel="stylesheet" href="css/style.css">
</head>

<body>