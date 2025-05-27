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
                            Whether you're launching a stunning online store  optimizing your our object-oriented 
                        </p>
                    </div>
                </div>
            </div>
            <!-- End Overview Area -->

            <!-- Start Form Area -->
            <div class="col-span-full lg:col-span-6 w-full lg:max-w-[600px]">
                <div class="border border-form dark:border-dark-border p-5 md:p-10 rounded-20 md:rounded-30 dk-theme-card-square">
                    <h3 class="text-xl md:text-[28px] leading-none font-semibold text-heading">
                        Forgot Password
                    </h3>
                    <p class="font-medium text-gray-500 dark:text-dark-text mt-4">
                        Welcome Back! Log in to your account
                    </p>
                    <form action="https://template.codexshaper.com/admin/dashkit/two-step.php" class="leading-none mt-8">
                        <div class="mb-7">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" placeholder="debra.holt@example.com" required autocomplete="off" class="form-input px-4 py-3.5 rounded-lg">
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn b-solid btn-primary-solid w-full dk-theme-card-square">Forgot Password</button>
                    </form>
                    <div class="text-gray-900 dark:text-dark-text font-medium leading-none mt-5">
                        Back to /
                        <a href="index.php" class="text-primary-500 font-semibold">Sign in</a>
                    </div>
                </div>
            </div>
            <!-- End Form Area -->
        </div>
    </div>
    <!-- End Main Content -->

    <script src="assets/js/vendor/jquery.min.js"></script>
    <script src="assets/js/vendor/flowbite.min.js"></script>
    <script src="assets/js/vendor/smooth-scrollbar/smooth-scrollbar.min.js"></script>
    <script src="assets/js/component/app-menu-bar.js"></script>
    <script src="assets/js/switcher.js"></script>
    <script src="assets/js/layout.js"></script>
    <script src="assets/js/main.js"></script>
</body>

 </html>