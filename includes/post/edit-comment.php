<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the database
$database = connectToDB();

// Check if user is logged in
if (!isset($_SESSION['user']['id'])) {
    die("Unauthorized access.");
}

// Check if comment_id is set
if (isset($_GET['id'])) {
    $comment_id = $_GET['id'];

    // Fetch the current comment from the database
    $sql = "SELECT * FROM comments WHERE comment_id = :comment_id";
    $query = $database->prepare($sql);
    $query->execute(['comment_id' => $comment_id]);
    $comment = $query->fetch();

    // Check if the comment exists
    if (!$comment) {
        die("Comment not found.");
    }

    // Check if the logged-in user is the author of the comment
    if ($comment['user_id'] != $_SESSION['user']['id']) {
        die("Unauthorized access.");
    }
} else {
    die("Comment ID not set.");
}

// Handle the form submission for editing the comment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_comment_text = $_POST['comment_text'];

    // Prepare and execute the update statement
    $update_sql = "UPDATE comments SET comment_text = :comment_text WHERE comment_id = :comment_id";
    $update_query = $database->prepare($update_sql);
    $result = $update_query->execute(['comment_text' => $new_comment_text, 'comment_id' => $comment_id]);

    if (!$result) {
        var_dump($update_query->errorInfo()); // Display SQL error info if the update fails
    } else {
        // Redirect back to the post view page or show success message
        header("Location: /view?id=" . $comment['post_id']);
        exit();
    }
}
?>

<!-- HTML Form for editing the comment -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Comment</h2>
        <form action="/edit-comment?id=<?= $comment_id; ?>" method="POST">
            <div class="mb-3">
                <label for="comment_text" class="form-label">Your Comment</label>
                <textarea class="form-control" id="comment_text" name="comment_text" rows="3" required><?= htmlspecialchars($comment['comment_text']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Comment</button>
            <a href="/view?id=<?= $comment['post_id']; ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
