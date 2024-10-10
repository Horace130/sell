<?php
checkIfuserIsNotLoggedIn();
require "parts/header.php";

// Check if the post ID is set in the query string
if (isset($_GET['id'])) {
    // 1. Connect to the database
    $database = connectToDB();

    // 2. Get the post ID from the URL
    $post_id = $_GET['id'];

    // 3. Fetch the post details from the database using the post ID
    $sql = "SELECT * FROM posts WHERE id = :id";
    $query = $database->prepare($sql);
    $query->execute(['id' => $post_id]);
    $post = $query->fetch();

    // 4. Check if post was retrieved successfully
    if (!$post) {
        echo "<div class='container my-5'><h1>Post not found!</h1></div>";
    } else {
        // Fetch categories from the database
        $category_sql = "SELECT * FROM categories";
        $category_query = $database->prepare($category_sql);
        $category_query->execute();
        $categories = $category_query->fetchAll();

        // Display the edit form
        ?>
        <div class="container my-5">
            <h1>Edit Post</h1>
            <form action="/post/edit" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $post['id']; ?>">
                
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= $post['title']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required><?= $post['content']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id']; ?>" <?= $post['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                <?= $category['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="published" <?= $post['status'] == 'published' ? 'selected' : ''; ?>>Published</option>
                        <option value="pending" <?= $post['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <img src="<?= $post['image_url']; ?>" alt="Current Image" style="max-width: 100px; margin-top: 10px;">
                </div>

                <button type="submit" class="btn btn-primary">Update Post</button>
            </form>
            <a href="/" class="btn btn-secondary mt-3">Back to Home</a>
        </div>
        <?php
    }
} else {
    // If no post ID is in the URL, show an error message
    echo "<div class='container my-5'><h1>No post ID specified!</h1></div>";
}

require 'parts/footer.php';
