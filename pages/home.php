<?php 

  // 1. connect to the database
  $database = connectToDB();

  $sql = "SELECT * FROM posts";
  $query = $database->prepare($sql);
  $query->execute();
  $posts = $query->fetchAll();

  require "parts/header.php"; 
?>

<div class="container min-vh-100">
  <div class="text-end">
    <a href="/posts-add" class="btn btn-primary btn-sm">Add New Post</a>
  </div>
  
  <div class="container">
    <div class="row">
      <?php foreach ($posts as $post) : ?>
        <div class="col-lg-3 col-md-4 col-sm-6 p-2"> <!-- Use padding instead of margin -->
          <div class="card" style="width: 100%;"> <!-- Set to 100% to fill the column -->
          <?php if ( $post['status'] == 'pending' ) : ?>
                  <span class="badge bg-warning"><?= $post['status']; ?></span>
                <?php endif; ?>
                
                <?php if ( $post['status'] == 'publish' ) : ?>
                  <span class="badge bg-success"><?= $post['status']; ?></span>
                <?php endif; ?>
            
            <!-- Ensure image fits the card with object-fit and fixed height -->
            <img src="<?= $post['image_url'] ?>" class="card-img-top" alt="<?= $post['title'] ?>" style="height: 200px; object-fit: cover;">
            
            <div class="card-body">
              <h5 class="card-title"><?= $post['title'] ?></h5>
              <p class="card-text"><?= $post['content'] ?></p>
              <a href="/post-view?id=<?= $post['id']; ?>" class="btn btn-primary">View book</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php require 'parts/footer.php'; ?>
