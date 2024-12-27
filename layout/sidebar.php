<?php 
    require_once "../koneksi.php";
    
    // Cek apakah user sudah login
    if (!isset($_SESSION["login"])) {
        header("Location: ../login.php");
        exit;
    }
    
    // Ambil data dari sesi
    $admin_name = $_SESSION["admin_name"];
    $admin_image = $_SESSION["admin_image"];
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* sidebar */
        main .sidebar {
            width: 230px;
            height: 100vh; /* Sidebar akan penuh hingga tinggi viewport */
            position: fixed; /* Sidebar tetap di kiri layar */
            top: 0;
            left: 0;
            transition: all 0.3s ease;
        }

        main .sidebar.collapsed {
            width: 10%;
        }

        .logo-small {
            width: 80px;
        }

        main .sidebar-header img {
            width: 65px;
            border-radius: 50%;
            object-fit: cover;
        }

        main .sidebar-header h6 {
            font-family: 'satoshi';
            font-size: 20px;
            font-weight: 600;
        }

        main .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            overflow: hidden;
            white-space: nowrap;
            transition: all 0.3s ease;
            font-size: 18px;
            font-family: 'satoshi';
            font-weight: 500;
            color: var(--ne100);
            background-color: transparent;
            transition: background-color 0.3s, color 0.3s;
        }

        main .sidebar .nav-link.active {
            background-color: var(--darkblue00);
            color: var(--ne00);
            border-radius: 5px;
        }

        main .sidebar.collapsed nav .nav-link span {
            display: none;
        }

        main .sidebar-footer {
            margin-top: auto;
            text-align: center;
            padding: 1rem;
        }

        main .content {
            margin-left: 225px; /* Memberi ruang untuk sidebar */
            transition: margin-left 0.3s ease;
            overflow: hidden;
        }

        main .sidebar.collapsed ~ .content {
            margin-left: 10%;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <section id="sidebar" class="bg-light sidebar d-flex flex-column gap-4 justify-content-center align-items-center">
        <!-- Header -->
        <a href="../index.php" target="_blank"><img src="../assets/images/logo-PACKSY.svg" alt="LOGO PACKSY" id="logo" class="mt-5"></a>
        <div class="sidebar-header text-center mt-4">
            <img src="../upload/<?= $admin_image ?>" alt="Admin Avatar">
            <h6 id="name" class="fs-5 mt-3"><?= $admin_name ?></h6>
        </div>
    
        <!-- Navigation -->
        <nav class="nav flex-column justify-content-center">
            <a href="profile.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'active' : '' ?>">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
            <a href="index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>
            <a href="reporting.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'reporting.php' ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-text"></i>
                <span>Reporting</span>
            </a>
            <a href="../logout.php" class="nav-link">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </nav>

        <!-- Footer -->
        <div class="sidebar-footer">
            <button id="toggleSidebar" class="btn btn-outline-primary">
                <i class="bi bi-chevron-double-left"></i>
            </button>
        </div>
    </section>
    
    <script>
        const sidebar = document.getElementById("sidebar");
        const toggleButton = document.getElementById("toggleSidebar");

        toggleButton.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            const icon = toggleButton.querySelector("i");
            icon.classList.toggle("bi-chevron-double-right");

            const logo = document.getElementById("logo");
            logo.classList.toggle("logo-small");
            
            const nameAdmin = document.getElementById("name");
            nameAdmin.classList.toggle("d-none");

        });
    </script>
</body>
</html>