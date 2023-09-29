<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <!-- Include Bootstrap CSS from a CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link to your custom CSS file -->
    <link rel="stylesheet" type="text/css" href="assets/css/master.css">
    <!-- Custom CSS styles here -->
    <style>
        /* Your custom CSS styles here */
        .side-navbar {
            width: 180px;
            height: 100%;
            position: fixed;
            margin-left: -300px;
            background-color: #100901;
            transition: 0.5s;
        }

        .nav-link:active,
        .nav-link:focus,
        .nav-link:hover {
            background-color: #ffffff26;
        }

        .my-container {
            transition: 0.4s;
        }

        .active-nav {
            margin-left: 0;
        }

        /* for main section */
        .active-cont {
            margin-left: 180px;
        }

        #menu-btn {
            background-color: #100901;
            color: #fff;
            margin-left: -62px;
        }
    </style>
</head>

<body>
    <div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column" id="sidebar">
        <nav class="nav flex-column text-white w-100">
            <a href="#" class="nav-link h3 text-white my-2">ADMINISTRATOR</a>
            <a href="/admin" class="nav-link">
                <span class="mx-2">Home</span>
            </a>
            <a href="/admin/produk" class="nav-link">
                <span class="mx-2">Produk</span>
            </a>
            <a href="/admin/user" class="nav-link">
                <span class="mx-2">User</span>
            </a>
            <a href="/admin/coupon" class="nav-link">
                <span class="mx-2">coupon</span>
            </a>
        </nav>
    </div>
    <div class="p-1 my-container active-cont">
        <div class="container mt-4">
            <!-- Your content goes here -->
            @yield('container')
        </div>
        <a class="btn border-0" id="menu-btn">
            <i class="bx bx-menu"></i>
        </a>
    </div>

    <!-- Include Bootstrap JavaScript from a CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var menu_btn = document.querySelector("#menu-btn");
        var sidebar = document.querySelector("#sidebar");
        var container = document.querySelector(".my-container");
        menu_btn.addEventListener("click", () => {
            sidebar.classList.toggle("active-nav");
            container.classList.toggle("active-cont");
        });
    </script>
</body>

</html>
