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

    <title>Jarvis</title>

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
              echo ('<a class="nav-link" href="./logout.php"> Hello, ' . $_SESSION['username'] . '!</a>');
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

    <pre align="left">
      Billing Information:

          CustomerID: <?php echo $_POST["customerId"]; ?>
          Customer Name: <?php echo $_POST["paymentName"]; ?>
          Card Number: *******
          Cardholder Address: <?php echo $_POST["paymentAddress"]; ?>
          Cardholder Phone Number: <?php echo $_POST["paymentPhoneNumber"]; ?>



      Shipping Information:

          Customer Name: <?php echo $_POST["customerName2"]; ?>
          Customer Address: <?php echo $_POST["customerAddress"]; ?>
          Customer Phone Number: <?php echo $_POST["customerPhoneNumber"] ?>

    </pre>
    <?php
    $custId = "";
  	if(isset($_POST['customerId'])){
  		$custId = $_POST['customerId'];
  	} else {
  		die("<h1>Invalid customer id.  Go back to the previous page and try again.</h1>");
  	}
    $productList = null;
  	if (isset($_SESSION['productList'])){
  		$productList = $_SESSION['productList'];
  	} else {
  		die("<h1>Your shopping cart is empty!</h1>");
  	}
    if(!is_numeric($custId)){
  		die("<h1>Invalid customer id.  Go back to the previous page and try again.</h1>");
  	}
    $custId = intval($custId);
    include 'dbConnection.php';
  	$con = mysqli_connect($host, $user, $password, $database);

    if($con->connect_error){
      die("Connection Failed");
    }
    $orderId = 0;

    echo("<h1>Your Order Summary</h1>");
          echo("<table><tr><th>Product Id</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr>");
        $cureee = 0;
        $quant = 0;
        $total =0;
        foreach ($productList as $id => $prod) {
              echo("<tr><td>".$prod['id']."</td>");
              echo("<td>".$prod['name']."</td>");
      echo("<td align=\"center\">".$prod['quantity']."</td>");
              $price = doubleval($prod['price']);
      echo("<td align=\"right\">".str_replace("USD","$",money_format('%i',$price))."</td>");
              echo("<td align=\"right\">".str_replace("USD","$",money_format('%i',$price*$prod['quantity']))."</td></tr>");
              echo("</tr>");
              $total = $total +$price*$prod['quantity'];

      $stmt2 = $con->prepare("INSERT INTO OrderQuantity (cure_id, quantity) VALUES(?, ?)");
      $pid = intval($prod['id']);
      $stmt2->bind_param("ss", $cureee, $quant);
      $cureee = $id;
      $quant = $prod['quantity'];
      $stmt2->execute();

        }
        echo("<tr><td colspan=\"4\" align=\"right\"><b>Order Total</b></td>" .
                      "<td aling=\"right\">".str_replace("USD","$",money_format('%i',$total))."</td></tr>");
        echo("</table>");

        //$stmt3 = $con->prepare("INSERT INTO Orders VALUES (?,?,?,?,?,?)");
        //$stmt3->bind_param
        //$stmt4 = $con->prepare("INSERT INTO Payment VALUES (?,?,?,?)");
        //$stmt5 = $con->prepare("INSERT INTO Shipment VALUES (?,?,?,?,?,?,?)");

    // Clear session variables (cart)
    $_SESSION['productList'] = null;

  mysqli_close($con);

  //  $stmt = $con->prepare("INSERT INTO Order VALUES ()")

    ?>



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


  </body>
  </html>
