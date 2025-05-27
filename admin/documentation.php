<?php
session_start(); // Start the session

// Include configuration
include 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirect to index.php
    exit(); // Stop further script execution
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
    <div class="col-span-full md:col-span-full">
                <div class="col-span-full">
                    <!-- Start Banner Area -->
                    <div class="bg-doc-hero bg-primary-600 ac-bg rounded-20 overflow-hidden flex-center flex-col px-4 py-16 mb-4 dk-theme-card-square">
                        <h2 class="text-2xl md:text-3xl xl:text-[42px] font-semibold text-white !leading-none mb-4">
                            Introduction
                        </h2>
                        <!-- Breadcrumb -->
                        <ul class="flex items-center gap-6 *:leading-none *:relative *:after:absolute *:after:font-remix *:after:content-['\ea6e'] *:after:text-white *:after:text-[16px] *:after:top-1/2 *:after:-translate-y-1/2 *:after:-right-5">
                            <li class="last:after:hidden"><a href="#" class="text-sm leading-none text-white">Documentation</a></li>
                            <li class="last:after:hidden"><a href="#" class="text-sm leading-none text-white">Guide</a></li>
                            <li class="last:after:hidden"><a href="#" class="text-sm leading-none text-white">Start</a></li>
                        </ul>
                    </div>
                    <!-- End Banner Area -->

                    <div class="card ">
    <article class="mt-6 ml-4 first:mt-0">
        <h5 class="card-title text-[25px] select-none">Overview</h5>
        <p class="font-spline_sans text-gray-500 dark:text-dark-text text-[15px] leading-[1.62] mt-3">
            This wallpaper website allows users to upload images categorized into specific categories. Administrators can manage categories, customize the website theme, and update essential website details. The following sections provide a comprehensive guide to the website’s features and functionalities.
        </p>
    </article>

    <article class="mt-6 first:mt-0 ml-0 ml-4">
        <h5 class="card-title text-[25px] ">Features</h5>
        <ul class="font-spline_sans text-gray-500 dark:text-dark-text text-[15px] leading-[1.62] mt-3 list-disc pl-5">
            <li><strong>Image Upload:</strong> Upload wallpapers and assign them to categories.</li>
            <li><strong>Category Management:</strong> Add, edit, delete, and organize categories.</li>
            <li><strong>Theme Customization:</strong> Change the appearance of the website with various themes.</li>
            <li><strong>Website Details Update:</strong> Modify website information, including title, tagline, and contact info.</li>
        </ul>
    </article>

    <article class="mt-6 first:mt-0 ml-4">
        <h5 class="card-title text-[25px]">User Roles</h5>
        <ul class="font-spline_sans text-gray-500 dark:text-dark-text text-[15px] leading-[1.62] mt-3 list-disc pl-5">
            <li><strong>Administrator:</strong> Full access to manage all website functionalities.</li>
            <li><strong>Content Manager:</strong> Manage images and categories without access to theme settings.</li>
            <li><strong>Viewer:</strong> Browse and download wallpapers.</li>
        </ul>
    </article>

    <article class="mt-6 first:mt-0 ml-4">
        <h5 class="card-title text-[25px]">Guidelines</h5>
        <ul class="font-spline_sans text-gray-500 dark:text-dark-text text-[15px] leading-[1.62] mt-3 list-disc pl-5">
            <li><strong>Uploading Images:</strong>
                <ol class="list-decimal pl-5">
                    <li>Navigate to the "Upload" section.</li>
                    <li>Select the image file and choose a category.</li>
                    <li>Add a title and optional description.</li>
                    <li>Click "Submit" to upload.</li>
                </ol>
            </li>
            <li><strong>Managing Categories:</strong>
                <ol class="list-decimal pl-5">
                    <li>Go to "Categories" in the admin panel.</li>
                    <li>Use "Add," "Edit," or "Delete" options as needed.</li>
                </ol>
            </li>
            <li><strong>Customizing Themes:</strong>
                <ol class="list-decimal pl-5">
                    <li>Open "Theme Settings" in the dashboard.</li>
                    <li>Choose a theme and adjust settings.</li>
                    <li>Save changes to apply the new theme.</li>
                </ol>
            </li>
        </ul>
    </article>

    <div class="bg-primary-200 dark:bg-dark-icon p-4 rounded-15 mt-6">
        <p class="font-spline_sans text-gray-500 dark:text-dark-text text-[15px] leading-[1.62]">
            <span class="font-semibold">Note:</span> Regularly update the website and backup your database to ensure optimal performance and data security.
        </p>
    </div>

    
</div>
                </div>
            </div>
         
    </div>
<!-- End Main Content -->

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
// Delete wallpaper function
function deleteWallpaper(wallpaperId) {
    if (confirm('Are you sure you want to delete this wallpaper?')) {
        window.location.href = 'delete-items.php?id=' + wallpaperId;
    }
}
</script>
</body>
</html>
