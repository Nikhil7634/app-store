<?php
session_start();
include 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

// Check if the video ID is provided
if (isset($_GET['id'])) {
    $videoId = $_GET['id'];

    // Prepare the SQL query to delete the video
    $sql = "DELETE FROM youtube WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $videoId);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the video list page with a success message
        header("Location: manage-youtube.php?msg=Video deleted successfully");
        exit();
    } else {
        // Redirect back to the video list page with an error message
        header("Location: manage-youtube.php?error=Error deleting the video");
        exit();
    }
} else {
    // Redirect back to the video list page if no ID is provided
    header("Location: manage-youtube.php?error=Invalid video ID");
    exit();
}
?>