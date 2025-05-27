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

// Fetch existing wallpaper data if id is provided for editing
if (isset($_GET['id'])) {
    $wallpaperId = $_GET['id'];
    $sql = "SELECT * FROM allwallpaper WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $wallpaperId);
    $stmt->execute();
    $wallpaper = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$wallpaper) {
        echo "Game not found!";
        exit();
    }
} else {
    echo "Invalid Game ID!";
    exit();
}

// Handle form submission for updating wallpaper
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $categoryId = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';
    $codeSnippet = $_POST['code_snippet'] ?? '';
    $appRating = $_POST['app_rating'] ?? '';
    $companyName = $_POST['company_name'] ?? '';
    $supportVersion = $_POST['support_version'] ?? '';
    $appVersion = $_POST['app_version'] ?? '';
    $imagePath = $wallpaper['image_path']; // Keep existing image if not updated
    $screenshotPaths = []; // Initialize empty array for screenshots

    // Get retained existing screenshots from hidden input
    $retainedScreenshots = !empty($_POST['retained_screenshots']) ? explode(',', $_POST['retained_screenshots']) : [];
    foreach ($retainedScreenshots as $screenshot) {
        if (!empty($screenshot) && file_exists($screenshot)) {
            $screenshotPaths[] = $screenshot;
        }
    }

    // Handle single image upload (main image)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'Uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . uniqid() . '-' . $fileName;
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB

        if (in_array($_FILES['image']['type'], $allowedTypes) && $_FILES['image']['size'] <= $maxFileSize) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = $targetPath;
                // Delete old image if it exists and is being replaced
                if (!empty($wallpaper['image_path']) && file_exists($wallpaper['image_path'])) {
                    unlink($wallpaper['image_path']);
                }
            } else {
                $error = "Error uploading the main image. Check directory permissions.";
            }
        } else {
            $error = "Invalid file type or size for main image. Allowed types: JPEG, PNG, GIF, WebP. Max size: 5MB.";
        }
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $error = "Main image upload error: " . $_FILES['image']['error'];
    }

    // Debug: Inspect $_FILES['screenshots']
    // Uncomment to debug
    /*
    echo "<pre>";
    print_r($_FILES['screenshots']);
    echo "</pre>";
    */

    // Handle multiple screenshot uploads
    if (isset($_FILES['screenshots']) && is_array($_FILES['screenshots']['name'])) {
        $uploadDir = 'Uploads/screenshots/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB

        foreach ($_FILES['screenshots']['name'] as $key => $name) {
            if ($_FILES['screenshots']['error'][$key] === UPLOAD_ERR_OK && !empty($name)) {
                $fileName = basename($name);
                $targetPath = $uploadDir . uniqid() . '-' . $fileName;

                if (in_array($_FILES['screenshots']['type'][$key], $allowedTypes) && $_FILES['screenshots']['size'][$key] <= $maxFileSize) {
                    if (move_uploaded_file($_FILES['screenshots']['tmp_name'][$key], $targetPath)) {
                        $screenshotPaths[] = $targetPath;
                    } else {
                        $error = "Error uploading screenshot: $name. Check directory permissions.";
                    }
                } else {
                    $error = "Invalid file type or size for screenshot: $name. Allowed types: JPEG, PNG, GIF, WebP. Max size: 5MB.";
                }
            } elseif ($_FILES['screenshots']['error'][$key] !== UPLOAD_ERR_NO_FILE) {
                $error = "Screenshot upload error for $name: " . $_FILES['screenshots']['error'][$key];
            }
        }
    }

    // Convert screenshot paths to a comma-separated string
    $screenshots = !empty($screenshotPaths) ? implode(',', $screenshotPaths) : '';

    // Delete physical files for removed screenshots
    $oldScreenshots = !empty($wallpaper['screenshots']) ? explode(',', $wallpaper['screenshots']) : [];
    $newScreenshots = !empty($screenshots) ? explode(',', $screenshots) : [];
    foreach ($oldScreenshots as $old) {
        if (!empty($old) && !in_array($old, $newScreenshots) && file_exists($old)) {
            unlink($old);
        }
    }

    // Update the wallpaper details in the database
    $sql = "UPDATE allwallpaper SET 
            title = :title, 
            category_id = :category_id, 
            description = :description, 
            code_snippet = :code_snippet, 
            image_path = :image_path, 
            screenshots = :screenshots, 
            app_rating = :app_rating, 
            company_name = :company_name, 
            support_version = :support_version, 
            app_version = :app_version 
            WHERE id = :id";
            
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
    $stmt->bindParam(':id', $wallpaperId);

    if ($stmt->execute()) {
        $msg = "Game updated successfully!";
        // Refresh the wallpaper data to reflect updates
        $sql = "SELECT * FROM allwallpaper WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $wallpaperId);
        $stmt->execute();
        $wallpaper = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $error = "Error updating the Game: " . implode(', ', $stmt->errorInfo());
    }
}
?>

