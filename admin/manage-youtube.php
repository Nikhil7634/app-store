<?php
session_start(); // Start the session

// Include configuration
include 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirect to index.php
    exit(); // Stop further script execution
}

// Fetch all YouTube videos
$query = "SELECT * FROM youtube ORDER BY id DESC";
$stmt = $dbh->prepare($query);
$stmt->execute();
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                
                <div class="flex-center-between p-6 pb-4 border-b border-gray-200 dark:border-dark-border">
                    <h3 class="text-lg card-title leading-none">All Games List</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div id="basicDataTable_wrapper" class="dataTables_wrapper dt-tailwindcss no-footer">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="my-2 col-span-full overflow-x-auto lg:col-span-full">
                                <table id="basicDataTable" class="table-auto border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium">
                                    <thead>
                                    <tr>
                                    <th class="p-6 py-4 bg-gray-100 dark:bg-dark-card">Thumbnail</th>
                                    <th class="p-6 py-4 bg-gray-100 dark:bg-dark-card">Title</th>
                                    <th class="p-6 py-4 bg-gray-100 dark:bg-dark-card">Description</th>
                                    <th class="p-6 py-4 bg-gray-100 dark:bg-dark-card w-10">Action</th>
                                </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                                    <?php foreach ($videos as $video): ?>
                                    <tr class="transition-all duration-150 ease-linear [&.selected]:bg-[#F2F4F9] dark:[&.selected]:bg-dark-icon">
                                        <td class="p-6 flex items-center py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting_1 capitalize">
                                            <a class="size-[70px] overflow-hidden">
                                                <img class="rounded" src="<?php echo htmlspecialchars($video['image_path']); ?>" alt="Thumbnail">
                                            </a>
                                        </td>
                                        <td class="p-6 py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting_1 capitalize">
                                            <?php
                                            $title = strip_tags(html_entity_decode($video['title']));
                                            $titleWords = explode(' ', $title);
                                            $shortTitle = implode(' ', array_slice($titleWords, 0, 7));
                                            echo htmlspecialchars($shortTitle) . '...';
                                            ?>
                                        </td>
                                        <td class="p-6 py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting_1 capitalize">
                                            <?php
                                            $description = strip_tags(html_entity_decode($video['description']));
                                            $words = explode(' ', $description);
                                            $shortDescription = implode(' ', array_slice($words, 0, 10));
                                            echo '<p class="card-description">' . htmlspecialchars($shortDescription) . '...</p>';
                                            ?>
                                        </td>
                                        <td class="p-6 py-3 group-[.bordered]:border dk-border-one group-[.bordered]:border-gray-200 dark:group-[.bordered]:border-dark-border sorting_1 capitalize">
                                            <div class="flex items-center gap-2">
                                                <a href="edit-youtube.php?id=<?php echo $video['id']; ?>" class="btn-icon btn-primary-icon-light size-7">
                                                    <i class="ri-edit-2-line text-[13px]"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="btn-icon btn-danger-icon-light size-7" onclick="deleteVideo(<?php echo $video['id']; ?>)">
                                                    <i class="ri-delete-bin-line text-[13px]"></i>
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
// Delete video function
function deleteVideo(videoId) {
    if (confirm('Are you sure you want to delete this video?')) {
        window.location.href = 'delete-youtube.php?id=' + videoId;
    }
}
</script>
</body>
</html>
