<?php 
session_start(); // Start the session

// Include configuration
include 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirect to index.php
    exit(); // Stop further script execution
}

// Fetch categories
$query = "SELECT * FROM categories ORDER BY id DESC LIMIT 10";
$stmt = $dbh->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch wallpapers with category names
$query = "SELECT allwallpaper.*, categories.category_name AS category_name 
          FROM allwallpaper 
          LEFT JOIN categories ON allwallpaper.category_id = categories.id 
          ORDER BY allwallpaper.id DESC LIMIT 10";
$stmt = $dbh->prepare($query);
$stmt->execute();
$wallpapers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count total categories
$query = "SELECT COUNT(*) AS total_categories FROM categories";
$stmt = $dbh->prepare($query);
$stmt->execute();
$totalCategories = $stmt->fetch(PDO::FETCH_ASSOC)['total_categories'];

// Count total wallpapers
$query = "SELECT COUNT(*) AS total_wallpapers FROM allwallpaper";
$stmt = $dbh->prepare($query);
$stmt->execute();
$totalWallpapers = $stmt->fetch(PDO::FETCH_ASSOC)['total_wallpapers'];

// Include header
include('includes/header.php'); 
?>


<body class="bg-body-light dark:bg-dark-body group-data-[theme-width=box]:container group-data-[theme-width=box]:max-w-screen-3xl xl:group-data-[theme-width=box]:px-3">
    
    <!-- Start Header -->
    <?php include('includes/top-navbar.php'); ?>
    <!-- End Header -->

    <!-- Start App Menu -->
    <?php include('includes/left-navbar.php'); ?>
    <!-- End App Menu -->

    <!-- Start App Settings Sidebar -->
    
    <!-- End App Settings Sidebar -->

    <!-- Start Main Content -->
    <div   class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
        <div class="grid grid-cols-12 gap-x-4">
            <!-- Start Intro -->
            <div class="col-span-full 2xl:col-span-7 card p-0">
                <div class="grid grid-cols-12 px-5 sm:px-12 py-11 relative overflow-hidden h-full">
                    <div class="col-span-full md:col-span-7 self-center inline-flex flex-col 2xl:block">
                        <p class="!leading-none text-sm lg:text-base text-gray-900 dark:text-dark-text">
                            Today is <span class="today">Thursday, 25 Jul 2024</span>
                        </p>
                        <h1 class="text-heading text-4xl xl:text-[42px] leading-[1.23] font-semibold mt-3  capitalize">
                            <span class="flex items-center justify-start">
                                <span class="shrink-0">Welcome Back.</span>
                                <span class="select-none hidden md:inline-block animate-hand-wave origin-[70%_70%]">👋</span><br>
                            </span>
                            <?php echo htmlspecialchars($adminName); ?>
                        </h1>
                        <a href="additem.php" class="btn b-solid btn-primary-solid btn-lg mt-6 dk-theme-card-square">
                            <i class="ri-add-line text-inherit"></i>
                            Add new Game
                        </a>
                    </div>
                    <div class="col-span-full md:col-span-5 flex-col items-center justify-center 2xl:block hidden md:flex">
                        <img src="assets/images/loti/loti-admin-dashboard.svg" alt="online-workshop" class="group-[.dark]:hidden">
                        <img src="assets/images/loti/loti-admin-dashboard-dark.svg" alt="online-workshop" class="group-[.light]:hidden">
                    </div>
                    <!-- Graphicla Elements -->
                    <ul>
                        <li class="absolute -top-[30px] left-1/2 animate-spin-slow">
                            <img src="assets/images/element/graphical-element-1.svg" alt="element">
                        </li>
                        <li class="absolute -bottom-[24px] left-1/4 animate-spin-slow">
                            <img src="assets/images/element/graphical-element-2.svg" alt="element">
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Intro -->
            <!-- Start Short Progress Card -->
            <div class="col-span-full 2xl:col-span-5 card">
                <div class="grid grid-cols-12 gap-4">
                    <!-- Total Revenue Progress Card -->
                    <div class="col-span-full sm:col-span-6 p-[10px_16px] dk-border-one rounded-xl h-full dk-theme-card-square">
                        <div class="flex-center-between">
                            <h6 class="leading-none text-gray-500 dark:text-white font-semibold">Total Games</h6>
                            <div class="leading-none shrink-0 text-xs text-gray-900 dark:text-dark-text dk-border-one rounded-full dk-theme-card-square px-2 py-1">All</div>
                        </div>
                        <div class="pt-3 bg-card-pattern dark:bg-card-pattern-dark bg-no-repeat bg-100% flex gap-4 mt-3">
                            <div class="pb-8 shrink-0">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="card-title">
                                        Total = <span class="counter-value" data-value="<?php echo $totalWallpapers; ?>">0</span>
                                    </div>
                                    <div class="flex-center text-primary-500 size-5 rounded-50 border border-primary-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" viewBox="0 0 6 6" fill="none">
                                            <path d="M3.38569 1.43565L5.45455 3.44715L6 2.91683L3 0L0 2.91683L0.545456 3.44715L2.6143 1.43565V6H3.38569V1.43565Z" fill="currentColor"/>
                                        </svg>
                                    </div>
                                </div>
                                 
                            </div>
                            <div class="grow self-center pb-3">
                                <div id="admin-total-revenue-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Enrollments Progress Card -->
                    <div class="col-span-full sm:col-span-6 p-[10px_16px] dk-border-one rounded-xl h-full dk-theme-card-square">
                        <div class="flex-center-between">
                            <h6 class="leading-none text-gray-500 dark:text-white font-semibold">Total Categories</h6>
                            <div class="leading-none shrink-0 text-xs text-gray-900 dark:text-dark-text dk-border-one rounded-full dk-theme-card-square px-2 py-1">All</div>
                        </div>
                        <div class="pt-3 bg-card-pattern dark:bg-card-pattern-dark bg-no-repeat bg-100% flex gap-4 mt-3">
                            <div class="pb-8 shrink-0">
                                <div class="flex items-center gap-2 mb-3">
                                Total = <div class="counter-value card-title" data-value="<?php echo $totalCategories; ?>">0</div>
                                    <div class="flex-center text-danger size-5 rounded-50 border border-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" viewBox="0 0 6 6" fill="none">
                                            <path d="M3.38569 1.43565L5.45455 3.44715L6 2.91683L3 0L0 2.91683L0.545456 3.44715L2.6143 1.43565V6H3.38569V1.43565Z" fill="currentColor"/>
                                        </svg>
                                    </div>
                                </div>
                             
                            </div>
                            <div class="grow self-center pb-3">
                                <div id="total-enrollment-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Courses Progress Card -->
                    <div class="col-span-full sm:col-span-6 p-[10px_16px] dk-border-one rounded-xl h-full dk-theme-card-square">
                        <div class="flex-center-between">
                            <h6 class="leading-none text-gray-500 dark:text-white font-semibold">Total Visiter</h6>
                            <div class="leading-none shrink-0 text-xs text-gray-900 dark:text-dark-text dk-border-one rounded-full dk-theme-card-square px-2 py-1">All</div>
                        </div>
                        <div class="pt-3 bg-card-pattern dark:bg-card-pattern-dark bg-no-repeat bg-100% flex gap-4 mt-3">
                            <div class="pb-8 shrink-0">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="counter-value card-title" data-value="25000">0</div>
                                    <div class="flex-center text-primary-500 size-5 rounded-50 border border-primary-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" viewBox="0 0 6 6" fill="none">
                                            <path d="M3.38569 1.43565L5.45455 3.44715L6 2.91683L3 0L0 2.91683L0.545456 3.44715L2.6143 1.43565V6H3.38569V1.43565Z" fill="currentColor"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="leading-none text-gray-900 dark:text-dark-text font-semibold">
                                    <span class="text-primary-500">50%</span>
                                    Below Target
                                </div>
                            </div>
                            <div class="grow self-center pb-3">
                                <div id="total-course-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Average rating Progress Card -->
                    <div class="col-span-full sm:col-span-6 p-[10px_16px] dk-border-one rounded-xl h-full dk-theme-card-square">
                        <div class="flex-center-between">
                            <h6 class="leading-none text-gray-500 dark:text-white font-semibold">Average rating</h6>
                            <div class="leading-none shrink-0 text-xs text-gray-900 dark:text-dark-text dk-border-one rounded-full dk-theme-card-square px-2 py-1">All</div>
                        </div>
                        <div class="pt-3 bg-card-pattern dark:bg-card-pattern-dark bg-no-repeat bg-100% flex gap-4 mt-3">
                            <div class="pb-8 shrink-0">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="counter-value card-title" data-value="4.5">0</div>
                                    <div class="flex-center text-primary-500 size-5 rounded-50 border border-primary-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" viewBox="0 0 6 6" fill="none">
                                            <path d="M3.38569 1.43565L5.45455 3.44715L6 2.91683L3 0L0 2.91683L0.545456 3.44715L2.6143 1.43565V6H3.38569V1.43565Z" fill="currentColor"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="leading-none text-gray-900 dark:text-dark-text font-semibold">
                                    <span class="text-primary-500">05%</span>
                                    Below Target
                                </div>
                            </div>
                            <div class="grow self-center pb-3">
                                <div id="average-rating-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Short Progress Card -->
            <!-- Start Average Enrollment Rate Chart -->
            <div class="col-span-full 2xl:col-span-8">
                 
                <div class="flex-center-between p-6 pb-4 border-b border-gray-200 dark:border-dark-border card">
                    <h3 class="text-lg card-title leading-none">All Games List</h3>
                </div>
                <div class="p-6 space-y-4 card">
                    <div id="basicDataTable_wrapper" class="dataTables_wrapper dt-tailwindcss no-footer ">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="my-2 col-span-full overflow-x-auto lg:col-span-full">
                                <table id="basicDataTable" class="table-auto  border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium">
                                    <thead>
                                        <tr>
                                            <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Image</th>
                                            <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Title</th>
                                            <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Description</th>
                                            <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one">Category</th>
                                            <th class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two dk-border-one w-10">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                                        <?php foreach ($wallpapers as $wallpaper): ?>
                                            <tr class="transition-all duration-150 ease-linear [&.selected]:bg-[#F2F4F9] dark:[&.selected]:bg-dark-icon">
                                                <td class="p-6 flex items-center py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting_1 capitalize">
                                                    <a class="size-[70px] overflow-hidden">
                                                        <img class="rounded-" src="<?php echo htmlspecialchars($wallpaper['image_path']); ?>" alt="Wallpaper">
                                                    </a>
                                                </td>
                                                <td class="p-6 py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting_1 capitalize"><?php echo htmlspecialchars($wallpaper['title']); ?></td>
                                                <td class="p-6 py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting_1 capitalize"> <?php