<?php include 'includes/header.php'; ?>
<body class="bg-body-light dark:bg-dark-body group-data-[theme-width=box]:container group-data-[theme-width=box]:max-w-screen-3xl xl:group-data-[theme-width=box]:px-3">
<?php include 'includes/top-navbar.php'; ?>
<?php include 'includes/left-navbar.php'; ?>

<div class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="retained-screenshots" name="retained_screenshots" value="<?php echo htmlspecialchars($wallpaper['screenshots'] ?? ''); ?>">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-7 card">
                <div class="p-1.5">
                    <h6 class="card-title">Edit Game Details</h6>

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
                                <input type="text" id="courseTitle" name="title" value="<?php echo htmlspecialchars($wallpaper['title']); ?>" placeholder="Title" class="form-input" required>
                            </div>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label class="form-label">Game Category</label>
                                <select class="singleSelect" name="category" required>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo $wallpaper['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($category['category_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="appRating" class="form-label">App Rating</label>
                                <input type="number" id="appRating" name="app_rating" value="<?php echo htmlspecialchars($wallpaper['app_rating'] ?? ''); ?>" placeholder="e.g., 4.5" step="0.1" min="0" max="5" class="form-input" required>
                            </div>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="companyName" class="form-label">Company Name</label>
                                <input type="text" id="companyName" name="company_name" value="<?php echo htmlspecialchars($wallpaper['company_name'] ?? ''); ?>" placeholder="e.g., Example Inc." class="form-input" required>
                            </div>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="supportVersion" class="form-label">Support Version</label>
                                <input type="text" id="supportVersion" name="support_version" value="<?php echo htmlspecialchars($wallpaper['support_version'] ?? ''); ?>" placeholder="e.g., Android 10+" class="form-input" required>
                            </div>
                            <div class="col-span-full xl:col-auto leading-none">
                                <label for="appVersion" class="form-label">App Version</label>
                                <input type="text" id="appVersion" name="app_version" value="<?php echo htmlspecialchars($wallpaper['app_version'] ?? ''); ?>" placeholder="e.g., 1.0.0" class="form-input" required>
                            </div>
                            <div class="col-span-full">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" rows="8" class="summernote form-input" required><?php echo htmlspecialchars($wallpaper['description']); ?></textarea>
                            </div>
                            <div class="col-span-full">
                                <label class="form-label">Insert Downloading Link</label>
                                <textarea name="code_snippet" rows="6" class="form-input" placeholder="Enter your Downloading Link here..."><?php echo htmlspecialchars($wallpaper['code_snippet']); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-full lg:col-span-5 card">
                <div class="p-1.5">
                    <h6 class="card-title">Change Images</h6>
                    <div class="mt-7 pt-0.5 flex flex-col gap-5">
                        <div class="col-span-full sm:col-span-4">
                            <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">Main Image</p>
                            <label for="thumbnailsrc" class="file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer aspect-[4/1.5] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 dark:border-dark-border rounded-10 dk-theme-card-square">
                                <input type="file" id="thumbnailsrc" name="image" hidden class="img-src peer/file" onchange="previewImage(this, 'main-image-preview')" accept="image/*">
                                <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                    <span class="size-10 md:size-15 flex-center bg-primary-200 dark:bg-dark-icon rounded-50 dk-theme-card-square">
                                        <img src="assets/images/icons/upload-file.svg" alt="icon" class="dark:brightness-200 dark:contrast-100 w-1/2 sm:w-auto">
                                    </span>
                                    <span class="mt-2 text-gray-500 dark:text-dark-text">Choose file</span>
                                </span>
                            </label>
                            <div id="main-image-preview" class="mt-3">
                                <?php if (!empty($wallpaper['image_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($wallpaper['image_path']); ?>" class="max-w-full h-auto rounded-10" style="max-height: 150px;">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-span-full sm:col-span-4">
                            <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">Screenshots</p>
                            <div id="screenshot-container">
                                <?php 
                                $existingScreenshots = !empty($wallpaper['screenshots']) ? explode(',', $wallpaper['screenshots']) : [];
                                foreach ($existingScreenshots as $index => $screenshot): 
                                    if (!empty($screenshot)):
                                ?>
                                    <div class="screenshot-wrapper" data-index="<?php echo $index; ?>">
                                        <label for="screenshots-<?php echo $index; ?>" class="file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer aspect-[4/1.5] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 dark:border-dark-border rounded-10 dk-theme-card-square">
                                            <input type="file" id="screenshots-<?php echo $index; ?>" name="screenshots[]" hidden class="img-src peer/file" onchange="previewImage(this, 'screenshot-preview-<?php echo $index; ?>')" accept="image/*">
                                            <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                                <span class="size-10 md:size-15 flex-center bg-primary-200 dark:bg-dark-icon rounded-50 dk-theme-card-square">
                                                    <img src="assets/images/icons/upload-file.svg" alt="icon" class="dark:brightness-200 dark:contrast-100 w-1/2 sm:w-auto">
                                                </span>
                                                <span class="mt-2 text-gray-500 dark:text-dark-text">Choose screenshot</span>
                                            </span>
                                        </label>
                                        <div id="screenshot-preview-<?php echo $index; ?>" class="mt-3">
                                            <img src="<?php echo htmlspecialchars($screenshot); ?>" class="max-w-full h-auto rounded-10" style="max-height: 150px;" data-path="<?php echo htmlspecialchars($screenshot); ?>">
                                            <button type="button" class="btn b-solid btn-danger-solid btn-sm dk-theme-card-square mt-2 remove-screenshot" onclick="removeScreenshot(this, '<?php echo htmlspecialchars($screenshot); ?>')">Remove</button>
                                        </div>
                                    </div>
                                <?php endif; endforeach; ?>
                                <!-- Add one empty screenshot field by default -->
                                <div class="screenshot-wrapper" data-index="<?php echo count($existingScreenshots); ?>">
                                    <label for="screenshots-<?php echo count($existingScreenshots); ?>" class="file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer aspect-[4/1.5] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 dark:border-dark-border rounded-10 dk-theme-card-square">
                                        <input type="file" id="screenshots-<?php echo count($existingScreenshots); ?>" name="screenshots[]" hidden class="img-src peer/file" onchange="previewImage(this, 'screenshot-preview-<?php echo count($existingScreenshots); ?>')" accept="image/*">
                                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                            <span class="size-10 md:size-15 flex-center bg-primary-200 dark:bg-dark-icon rounded-50 dk-theme-card-square">
                                                <img src="assets/images/icons/upload-file.svg" alt="icon" class="dark:brightness-200 dark:contrast-100 w-1/2 sm:w-auto">
                                            </span>
                                            <span class="mt-2 text-gray-500 dark:text-dark-text">Choose screenshot</span>
                                        </span>
                                    </label>
                                    <div id="screenshot-preview-<?php echo count($existingScreenshots); ?>" class="mt-3"></div>
                                </div>
                            </div>
                            <button type="button" id="add-screenshot" class="btn b-solid btn-primary-solid btn-sm dk-theme-card-square mt-3">Add Another Screenshot</button>
                        </div>
                        <div class="flex-center !justify-end">
                            <button type="submit" class="btn b-solid btn-primary-solid btn-lg dk-theme-card-square">Update</button>
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
        const wrapper = input.closest('.screenshot-wrapper');
        previewContainer.innerHTML = ''; // Clear previous preview

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'max-w-full h-auto rounded-10';
                img.style.maxHeight = '150px';
                previewContainer.appendChild(img);

                // Add remove button for new uploads
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn b-solid btn-danger-solid btn-sm dk-theme-card-square mt-2';
                removeBtn.textContent = 'Remove';
                removeBtn.onclick = function() {
                    previewContainer.innerHTML = '';
                    input.value = ''; // Clear the file input
                    if (wrapper.querySelector('img[data-path]')) {
                        updateRetainedScreenshots();
                    }
                };
                previewContainer.appendChild(removeBtn);

                // If replacing an existing screenshot, update retained screenshots
                if (wrapper.querySelector('img[data-path]')) {
                    const oldPath = wrapper.querySelector('img[data-path]').getAttribute('data-path');
                    removeScreenshot(null, oldPath);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Function to remove a screenshot and update retained screenshots
    function removeScreenshot(button, path) {
        const wrapper = button ? button.closest('.screenshot-wrapper') : document.querySelector(`img[data-path="${path}"]`).closest('.screenshot-wrapper');
        const retainedInput = document.getElementById('retained-screenshots');
        let retained = retainedInput.value ? retainedInput.value.split(',') : [];
        
        // Remove the path from retained screenshots
        retained = retained.filter(p => p !== path);
        retainedInput.value = retained.join(',');
        
        // Remove the wrapper if button is provided
        if (button && wrapper) {
            wrapper.remove();
        }
    }

    // Function to update retained screenshots
    function updateRetainedScreenshots() {
        const screenshotContainer = document.getElementById('screenshot-container');
        const retainedScreenshotsInput = document.getElementById('retained-screenshots');
        const screenshotImages = screenshotContainer.querySelectorAll('img[data-path]');
        const retainedPaths = Array.from(screenshotImages).map(img => img.getAttribute('data-path'));
        retainedScreenshotsInput.value = retainedPaths.join(',');
    }

    // Function to add new screenshot input field
    document.getElementById('add-screenshot').addEventListener('click', function() {
        const container = document.getElementById('screenshot-container');
        const wrappers = container.querySelectorAll('.screenshot-wrapper');
        const count = wrappers.length;

        if (count >= 5) {
            alert('Maximum 5 screenshots allowed.');
            return;
        }

        const wrapper = document.createElement('div');
        wrapper.className = 'screenshot-wrapper';
        wrapper.setAttribute('data-index', count);

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
        newInput.setAttribute('accept', 'image/*');

        const span = document.createElement('span');
        span.className = 'flex-center flex-col peer-[.uploaded]/file:';
        span.innerHTML = `
            <span class="size-10 md:size-15 flex-center bg-primary-200 dark:bg-dark-icon rounded-full dk-theme-card-square">
                <img src="assets/images/icons/upload-file.svg" alt="icon" class="dark:brightness-200 dark:contrast-100 w-1/2 sm:w-auto">
            </span>
            <span class="mt-2 text-gray-500 dark:text-dark-text">Choose screenshot</span>
        `;

        const newPreview = document.createElement('div');
        newPreview.id = `screenshot-preview-${count}`;
        newPreview.className = 'mt-3';

        newLabel.appendChild(newInput);
        newLabel.appendChild(span);
        wrapper.appendChild(newLabel);
        wrapper.appendChild(newPreview);

        container.appendChild(wrapper);
    });

    // Initialize retained screenshots on page load
    document.addEventListener('DOMContentLoaded', updateRetainedScreenshots);
</script>
</body>
</html>