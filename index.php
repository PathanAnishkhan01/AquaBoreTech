<!DOCTYPE html>
<html lang="en">
<?php
include 'connection.php';


// Fetch products from the database
$products = [];
$sql = "SELECT * FROM products LIMIT 3";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="logo-removebg.png"/>
  <title>Aqua Bore Tech</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="responsive.css">
</head>

<body>

<?php include 'navbar.php'; ?>
  <!-- first page of home -->
  <div class="container">
    <div class="row">
      <div class="col-md-7" style="margin-top: 20px;">
        <h1> Welcome to Aqua Bore Tech</h1>
        <p>At New Bharat Engineering Works, we take pride in being a leading manufacturer and specialist in high-quality water well rig machine parts. With decades of experience in the industry, we have established ourselves as a trusted name for precision-engineered components that meet the highest standards of durability, performance, and reliability.</p>
                
      </div>

      <div class="col-md-5" style="margin-top: 20px;"">
            <img src=" images/first_home.jpg" class="rounded float-left" style="max-height: 800px; width: 100%; object-fit: cover;"  alt="">
      </div>
    </div>
  </div>
  <hr class="hr1">

  
  <!-- Product Of Home Page -->
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center mb-3">
        <span class="homeproduct"><u>Products</u></span>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <!-- Dynamically display products here -->
      <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
          <div class="col-md-4">
            <!-- Product Card -->
            <div class="card mt-2" style="width: 18rem; border: 1px solid black;">
              <img src="images/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-height: 250px;">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
              </div>
              <hr class="hr2">
              <div class="card-body">
                <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-success">
                  <i class="fa-solid fa-bag-shopping mr-2"></i>Shop Now
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No products available at the moment.</p>
      <?php endif; ?>
    </div>
  </div>

  <hr class="hr1 mt-5">

 <!-- Our Clients -->
<div class="container">
  <div class="row">
    <div class="col-md-12 text-center mb-3">
      <span class="homeproduct"><u>Our Clients</u></span>
    </div>
  </div>
</div>

<div class="customer-slider">
  <div class="slider-wrapper">
    <!-- Customer 1 -->
    <div class="customer-card">
      <img src="cust company/ongcLogo.jpg" alt="ONGC">
      <h5>ONGC</h5>
    </div>

    <!-- Customer 2 -->
    <div class="customer-card">
      <img src="cust company/jgon.jpg" alt="John Infra">
      <h5>John Infra</h5>
    </div>

    <!-- Customer 3 -->
    <div class="customer-card">
      <img src="cust company/head-logo.png" alt="Doctor Pumps">
      <h5>Doctor Pumps</h5>
    </div>

    <!-- Customer 4 -->
    <div class="customer-card">
      <img src="images/circle4.png" alt="Mercidize">
      <h5>Mercidize</h5>
    </div>

    <!-- Customer 5 -->
    <div class="customer-card">
      <img src="images/circle5.png" alt="BMW">
      <h5>BMW</h5>
    </div>

    <!-- Duplicate Customer Cards for Infinite Effect -->
    <div class="customer-card">
      <img src="cust company/ongcLogo.jpg" alt="ONGC">
      <h5>ONGC</h5>
    </div>
    <div class="customer-card">
      <img src="cust company/jgon.jpg" alt="John Infra">
      <h5>John Infra</h5>
    </div>
    <div class="customer-card">
      <img src="cust company/head-logo.png" alt="Doctor Pumps">
      <h5>Doctor Pumps</h5>
    </div>
    <div class="customer-card">
      <img src="images/circle4.png" alt="Mercidize">
      <h5>Mercidize</h5>
    </div>
    <div class="customer-card">
      <img src="images/circle5.png" alt="BMW">
      <h5>BMW</h5>
    </div>
  </div>
</div>

  <hr class="hr1 mt-5">

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <p ><u style="font-size:xx-large; font-weight: 900;text-decoration:none;text-transform:capitalize">any query?</u></p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <form action="" method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              placeholder="Enter Name" style="max-width: 500px; border: 1px solid black;" name="name">
            <small id="emailHelp" class="form-text text-muted"></small>
          </div>

          <label for="exampleInputEmail1">Email</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
            placeholder="Enter email" style="max-width: 500px; border: 1px solid black;" name="email">
          <small id="emailHelp" class="form-text text-muted  mb-2">We'll never share your email with anyone
            else.</small>

          <label for="exampleInputEmail1">Your Number</label>
          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
            placeholder="Enter Mobile No" style="max-width: 500px; border: 1px solid black;" name="mobile">
          <small id="emailHelp" class="form-text text-muted">We'll never share your Number with anyone else.</small>

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div>
          <input type="submit" class="btn btn-primary" name="submit">
        </form>
      </div>
      <div class="col-md-6">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3656.352480691743!2d72.36840067533105!3d23.591688478779037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395c414d951f7051%3A0xd60c7321f70b73a!2sNew%20bharat%20engineering%20works!5e0!3m2!1sen!2sin!4v1717786547678!5m2!1sen!2sin" width="500" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </div>
  </div>
  <?php
if($_SERVER['REQUEST_METHOD']=='POST'){
$n=$_POST['name'];
$e=$_POST['email'];
$m=$_POST['mobile'];

$sql="INSERT INTO user_query(name, email, messege) VALUES ('$n','$e','$m')";
$s=$conn->query($sql);
if($s){

  echo'<script>alert("data inseted");</script>';
}
else{
  
  echo'<script>alert("not inseted");</script>';
}
}

?>
  <hr class="hr1 mt-4">


  <!-- Our Specialities -->

  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center mb-3">
        <span class="homeproduct"><u>Our Specialities</u></span>
      </div>
    </div>
  </div>


  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card text-center">
          <div class="card-header">
            Featured
          </div>
          <div class="card-body">
            <h5 class="card-title">We stay here approximately at least 5 years.</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          </div>
          <div class="card-footer text-muted">
            2 days ago
          </div>
        </div>
      </div>
    </div>
  </div>

  <hr class="hr1 mt-4">

  <!-- Footer Start Here -->

  <div class="container">
    <div class="row">
      <div class="col-md-12">
      <?php include "footer.php"; ?>
      </div>
    </div>
  </div>



  <!-- Rest of your page content goes here -->

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="index.js"></script>
</body>

</html>