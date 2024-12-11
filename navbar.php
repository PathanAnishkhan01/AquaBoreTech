<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
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
        <a class="navbar-brand" href="index.php">
            <img src="logo-removebg.png" alt="Logo" style="height: 60px; width: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $currentPage == 'products.php' ? 'active' : ''; ?>" href="products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $currentPage == 'contactUs.php' ? 'active' : ''; ?>" href="contactUs.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $currentPage == 'Aboutus.php' ? 'active' : ''; ?>" href="Aboutus.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $currentPage == 'quotation.php' ? 'active' : ''; ?>" href="quotation.php">Make Quotation</a>
                </li>
            </ul>
        </div>

        <div class="navbar-buttons d-flex align-items-center ml-3">
            <?php
            if (empty($_SESSION['email'])) {
                echo "<a href='login.php' class='btn btn-outline-primary mr-2'>Login</a>";
                echo "<a href='signup.php' class='btn btn-outline-primary mr-3'>SignUp</a>";
            } else {
                echo "<a href='logout.php' class='btn btn-outline-primary mr-3'>Logout</a>";
            }
            ?>
            <a href="<?php echo empty($_SESSION['email']) ? 'login.php' : 'cart.php'; ?>" class="cart-icon">
                <i class="fas fa-shopping-cart" style="font-size: larger; cursor: pointer;"></i>
            </a>

        </div>
    </nav>

    <!-- Include jQuery and Bootstrap JS for proper navbar toggle functionality -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</body>

</html>