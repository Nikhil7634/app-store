<?php
session_start(); // Start the session

// Include configuration
include 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirect to index.php
    exit(); // Stop further script execution
}

// Check if the category_id is set in the URL
if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];

    // Fetch category name
    $categoryQuery = "SELECT category_name FROM categories WHERE id = :category_id";
    $categoryStmt = $dbh->prepare($categoryQuery);
    $categoryStmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    $categoryStmt->execute();
    $category = $categoryStmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        // If the category does not exist, redirect to category list page
        header("Location: manage-category.php");
        exit();
    }

    $categoryName = $category['category_name'];

    // Fetch the items related to this category
    $query = "SELECT aw.*, c.category_name FROM allwallpaper aw 
              JOIN categories c ON aw.category_id = c.id 
              WHERE aw.category_id = :category_id";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();
    $wallpapers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If no category_id is set, redirect to the category list page
    header("Location: manage-category.php");
    exit();
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
        <div class="col-span-full">
            <div class="card p-0">
                <div class="flex justify-between p-6 pb-4 border-b border-gray-200 dark:border-dark-border">
                    <h3 class="text-lg font-bold">Items for Category: <?php echo htmlspecialchars($categoryName); ?></h3>
                </div>
                <div class="p-6 space-y-4">
                    <?php if (empty($wallpapers)): ?>
                        <p class="text-center text-gray-500 dark:text-gray-300">No items found in this category.</p>
                    <?php else: ?>
                        <div id="dataTableWrapper" class="overflow-x-auto">
                            <table id="basicDataTable" class="table-auto border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium dataTable align-middle text-sm dark:text-gray-400 no-footer">
                                <thead>
                                    <tr>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one py-3 group-[.bordered]:border group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting bg-slate-200/50 font-semibold text-left first:rounded-l-lg last:rounded-r-lg group-[.bordered]:rounded-none sorting_desc" tabindex="0" aria-controls="basicDataTable" rowspan="1" colspan="1" aria-label="Image: activate to sort column ascending" style="width: 154.05px;" aria-sort="descending">Image</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one py-3 group-[.bordered]:border group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting bg-slate-200/50 font-semibold text-left first:rounded-l-lg last:rounded-r-lg group-[.bordered]:rounded-none" tabindex="0" aria-controls="basicDataTable" rowspan="1" colspan="1" aria-label="Title: activate to sort column ascending" style="width: 393.775px;">Title</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one py-3 group-[.bordered]:border group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting bg-slate-200/50 font-semibold text-left first:rounded-l-lg last:rounded-r-lg group-[.bordered]:rounded-none" tabindex="0" aria-controls="basicDataTable" rowspan="1" colspan="1" aria-label="Description: activate to sort column ascending" style="width: 163.938px;">Description</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one py-3 group-[.bordered]:border group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting bg-slate-200/50 font-semibold text-left first:rounded-l-lg last:rounded-r-lg group-[.bordered]:rounded-none" tabindex="0" aria-controls="basicDataTable" rowspan="1" colspan="1" aria-label="Category: activate to sort column ascending" style="width: 136.237px;">Category</th>
                                        <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one w-10 py-3 group-[.bordered]:border group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting bg-slate-200/50 font-semibold text-left first:rounded-l-lg last:rounded-r-lg group-[.bordered]:rounded-none" tabindex="0" aria-controls="basicDataTable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 63.2px;">Action</th>
                                    </tr>
                                </thead>
                               
                                
                                <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                                    <?php foreach ($wallpapers as $wallpaper): ?>
                                        <tr class="transition-all duration-150 ease-linear [&.selected]:bg-[#F2F4F9] dark:[&.selected]:bg-dark-icon">
                                            <td class="p-6 flex items-center py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border capitalize">
                                                <a class="size-[70px] overflow-hidden">
                                                    <img class="rounded-" src="<?php echo htmlspecialchars($wallpaper['image_path']); ?>" alt="Wallpaper">
                                                </a>
                                            </td>
                                            <td class="p-6 py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border capitalize"><?php echo htmlspecialchars($wallpaper['title']); ?></td>
                                            <td class="p-6 py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border capitalize"><?php echo htmlspecialchars(strip_tags($wallpaper['description'])); ?></td>
                                            <td class="p-6 py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border capitalize"><?php echo htmlspecialchars($wallpaper['category_name']); ?></td>
                                            <td class="p-6 py-4 dk-border-one group-[.bordered]:border group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border">
                                                <div class="flex items-center gap-2">
                                                    <a href="edit-wallpaper.php?id=<?php echo $wallpaper['id']; ?>" class="btn-icon btn-primary-icon-light size-7">
                                                        <i class="ri-edit-2-line text-inherit text-[13px]"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn-icon btn-danger-icon-light size-7" onclick="deleteWallpaper(<?php echo $wallpaper['id']; ?>)">
                                                        <i class="ri-delete-bin-line text-inherit text-[13px]"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
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
function deleteWallpaper(wallpaperId) {
    if (confirm('Are you sure you want to delete this wallpaper?')) {
        window.location.href = `delete-items.php?id=${wallpaperId}`;
    }
}
</script>

</body>
</html>
