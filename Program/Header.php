
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Genius - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="DropDown.css">

    <script type="text/javascript" src="DatePicker/datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css"/>

      <style>
        .btn:link, .btn:visited {
        background-color: #f44336;
        color: white;
        padding: 15px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        }

        .btn:hover, .btn:active {
          background-color: red;
        }
      </style>

  </head>
  <body>
    
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="Home.php"><i class="flaticon-university"></i>Shine<br><small>Library</small></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">

        <?php 
          if(isset($_SESSION['StaffGrade']))
          {
            if($_SESSION['StaffGrade']=='Library Assistant')
            {
          ?>


        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="Borrow.php" class="nav-link">Borrow</a></li>
          <li class="nav-item"><a href="BorrowSearch.php" class="nav-link">BorrowSearch</a></li>
          <li class="nav-item"><a href="Return.php" class="nav-link">Return</a></li>
          <li class="nav-item"><a href="ReturnSearch.php" class="nav-link">ReturnSearch</a></li>
          <li class="nav-item"><a href="Damage&Lost.php" class="nav-link">Damage&Lost</a></li>
          <li class="nav-item"><a href="Member.php" class="nav-link">Member</a></li>
          <li class="nav-item"><a href="LogOut.php" class="nav-link">LogOut</a></li>

        </ul>

          <?php
            }
            else if($_SESSION['StaffGrade']=='Database Administrator' || $_SESSION['StaffGrade']=='Library Manager')
            {
              ?>


        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="MemberType.php" class="nav-link">MemberType</a></li>
          <li class="nav-item"><a href="Supplier.php" class="nav-link">Supplier</a></li>
          <li class="nav-item"><a href="StaffGrade.php" class="nav-link">StaffGrade</a></li>
          <li class="nav-item"><a href="Staff.php" class="nav-link">Staff</a></li>
          <li class="nav-item"><a href="Category.php" class="nav-link">Category</a></li>
          <li class="nav-item"><a href="ItemType.php" class="nav-link">ItemType</a></li>
          <li class="nav-item"><a href="Purchase_Order.php" class="nav-link">Purchase</a></li>
          <li class="nav-item"><a href="Purchase_Order_Report.php" class="nav-link">PurchaseReport</a></li>
          <li class="nav-item"><a href="Product.php" class="nav-link">Book</a></li>
          <li class="nav-item"><a href="LogOut.php" class="nav-link">LogOut</a></li>

        </ul>


            <?php
            }


          }
          else

          {
            ?>

               <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a  href="Home.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a  href="Login.php" class="nav-link">Login</a></li>
        </ul>
          <?php
          }
          ?>
      </div>
    </div>
  </nav>
    <!-- END nav -->
    
    <div class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg'); background-attachment:fixed;">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 ftco-animate text-center">
            <h1 class="mb-3 bread" style>Shine Library</h1>
            <p>
              If you need help click on this!!<br/><a href="User_Manual.pdf" class="btn">Help:</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </body>
  </html>