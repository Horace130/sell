<?php

// 1. connect to Database
$database = connectToDB();

// 2. get the user_id from the form
$post_id = $_POST["id"];

// 3. delete the user
// 3.1
$sql = "DELETE FROM posts where id = :id";
// 3.2
$query = $database->prepare( $sql );
// 3.3
$query->execute([
    'id' => $post_id
]);

// 4. redireact to manage users
header("Location: /");
exit;