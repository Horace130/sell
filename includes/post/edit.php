<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Connect to the database
    $database = connectToDB();

    // 2. Get all the data from the form using $_POST
    $id = $_POST['id'];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $status = $_POST["status"];

    // 3. Check if required fields are filled
    if (empty($title) || empty($content) || empty($status) || empty($id)) {
        header("Location: /manage-posts-edit?id=$id&error=All fields are required.");
        exit;
    }

    // 4. Handle file upload if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        // Update the post with the new image
        $sql = "UPDATE posts SET title = :title, content = :content, status = :status, image_url = :image_url WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute([
            'title' => $title,
            'content' => $content,
            'status' => $status,
            'image_url' => $target_file,
            'id' => $id
        ]);
    } else {
        // No image uploaded, update only the other fields
        $sql = "UPDATE posts SET title = :title, content = :content, status = :status WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute([
            'title' => $title,
            'content' => $content,
            'status' => $status,
            'id' => $id
        ]);
    }

    // 5. Redirect after successful update
    header("Location: /view");
    exit;
}
?>
