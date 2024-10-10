<?php
require "parts/header.php"; 

// Connect to the database
$database = connectToDB();

// Get the category ID from the URL
$category_id = $_GET['id'];

// Fetch posts by category
$sql = "SELECT posts.*, categories.name AS category_name FROM posts 
        JOIN categories ON posts.category_id = categories.id 
        WHERE categories.id = :category_id";
$query = $database->prepare($sql);
$query->execute(['category_id' => $category_id]);
$posts = $query->fetchAll();

// Display posts in the selected category
if ($posts) {
    foreach ($posts as $post) {
        echo "<h2>{$post['title']}</h2>";
        echo "<p>Category: {$post['category_name']}</p>";
        // Display other post details...
    }
} else {
    echo "<p>No posts found in this category.</p>";
}

require 'parts/footer.php';
?>
