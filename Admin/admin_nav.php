<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .nav-link.active {
            color: #007bff;
            font-weight: bold;
            border-bottom: 2px solid #007bff;
        }

        .navbar-nav {
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .navbar-nav {
                display: flex;
                justify-content: center;
                width: 100%;
            }
        }

        .navbar-toggler {
            border: none;
            outline: none;
        }

        .navbar {
            background-color: rgb(235, 251, 251);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light pl-5 mt-2 font-weight-bold" style="background-color: rgb(235, 251, 251);">
        <a class="navbar-brand" href="admin_dashboard.php">
            <img src="../logo-removebg.png" alt="Logo" style="height: 60px; width: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>" href="index.php">ManageUsers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $currentPage == 'productsmanage.php' ? 'active' : ''; ?>" href="productsmanage.php">ManageProducts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $currentPage == 'cust_query.php' ? 'active' : ''; ?>" href="cust_query.php">CustomersQuery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $currentPage == 'allorders.php' ? 'active' : ''; ?>" href="allorders.php">All Orders</a>
                </li>
                <!-- <li class="nav-item">
                <a class="nav-link <?php echo $currentPage == 'settings.php' ? 'active' : ''; ?>" href="settings.php">Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $currentPage == 'admin_quotations.php' ? 'active' : ''; ?>" href="admin_quotations.php">Quotations</a> -->
                </li>
                <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    More Options
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="logs.php">Logs</a>
                    <a class="dropdown-item" href="feedback.php">Feedback</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="help.php">Help</a>
                </div>
            </li> -->
            </ul>
        </div>

        <!-- <div class="navbar-buttons d-flex align-items-center ml-3">
        <?php
        if (empty($_SESSION['admin_email'])) {
            echo "<a href='admin_login.php' class='btn btn-outline-primary mr-2'>Login</a>";
        } else {
            echo "<a href='admin_logout.php' class='btn btn-outline-primary mr-3'>Logout</a>";
        }
        ?>
    </div> -->
    </nav>

    <!-- Include jQuery and Bootstrap JS for proper navbar toggle functionality -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</body>

</html>