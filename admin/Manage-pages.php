<?php
session_start();
include 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

// Handle form submission (Insert or Update)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $about_us = $_POST['about_us'];
    $privacy_policy = $_POST['Privacy_Policy'];
    $term_conditions = $_POST['Term_Conditions'];

    try {
        // Check if data exists in the pages table (Assuming only one record with id = 1)
        $sql_check = "SELECT id FROM pages WHERE id = 1";
        $stmt = $dbh->prepare($sql_check);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Update data if it exists
            $sql_update = "UPDATE pages SET about_us = :about_us, privacy_policy = :privacy_policy, term_conditions = :term_conditions WHERE id = 1";
            $stmt = $dbh->prepare($sql_update);
            $stmt->bindParam(':about_us', $about_us);
            $stmt->bindParam(':privacy_policy', $privacy_policy);
            $stmt->bindParam(':term_conditions', $term_conditions);

            if ($stmt->execute()) {
                $msg = "Data updated successfully!";
            } else {
                $error = "Error updating data!";
            }
        } else {
            // Insert data if it does not exist
            $sql_insert = "INSERT INTO pages (about_us, privacy_policy, term_conditions) VALUES (:about_us, :privacy_policy, :term_conditions)";
            $stmt = $dbh->prepare($sql_insert);
            $stmt->bindParam(':about_us', $about_us);
            $stmt->bindParam(':privacy_policy', $privacy_policy);
            $stmt->bindParam(':term_conditions', $term_conditions);

            if ($stmt->execute()) {
                $msg = "Data inserted successfully!";
            } else {
                $error = "Error inserting data!";
            }
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Fetch existing data to populate the form fields
try {
    $sql_fetch = "SELECT about_us, privacy_policy, term_conditions FROM pages WHERE id = 1";
    $stmt = $dbh->prepare($sql_fetch);
    $stmt->execute();
    $page_data = $stmt->fetch(PDO::FETCH_ASSOC);

    // If data exists, populate the fields; otherwise, use empty strings
    $about_us_data = $page_data['about_us'] ?? '';
    $privacy_policy_data = $page_data['privacy_policy'] ?? '';
    $term_conditions_data = $page_data['term_conditions'] ?? '';
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
}
?>

<?php include 'includes/header.php'; ?>
<head>
    <style>
        /* In your global CSS file, for example, tailwind.css */
/* Custom Heading Styles */
h1 {
    font-size: 2.25rem; /* equivalent to text-4xl in Tailwind */
    font-weight: 700;   /* equivalent to font-bold in Tailwind */
}

h2 {
    font-size: 1.875rem; /* equivalent to text-3xl in Tailwind */
    font-weight: 600;    /* equivalent to font-semibold in Tailwind */
}

h3 {
    font-size: 1.5rem;   /* equivalent to text-2xl in Tailwind */
    font-weight: 500;    /* equivalent to font-medium in Tailwind */
}

h4 {
    font-size: 1.25rem;  /* equivalent to text-xl in Tailwind */
    font-weight: 400;    /* equivalent to font-normal in Tailwind */
}

h5 {
    font-size: 1.125rem; /* equivalent to text-lg in Tailwind */
    font-weight: 400;    /* equivalent to font-normal in Tailwind */
}

h6 {
    font-size: 1rem;     /* equivalent to text-base in Tailwind */
    font-weight: 400;    /* equivalent to font-normal in Tailwind */
}

 
 
    </style>
</head>
<body class="bg-body-light dark:bg-dark-body group-data-[theme-width=box]:container group-data-[theme-width=box]:max-w-screen-3xl xl:group-data-[theme-width=box]:px-3">
<?php include 'includes/top-navbar.php'; ?>
<?php include 'includes/left-navbar.php'; ?>

<div class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:px-0 px-3 xl:px-4 ac-transition">
    <h6 class="card">Manage Pages</h6>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6 card">
                <div class="p-1.5">

                    <!-- Display Success or Error Message -->
                    <?php if (isset($msg)) : ?>
                        <div class="aleart aleart-success-light rounded-full mt-1 mb-4">
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

                    <div class="pt-0.5">
                        <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                            <div class="col-span-full">
                                <label for="description" class="form-label">About Us</label>
                                <textarea id="about_us" name="about_us" rows="8" class="summernote form-input" required><?php echo html_entity_decode($about_us_data); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-full lg:col-span-6 card">
                <div class="p-1.5">
                    <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                        <div class="col-span-full">
                            <label for="description" class="form-label">Privacy Policy</label>
                            <textarea id="Privacy_Policy" name="Privacy_Policy" rows="8" class="summernote form-input" required><?php echo html_entity_decode($privacy_policy_data); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-full lg:col-span-6 card">
                <div class="p-1.5">
                    <div class="pt-0.5">
                        <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                            <div class="col-span-full">
                                <label for="description" class="form-label">Term and Conditions</label>
                                <textarea id="Term_Conditions" name="Term_Conditions" rows="8" class="summernote form-input" required><?php echo html_entity_decode($term_conditions_data); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                     
                <button type="submit" class="btn b-solid btn-primary-solid btn-lg dk-theme-card-square mt-4">Update</button>
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
</body>
</html>
