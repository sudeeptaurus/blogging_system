<?php if ($posts = $post_obj->loadPosts()) : ?>
  <?php foreach ($posts as $post) : ?>


    <div class="col-md-6">
      <a href="post/<?php echo $post->slug; ?>" class="blog-entry element-animate" data-animate-effect="fadeIn">
        <img src="admin/<?php echo $post->image; ?>" alt="Image placeholder">
        <div class="blog-content-body">
          <div class="post-meta">
            <span class="author mr-2"><?php echo $post->author; ?></span>&bullet;
            <span class="mr-2"><?php echo $post->date_added; ?> </span> &bullet;
            <!-- <span class="ml-2"><span class="fa fa-comments"></span> 3</span> -->
          </div>
          <h2><?php echo $post->title; ?></h2>
        </div>
      </a>
    </div>

  <?php endforeach; ?>
<?php endif; ?>