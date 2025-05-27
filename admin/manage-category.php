<?php
session_start(); // Start the session

// Include configuration
include 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirect to index.php
    exit(); // Stop further script execution
}

// Fetch all categories
$query = "SELECT * FROM categories ORDER BY id DESC";
$stmt = $dbh->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);



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

        <!-- BASIC Radius -->
        <div class="col-span-full">
            <div class="card p-0">
                <div class="flex-center-between p-6 pb-4 border-b border-gray-200 dark:border-dark-border">
                    <h3 class="text-lg card-title leading-none">Category List</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div id="basicDataTable_wrapper" class="dataTables_wrapper dt-tailwindcss no-footer">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="my-2 col-span-full overflow-x-auto lg:col-span-9">
                                <table id="basicDataTable" class="table-auto border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium">
                                    <thead>
                                        <tr>
                                             <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Category Name</th>
                                            <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one w-10">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                                        <!-- Dynamic data will be inserted here -->
                                        <?php foreach ($categories as $category): ?>
                                            <tr class="transition-all duration-150 ease-linear [&.selected]:bg-[#F2F4F9] dark:[&.selected]:bg-dark-icon">
                                             
                                                <td class="p-6 py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting_1 capitalize"><?php echo htmlspecialchars($category['category_name']); ?></td>
                                                <td class="p-6 py-4 dk-border-one">
                                                    <div class="flex items-center gap-2">
                                                        <!-- Edit Button -->
                                                        <a href="edit-items.php?id=<?php echo $category['id']; ?>" class="btn-icon btn-primary-icon-light size-7">
                                                            <i class="ri-edit-2-line text-inherit text-[13px]"></i>
                                                        </a>
                                                        <!-- Delete Button -->
                                                        <a href="javascript:void(0)" class="btn-icon btn-danger-icon-light size-7" onclick="deleteCategory(<?php echo $category['id']; ?>)">
                                                            <i class="ri-delete-bin-line text-inherit text-[13px]"></i>
                                                        </a>

                                                    
                                                        <a href="category-items.php?category_id=<?php echo $category['id']; ?>" class="badge badge-success-light">Manage Games</a>
                                                        
                                                         
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
// Delete category function
function deleteCategory(categoryId) {
    if (confirm('Are you sure you want to delete this category?')) {
        window.location.href = 'delete-category.php?id=' + categoryId;
    }
}
</script>
</body>
</html>
