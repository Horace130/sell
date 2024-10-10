<?php

// 1. Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 2. Connect to the database
    $database = connectToDB();

    // 3. Get form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    // 4. Perform error checking
    if (empty($name) || empty($role)) {
        setError('All fields are required', '/manage-users-edit?id=' . $id);
        exit;
    }

    // 5. Update the user in the database
    $sql = "UPDATE users SET name = :name, role = :role WHERE id = :id";
    $query = $database->prepare($sql);
    $query->execute([
        'name' => $name,
        'role' => $role,
        'id' => $id
    ]);

    // 6. Redirect to the users management page after successful update
    header('Location: /manage-users');
    exit;
}
?>
