<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config("app.name", "InvenTrack") }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
            rel="stylesheet"
        />

        <!-- Favicons -->
        <link href="{{ asset('assets/img/InvenTrack-logo.png') }}" rel="icon" />
        <link
            href="{{ asset('assets/img/apple-touch-icon.png') }}"
            rel="apple-touch-icon"
        />

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect" />
        <link
            href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
            rel="stylesheet"
        />

        <!-- Vendor CSS Files -->
        <link
            href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{
                asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')
            }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('assets/vendor/quill/quill.snow.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('assets/vendor/quill/quill.bubble.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('assets/vendor/remixicon/remixicon.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('assets/vendor/simple-datatables/style.css') }}"
            rel="stylesheet"
        />

        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

        <!-- flux -->
        @fluxAppearance

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js']) @livewireStyles
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <header id="header" class="header fixed-top d-flex align-items-center">
            <a href="{{ route('dashboard') }}" style="text-decoration: none">
                <div class="flex items-center space-x-3">
                    <img
                        src="{{ asset('assets/img/InvenTrack-logo.png') }}"
                        alt="InvenTrack Logo"
                        style="width: 45px; height: 45px; object-fit: contain"
                    />
                    <span
                        style="
                            font-size: 30px; /* Adjust font size */
                            font-weight: 500;
                            letter-spacing: 2px;
                            color: #111827; /* Dark gray (similar to Tailwind's gray-900) */
                            font-family: Arial, sans-serif; /* Or any font you want */
                        "
                    >
                        Inven<span style="color: #4b5563">Track</span>
                    </span>
                </div>
            </a>

            <!-- End Logo -->
<!-- 
            <div class="search-bar">
                <livewire:search />
            </div> -->
            <!-- End Search Bar -->

            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <li class="nav-item d-block d-lg-none">
                        <a class="nav-link nav-icon search-bar-toggle" href="#">
                            <i class="bi bi-search"></i>
                        </a>
                    </li>
                    <!-- End Search Icon-->

                    <!-- notifications -->
                    <livewire:notifications />
                    <li class="nav-item">
                        <a
                            href="{{ route('create-bill') }}"
                            class="nav-link btn btn-light px-2 py-2 me-3 fw-semibold rounded-pill shadow-sm"
                        >
                            <i class="bi bi-cart-plus me-2"></i> New Sale
                        </a>
                    </li>
                    <li class="nav-item dropdown pe-3">
                        <a
                            class="nav-link nav-profile d-flex align-items-center pe-0"
                            href="#"
                            data-bs-toggle="dropdown"
                        >
                            <img
                                src="{{ asset('storage/profile_images/' . auth()->user()->profile_img) }}"
                                alt="Profile"
                                class="rounded-circle"
                                style="
                                    width: 40px;
                                    height: 45px;
                                    object-fit: cover;
                                    border: 2px solid #fff;
                                "
                            />
                            <span
                                class="d-none d-md-block dropdown-toggle ps-2"
                                >{{ auth()->user()->name }}</span
                            > </a
                        ><!-- End Profile Iamge Icon -->

                        <ul
                            class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
                        >
                            <li class="dropdown-header">
                                <h6>{{ auth()->user()->name }}</h6>
                                <span>{{ auth()->user()->role }}</span>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a
                                    class="dropdown-item d-flex align-items-center"
                                    href="{{ route('profile') }}"
                                >
                                    <i class="bi bi-person"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <form
                                    method="POST"
                                    action="{{ route('logout') }}"
                                    class="d-flex align-items-center m-0 p-0"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="dropdown-item d-flex align-items-center"
                                    >
                                        <i class="bi bi-box-arrow-right"></i>
                                        <span>Sign Out</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                        <!-- End Profile Dropdown Items -->
                    </li>
                    <!-- End Profile Nav -->
                </ul>
            </nav>
            <!-- End Icons Navigation -->
        </header>
        <!-- End Header -->

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">
            <ul class="sidebar-nav" id="sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories.index') }}">
                        <i class="bi bi-grid"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('brands.index') }}">
                        <i class="bi bi-tags"></i>
                        <span>Brands</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('product.index') }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('supplier.index') }}">
                        <i class="bi-person-lines-fill"></i>
                        <span>Suppliers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('purchase.index') }}">
                        <i class="bi bi-cart-check"></i>
                        <span>Purchases</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sales.index') }}">
                        <i class="bi bi-receipt"></i>
                        <span>Sales</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sale.items') }}">
                        <i class="bi bi-list-check"></i>
                        <span>Sale-Items</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Customers</span>
                    </a>
                </li>
                <!-- End Dashboard Nav -->

                <!-- End Blank Page Nav -->
            </ul>
        </aside>
        <!-- End Sidebar-->

        <main id="main" class="main">
            @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endif<!-- End Page Title -->
            <section class="section dashboard">
                {{ $slot }}
            </section>
        </main>
        <!-- End #main -->

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>InvenTrack</span></strong
                >. All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by
                <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </footer>
        <!-- End Footer -->

        <a
            href="#"
            class="back-to-top d-flex align-items-center justify-content-center"
            ><i class="bi bi-arrow-up-short"></i
        ></a>

        <!-- Vendor JS Files -->
        <script src="{{
                asset('assets/vendor/apexcharts/apexcharts.min.js')
            }}"></script>
        <script src="{{
                asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')
            }}"></script>
        <script src="{{
                asset('assets/vendor/chart.js/chart.umd.js')
            }}"></script>
        <script src="{{
                asset('assets/vendor/echarts/echarts.min.js')
            }}"></script>
        <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
        <script src="{{
                asset('assets/vendor/simple-datatables/simple-datatables.js')
            }}"></script>
        <script src="{{
                asset('assets/vendor/tinymce/tinymce.min.js')
            }}"></script>
        <script src="{{
                asset('assets/vendor/php-email-form/validate.js')
            }}"></script>

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/js/main.js') }}"></script>
        @livewireScripts @fluxScripts @stack('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Livewire.hook("message.processed", (message, component) => {
                    // Reinitialize Bootstrap components
                    var dropdowns =
                        document.querySelectorAll(".dropdown-toggle");
                    dropdowns.forEach((dropdown) => {
                        new bootstrap.Dropdown(dropdown);
                    });

                    // Reinitialize other third-party scripts
                    if (typeof $ !== "undefined") {
                        $(".tooltip").tooltip(); // Example: Bootstrap tooltip
                        $(".modal").modal(); // Example: Bootstrap modal
                    }
                });
            });
        </script>
        @push('scripts')
        <script>
            $(document).ready(function () {
                console.log("Reinitializing scripts for this component");
            });
        </script>
        @endpush
    </body>
</html>
