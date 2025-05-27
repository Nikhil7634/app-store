<?php
session_start(); // Start the session

// Include configuration
include 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Handle the form submission
if (isset($_POST['update'])) {
    $newUsername = $_POST['newUsername'];
    $newPassword = md5($_POST['newPassword']); // Encrypt the password

    // Prepare the SQL query to update the user details
    $sql = "UPDATE admin SET UserName=:newUsername, Password=:newPassword WHERE UserName=:currentUsername";
    $query = $dbh->prepare($sql);
    $query->bindParam(':newUsername', $newUsername, PDO::PARAM_STR);
    $query->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
    $query->bindParam(':currentUsername', $_SESSION['username'], PDO::PARAM_STR);

    // Execute the query
    if ($query->execute()) {
        // Update session username
        $_SESSION['username'] = $newUsername;
        echo "<script>alert('Details updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update details. Please try again.');</script>";
    }
}

?>

<?php include('includes/header.php'); ?>

<body class="bg-body-light dark:bg-dark-body group-data-[theme-width=box]:container group-data-[theme-width=box]:max-w-screen-3xl xl:group-data-[theme-width=box]:px-3">
<?php include 'includes/top-navbar.php'; ?>
<!-- End Header -->

<!-- Start App Menu -->
<?php include 'includes/left-navbar.php'; ?>

<div class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-8">
        <div class="main-content m-4">
        <div class="container max-w-lg p-6  rounded-lg shadow-lg">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Update Admin Details</h3>
            <form method="post" class="leading-none mt-8">
                <div class="mb-2.5">
                    <label for="newUsername" class="form-label">New Username</label>
                    <input type="text" id="newUsername" name="newUsername" placeholder="Enter new username" required class="form-input px-4 py-3.5 rounded-lg">
                </div>
                <div class="mt-5">
                    <label for="newPassword" class="form-label">New Password</label>
                    <div class="relative">
                        <input type="password" id="newPassword" name="newPassword" placeholder="Enter new password" required class="form-input px-4 py-3.5 rounded-lg">
                        <label for="toggleInputType" class="size-8 rounded-md flex-center hover:bg-gray-200 dark:hover:bg-dark-icon focus:bg-gray-200 dark:focus:bg-dark-icon position-center !left-auto -right-2.5">
                            <input type="checkbox" id="toggleInputType" class="inputTypeToggle peer/it" hidden>
                            <i class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                        </label>
                    </div>
                </div>
                <button type="submit" name="update" class="btn b-solid btn-primary-solid dk-theme-card-square mt-5">Update Details</button>
            </form>
        </div>
    </div>
        </div>
    </div>

    

   
<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
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
