<!doctype html>
<html>

<head>
    <title>NeoWear Admin Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav
            class="p-2.5 flex fixed top-0 left-0 right-0 z-50 bg-white justify-between items-center border-neutral-100 border-b-2">
            <div id="nav-menu" class="flex justify-center gap-9  items-center">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button" id="menu-toggle-btn"
                    class="flex items-center p-1 ms-2 text-sm text-gray-500 rounded-lg sm:hidden">
                    <span class="sr-only">Open sidebar</span>
                    <i id="menu-icon"
                        class="ri-menu-line w-6 h-6 mb-1 text-2xl font-semibold text-gray-500 hover:text-gray-900 transition-colors duration-200"></i>
                    <i id="close-icon"
                        class="ri-arrow-left-line w-6 h-6 mb-1 text-2xl font-semibold text-gray-500 hover:text-gray-900 transition-colors duration-200 hidden"></i>
                </button>
                <span
                    class="text-2xl font-display ml-2 text-gray-900 font-semibold text-center hidden sm:flex">Admin</span>
            </div>
            <a href="../php/index.php" id="brand" class="flex gap-2 items-center text-2xl">
                <span class="logo"
                    style="font-family: 'Octin Stencil', sans-serif;     text-decoration: none;
    color: black;
    text-transform: uppercase;
    font-family: 'Octin Stencil', sans-serif;
    font-weight: 400;
    font-size: 34px;
    cursor: pointer;
    letter-spacing: 1.2px;">NeoWear</span>
            </a>
            <div id="RightNav" class="flex gap-3 items-end">
                @php
                    use App\Models\User;
                    $u = User::find(Session::get('user_id'));
                @endphp
                <a href="{{ url('/admin_profile') }}" class="text-3xl hover:text-primary relative">
                    <img src="{{ $u->profile_image ? asset('images/users/' . $u->profile_image) : asset('images/users/main_user_image.webp') }}"
                        alt="Admin Profile"
                        class="w-10 h-10 bg-cover rounded-full cursor-pointer" />
                </a>
            </div>
        </nav>
    </header>

    <!-- Sidebar -->
    <aside id="logo-sidebar"
        class="fixed top-14 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-50 border-r-2 border-neutral-100">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ url('/home') }}"
                        class="flex items-center px-2 pb-2 text-gray-900 transition-all duration-300 border-b-2 border-neutral-100 hover:border-neutral-600  group">
                        <i
                            class="ri-dashboard-line w-5 h-5 text-gray-500 text-xl group-hover:text-gray-900 transition-colors duration-200"></i>
                        <span class="ms-3 whitespace-nowrap  mt-1.5">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin_products') }}"
                        class="flex items-center px-2 pb-2 text-gray-900 transition-all duration-300 border-b-2 border-neutral-100 hover:border-neutral-600  group">
                        <i
                            class="ri-shopping-bag-line w-5 h-5 text-gray-500 text-xl group-hover:text-gray-900 transition-colors duration-200"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap mt-1.5">Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin_users') }}"
                        class="flex items-center px-2 pb-2 text-gray-900 transition-all duration-300 border-b-2 border-neutral-100 hover:border-neutral-600  group">
                        <i
                            class="ri-user-line w-5 h-5 text-gray-500 text-xl group-hover:text-gray-900 transition-colors duration-200"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap mt-1.5">Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin_categories') }}"
                        class="flex items-center px-2 pb-2 text-gray-900 transition-all duration-300 border-b-2 border-neutral-100 hover:border-neutral-600  group">
                        <i
                            class="ri-price-tag-3-line w-5 h-5 text-gray-500 text-xl group-hover:text-gray-900 transition-colors duration-200"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap mt-1.5">Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin_offers') }}"
                        class="flex items-center px-2 pb-2 text-gray-900 transition-all duration-300 border-b-2 border-neutral-100 hover:border-neutral-600  group">
                        <i
                            class="ri-percent-line w-5 h-5 text-gray-500 text-xl group-hover:text-gray-900 transition-colors duration-200"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap mt-1.5">Offers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin_orders') }}"
                        class="flex items-center px-2 pb-2 text-gray-900 transition-all duration-300 border-b-2 border-neutral-100 hover:border-neutral-600  group">
                        <i
                            class="ri-shopping-cart-line w-5 h-5 text-gray-500 text-xl group-hover:text-gray-900 transition-colors duration-200"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap mt-1.5">Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('inquires') }}"
                        class="flex items-center px-2 pb-2 text-gray-900 transition-all duration-300 border-b-2 border-neutral-100 hover:border-neutral-600  group">
                        <i
                            class="ri-message-3-line w-5 h-5 text-gray-500 text-xl group-hover:text-gray-900 transition-colors duration-200"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap mt-1.5">Inquires</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin_profile') }}"
                        class="flex items-center px-2 pb-2 text-gray-900 transition-all duration-300 border-b-2 border-neutral-100 hover:border-neutral-600  group">
                        <i
                            class="ri-user-settings-line w-5 h-5 text-gray-500 text-xl group-hover:text-gray-900 transition-colors duration-200"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap mt-1.5">Profile</span>
                    </a>
                </li>
                <li class="relative">
                    <button id="settingsDropdownBtn"
                        class="w-full flex items-center px-2 pb-2 text-gray-900 transition-all duration-300 border-b-2 border-neutral-100 hover:border-neutral-600 group focus:outline-none"
                        type="button" aria-haspopup="true" aria-expanded="false">
                        <i
                            class="ri-settings-3-line w-6 h-6 shrink-0 text-gray-500 text-xl group-hover:text-gray-900 transition-colors duration-200"></i>
                        <span class="ms-3 whitespace-nowrap mt-1.5">Settings</span>
                        <svg class="ml-2 w-4 h-4 text-gray-500 group-hover:text-gray-900 transition-colors duration-200"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="settingsDropdownMenu"
                        class="absolute left-0 mt-2 z-50 bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-44 hidden border border-gray-200 sm:w-44 w-full sm:left-0 left-0">
                        <ul class="py-2 px-0 text-center text-sm text-gray-700" aria-labelledby="settingsDropdownBtn">
                            <li>
                                <a href="{{ route('admin.sliders') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 transition-colors">
                                    <i class="ri-image-line text-lg text-gray-500"></i>
                                    <span>Slider Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.about') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 transition-colors">
                                    <i class="ri-information-line text-lg text-gray-500"></i>
                                    <span>About Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.contact') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 transition-colors">
                                    <i class="ri-mail-line text-lg text-gray-500"></i>
                                    <span>Contact Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </aside>

    <div id="main-content" class="transition-all mt-16 duration-300 sm:ml-64">
        @yield('main_content')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script>
        $(document).ready(function() {
            const $userIcon = $('.user-icon');
            const $userDropDown = $('.user-drop-down');

            $userIcon.on('click', function(e) {
                e.preventDefault();
                $userDropDown.stop(true, true).fadeToggle(300).toggleClass('block');
            });

            // Close dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#RightNav').length) {
                    $userDropDown.fadeOut(300).removeClass('block');
                }
            });

            // Settings dropdown functionality
            $('#dropdownDefaultButton').on('click', function() {
                $('#dropdown').toggleClass('hidden');
            });

            // Close settings dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#dropdownDefaultButton').length) {
                    $('#dropdown').addClass('hidden');
                }
            });
        });

        // Toggle menu/close icon
        const menuBtn = document.getElementById('menu-toggle-btn');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');
        const navDialog = document.getElementById('logo-sidebar');

        menuBtn.addEventListener('click', function() {
            setTimeout(() => {
                if (!navDialog.classList.contains('-translate-x-full')) {
                    menuIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                } else {
                    menuIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                }
            }, 100); // wait for drawer animation
        });

        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('settingsDropdownBtn');
            const menu = document.getElementById('settingsDropdownMenu');

            function closeMenu() {
                menu.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
            }

            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('hidden');
                btn.setAttribute('aria-expanded', !menu.classList.contains('hidden'));
            });

            document.addEventListener('click', function(e) {
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    closeMenu();
                }
            });

            window.addEventListener('resize', closeMenu);
        });
    </script>

</body>

</html>
