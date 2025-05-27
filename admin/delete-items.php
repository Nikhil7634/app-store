<?php
// delete-wallpaper.php

// Include the configuration file
include 'includes/config.php';

// Check if the ID is set
if (isset($_GET['id'])) {
    // Get the wallpaper ID from the URL
    $wallpaperId = $_GET['id'];

    // Prepare the DELETE query
    $query = "DELETE FROM allwallpaper WHERE id = :id";
    $stmt = $dbh->prepare($query);
    
    // Bind the parameter
    $stmt->bindParam(':id', $wallpaperId, PDO::PARAM_INT);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the wallpaper list page with a success message
        header("Location: manage-items.php?message=Wallpaper deleted successfully");
        exit();
    } else {
        // Redirect with an error message
        header("Location: manage-items.php?error=Failed to delete wallpaper");
        exit();
    }
} else {
    // If ID is not set, redirect to the wallpaper list page
    header("Location: manage-items.php");
    exit();
}
?>
