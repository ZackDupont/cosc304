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

          <?
          // Get the current list of products
          $productList = null;
          if (isset($_SESSION['productList'])){
          	$productList = $_SESSION['productList'];
          	echo("<h1 align='center'>Review Your Order</h1>");
          	echo("<table class='table' align='center'><tr><thead><th width='150'>Product Id</th><th>Product Name</th><th>Quantity</th>");
          	echo("<th>Price</th><th>Subtotal</th></tr></thead>");

          	$total = 0;
          	foreach ($productList as $id => $prod) {
          		echo("<tr><td>". $prod['id'] . "</td>");
          		echo("<td>" . $prod['name'] . "</td>");

          		echo("<td align=\"center\">".$prod['quantity']."</td>");
          		$price = $prod['price'];

          		echo("<td align=\"right\">$".str_replace("USD","$",money_format('%i',$price))."</td>");
          		echo("<td align=\"right\">$" . str_replace("USD","$",money_format('%i',$prod['quantity']*$price)) . "</td></tr>");
          		echo("</tr>");
          		$total = $total +$prod['quantity']*$price;
          	}
            echo("<tr><td colspan=\"4\" align=\"right\"><b>Shipping</b></td><td align=\"right\">".str_replace("USD","$",money_format('%i',$total))."</td></tr>");
            echo("<tr><td colspan=\"4\" align=\"right\"><b>Order Total</b></td><td align=\"right\">".str_replace("USD","$",money_format('%i',$total))."</td></tr>");
          	echo("</table>");
            ?>
            <div class="wrapper">
            <form class="login" method="POST" action="./order.php" >
              <p class="title">Enter Payment Info</p>
              Card Number:<input type="text" name="cardNumber" maxlength='16'placeholder="EX: 00001111222233333" pattern="[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]"autofocus required/>
              Expiration Date:<input type="date" name="expiry" maxlength='5' placeholder="MM/YY" pattern="[0-9][0-9]/[0-9][0-9]" required/>
              CVV:<input type="text" name="cvv"placeholder="EX: 345" maxlength='3'pattern="[0-9][0-9][0-9]" required/>
              Card Type:
              <select name="cardType"required>
                <option value="">Please select an option</option>
                <option value="VISA">VISA</option>
                <option value="Mastercard">Mastercard</option>
                <option value="AMEX">AMEX</option>
              </select>
              <button>
                <i class="spinner"></i>
                <span class="state">Place Order</span>
              </button>

              </p>
            </form>
          </div>
            <?
          } else{
          	echo("<H1 align='center'>Your Shopping Cart is Empty!</H1>");
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
