<?php
include 'includes/config.php';

// Check if category ID is provided
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    // Prepare and execute the delete query
    $query = "DELETE FROM categories WHERE id = :id";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        // Redirect to the category list page after deletion
        header("Location: manage-category.php");
        exit();
    } else {
        echo "Error deleting category.";
    }
} else {
    echo "Category ID not provided.";
}
?>
