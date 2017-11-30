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
            echo('<li class="nav-item">');
            echo('<a class="nav-link" href="logout.php">Sign Out</a>');
            echo('</li>');
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
          $uid = "";
          // include database connection
          include 'dbConnection.php';

          // Get current user's id
          $stmt = $connection->prepare("SELECT * FROM Users WHERE user_name = ?");
          $stmt->bind_param( "s", $username);
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11);

          echo("<h3 align='center'>Info</h3>");
          echo("<table class='table'>");
          while($stmt->fetch()){
          $uid = $col1;
          echo("<tr><th>User ID</th><td align='right'>" . $col1 ."</td></tr>");
          echo("<tr><th>Username</th><td align='right'>" . $col2 ."</td></tr>");
          echo("<tr><th>Password</th><td align='right'>" . $col3 ."</td></tr>");
          echo("<tr><th>Email</th><td align='right'>" . $col4 ."</td></tr>");
          echo("<tr><th>DNA</th><td align='right'>" . $col5 ."</td></tr>");
          echo("<tr><th>Address</th><td align='right'>" . $col6 ."</td></tr>");
          echo("<tr><th>City</th><td align='right'>" . $col7 ."</td></tr>");
          echo("<tr><th>Province</th><td align='right'>" . $col8 ."</td></tr>");
          echo("<tr><th>Postal Code</th><td align='right'>" . $col9 ."</td></tr>");
          echo("<tr><th>Country</th><td align='right'>" . $col10 ."</td></tr>");
          echo("<tr><th>Doctor ID</th><td align='right'>" . $col11 ."</td></tr>");
          }
          echo("</table>");


          // Get current user's id
          $stmt2 = $connection->prepare("SELECT order_id, order_total, order_desc, order_date FROM Orders WHERE user_id = ?");
          $stmt2->bind_param( "i", $uid);
          $stmt2->execute();
          $stmt2->store_result();
          $stmt2->bind_result($col1,$col2,$col3,$col4);
          $rows = $stmt2->num_rows;

          echo("<br /><h3 align='center'>Order History</h3>");
          if($rows > 0){
          echo("<table class='table table-hover'>");
          echo("<tr><thead><th>Order ID</th><th>Order Total</th><th>Order Description</th><th>Order Date</th></thead></tr>");
          while($stmt2->fetch()){
            echo("<tr><td><a href='showOrder.php?id=". $col1 ."'>".$col1."</a></td><td>$". $col2 ."</td><td>". $col3 ."</td><td>". $col4 ."</td></tr>");
          }
          echo("</table>");
        }else{
          echo("<h1 align='center'>You Haven't Place Any Orders Yet! <a href='shop.php'>Start Shopping</a></h1>");
        }

        // Get current user's id
        $stmt2 = $connection->prepare("SELECT review_date, review_rating, review_desc, Review.cure_id, cure_name FROM Review, Cure WHERE Review.cure_id = Cure.cure_id AND user_id = ?");
        $stmt2->bind_param( "i", $uid);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($col1,$col2,$col3,$col4,$col5);
        $rows = $stmt2->num_rows;

        echo("<br /><h3 align='center'>Product Reviews</h3>");
        if($rows > 0){
        echo("<table class='table'>");
        echo("<tr><thead><th>Review Date</th><th>Review&nbsp;Rating</th><th>Review&nbsp;Description</th><th>Cure&nbsp;Name</th></thead></tr>");
        while($stmt2->fetch()){
          echo("<tr><td>". $col1 ."</td><td>". $col2 ."/5</td><td>". $col3 ."</td><td>". $col5 ."</td></tr>");
        }
        echo("</table>");
      }else{
        echo("<h1 align='center'>You Haven't Reviewed Any Products Yet! <a href='shop.php'>Start Shopping</a></h1>");
      }
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
