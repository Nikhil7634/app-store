 

<?php
include 'includes/config.php';

// Check if blog ID is provided
if (isset($_GET['id'])) {
    $blogId = $_GET['id'];

    // Prepare and execute the delete query
    $query = "DELETE FROM blogs WHERE id = :id";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':id', $blogId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        // Redirect to the blog list page after deletion
        header("Location: manage-category.php");
        exit();
    } else {
        echo "Error deleting blog.";
    }
} else {
    echo "Blog ID not provided.";
}
?>
