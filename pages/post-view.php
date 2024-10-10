<?php 
checkIfuserIsNotLoggedIn();
require "parts/header.php"; 

// Connect to the database
$database = connectToDB();

// Check if the post ID is set in the URL
if (!isset($_GET['id'])) {
    die("Post ID not specified.");
}

$post_id = $_GET['id'];

// Fetch the specific post with its category
$sql = "SELECT posts.*, categories.name AS category_name FROM posts 
        LEFT JOIN categories ON posts.category_id = categories.id 
        WHERE posts.id = :post_id";
$query = $database->prepare($sql);
$query->execute(['post_id' => $post_id]);
$post = $query->fetch();

if (!$post) {
    die("Post not found.");
}

// Output the post details
?>
<div class="container my-5">
    <h2><?= $post['title']; ?></h2>
    <p><strong>Category:</strong> <?= $post['category_name']; ?></p>
    <p><strong>Status:</strong> <?= $post['status']; ?></p>
    <img src="<?= $post['image_url']; ?>" alt="<?= $post['title']; ?>" style="width: 300px; height: 200px; object-fit: cover;" />
    <p class="mt-3"><?= nl2br(($post['content'])); ?></p>

   <!-- Edit and Delete buttons for authorized users -->
<?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $post['user_id']) : ?>
    <div class="d-flex gap-2 mt-3">
        <a href="/edit-views?id=<?= $post['id']; ?>" class="btn btn-warning">Edit</a>
        <form action="/post/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
            <input type="hidden" name="id" value="<?= $post['id']; ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
<?php else : ?>
    <a href="/" class="btn btn-secondary mt-3">Back to Home</a>
<?php endif; ?>

    
    <!-- Comment Form -->
    <div class="mt-5">
        <h2>Leave a Comment</h2>
        <form action="/add-comment" method="POST">
            <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
            <div class="mb-3">
                <label for="comment_content" class="form-label">Your Comment</label>
                <textarea class="form-control" id="comment_content" name="content" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Comment</button>
        </form>
    </div>

     <!-- Display Comments -->
<div class="mt-5">
    <h3>Comments</h3>
    <?php
    // Fetch comments from the database, joining with the users table to get usernames
    $comment_sql = "SELECT comments.*, users.name AS user_name 
                    FROM comments 
                    JOIN users ON comments.user_id = users.id 
                    WHERE comments.post_id = :post_id 
                    ORDER BY comments.created_at DESC";
    $comment_query = $database->prepare($comment_sql);
    $comment_query->execute(['post_id' => $post['id']]);
    $comments = $comment_query->fetchAll();

    // Check if there are any comments
    if ($comments) {
        foreach ($comments as $comment) {
            ?>
            <div class="border p-3 mb-3">
                <p><strong><?=$comment['user_name']; ?>:</strong></p>
                <p><?=$comment['comment_text']; ?></p>
                <p class="text-muted small"><?= $comment['created_at']; ?></p>

                <!-- Edit and Delete buttons for comment author or admin -->
                <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $comment['user_id']) { ?>
                    <div class="d-flex gap-2 mt-2">
                        <a href="/edit-comment?id=<?= $comment['comment_id']; ?>&post_id=<?= $post['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form action="/delete-comment" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                            <input type="hidden" name="comment_id" value="<?= $comment['comment_id']; ?>">
                            <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
            <?php
        }
    } else {
        echo "<p>No comments yet. Be the first to comment!</p>";
    }
    ?>
</div>

    </div>
    <?php

require 'parts/footer.php'; 
?>
