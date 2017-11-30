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

    <title>Order Details</title>

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
            }
            else{
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

          <?

            // Check if id is set
            if(isset($_GET['id'])){
              $id = $_GET['id'];

              // include database connection
              include 'dbConnection.php';

              // Get items in order
              $stmt = $connection->prepare("SELECT OrderQuantity.order_id, OrderQuantity.cure_id, quantity, Orders.order_total, cure_name, price FROM OrderQuantity, Orders, Cure WHERE OrderQuantity.order_id = Orders.order_id AND OrderQuantity.cure_id = Cure.cure_id AND Orders.order_id = ?");
              $stmt->bind_param( "i", $id);
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6);

              echo("<h1 align='center'> Summary of Order ". $id ."</h1><p></p>");
              echo("<table class='table'><tr><thead><th>Cure&nbsp;ID</th><th>Item Name</th><th>Quantity</th><th>Cost</th></thead></tr>");
              while($stmt->fetch()){
                echo("<tr><td>". $col2. "</td><td>". $col5. "</td><td>". $col3. "</td><td>$". $col6. "</td></tr>");
              }
              echo("<tr><td colspan=\"3\" align=\"right\"><b>Order Total (Shipping and Taxes included)</b></td><td align=\"right\">$".str_replace("USD","$",money_format('%i',$col4*1.40))."</td></tr>");
              echo("</table>");


              echo("<h3 align='center'>Shipping Info</h3>");
              // Select shipping info from current order
              $stmt2 = $connection->prepare("SELECT ship_desc, ship_total, user_card, user_name FROM Shipment WHERE order_id = ?");
              $stmt2->bind_param( "i", $id);
              $stmt2->execute();
              $stmt2->store_result();
              $stmt2->bind_result($col1,$col2,$col3,$col4);

              while($stmt2->fetch()){
              echo("<table class='table' align='center'><tr><thead><th>Details</th><th>Shipping Cost</th></thead>");
                echo("<tr><td>" . $col1 . "</td><td>$". $col2. "</td></tr>");
              echo("</table>");
              }

              echo("<h3 align='center'>Billing Info</h3>");
              // Select shipping info from current order
              $stmt2 = $connection->prepare("SELECT user_card, user_name, method, order_id FROM Payment, Orders WHERE Payment.user_id = Orders.user_id AND order_id = ?");
              $stmt2->bind_param( "i", $id);
              $stmt2->execute();
              $stmt2->store_result();
              $stmt2->bind_result($col1,$col2,$col3,$col4);

              while($stmt2->fetch()){
              echo("<table class='table' align='center'><tr><thead><th>Card Number</th><th>Customer Name</th><th>Method</th></thead>");
                echo("<tr><td>" . $col1 . "</td><td>". $col2. "</td><td>". $col3. "</td></tr>");
              echo("</table>");
              }







            } else{
              header('Location: shop.php');
            }

          ?>
					<p></p>
					<h3 align='center'><a href='account.php'>Back to Account </a></h3>
          </body>
          </html>
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
                <a href="https://github.com/zdupo067/cosc304">
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
