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

    <title>Your Shopping Cart</title>

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


          <?
          // Get the current list of products
          $productList = null;
          if (isset($_SESSION['productList'])){
          	$productList = $_SESSION['productList'];
          	echo("<h1 align='center'>Your Shopping Cart</h1>");
          	echo("<table class='table' align='center'><tr><thead><th>Product&nbsp;Id</th><th>Product Name</th><th>Quantity</th>");
          	echo("<th>Price</th><th>Subtotal</th></tr></thead>");

          	$total = 0;
          	foreach ($productList as $id => $prod) {
          		echo("<tr><td>". $prod['id'] . "</td>");
          		echo("<td>" . $prod['name'] . "</td>");

          		echo("<td align=\"center\">".$prod['quantity']."</td>");
              $price = $prod['price'];

          		echo("<td align=\"right\">$".str_replace("USD","$",money_format('%i',$price))."</td>");
          		echo("<td align=\"right\">$" . str_replace("USD","$",money_format('%i',$prod['quantity']*$price)) . "</td><td><a href='deleteRow.php?id=".$id."'>Remove</a></td></tr>");
          		echo("</tr>");
          		$total = $total +$prod['quantity']*$price;

          	}



          	echo("<tr><td colspan=\"4\" align=\"right\"><b>Order Total</b></td><td align=\"right\">".str_replace("USD","$",money_format('%i',$total))."</td></tr>");
          	echo("</table>");



            //echo("<h3 align='center'><a href='updateCart.php?id='>Update Cart</a></h3><p></p>");
          	echo("<h3 align='center'><a href=\"checkout.php\">Check Out</a></h3>");
          } else{
          	echo("<h1 align='center'>Your Shopping Cart is Empty!</h1>");
          }
          ?>
					<p></p>
					<h3 align='center'><a href='shop.php'>Continue Shopping </a></h3>
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
