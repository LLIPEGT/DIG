<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIG</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #faf9f4;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #f8f9fa; /* bg-light equivalente */
        }

        .offcanvas {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body>

    <div class="d-flex min-vh-100">

            <div class="sidebar d-none d-lg-flex flex-shrink-0 border-end-0 shadow-sm overflow-auto">
                 <x-nav />
            </div>

            <button class="btn btn-outline-primary d-lg-none position-fixed top-0 start-0 m-3 z-3 rounded-pill shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                <i class="bi bi-list"></i> Menu
            </button>


            <div class="offcanvas offcanvas-start bg-light shadow border-0" tabindex="-1" id="mobileSidebar" aria-labelledby="sidebarLabel">
                <div class="offcanvas-header p-3 border-bottom-0">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <x-nav class="p-3" />
                </div>
            </div>


           <div class="flex-grow-1 p-4">
                @yield('content')
            </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
