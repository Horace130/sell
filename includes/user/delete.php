<?php
// Connect to the database
$database = connectToDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['id'];

    // Step 1: Fetch all posts by the user
    $sql = "SELECT id FROM posts WHERE user_id = :user_id";
    $query = $database->prepare($sql);
    $query->execute(['user_id' => $user_id]);
    $posts = $query->fetchAll();

    // Step 2: Delete all comments related to the user's posts
    foreach ($posts as $post) {
        $sql = "DELETE FROM comments WHERE post_id = :post_id";
        $query = $database->prepare($sql);
        $query->execute(['post_id' => $post['id']]);
    }

    // Step 3: Delete the user's posts
    $sql = "DELETE FROM posts WHERE user_id = :user_id";
    $query = $database->prepare($sql);
    $query->execute(['user_id' => $user_id]);

    // Step 4: Delete the user's comments
    $sql = "DELETE FROM comments WHERE user_id = :user_id";
    $query = $database->prepare($sql);
    $query->execute(['user_id' => $user_id]);

    // Step 5: Now delete the user
    $sql = "DELETE FROM users WHERE id = :user_id";
    $query = $database->prepare($sql);
    $query->execute(['user_id' => $user_id]);

    // Redirect back to manage users page
    header("Location: /manage-users");
    exit;
}
?>
