<?php

// 1. connect to database
$database = connectToDB();

// 2. get all the data from the form using $_POST
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];
$id = $_POST['id'];

/* 
    3. do error checking 
    - all the fields are filled
    - password and confirm password are the same
*/
if (empty($password) || empty($confirm_password)) {
    setError("Please fill in all fields.", '/manage-users-changepwd?id=' . $id);
    exit;
} else if ($password !== $confirm_password) {
    setError("Password must be the same.", '/manage-users-changepwd?id=' . $id);
    exit;
}

// 4. update the password
$sql = "UPDATE users SET password = :password WHERE id = :id";
$query = $database->prepare($sql);
$query->execute([
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'id' => $id
]);

// 5. redirect back to /manage-users after successful update
header("Location: /manage-users");
exit;
