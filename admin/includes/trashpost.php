<?php

// Posts::$pageno = 1;

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $post_obj->deletePost($id, $_GET['image']);
    $page = $_GET['page'];
    header("Location: posts.php?source=trash&page=$page");
}

?>

<?php if ($post_obj->loadTrashPosts()) : ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th colspan="3" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($post_obj->loadTrashPosts() as $posts) :
                    $title = $posts->title;
                    $content = substr($posts->content, 0, 100);
                    $author = $posts->author;
                    $category = $posts->category;
                    $status = $posts->status;
                    $status = ($status ? "published" : "draft");
                ?>

                    <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $content; ?></td>
                        <td><?php echo $author; ?></td>
                        <td><?php echo $category; ?></td>
                        <td><?php echo $status; ?></td>
                        <td><a href="?source=trash&restore=<?php echo $posts->id; ?>" class="btn btn-primary btn-block">Restore</a></td>
                        <td><a href="?source=trash&delete=<?php echo $posts->id; ?>&image=<?php echo $posts->image; ?>&page=<?php echo Posts::$pageno; ?>" class="btn btn-danger btn-block">Delete</a></td>
                    </tr>

                <?php endforeach; ?>

            </tbody>
        </table>

    </div>

<?php else : ?>

    <h4 class="text-center">
        No Data Here
    </h4>


<?php endif; ?>

<ul class="pager">
    <!-- first page -->
    <li>
        <a href="?source=trash&page=1" class="page-link">1</a>
    </li>
    <!-- previous page -->
    <li class="page-item <?php echo (Posts::$pageno <= 1) ? "disabled" : "" ?>">
        <a href="?source=trash&page=<?php echo (Posts::$pageno <= 1) ? "#" : (Posts::$pageno - 1) ?>">&laquo;</a>
    </li>
    <!-- next page -->
    <li class="page-item <?php echo (Posts::$pageno >= $post_obj->totalPages) ? "disabled" : "" ?>">
        <a href="?source=trash&page=<?php echo (Posts::$pageno >= $post_obj->totalPages) ? "#" : (Posts::$pageno + 1) ?>">&raquo;</a>
    </li>
    <!-- last page -->
    <li class="page-item <?php echo (Posts::$pageno == $post_obj->totalPages) ? "disabled" : "" ?>">
        <a href="?source=trash&page=<?php echo (Posts::$pageno == $post_obj->totalPages) ? "#" : $post_obj->totalPages; ?>" class="page-link"><?php echo $post_obj->totalPages; ?></a>
    </li>
</ul>