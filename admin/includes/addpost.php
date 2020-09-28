<?php

include_once "functions.php";

function add($title, $content, $tags, $image, $author, $slug, $category, $status, $date)
{
    global $post_obj;
    if ($target = upload($image, "post_images/", true)) {
        $title = ucwords($title);
        $data = [$title, $content, $category, $tags, $target, $author, $status, $slug, $date];
        if ($post_obj->addPost($data)) {
            return true;
        }
        return false;
    }
    return false;
}

// save
if (isset($_POST['save'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    $category = $_POST['categories'];
    $image = $_FILES['image'];
    $author = $user;
    $slug = create_slug($title);
    $status = (isset($_POST['status']) ? true : false);
    $date = date("F d, Y");

    if ($auth->isAuth($user_id)) {
        if (add($title, $content, $tags, $image, $author, $slug, $category, $status, $date)) {
            $msg = "<div class='alert alert-success'>Post added successfully</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Please setup your Profile first! <a href='profile.php'>setup</a></div>";
    }
}

// save and contine
if (isset($_POST['save_continue'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    $category = $_POST['categories'];
    $image = $_FILES['image'];
    $author = $user;
    $slug = create_slug($title);
    $status = (isset($_POST['status']) ? true : false);
    $date = date("F d, Y");

    if ($auth->isAuth($user_id)) {
        if (add($title, $content, $tags, $image, $author, $slug, $category, $status, $date)) {
            header("Location: posts.php");
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Please setup your Profile first! <a href='profile.php'>setup</a></div>";
    }
}

?>

<div class="col-lg-8">
    <h2 class="text-left">Add Post</h2>

    <?php
    if (isset($msg)) {
        echo $msg;
    }
    ?>

    <form action="" method="post" enctype="multipart/form-data" autocomplete="off">

        <div class="form-group">
            <label for="">Post Tile</label>
            <input type="text" name="title" id="" class="form-control" placeholder="Post Title">
        </div>

        <div class="form-group">
            <label for="">Image</label>
            <input type="file" name="image">
        </div>

        <div class="form-group">
            <label for="">Tags</label>
            <input type="text" name="tags" id="" class="form-control" placeholder="Add Tags">
        </div>

        <div class="form-group">
            <label for="">Post Content</label>
            <textarea name="content" id="" cols="5" rows="5" class="form-control" placeholder="Add Content"></textarea>
        </div>

        <div class="form-group">
            <label for="">Categories</label>
            <select name="categories" class="form-control">
                <?php
                if ($category_obj->loadCategories()) {
                    foreach ($category_obj->loadCategories() as $category) {
                        echo "<option
                        value='$category->category'>$category->category</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="">Publish Now?
                <input type="checkbox" name="status" id="">
            </label>
        </div>

        <div class="col-lg-12">
            <div class="col-lg-6">
                <div class="form-group">
                    <input type="submit" name="save_continue" value="Save and Continue" class="btn btn-success btn-block">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <input type="submit" name="save" value="Save" class="btn btn-info btn-block">
                </div>
            </div>
        </div>
    </form>


</div>