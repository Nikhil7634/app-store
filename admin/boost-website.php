<?php
session_start(); // Start the session

// Include configuration
include 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirect to index.php
    exit(); // Stop further script execution
}

// Fetch current settings
$query = "SELECT * FROM boost_website LIMIT 1";
$stmt = $dbh->prepare($query);
$stmt->execute();
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $competitorWebsiteTitle = $_POST['competitor_website_title'] ?? '';
    $competitorWebsiteDescription = $_POST['competitor_website_description'] ?? '';
    $yourWebsiteTitle = $_POST['your_website_title'] ?? '';
    $yourWebsiteDescription = $_POST['your_website_description'] ?? '';

    // Remove logo and favicon handling
    // No need to keep logo and favicon paths
    $logoPath = $faviconPath = ''; // These are no longer needed

    // Update settings in database if settings exist
    if ($settings) {
        $sql = "UPDATE boost_website SET 
                competitor_website_title = :competitor_website_title, 
                competitor_website_description = :competitor_website_description, 
                your_website_title = :your_website_title, 
                your_website_description = :your_website_description
            ";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':competitor_website_title', $competitorWebsiteTitle);
        $stmt->bindParam(':competitor_website_description', $competitorWebsiteDescription);
        $stmt->bindParam(':your_website_title', $yourWebsiteTitle);
        $stmt->bindParam(':your_website_description', $yourWebsiteDescription);

        if ($stmt->execute()) {
            $msg = "Website boosted successfully!";
        } else {
            $error = "Error updating the website settings.";
        }
    } else {
        // Insert new settings if none exist
        $sql = "INSERT INTO boost_website (
                competitor_website_title, 
                competitor_website_description, 
                your_website_title, 
                your_website_description
            ) VALUES (
                :competitor_website_title, 
                :competitor_website_description, 
                :your_website_title, 
                :your_website_description
            )";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':competitor_website_title', $competitorWebsiteTitle);
        $stmt->bindParam(':competitor_website_description', $competitorWebsiteDescription);
        $stmt->bindParam(':your_website_title', $yourWebsiteTitle);
        $stmt->bindParam(':your_website_description', $yourWebsiteDescription);

        if ($stmt->execute()) {
            $msg = "Website boosted successfully!";
        } else {
            $error = "Error inserting the website settings.";
        }
    }
}
?>


<?php include 'includes/header.php'; ?>

<body class="bg-body-light dark:bg-dark-body">
<?php include 'includes/top-navbar.php'; ?>

<!-- Start App Menu -->
<?php include 'includes/left-navbar.php'; ?>
<!-- End App Menu -->

<!-- Start Main Content -->
<div class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
<div class="main-content">
    <div class="grid grid-cols-12 gap-x-4">
        <!-- Boost Website Form -->
        <div class="col-span-full lg:col-span-8">
            <div class="card p-0">
                <div class="flex-center-between p-6 pb-4 border-b border-gray-200 dark:border-dark-border">
                    <h3 class="text-lg card-title leading-none">Boost Website</h3>
                    
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
                <form class="p-6 space-y-4" method="POST" action="" enctype="multipart/form-data">
                    <div>
                        <label for="competitor_website_title" class="form-label">Competitor Website Title</label>
                        <input type="text" id="competitor_website_title" name="competitor_website_title" class="form-input" value="<?php echo htmlspecialchars($settings['competitor_website_title'] ?? ''); ?>" placeholder="Enter the Competitor Website Title" autocomplete="off" required>
                    </div>
                    <div>
                        <label for="competitor_website_description" class="form-label">Competitor Website Description</label>
                        <textarea id="competitor_website_description" name="competitor_website_description" class="form-input" placeholder="Enter the Competitor Website Description" autocomplete="off" required><?php echo htmlspecialchars($settings['competitor_website_description'] ?? ''); ?></textarea>
                    </div>
                    <div>
                        <label for="your_website_title" class="form-label">Your Website Title</label>
                        <input type="text" id="your_website_title" name="your_website_title" class="form-input" value="<?php echo htmlspecialchars($settings['your_website_title'] ?? ''); ?>" placeholder="Enter Your Website Title" autocomplete="off" required>
                    </div>
                    <div>
                        <label for="your_website_description" class="form-label">Your Website Description</label>
                        <textarea id="your_website_description" name="your_website_description" class="form-input" placeholder="Enter Your Website Description" autocomplete="off" required><?php echo htmlspecialchars($settings['your_website_description'] ?? ''); ?></textarea>
                    </div>
                    <!-- Favicon and Logo fields are removed -->
                    <div class="mt-4">
                        <button type="submit" id="boostButton" class="btn b-solid btn-primary-solid px-5 dk-theme-card-square">Save Settings</button>
                    </div>
                </form>
            </div>
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
<script>
document.getElementById('boostButton').addEventListener('click', function() {
    // Show the loader
    document.getElementById('loader').style.display = 'block';
    document.getElementById('successMessage').style.display = 'none';

    // Simulate the "boost" process with a delay
    setTimeout(function() {
        // Hide the loader
        document.getElementById('loader').style.display = 'none';

        // Show the success message
        document.getElementById('successMessage').style.display = 'block';
    }, 5000); // Delay of 5 seconds (5000ms)
});
</script>

</body>
</html>
