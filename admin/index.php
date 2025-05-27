<?php
session_start(); // Start the session

// Include configuration
include 'includes/config.php';

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard-lms.php"); // Redirect to the dashboard
    exit(); // Stop further script execution
}

// Check if the login form is submitted
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Encrypt the password

    // Prepare the SQL query to validate the user
    $sql = "SELECT UserName, Password FROM admin WHERE UserName=:username AND Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();

    // Check if the user exists
    if ($query->rowCount() > 0) {
        // User is valid, set session variables and redirect
        $_SESSION['loggedin'] = true; // Mark the user as logged in
        $_SESSION['username'] = $username; // Store the username
        header("Location: dashboard-lms.php");
        exit();
    } else {
        // Invalid login details
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>


<?php include('includes/header.php'); ?>

<body class="bg-body-light dark:bg-dark-body">
    <div id="loader" class="w-screen h-screen flex-center bg-white dark:bg-dark-card fixed inset-0 z-[9999]">
        <img src="assets/pre-loader/bar-loader.gif" alt="loader">
    </div>

    <!-- Start Main Content -->
    <div class="main-content m-4">
        <div class="grid grid-cols-12 gap-y-7 sm:gap-7 card px-4 sm:px-10 2xl:px-[70px] py-15 lg:items-center lg:min-h-[calc(100vh_-_32px)]">
            <!-- Start Overview Area -->
            <div class="col-span-full lg:col-span-6">
                <div class="flex flex-col items-center justify-center gap-10 text-center">
                    <div class="hidden sm:block">
                        <img src="assets/images/loti/loti-auth.svg" alt="loti" class="group-[.dark]:hidden">
                        <img src="assets/images/loti/loti-auth-dark.svg" alt="loti" class="group-[.light]:hidden">
                    </div>
                    <div>
                        <h3 class="text-xl md:text-[28px] leading-none font-semibold text-heading">
                            Welcome back!
                        </h3>
                        <p class="font-medium text-gray-500 dark:text-dark-text mt-4 px-[10%]">
                            Whether you're launching a stunning online store or optimizing your object-oriented logic.
                        </p>
                    </div>
                </div>
            </div>
            <!-- End Overview Area -->

            <!-- Start Form Area -->
            <div class="col-span-full lg:col-span-6 w-full lg:max-w-[600px]">
                <div class="border border-form dark:border-dark-border p-5 md:p-10 rounded-20 md:rounded-30 dk-theme-card-square">
                    <h3 class="text-xl md:text-[28px] leading-none font-semibold text-heading">
                        Sign In
                    </h3>
                    <p class="font-medium text-gray-500 dark:text-dark-text mt-4">
                        Welcome Back! Log in to your account.
                    </p>
                    <form method="post" class="leading-none mt-8">
                        <div class="mb-2.5">
                            <label for="username" class="form-label">User Name</label>
                            <input type="text" id="username" name="username" placeholder="Enter the valid user name" required class="form-input px-4 py-3.5 rounded-lg">
                        </div>
                        <div class="mt-5">
                            <label for="password" class="form-label">Password</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" placeholder="Password" required class="form-input px-4 py-3.5 rounded-lg">
                                <label for="toggleInputType" class="size-8 rounded-md flex-center hover:bg-gray-200 dark:hover:bg-dark-icon focus:bg-gray-200 dark:focus:bg-dark-icon position-center !left-auto -right-2.5">
                                    <input type="checkbox" id="toggleInputType" class="inputTypeToggle peer/it" hidden>
                                    <i class="ri-eye-off-line text-gray-500 dark:text-dark-text peer-checked/it:before:content-['\ecb5']"></i>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-3 mb-7">
                            <div class="flex items-center gap-1 select-none">
                                <input type="checkbox" name="remember-me" id="rememberMe" onchange="handleRememberMe()">
                                <label for="rememberMe" class="font-spline_sans text-sm leading-none text-gray-900 dark:text-dark-text cursor-pointer">Remember Me</label>
                            </div>
                         </div>
                        <!-- Submit Button -->
                        <button type="submit" name="login" class="btn b-solid btn-primary-solid w-full dk-theme-card-square">Sign In</button>
                    </form>
                </div>
            </div>
            <!-- End Form Area -->
        </div>
    </div>
    <!-- End Main Content -->

    <script src="assets/js/vendor/jquery.min.js"></script>
    <script src="assets/js/switcher.js"></script>
    <script src="assets/js/layout.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
    // Function to handle Remember Me
    function handleRememberMe() {
        const rememberMe = document.getElementById('rememberMe');
        const usernameField = document.getElementById('username');
        const passwordField = document.getElementById('password');

        if (rememberMe.checked) {
            // Save the username and password in localStorage
            localStorage.setItem('rememberMe', 'true');
            localStorage.setItem('username', usernameField.value);
            localStorage.setItem('password', passwordField.value);
        } else {
            // Remove username and password from localStorage
            localStorage.removeItem('rememberMe');
            localStorage.removeItem('username');
            localStorage.removeItem('password');
        }
    }

    // Populate fields on page load if Remember Me was checked
    document.addEventListener('DOMContentLoaded', () => {
        const rememberMe = localStorage.getItem('rememberMe') === 'true';
        if (rememberMe) {
            document.getElementById('rememberMe').checked = true;
            document.getElementById('username').value = localStorage.getItem('username') || '';
            document.getElementById('password').value = localStorage.getItem('password') || '';
        }
    });
    </script>

</body>
</html>
