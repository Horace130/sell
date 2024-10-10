<?php 
checkIfuserIsNotLoggedIn();
require "parts/header.php"; 

// Connect to the database
$database = connectToDB();

// Fetch categories for the dropdown
$category_sql = "SELECT * FROM categories";
$category_query = $database->prepare($category_sql);
$category_query->execute();
$categories = $category_query->fetchAll();
?>

<div class="container mx-auto my-5" style="max-width: 700px;">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Add New Post</h1>
    </div>
    <div class="card mb-2 p-4">
        <form action="/post/add" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <?php require 'parts/error_message.php'; ?>
                <label for="post-title" class="form-label">Title</label>
                <input type="text" class="form-control" id="post-title" name="title" required />
            </div> 

            <div class="mb-3">
                <label for="post-content" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">

                <?php if ( $post['status'] == 'pending' ) : ?>
                  <option value="pending" selected>Pending for Review</option>
                <?php else: ?>
                  <option value="pending">Pending for review</option>
                <?php endif; ?>

                <?php if ( $post['status'] == 'publish' ) : ?>
                  <option value="publish" selected class="bg-success-option">Publish</option>
                  <?php else: ?>
                      <option value="publish" class="bg-success-option">Publish</option>
                <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id']; ?>">
                            <?= $category['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required />
            </div>

            <div class="mb-3">
                <label for="post-content" class="form-label">Content</label>
                <textarea class="form-control" id="post-content" rows="5" name="content" required></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
    <div class="text-center">
        <a href="/manage-posts" class="btn btn-link btn-sm"><i class="bi bi-arrow-left"></i> Back to Posts</a>
    </div>
</div>

<?php require 'parts/footer.php'; ?>
