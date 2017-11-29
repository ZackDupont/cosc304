<?php
  session_start();
  if(!isset($_SESSION['username'])){
    header('Location: index.php');
  }
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My Account</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="css/clean-blog.min.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="index.php">Jarvis</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <?
            if(!isset($_SESSION['username'])){
              echo('<li class="nav-item">');
              echo('<a class="nav-link" href="index.php">Home</a>');
              echo('</li>');
              echo('<li class="nav-item">');
              echo('<a class="nav-link" href="login.php">Login</a>');
              echo('</li>');
            }else{
              echo ('<li class="nav-item">');
              echo ('<a class="nav-link" href="./account.php"> Hello, ' . $_SESSION['username'] . '!</a>');
              echo('</li>');

            echo('<li class="nav-item">');
            echo('<a class="nav-link" href="shop.php">Shop</a>');
            echo('</li>');

            if(isset($_SESSION['productList'])){
            echo('<li class="nav-item">');
            echo('<a class="nav-link" href="showCart.php"> <i class="fa fa-shopping-cart" style="font-size:17px"></i><span class="badge">'. count($_SESSION['productList']) . '</span></a>');
            echo('</li>');
            }else{
            echo('<li class="nav-item">');
            echo('<a class="nav-link" href="showCart.php"> <i class="fa fa-shopping-cart" style="font-size:17px"></i><span class="badge">0</span></a>');
            echo('</li>');
          }

          }
            ?>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/chemistry.jpg')">
      <br /><div class="overlay"></div><br />
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="post-preview">
            <h1 align='center'>My Account</h1>


          <!-- PHP for search-->
          <?
          $username = $_SESSION["username"];
          $id = ";"
          // include database connection
          include 'dbConnection.php';

          // Get current user's id
          $stmt = $connection->prepare("SELECT * FROM Users WHERE user_name = ?");
          $stmt->bind_param( "s", $username);
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11);

          echo("<table class='table table-striped'>");
          while($stmt->fetch()){
          echo("<tr><thead><th>User ID</th></thead></tr><tr><td colspan='4'>" . $col1 ."</td></tr>");
          echo("<tr><thead><th>Username</th></thead></tr><tr><td colspan='4'>" . $col2 ."</td></tr>");
          echo("<tr><thead><th>Password</th></thead></tr><tr><td colspan='4'>" . $col3 ."</td></tr>");
          echo("<tr><thead><th>Email</th></thead></tr><tr><td colspan='4'>" . $col4 ."</td></tr>");
          echo("<tr><thead><th>DNA</th></thead></tr><tr><td colspan='4'>" . $col5 ."</td></tr>");
          echo("<tr><thead><th>Address</th></thead></tr><tr><td colspan='4'>" . $col6 ."</td></tr>");
          echo("<tr><thead><th>City</th></thead></tr><tr><td colspan='4'>" . $col7 ."</td></tr>");
          echo("<tr><thead><th>Province</th></thead></tr><tr><td colspan='4'>" . $col8 ."</td></tr>");
          echo("<tr><thead><th>Postal Code</th></thead></tr><tr><td colspan='4'>" . $col9 ."</td></tr>");
          echo("<tr><thead><th>Country</th></thead></tr><tr><td colspan='4'>" . $col10 ."</td></tr>");
          echo("<tr><thead><th>Doctor ID</th></thead></tr><tr><td colspan='4'>" . $col11."</td></tr>");
          }
          echo("</table>");
          echo("<h3 align='center'><a href=\"logout.php\">Log Out</a></h3>");


          // Get current user's id
          $stmt = $connection->prepare("SELECT * FROM Orders WHERE user_id = ?");
          $stmt->bind_param( "s", $username);
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11);

          ?>

        </div>
      </div>
    </div>
  </div>

    <hr>

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <ul class="list-inline text-center">
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
            </ul>
            <p class="copyright text-muted">Copyright &copy; Zack Dupont & Gage Buchanan</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/clean-blog.min.js"></script>

  </body>

</html>
