<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $embedCode = $_POST['embade_code'] ?? ''; // Get the embed code
    $imagePath = '';

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . uniqid() . '-' . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = $targetPath;
        } else {
            echo "Error uploading the file.";
        }
    }

    // Insert into database
    $sql = "INSERT INTO youtube (title, description, embed_code, image_path) 
            VALUES (:title, :description, :embed_code, :image_path)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':embed_code', $embedCode);
    $stmt->bindParam(':image_path', $imagePath);

    if ($stmt->execute()) {
        $msg = "YouTube details added successfully!";
    } else {
        $error = "Error saving the data.";
    }
}
?>


<?php include 'includes/header.php'; ?>
<body class="bg-body-light dark:bg-dark-body group-data-[theme-width=box]:container group-data-[theme-width=box]:max-w-screen-3xl xl:group-data-[theme-width=box]:px-3">
<?php include 'includes/top-navbar.php'; ?>
<?php include 'includes/left-navbar.php'; ?>

<div class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-7 card">
                <div class="p-1.5">
                    <h6 class="card-title">Add Youtube Video Details</h6>


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
                    <div class="mt-7 pt-0.5">
                        <div class="grid grid-cols-full gap-x-4 gap-y-5">
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="courseTitle" class="form-label">Title</label>
                                <input type="text" id="courseTitle" name="title" placeholder="Title" class="form-input" required>
                            </div>
                             
                            <div class="col-span-full">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" rows="8" class="summernote form-input" required></textarea>
                            </div>


                            <div class="col-span-full">
                                <label class="form-label">Insert Youtube Embed code</label>
                                <textarea   name="embade_code" rows="6" class="form-input " placeholder="Enter your Youtube Embed code here..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-full lg:col-span-5 card">
                <div class="p-1.5">
                    <h6 class="card-title">Add Thumbnail</h6>
                    <div class="mt-7 pt-0.5 flex flex-col gap-5">
                        <div class="col-span-full sm:col-span-4">
                            <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">Image</p>
                            <label for="thumbnailsrc" class="file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer aspect-[4/1.5] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 dark:border-dark-border rounded-10 dk-theme-card-square">
                                <input type="file" id="thumbnailsrc" name="image" hidden class="img-src peer/file" required>
                                <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                    <span class="size-10 md:size-15 flex-center bg-primary-200 dark:bg-dark-icon rounded-50 dk-theme-card-square">
                                        <img src="assets/images/icons/upload-file.svg" alt="icon" class="dark:brightness-200 dark:contrast-100 w-1/2 sm:w-auto">
                                    </span>
                                    <span class="mt-2 text-gray-500 dark:text-dark-text">Choose file</span>
                                </span>
                            </label>
                        </div>
                        <div class="flex-center !justify-end">
                            <button type="submit" class="btn b-solid btn-primary-solid btn-lg dk-theme-card-square">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/vendor/jquery.min.js"></script>
<script src="assets/js/vendor/select/select2.min.js"></script>
<script src="assets/js/vendor/summernote.min.js"></script>
<script src="assets/js/vendor/flowbite.min.js"></script>
<script src="assets/js/vendor/smooth-scrollbar/smooth-scrollbar.min.js"></script>
<script src="assets/js/component/app-menu-bar.js"></script>
<script src="assets/js/switcher.js"></script>
<script src="assets/js/layout.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
