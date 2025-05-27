<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

 

// Fetch current settings
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form inputs with proper variable names
    $ads1_code = $_POST['ads1_code'] ?? '';
    $ads2_code = $_POST['ads2_code'] ?? '';
    $ads3_code = $_POST['ads3_code'] ?? '';
    $ads4_code = $_POST['ads4_code'] ?? '';

    try {
        // Check if the record already exists
        $stmt = $dbh->prepare("SELECT id FROM manage_ads LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Update existing record
            $sql = "UPDATE manage_ads SET 
                        ads1_code = :ads1_code, 
                        ads2_code = :ads2_code, 
                        ads3_code = :ads3_code, 
                        ads4_code = :ads4_code, 
                        updated_at = NOW() 
                    WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $row['id']);
        } else {
            // Insert new record
            $sql = "INSERT INTO manage_ads (ads1_code, ads2_code, ads3_code, ads4_code) 
                    VALUES (:ads1_code, :ads2_code, :ads3_code, :ads4_code)";
            $stmt = $dbh->prepare($sql);
        }

        // Bind parameters
        $stmt->bindParam(':ads1_code', $ads1_code);
        $stmt->bindParam(':ads2_code', $ads2_code);
        $stmt->bindParam(':ads3_code', $ads3_code);
        $stmt->bindParam(':ads4_code', $ads4_code);

        // Execute the query
        if ($stmt->execute()) {
            $msg = "Ads updated successfully!";
        } else {
            $error = "An error occurred while updating ads.";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}

try {
    $stmt = $dbh->prepare("SELECT * FROM manage_ads LIMIT 1");
    $stmt->execute();
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error while fetching settings: " . $e->getMessage();
}
?>


 


<?php include 'includes/header.php'; ?>
<body class="bg-body-light dark:bg-dark-body group-data-[theme-width=box]:container group-data-[theme-width=box]:max-w-screen-3xl xl:group-data-[theme-width=box]:px-3">
<?php include 'includes/top-navbar.php'; ?>
<?php include 'includes/left-navbar.php'; ?>


<div class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
    <div class="card">
        <h2 class="card-title">Manage Ads</h2>
    </div>
    
    <form action="" method="POST">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-8">
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
                        <!-- Ads Section -->
                        <div class="col-span-full p-6 card">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Ads Section</h2>

                            <div class="col-span-full xl:col-auto leading-none">
    <label for="ads1_code" class="form-label">Ads Top Code</label>
    <textarea id="ads1_code" name="ads1_code" class="form-input" required><?php echo htmlspecialchars($settings['ads1_code'] ?? ''); ?></textarea>
</div>

<div class="col-span-full xl:col-auto leading-none mt-4">
    <label for="ads2_code" class="form-label">Ads Bottom Code</label>
    <textarea id="ads2_code" name="ads2_code" class="form-input"><?php echo htmlspecialchars($settings['ads2_code'] ?? ''); ?></textarea>
</div>

<div class="col-span-full xl:col-auto leading-none mt-4">
    <label for="ads3_code" class="form-label">Ads Left Code</label>
    <textarea id="ads3_code" name="ads3_code" class="form-input"><?php echo htmlspecialchars($settings['ads3_code'] ?? ''); ?></textarea>
</div>

<div class="col-span-full xl:col-auto leading-none mt-4">
    <label for="ads4_code" class="form-label">Ads Right Code</label>
    <textarea id="ads4_code" name="ads4_code" class="form-input"><?php echo htmlspecialchars($settings['ads4_code'] ?? ''); ?></textarea>
</div>



                            <div class="mt-4">
                                <button type="submit" class="btn b-solid btn-primary-solid btn-lg dk-theme-card-square mt-10">Save</button>
                            </div>
                        </div>
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
 
</body>
</html>