// Extract the description
$description = html_entity_decode($wallpaper['description']);

// Remove images and other HTML tags
$plainText = strip_tags($description);

// Split the plain text into words
$words = explode(' ', $plainText);

// Get the first 20 words
$shortDescription = implode(' ', array_slice($words, 0, 10));

// Display the shortened description
echo '<p class="card-description">' . htmlspecialchars($shortDescription) . '...</p>';
?>
</td>
                                                <td class="p-6 py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting_1 capitalize"><?php echo htmlspecialchars($wallpaper['category_name']); ?></td>
                                                <td class="p-6 py-4 dk-border-one">
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
                        </div>
                    </div>
                </div>
             </div>
            <!-- End Average Enrollment Rate Chart -->
            <!-- Start Top Performing Course -->
            <div class="col-span-full 2xl:col-span-4 card">
                <div class="flex-center-between">
                    <h6 class="card-title">Top 10 Categories</h6>
                    <a href="manage-category.php" class="btn b-solid btn-primary-solid btn-sm dk-theme-card-square">See all</a>
                </div>
                <!-- Course Table -->
                 <div id="basicDataTable_wrapper" class="dataTables_wrapper dt-tailwindcss no-footer mt-5 ">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="my-2 col-span-full overflow-x-auto lg:col-span-full">
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
    if (confirm('Are you sure you want to delete this Game?')) {
        window.location.href = 'delete-items.php?id=' + wallpaperId;
    }
}
</script>

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