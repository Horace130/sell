<?php

// 1. Connect to the database
$database = connectToDB();
$target_dir = "uploads/";


$target_file = $target_dir . basename($_FILES["image"]["name"]);


move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);


$title = $_POST['title'];
$content = $_POST['content'];
$image_url = $target_file; 

// 4. Prepare and execute the SQL statement
$sql = "INSERT INTO posts (`title`, `content`, `user_id`, `image_url`) VALUES (:title, :content, :user_id, :image_url)";
$query = $database->prepare($sql);
$query->execute([
    'title' => $title,
    'content' => $content,
    'user_id' => $_SESSION['user']['id'],
    'image_url' => $image_url
]);

// 5. Redirect to the main page
header("Location: /");
exit;

