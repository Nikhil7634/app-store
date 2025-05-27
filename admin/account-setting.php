<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

// Fetch current settings
$query = "SELECT * FROM site_settings LIMIT 1";
$stmt = $dbh->prepare($query);
$stmt->execute();
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $websiteTitle = $_POST['website_title'] ?? '';
    $metaDescription = $_POST['meta_description'] ?? '';
    $sitemapCode = $_POST['sitemap_code'] ?? '';
    $whatsappLink = $_POST['whatsapp_link'] ?? '';
    $telegramLink = $_POST['telegram_link'] ?? '';
    $customHeadCode = $_POST['custom_head_code'] ?? '';
    $customBodyCode = $_POST['custom_body_code'] ?? '';
    $customFooterCode = $_POST['custom_footer_code'] ?? '';
    $logoPath = $settings['logo'] ?? '';
    $faviconPath = $settings['favicon'] ?? '';

    // Handle file upload for logo
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['logo']['name']);
        $targetPath = $uploadDir . uniqid() . '-' . $fileName;

        if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetPath)) {
            $logoPath = $targetPath;
        } else {
            echo "Error uploading the logo.";
        }
    }

    // Handle file upload for favicon
    if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['favicon']['name']);
        $targetPath = $uploadDir . uniqid() . '-' . $fileName;

        if (move_uploaded_file($_FILES['favicon']['tmp_name'], $targetPath)) {
            $faviconPath = $targetPath;
        } else {
            echo "Error uploading the favicon.";
        }
    }

    if ($settings) {
        // Update settings in database
        $sql = "UPDATE site_settings SET 
                website_title = :website_title, 
                meta_description = :meta_description, 
                sitemap_code = :sitemap_code, 
                whatsapp_link = :whatsapp_link, 
                telegram_link = :telegram_link, 
                custom_head_code = :custom_head_code, 
                custom_body_code = :custom_body_code, 
                custom_footer_code = :custom_footer_code, 
                logo = :logo, 
                favicon = :favicon";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':website_title', $websiteTitle);
        $stmt->bindParam(':meta_description', $metaDescription);
        $stmt->bindParam(':sitemap_code', $sitemapCode);
        $stmt->bindParam(':whatsapp_link', $whatsappLink);
        $stmt->bindParam(':telegram_link', $telegramLink);
        $stmt->bindParam(':custom_head_code', $customHeadCode);
        $stmt->bindParam(':custom_body_code', $customBodyCode);
        $stmt->bindParam(':custom_footer_code', $customFooterCode);
        $stmt->bindParam(':logo', $logoPath);
        $stmt->bindParam(':favicon', $faviconPath);

        if ($stmt->execute()) {
            $msg = "Settings updated successfully!";
        } else {
            $error = "Error updating the settings.";
        }
    } else {
        // Insert new settings if none exist
        $sql = "INSERT INTO site_settings (
                website_title, 
                meta_description, 
                sitemap_code, 
                whatsapp_link, 
                telegram_link, 
                custom_head_code, 
                custom_body_code, 
                custom_footer_code, 
                logo, 
                favicon
            ) VALUES (
                :website_title, 
                :meta_description, 
                :sitemap_code, 
                :whatsapp_link, 
                :telegram_link, 
                :custom_head_code, 
                :custom_body_code, 
                :custom_footer_code, 
                :logo, 
                :favicon
            )";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':website_title', $websiteTitle);
        $stmt->bindParam(':meta_description', $metaDescription);
        $stmt->bindParam(':sitemap_code', $sitemapCode);
        $stmt->bindParam(':whatsapp_link', $whatsappLink);
        $stmt->bindParam(':telegram_link', $telegramLink);
        $stmt->bindParam(':custom_head_code', $customHeadCode);
        $stmt->bindParam(':custom_body_code', $customBodyCode);
        $stmt->bindParam(':custom_footer_code', $customFooterCode);
        $stmt->bindParam(':logo', $logoPath);
        $stmt->bindParam(':favicon', $faviconPath);

        if ($stmt->execute()) {
            $msg = "Settings inserted successfully!";
        } else {
            $error = "Error inserting the settings.";
        }
    }
}
?>

 


