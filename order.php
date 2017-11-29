<?php
  session_start();
  if(!isset($_SESSION['username'])){
    header('Location: index.php');
  }
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <style>
    /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */


@keyframes spinner {
0% {
  transform: rotateZ(0deg);
}
100% {
  transform: rotateZ(359deg);
}
}
* {
box-sizing: border-box;
}

.wrapper {
display: flex;
align-items: center;
flex-direction: column;
justify-content: center;
width: 100%;
min-height: 100%;
padding: 20px;
}

.login {
border-radius: 2px 2px 5px 5px;
padding: 10px 20px 20px 20px;
width: 100%;
max-width: 320px;
background: #ffffff;
position: relative;
padding-bottom: 80px;
box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.3);
}
.login.loading button {
max-height: 100%;
padding-top: 50px;
}
.login.loading button .spinner {
opacity: 1;
top: 40%;
}
.login.ok button {
background-color: #8bc34a;
}
.login.ok button .spinner {
border-radius: 0;
border-top-color: transparent;
border-right-color: transparent;
height: 20px;
animation: none;
transform: rotateZ(-45deg);
}
.login input {
display: block;
padding: 15px 10px;
margin-bottom: 10px;
width: 100%;
border: 1px solid #ddd;
transition: border-width 0.2s ease;
border-radius: 2px;
color: #ccc;
}
.login input + i.fa {
color: #fff;
font-size: 1em;
position: absolute;
margin-top: -47px;
opacity: 0;
left: 0;
transition: all 0.1s ease-in;
}
.login input:focus {
outline: none;
color: #444;
border-color: #2196F3;
border-left-width: 35px;
}
.login input:focus + i.fa {
opacity: 1;
left: 30px;
transition: all 0.25s ease-out;
}
.login a {
font-size: 0.8em;
color: #2196F3;
text-decoration: none;
}
.login .title {
color: #444;
font-size: 1.2em;
font-weight: bold;
margin: 10px 0 30px 0;
border-bottom: 1px solid #eee;
padding-bottom: 20px;
}
.login button {
width: 100%;
height: 100%;
padding: 10px 10px;
background: #2196F3;
color: #fff;
display: block;
border: none;
margin-top: 20px;
position: absolute;
left: 0;
bottom: 0;
max-height: 60px;
border: 0px solid rgba(0, 0, 0, 0.1);
border-radius: 0 0 2px 2px;
transform: rotateZ(0deg);
transition: all 0.1s ease-out;
border-bottom-width: 7px;
}
.login button .spinner {
display: block;
width: 40px;
height: 40px;
position: absolute;
border: 4px solid #ffffff;
border-top-color: rgba(255, 255, 255, 0.3);
border-radius: 100%;
left: 50%;
top: 0;
opacity: 0;
margin-left: -20px;
margin-top: -20px;
animation: spinner 0.6s infinite linear;
transition: top 0.3s 0.3s ease, opacity 0.3s 0.3s ease, border-radius 0.3s ease;
box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.2);
}
.login:not(.loading) button:hover {
box-shadow: 0px 1px 3px #2196F3;
}
.login:not(.loading) button:focus {
border-bottom-width: 4px;
}


  </style>
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


    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="post-preview">

              <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                  if(isset($_POST["cardNumber"]) && isset($_POST["expiry"]) && isset($_POST["cvv"])){
                    //handle the user inputted data
                    $card= $_POST["cardNumber"];
                    $username = $_SESSION["username"];
                    $method = $_POST["cardType"];
                    $expiry = $_POST["expiry"];
                    $cvv = $_POST["cvv"];
                    $date = date('Y-m-d');
                    $user_id = "";
                    $doc_id = "";
                    $user_email = "";
                    $user_addr = "";
                    $user_city = "";
                    $user_province = "";
                    $user_postal = "";
                    $user_country = "";
                    $productList = $_SESSION["productList"];
                    $desc="Order for " . $username;


                    // include database connection
                    include 'dbConnection.php';

                    // Get current user's id
                    $stmt = $connection->prepare("SELECT user_id, user_email, address, city, province, postal, country, doc_id FROM Users WHERE user_name = ?");
                    $stmt->bind_param( "s", $username);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8);


                    while($stmt->fetch()){
                      $user_id = $col1;
                      $user_email = $col2;
                      $user_addr = $col3;
                      $user_city = $col4;
                      $user_province = $col5;
                      $user_postal= $col6;
                      $user_country = $col7;
                      $doc_id = $col8;
                    }
                    $ship_desc =  "<br />Ship to: <br /> $username <br />$user_addr<br />$user_city, $user_province, $user_postal<br />$user_country<br/>Shipped on: $date<br />Receipt emailed to: $user_email";

                    // Check if card already used by User
                    $stmt = $connection->prepare("SELECT user_id FROM Payment WHERE user_card = ?");
                    $stmt->bind_param( "s", $card);
                    $stmt->execute();
                    $stmt->store_result();
                    $rows = $stmt->num_rows;

                    // Insert payment info if not already stored
                    if(!$rows > 0){
                      // Insert info into Payment
                       $sql = $connection->prepare("INSERT INTO Payment (user_card, user_name, method, user_id) VALUES (?,?,?,?)");
                       $sql->bind_param("sssi", $card, $username, $method, $id);
                       $sql->execute();
                    }

                    // Set order total value
                    $total=0;
                    foreach ($productList as $id => $prod) {
                      $total = $total +$prod['quantity']*$prod['price'];
                    }

                    //Insert info into Orders
                    $sql = $connection->prepare("INSERT INTO Orders (order_total, order_desc, order_date, user_id, doc_id) VALUES (?,?,?,?,?)");
                    $sql->bind_param("dssii", $total, $desc, $date, $user_id, $doc_id);
                    $sql->execute();

                    // Get current order id
                    $orderId = $connection->insert_id;

                    // Insert into OrderedProduct with orderid = last order
                    foreach ($productList as $id => $prod) {
                      //Insert info into Orders
                      $sql = $connection->prepare("INSERT INTO OrderQuantity (order_id, cure_id, quantity) VALUES (?,?,?)");
                      $sql->bind_param("iii", $orderId, $prod["id"], $prod["quantity"]);
                      $sql->execute();
                    }

                    // Shipping cost
                    $shipping = $total * 0.25;

                    //Insert info into Shipment
                    $sql = $connection->prepare("INSERT INTO Shipment (ship_total, ship_desc, ship_date, user_card, user_name, order_id) VALUES (?,?,?,?,?,?)");
                    $sql->bind_param("issssi",$shipping, $ship_desc, $date, $card, $username, $orderId);
                    $sql->execute();

                    if (isset($_SESSION['productList'])){
                      $productList = $_SESSION['productList'];

                      // Get cures and quantity in current order
                      $stmt = $connection->prepare("SELECT cure_name, price, quantity, order_total FROM Cure, OrderQuantity, Orders WHERE OrderQuantity.cure_id = Cure.cure_id AND OrderQuantity.order_id = Orders.order_id AND Orders.order_id = ?");
                      $stmt->bind_param( "i", $orderId);
                      $stmt->execute();
                      $stmt->store_result();
                      $stmt->bind_result($col1,$col2,$col3,$col4);


                      echo("<h1 align='center'>Order Summary</h1>");
                      echo("<h2 align='center'>Order Id: " . $orderId. "</h2>");
                      echo("<table class='table' align='center'><tr><thead><th>Items</th><th>Quantity</th><th>Price</th><th>Subtotal</th></thead>");

                      while($stmt->fetch()){
                        $sub = str_replace("USD","$",money_format('%i',$col2*$col3));
                        echo("<tr><td>" . $col1 . "</td><td>". $col3 ."</td><td>$". $col2 ."</td><td>$" .$sub ."</td></tr>");
                      }
                      echo("<tr><td colspan=\"3\" align=\"right\"><b>Order Total (Shipping and Tax Included)</b></td><td align=\"right\">$".str_replace("USD","$",money_format('%i',$col4+$shipping))."</td></tr>");
                      echo("</table>");


                      echo("<h2 align='center'>Shipping Info</h2>");
                      // Select shipping info from current order
                      $stmt2 = $connection->prepare("SELECT ship_desc, ship_total FROM Shipment WHERE order_id = ?");
                      $stmt2->bind_param( "i", $orderId);
                      $stmt2->execute();
                      $stmt2->store_result();
                      $stmt2->bind_result($col1,$col2);

                      while($stmt2->fetch()){
                      echo("<table class='table' align='center'><tr><thead><th>Details</th><th>Shipping Cost</th></thead>");
                        echo("<tr><td>" . $col1 . "</td><td>$". $col2. "</td></tr>");
                      echo("</table>");
                      }

                      $_SESSION["productList"] = null;
                      header('Location: index.php');
                    }
                    }
                    else{
                      header('Location: index.php');
                    }
                    mysqli_close($connection);
                  }
                  else{
                    header('Location: index.php');
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
