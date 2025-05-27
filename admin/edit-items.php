<?php
session_start(); // Start the session

// Include configuration
include 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirect to index.php
    exit(); // Stop further script execution
}

// Check if category ID is provided
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    // Fetch the category details
    $query = "SELECT * FROM categories WHERE id = :id";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "Category ID not provided.";
    exit();
}

// Handle form submission for updating category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['category_name'];
    $uploadDir = 'uploads/categories/'; // Directory where images will be saved

    // Validate category name
    if (empty($categoryName)) {
        $error = "Category name is required.";
    } else {
        // Handle file upload
        if (!empty($_FILES['category_image']['name'])) {
            $fileName = basename($_FILES['category_image']['name']);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array(strtolower($fileType), $allowedTypes)) {
                // Move uploaded file
                if (move_uploaded_file($_FILES['category_image']['tmp_name'], $targetFilePath)) {
                    $imageQuery = ", category_image = :category_image";
                } else {
                    $error = "Failed to upload image.";
                }
            } else {
                $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            }
        }

        // Update query
        $updateQuery = "UPDATE categories SET category_name = :category_name" . ($imageQuery ?? '') . " WHERE id = :id";
        $stmt = $dbh->prepare($updateQuery);
        $stmt->bindParam(':category_name', $categoryName, PDO::PARAM_STR);
        $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);

        // Bind image param if uploaded
        if (!empty($imageQuery)) {
            $stmt->bindParam(':category_image', $fileName, PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            $msg = "Category updated successfully!";
        } else {
            $error = "Error updating category.";
        }
    }
}

?>

<?php include 'includes/header.php'; ?>

<body class="bg-body-light dark:bg-dark-body group-data-[theme-width=box]:container group-data-[theme-width=box]:max-w-screen-3xl xl:group-data-[theme-width=box]:px-3">
    <?php include 'includes/top-navbar.php'; ?>

    <!-- End Header -->

    <!-- Start App Menu -->
    <?php include 'includes/left-navbar.php'; ?>

    <!-- End App Menu -->

    <!-- Start Main Content -->
    <div class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
        <div class="grid grid-cols-12 gap-x-4">
            <!-- BASIC INPUT -->
            <div class="col-span-full lg:col-span-8">
                <div class="card p-0">
                    <div class="flex-center-between p-6 pb-4 border-b border-gray-200 dark:border-dark-border">
                        <h3 class="text-lg card-title leading-none">Edit Category</h3>
                    </div>

                    <?php if (isset($msg)) : ?>
                        <div class="aleart aleart-success-light rounded-full mt-4">
                            <div class="flex-center gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                </svg>                                  
                                <?php echo $msg; ?>
                            </div>
                            <button class="close-button">
                                <i class="ri-close-line text-inherit"></i>
                            </button>
                        </div>
                     <?php endif; ?>
                    <?php if (isset($error)) : ?>
                        <div class="aleart aleart-danger-light rounded-full mt-4">
                            <div class="flex-center gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"></path>
                                </svg>                                  
                                <?php echo $error; ?>
                            </div>
                            <button class="close-button">
                                <i class="ri-close-line text-inherit"></i>
                            </button>
                        </div>
                     <?php endif; ?>
                    <!-- Form to edit category -->
                    <form class="p-6 space-y-4" method="POST" action="edit-items.php?id=<?php echo $categoryId; ?>" enctype="multipart/form-data">
    <div>
        <label for="category_name" class="form-label">Category Name</label>
        <input type="text" id="category_name" name="category_name" class="form-input" placeholder="Enter the category name" autocomplete="off" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
    </div>
  
    
    <!-- Show Existing Image -->
    <?php if (!empty($category['category_image'])): ?>
        <div>
            <img src="uploads/categories/<?php echo htmlspecialchars($category['category_image']); ?>" alt="Category Image" width="150">
        </div>
    <?php endif; ?>

    <button type="submit" name="submit" class="btn b-solid btn-primary-solid px-5 dk-theme-card-square">Update Category</button>
</form>

                </div>
            </div>
        </div>
    </div>
    <!-- End Main Content -->

    <script src="assets/js/vendor/jquery.min.js"></script>
    <script src="assets/js/vendor/flowbite.min.js"></script>
    <script src="assets/js/vendor/smooth-scrollbar/smooth-scrollbar.min.js"></script>
    <script src="assets/js/vendor/prism.min.js"></script>
    <!-- datatable -->
    <script src="assets/js/vendor/datatables/data-tables.min.js"></script>
    <script src="assets/js/vendor/datatables/data-tables.tailwindcss.min.js"></script>
    <script src="assets/js/vendor/datatables/datatables.init.js"></script>
    <!-- datatable -->
    <script src="assets/js/component/prism-custom.js"></script>
    <script src="assets/js/component/app-menu-bar.js"></script>
    <script src="assets/js/switcher.js"></script>
    <script src="assets/js/layout.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
