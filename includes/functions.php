<?php

// connect to database
function connectToDB() {
    // Step 1: list out all the database info
     $host = 'localhost';
     $database_name = 'sell';
     $database_user = 'root';
     $database_password = 'pass123';
  
     // Step 2: connect to the database
     $database = new PDO(
      "mysql:host=$host;dbname=$database_name",
      $database_user,
      $database_password
    );
    
    return $database;
}
// set error message
function setError( $error_message, $redirect_page ) {
    $_SESSION["error"] = $error_message;
    // redirect back to login page
    header("Location: " . $redirect_page );
    exit;
}
// check if user is logged in or not
function checkIfuserIsNotLoggedIn() {
    // check if whoever that viewing this page is logged in.
    // if not logged in, you want to redirect back to login page
    if ( !isset( $_SESSION['user'] ) ) {
      header("Location: /login");
      exit;
    }
  }
  // check if current user is an admin or not
function checkIfIsNotAdmin() {
    if ( isset( $_SESSION['user'] ) && $_SESSION['user']['role'] != 'admin' ) {
        header("Location: /");
        exit;
    }
}
function checkIfIsNotEditor() {
    if ( isset( $_SESSION['user'] ) && $_SESSION['user']['role'] != 'editor' ) {
        header("Location: /dashboard");
        exit;
    }
}
