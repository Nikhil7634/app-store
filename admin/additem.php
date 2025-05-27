<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

// Fetch all categories
$query = "SELECT id, category_name FROM categories ORDER BY id DESC";
$stmt = $dbh->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $categoryId = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';
    $codeSnippet = $_POST['code_snippet'] ?? '';
    $appRating = $_POST['app_rating'] ?? '';
    $companyName = $_POST['company_name'] ?? '';
    $supportVersion = $_POST['support_version'] ?? '';
    $appVersion = $_POST['app_version'] ?? '';
    $imagePath = '';
    $screenshotPaths = [];

    // Handle single image upload (main image)
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
            echo "Error uploading the main image.";
        }
    }

    // Handle multiple screenshot uploads
    if (isset($_FILES['screenshots']) && !empty($_FILES['screenshots']['name'][0])) {
        $uploadDir = 'Uploads/screenshots/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES['screenshots']['name'] as $key => $name) {
            if ($_FILES['screenshots']['error'][$key] === UPLOAD_ERR_OK) {
                $fileName = basename($name);
                $targetPath = $uploadDir . uniqid() . '-' . $fileName;

                if (move_uploaded_file($_FILES['screenshots']['tmp_name'][$key], $targetPath)) {
                    $screenshotPaths[] = $targetPath;
                } else {
                    echo "Error uploading screenshot: $name";
                }
            }
        }
    }

    // Convert screenshot paths to a comma-separated string
    $screenshots = !empty($screenshotPaths) ? implode(',', $screenshotPaths) : '';

    // Insert into database
    $sql = "INSERT INTO allwallpaper (title, category_id, description, code_snippet, image_path, screenshots, app_rating, company_name, support_version, app_version) 
            VALUES (:title, :category_id, :description, :code_snippet, :image_path, :screenshots, :app_rating, :company_name, :support_version, :app_version)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':category_id', $categoryId);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':code_snippet', $codeSnippet);
    $stmt->bindParam(':image_path', $imagePath);
    $stmt->bindParam(':screenshots', $screenshots);
    $stmt->bindParam(':app_rating', $appRating);
    $stmt->bindParam(':company_name', $companyName);
    $stmt->bindParam(':support_version', $supportVersion);
    $stmt->bindParam(':app_version', $appVersion);

    if ($stmt->execute()) {
        $msg = "Game details added successfully!";
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
                    <h6 class="card-title">Add Game Details</h6>

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
                        <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="courseTitle" class="form-label">Title</label>
                                <input type="text" id="courseTitle" name="title" placeholder="Title" class="form-input" required>
                            </div>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label class="form-label">Game Category</label>
                                <select class="singleSelect" name="category" required>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                            <?php echo htmlspecialchars($category['category_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="appRating" class="form-label">App Rating</label>
                                <input type="number" id="appRating" name="app_rating" placeholder="e.g., 9.5" step="0.1" min="0" max="10" class="form-input" required>
                            </div>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="companyName" class="form-label">Company Name</label>
                                <input type="text" id="companyName" name="company_name" placeholder="e.g., Example Inc." class="form-input" required>
                            </div>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="supportVersion" class="form-label">Support Version</label>
                                <input type="text" id="supportVersion" name="support_version" placeholder="e.g., Android 10+" class="form-input" required>
                            </div>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="appVersion" class="form-label">App Version</label>
                                <input type="text" id="appVersion" name="app_version" placeholder="e.g., 1.0.0" class="form-input" required>
                            </div>
                            <div class="col-span-full">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" rows="8" class="summernote form-input" required></textarea>
                            </div>
                            <div class="col-span-full">
                                <label class="form-label">Insert Downloading Link</label>
                                <textarea name="code_snippet" rows="6" class="form-input" placeholder="Enter your Downloading Link here..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-full lg:col-span-5 card">
                <div class="p-1.5">
                    <h6 class="card-title">Add Images</h6>
                    <div class="mt-7 pt-0.5 flex flex-col gap-5">
                        <div class="col-span-full sm:col-span-4">
                            <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">App Icon</p>
                            <label for="thumbnailsrc" class="file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer aspect-[4/1.5] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 dark:border-dark-border rounded-10 dk-theme-card-square">
                                <input type="file" id="thumbnailsrc" name="image" hidden class="img-src peer/file" required onchange="previewImage(this, 'main-image-preview')">
                                <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                    <span class="size-10 md:size-15 flex-center bg-primary-200 dark:bg-dark-icon rounded-50 dk-theme-card-square">
                                        <img src="assets/images/icons/upload-file.svg" alt="icon" class="dark:brightness-200 dark:contrast-100 w-1/2 sm:w-auto">
                                    </span>
                                    <span class="mt-2 text-gray-500 dark:text-dark-text">Choose file</span>
                                </span>
                            </label>
                            <div id="main-image-preview" class="mt-3"></div>
                        </div>
                        <div class="col-span-full sm:col-span-4">
                            <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">Screenshots</p>
                            <div id="screenshot-container">
                                <label for="screenshots-0" class="file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer aspect-[4/1.5] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 dark:border-dark-border rounded-10 dk-theme-card-square">
                                    <input type="file" id="screenshots-0" name="screenshots[]" hidden class="img-src peer/file" onchange="previewImage(this, 'screenshot-preview-0')">
                                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                        <span class="size-10 md:size-15 flex-center bg-primary-200 dark:bg-dark-icon rounded-50 dk-theme-card-square">
                                            <img src="assets/images/icons/upload-file.svg" alt="icon" class="dark:brightness-200 dark:contrast-100 w-1/2 sm:w-auto">
                                        </span>
                                        <span class="mt-2 text-gray-500 dark:text-dark-text">Choose screenshot</span>
                                    </span>
                                </label>
                                <div id="screenshot-preview-0" class="mt-3"></div>
                            </div>
                            <button type="button" id="add-screenshot" class="btn b-solid btn-primary-solid btn-sm dk-theme-card-square mt-3">Add Another Screenshot</button>
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

<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="assets/js/vendor/jquery.min.js"></script>
<script src="assets/js/vendor/select/select2.min.js"></script>
<script src="assets/js/vendor/summernote.min.js"></script>
<script src="assets/js/vendor/flowbite.min.js"></script>
<script src="assets/js/vendor/smooth-scrollbar/smooth-scrollbar.min.js"></script>
<script src="assets/js/component/app-menu-bar.js"></script>
<script src="assets/js/switcher.js"></script>
<script src="assets/js/layout.js"></script>
<script src="assets/js/main.js"></script>
<script>
    // Function to preview selected image
    function previewImage(input, previewId) {
        const previewContainer = document.getElementById(previewId);
        previewContainer.innerHTML = ''; // Clear previous preview

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'max-w-full h-auto rounded-10';
                img.style.maxHeight = '150px';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Function to add new screenshot input field
    document.getElementById('add-screenshot').addEventListener('click', function() {
        const container = document.getElementById('screenshot-container');
        const count = container.querySelectorAll('input[name="screenshots[]"]').length;

        const newLabel = document.createElement('label');
        newLabel.setAttribute('for', `screenshots-${count}`);
        newLabel.className = 'file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer aspect-[4/1.5] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 dark:border-dark-border rounded-10 dk-theme-card-square';

        const newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.id = `screenshots-${count}`;
        newInput.name = 'screenshots[]';
        newInput.hidden = true;
        newInput.className = 'img-src peer/file';
        newInput.setAttribute('onchange', `previewImage(this, 'screenshot-preview-${count}')`);

        const span = document.createElement('span');
        span.className = 'flex-center flex-col peer-[.uploaded]/file:hidden';
        span.innerHTML = `
            <span class="size-10 md:size-15 flex-center bg-primary-200 dark:bg-dark-icon rounded-50 dk-theme-card-square">
                <img src="assets/images/icons/upload-file.svg" alt="icon" class="dark:brightness-200 dark:contrast-100 w-1/2 sm:w-auto">
            </span>
            <span class="mt-2 text-gray-500 dark:text-dark-text">Choose screenshot</span>
        `;

        newLabel.appendChild(newInput);
        newLabel.appendChild(span);

        const newPreview = document.createElement('div');
        newPreview.id = `screenshot-preview-${count}`;
        newPreview.className = 'mt-3';

        container.appendChild(newLabel);
        container.appendChild(newPreview);
    });
</script>
</body>
</html>