<?php include 'includes/header.php'; ?>
<body class="bg-body-light dark:bg-dark-body group-data-[theme-width=box]:container group-data-[theme-width=box]:max-w-screen-3xl xl:group-data-[theme-width=box]:px-3">
<?php include 'includes/top-navbar.php'; ?>
<?php include 'includes/left-navbar.php'; ?>


<div class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
<div class="card">
            <h2 class="card-title">Website Settings</h2>
        </div>
         
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6">
                <div class="p-1.5">
                     <?php if (isset($msg)) : ?>
                        <div class="aleart a-outline aleart-success-outline rounded-full card">
                            <div class="flex-center gap-2.5">
                            <?php echo $msg; ?>
                            </div>
                            <button class="close-button">
                                <i class="ri-close-line text-inherit"></i>
                            </button>
                        </div>
                     <?php endif; ?>
                    <?php if (isset($error)) : ?>
                        <div class="aleart a-outline aleart-danger-outline rounded-full">
                            <div class="flex-center gap-2.5">
                            <?php echo $error; ?>
                            </div>
                            <button class="close-button">
                                <i class="ri-close-line text-inherit"></i>
                            </button>
                        </div>
                     <?php endif; ?>

                     <div class="grid grid-cols-2 gap-x-4 mt-0">
    <!-- SEO Section -->
    <div class="col-span-full  p-6 card">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">SEO Section</h2>

        <div class="col-span-full xl:col-auto leading-none">
                            <label for="website_title" class="form-label">Website Title</label>
                            <input  type="text" id="website_title" name="website_title" value="<?php echo htmlspecialchars($settings['website_title'] ?? ''); ?>" class="form-input" required>
                        </div>
        <div class="col-span-full xl:col-auto leading-none mt-4">
            <label for="meta_description" class="form-label">Meta Description</label>
            <textarea id="meta_description" name="meta_description" class="form-input"><?php echo htmlspecialchars($settings['meta_description'] ?? ''); ?></textarea>
        </div>
        <div class="col-span-full xl:col-auto leading-none mt-4">
            <label for="sitemap_code" class="form-label">Sitemap Code</label>
            <textarea id="sitemap_code" name="sitemap_code" class="form-input"><?php echo htmlspecialchars($settings['sitemap_code'] ?? ''); ?></textarea>
        </div>
        <div class="flex-center-between pb-4 border-b border-gray-200 dark:border-dark-border mt-6">
                        <h3 class="text-lg card-title leading-none">Google Search Console</h3>
                        <a href="https://search.google.com/search-console?utm_source=about-page&resource_id=https://nikhilpal8n.blogspot.com/" class="btn b-light btn-primary-light btn-sm prism-toggle !py-2.5 focus:bg-primary-500 focus:text-white dark:!bg-dark-icon">
                            <span class="shrink-0">Go Now</span>
                            <i class="fa-brands fa-google"></i>                        </a>
                    </div>

                    <div class="flex-center-between pb-4 border-b border-gray-200 dark:border-dark-border mt-6">
                        <h3 class="text-lg card-title leading-none">Image Compressor </h3>
   
                        <label class="switch">
    <input class="cb" id="customSwitch" type="checkbox" />
    <span class="toggle">
      <span class="left">off</span>
      <span class="right">on</span>
    </span>
  </label>
                    </div>
    </div>

    <!-- Social Media Links Section -->
    


   
