<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'])) {
    // 1. Get the post ID, user ID (if applicable), and comment content
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user']['id']; // Assuming the user is logged in; replace this with the actual user ID from the session.
    $comment_text = $_POST['content'];

    // 2. Connect to the database
    $database = connectToDB();

    // 3. Insert the comment into the database
    $sql = "INSERT INTO comments (post_id, user_id, comment_text) VALUES (:post_id, :user_id, :comment_text)";
    $query = $database->prepare($sql);
    $query->execute([
        'post_id' => $post_id,
        'user_id' => $user_id, 
        'comment_text' => $comment_text
    ]);

    // 4. Redirect back to the same post page after submission
    header("Location: /post-view?id=$post_id");
    exit;
}