
 

<header class="header px-4 sm:px-6 h-[calc(theme('spacing.header')_-_10px)] sm:h-header bg-white dark:bg-dark-card rounded-none xl:rounded-15 flex items-center mb-4 xl:m-4 group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_32px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_32px)] group-data-[sidebar-size=sm]:group-data-[theme-width=box]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] group-data-[theme-width=box]:xl:mr-0 dk-theme-card-square z-10 ac-transition">
        <div class="flex-center-between grow">
            <!-- Header Left -->
            <div class="flex items-center gap-4">
                <div class="menu-hamburger-container flex-center">
                    <button type="button" id="app-menu-hamburger" class="menu-hamburger hidden xl:block"></button>
                    <button type="button" class="menu-hamburger block xl:hidden" data-drawer-target="app-menu-drawer" data-drawer-show="app-menu-drawer" aria-controls="app-menu-drawer"></button>
                </div>
              
            </div>
            <!-- Header Right -->
            <div class="flex items-center gap-1 sm:gap-3">
            <a href="/" target="_blank" class="size-8 flex-center hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md" data-drawer-target="app-setting-drawer" data-drawer-show="app-setting-drawer" data-drawer-placement="right" aria-controls="app-setting-drawer">
            <i class="ri-eye-line text-[22px] dark:text-dark-text-two"></i>
            </a>
                <!-- Dark Light Button -->
                <button type="button" class="themeMode size-8 flex-center hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md" onclick="toggleThemeMode()">
                    <i class="ri-contrast-2-line text-[22px] dark:text-dark-text-two dark:before:!content-['\f1bf']"></i>
                </button>
                <!-- Settings Button -->
              
                <!-- Notification Button -->
                
             
                <!-- Border -->
                <div class="w-[1px] h-[calc(theme('spacing.header')_-_10px)] sm:h-header bg-[#EEE] dark:bg-dark-border hidden sm:block"></div>
                <!-- User Profile Button -->
                <div class="relative">
                    <button type="button" data-popover-target="dropdownProfile" data-popover-trigger="click" data-popover-placement="bottom-end" class="text-gray-500 dark:text-dark-text flex items-center gap-2 sm:pr-4 relative after:absolute after:right-0 after:font-remix after:content-['\ea4e'] after:text-[18px] after:hidden sm:after:block">
                        <img src="assets/images/user/profile-img.png" alt="user-img" class="size-7 sm:size-9 rounded-50 dk-theme-card-square">
                        <span class="font-semibold leading-none text-lg capitalize hidden sm:block"><?php echo htmlspecialchars($adminName); ?></span>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownProfile" class="invisible z-backdrop bg-white text-left divide-y divide-gray-100 rounded-lg shadow w-48 dark:bg-dark-card-shade dark:divide-dark-border-four">
                        <div class="px-4 py-3 text-sm text-gray-500 dark:text-white">
                            <div class="font-medium capitalize"><?php echo htmlspecialchars($adminName); ?></div>
                         </div>
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                            <li>
                                <a href="dashboard-lms.php" class="flex font-medium px-4 py-2 hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white">Dashboard</a>
                            </li>
                            <li>
                                <a href="account-setting.php" class="flex font-medium px-4 py-2 hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white">Settings</a>
                            </li>
                        </ul>
                        <div class="py-2">
                            <a href="logout.php" class="flex font-medium px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 dark:hover:bg-dark-icon dark:text-gray-200 dark:hover:text-white">Sign out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>