</div>


                   
                </div>
            </div>


            <div class="col-span-full lg:col-span-5">
                <div class="p-4 card">
                    <h6 class="card-title">Add media files</h6>
                    <div class="mt-7 pt-0.5 flex gap-5">
                        <!-- Website Logo Upload Section -->
                        <div class="col-span-6 sm:col-span-4 w-full">
                            <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">Website Logo</p>
                            <label for="logo" class="file-container text-xs leading-none font-semibold mb-3 cursor-pointer aspect-[4/1.5] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 dark:border-dark-border rounded-10 dk-theme-card-square">
                                <input type="file" id="logo" name="logo" hidden class="peer/file img-src">
                                <span class="flex-center flex-col">
                                    <span class="size-10 md:size-15 flex-center bg-primary-200 dark:bg-dark-icon rounded-50 dk-theme-card-square">
                                        <img src="assets/images/icons/upload-file.svg" alt="icon" class="dark:brightness-200 dark:contrast-100 w-1/2 sm:w-auto">
                                    </span>
                                    <span class="file-name text-gray-500 dark:text-dark-text mt-2">Choose file</span>
                                </span>
                            </label>
                            <?php if (!empty($settings['logo'])): ?>
                                <img src="<?php echo htmlspecialchars($settings['logo']); ?>" alt="Logo" width="100" class="mt-3 rounded">
                            <?php endif; ?>
                        </div>

                        <!-- Favicon Upload Section -->
                        <div class="col-span-6 sm:col-span-4 w-full">
                            <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">Favicon</p>
                            <label for="favicon" class="file-container text-xs leading-none font-semibold mb-3 cursor-pointer aspect-[4/1.5] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 dark:border-dark-border rounded-10 dk-theme-card-square">
                                <input type="file" id="favicon" name="favicon" hidden class="peer/file file-src">
                                <span class="flex-center flex-col">
                                    <span class="size-10 md:size-15 flex-center bg-primary-200 dark:bg-dark-icon rounded-50 dk-theme-card-square">
                                        <img src="assets/images/icons/upload-file.svg" alt="icon" class="dark:brightness-200 dark:contrast-100 w-1/2 sm:w-auto">
                                    </span>
                                    <span class="file-name text-gray-500 dark:text-dark-text mt-2">Choose file</span>
                                </span>
                            </label>
                            <?php if (!empty($settings['favicon'])): ?>
                                <img src="<?php echo htmlspecialchars($settings['favicon']); ?>" alt="Favicon" width="32" class="mt-3 rounded">
                            <?php endif; ?>
                        </div>
                    </div>
                    
                </div>
                 <!-- Custom Code Section -->
    <div class="col-span-full  p-6 card">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Custom Code</h2>
        <div class="col-span-full xl:col-auto leading-none">
            <label for="custom_head_code" class="form-label">Custom Code (Head Tag)</label>
            <textarea id="custom_head_code" name="custom_head_code" class="form-input"><?php echo htmlspecialchars($settings['custom_head_code'] ?? ''); ?></textarea>
        </div>
        <div class="col-span-full xl:col-auto leading-none mt-4">
            <label for="custom_body_code" class="form-label">Custom Code (Body Tag)</label>
            <textarea id="custom_body_code" name="custom_body_code" class="form-input"><?php echo htmlspecialchars($settings['custom_body_code'] ?? ''); ?></textarea>
        </div>
        <div class="col-span-full xl:col-auto leading-none mt-4">
            <label for="custom_footer_code" class="form-label">OpenGraph Meta (Head Tag)</label>
            <textarea id="custom_footer_code" name="custom_footer_code" class="form-input"><?php echo htmlspecialchars($settings['custom_footer_code'] ?? ''); ?></textarea>
        </div>
        <div class="col-span-full xl:col-auto leading-none mt-4">
            <label for="whatsapp_link" class="form-label">Schema Meta (Head Tag)</label>
            <textarea type="text" id="whatsapp_link" name="whatsapp_link"  class="form-input"><?php echo htmlspecialchars($settings['whatsapp_link'] ?? ''); ?></textarea>
        </div>

        <div class="mt-4">
                        <button type="submit" class="btn b-solid btn-primary-solid btn-lg dk-theme-card-square mt-10">Save Settings</button>
                    </div>
    </div>
            </div>
        </div>
    </form>
 
    
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
    // Reference the checkbox
    const customSwitch = document.getElementById('customSwitch');

    // Function to save the switch state to localStorage
    function saveSwitchState(isChecked) {
      localStorage.setItem('customSwitchState', isChecked ? 'on' : 'off');
    }

    // Load the switch state on page load
    document.addEventListener('DOMContentLoaded', () => {
      const savedState = localStorage.getItem('customSwitchState');
      if (savedState === 'on') {
        customSwitch.checked = true;
      }
    });

    // Add an event listener for switch changes
    customSwitch.addEventListener('change', () => {
      saveSwitchState(customSwitch.checked);
    });
  </script>
</body>
</html>
