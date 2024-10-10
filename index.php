<?php 

// Start a session
session_start();

// Include necessary functions
require 'includes/functions.php';

// Get the current path the user is on
$path = $_SERVER["REQUEST_URI"];

// Remove query string from the URL
$path = parse_url($path, PHP_URL_PATH);

// Determine what to do based on the user action
switch ($path) {
    // Auth-related routes
    case '/auth/signup':
        require 'includes/auth/signup.php';
        break;
    case '/auth/login':
        require 'includes/auth/login.php';
        break;

    // Pages
    case '/login':
        require 'pages/login.php';
        break;
    case '/signup':
        require 'pages/signup.php';
        break;
    case '/posts-add':
        require 'pages/posts-add.php';
        break;
    case '/edit-views':
        require 'pages/edit-views.php';
        break;
    case '/logout':
        require 'pages/logout.php';
        break;

    // Post-related actions
    case '/post/add':
        require 'includes/post/add.php';
        break;
    case '/post/delete':
        require 'includes/post/delete.php';
        break;
    case '/post/edit':
        require 'includes/post/edit.php';
        break;

    // View post

    case '/post-view':
        require 'pages/post-view.php';
        break;

    // Comment routes
    case '/add-comment':
        require 'includes/post/add-comment.php'; 
        break;
    case '/edit-comment':
        require 'includes/post/edit-comment.php';
        break;
    case '/delete-comment':
        require 'includes/post/delete-comment.php';  // Add delete-comment route
        break;
        // Category management routes
    case '/categories/add':
        require 'includes/categories/add-category.php';
        break;
    case '/categories/edit':
        require 'includes/categories/edit-category.php';
        break;
    case '/categories/delete':
        require 'includes/categories/delete-category.php';
        break;
    case '/categories/list':
        require 'includes/categories/list-categories.php';
        break;

    // Default route to home if path is not found
    default:
        require 'pages/home.php';
        break;
}
