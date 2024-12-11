<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="logo-removebg.png"/>
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="css/contactUs.css">
    <style>
        * {
            box-sizing: border-box;
        }
        .container {
            width: fit-content;
            padding: 10px;
            max-width: 800px;
            margin: auto; /* Center-align the container */
        }
        .contact_grid {
            display: grid;
            grid-template-columns: 100%;
            grid-gap: 30px;
        }
        .left, .right {
            border-radius: 3px;
            padding: 20px;
            background-color: #CDF5FD;
        }
        .left {
            margin-bottom: 0px;
        }
        .column {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .column img {
            width: 30px;
            height: 30px;
            background-color: #89CFF3;
            border-radius: 100%;
            padding: 10px;
            margin-right: 6px;
        }
        .call_mail_des a {
            color: rgb(1, 1, 1);
            text-decoration: none;
        }
        .form {
            display: grid;
            gap: 16px;
        }
        input[type="text"], input[type="email"], input[type="tel"], textarea {
            width: 100%;
            padding: 15px;
            background-color: #A0E9FF;
            border: 1px solid #89CFF3;
            border-radius: 5px;
            box-sizing: border-box;
        }
        #submit {
            width: 100%;
            padding: 15px;
            background-color: #00A9FF;
            border: none;
            border-radius: 5px;
            color: black;
            font-size: 16px;
        }
        #message {
            margin-bottom: 20px;
        }
        @media only screen and (min-width: 768px) {
            .contact_grid {
                grid-template-columns: 30% 70%;
            }
            .form {
                grid-template-columns: repeat(3, 1fr);
            }
            .submit {
                grid-row-start: 3;
                grid-column-start: 3;
            }
            textarea {
                grid-row-start: 2;
                grid-column-start: 1;
                grid-column-end: 4;
            }
        }
        @media only screen and (min-width: 992px) {
            .container {
                max-width: 60%;
            }
        }
    </style>
</head>
<body>

<!-- Nav-Bar -->
<?php include 'navbar.php'; ?>

<!-- ContactUs page -->
<div class="container">
    <!-- Display PHP message if set -->
    <div id="message"><?php echo isset($message) ? $message : ''; ?></div>
    <div class="contact_grid">
        <div class="left">
            <div class="call">
                <div class="column">
                    <img src="phone-line.svg" alt="" width="30px">
                    <h4>Call Us</h4>
                </div>
                <div class="call_mail_des">
                    <p>We are available 24/7, 7 days a week</p>
                    <p>Call Now: <a href="tel:+917567521564">+91 7567521564</a></p>
                </div>
            </div>
            <hr class="hline">
            <div class="message">
                <div class="column">
                    <img src="mail-line.svg" alt="" width="30px">
                    <h4>Write To Us</h4>
                </div>
                <div class="call_mail_des">
                    <p>Fill out our form and we will contact you within 24 hours</p>
                    <p>Email Now: <a href="mailto:anishkhan@gmail.com">anishkhan@gmail.com</a></p>
                </div>
            </div>
        </div>
        <div class="right">
            <form method="post">
                <div class="form">
                    <input type="text" name="Cname" id="Name" placeholder="Your Name *" required>
                    <input type="email" name="CEmail" id="Email" placeholder="Your Email *" required>
                    <input type="tel" name="Cphone" id="Phone" placeholder="Your Phone">
                    <textarea name="CMessage" id="Message" cols="20" rows="10" placeholder="Your Query Write in this space"></textarea>
                    <input type="submit" id="submit" name="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Cname'];
    $Email = $_POST['CEmail'];
    $phone = $_POST['Cphone'];
    $Message = $_POST['CMessage'];

    $sql = "INSERT INTO contactus(name, Email, phone, Message) VALUES ('$name', '$Email', '$phone', '$Message')";
    if (mysqli_query($conn, $sql)) {
        $message = '<div class="alert alert-success" role="alert">Submission successful!</div>';
    } else {
        $message = '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($conn) . '</div>';
    }

    mysqli_close($conn);
}
?>

<!-- Footer -->
<?php include "footer.php"; ?>

</body>
</html>
