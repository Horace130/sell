<?php

$database = connectToDB();

// Check if user is logged in
if (!isset($_SESSION['user']['id'])) {
    die("Unauthorized access.");
}

// Check if comment_id and post_id are set
if (isset($_POST['comment_id']) && isset($_POST['post_id'])) {
    $comment_id = $_POST['comment_id'];
    $post_id = $_POST['post_id'];

    // Prepare and execute delete statement
    $sql = "DELETE FROM comments WHERE comment_id = :comment_id AND post_id = :post_id"; // Use 'comment_id' here
    $query = $database->prepare($sql);
    
    // Execute the query with parameters
    $query->execute(['comment_id' => $comment_id, 'post_id' => $post_id]);

    // Redirect back to the post view page or show success message
    header("Location: /view?id=" . $post_id);
    exit();
} else {
    echo "Comment ID or Post ID not set.";
}
?>
