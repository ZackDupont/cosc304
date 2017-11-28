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

<body>

<h5 align="center">Checkout</h5><br>


<form align="center" action="summary.php" method = "post">
  <fieldset>
    <legend>Billing Information</legend>
    <br>
  Customer ID: <input type="text" name="customerId" size="20" required><br>
  Cardholder Name: <input type="text" name="paymentName" size="40" required><br>
  Card Numer: <input type="text" name="paymentNumber" size="16" maxlength="16" min="16" required><br>
  Card Expiry: <input type = "month" name="paymentExpiry" maxlength="6" size="6" required>
  CVV: <input type="text" name="paymentCVV" size="4" maxlength="4" min="3" required><br>
  Cardholder Address: <input type="text" name="paymentAddress" size="40" required><br>
  Cardholder Phone Number: <input type="text" name="paymentPhoneNumber" size="11" required><br>
</fieldset>
<br>
Shipping information same as billing information: <input type="checkbox" onclick="fillShippingInfo(this.checked)">
<br>
<br>
<fieldset>
<legend>Shipping Information</legend>
<br>
Customer Name:<input type="text" name="customerName2" size="40" required><br>
Customer Address: <input type="text" name="customerAddress" size="40" required><br>
Customer Phone Number: <input type="text" name="customerPhoneNumber" size="11" required><br>
<br>
</fieldset>


<br>
<?php
$productList = null;
if (isset($_SESSION['productList'])){
$productList = $_SESSION['productList'];
echo("<table class='table' align='center'><tr><thead><th width='150'>Product Id</th><th>Product Name</th><th>Quantity</th>");
echo("<th>Price</th><th>Subtotal</th></tr></thead>");

$total =0;
$tax = 0;
$shipping = 0;
$purchasePrice =0;
foreach ($productList as $id => $prod) {
echo("<tr><td>". $prod['id'] . "</td>");
echo("<td>" . $prod['name'] . "</td>");

echo("<td align=\"center\"><input type='number' name='quantity' min='1' max='100' value='".$prod['quantity']."'/></td>");
$price = $prod['price'];

echo("<td align=\"right\">$".str_replace("USD","$",money_format('%i',$price))."</td>");
echo("<td align=\"right\">$" . str_replace("USD","$",money_format('%i',$prod['quantity']*$price)) . "</td><td>X</td></tr>");
echo("</tr>");
$total = $total +$prod['quantity']*$price;
$tax = $total * 0.05;
$purchasePrice = $total + $tax;
$_SESSION["orderTotal"] = $total;

}
echo("<tr><td colspan=\"4\" align=\"right\"><b>Subtotal:</b></td><td align=\"right\">".str_replace("USD","$",money_format('%i',$total))."</td></tr>");
echo("<tr><td colspan=\"4\" align=\"right\"><b>Shipping:</b></td><td align=\"right\">".str_replace("USD","$",money_format('%i',$shipping))."</td></tr>");
echo("<tr><td colspan=\"4\" align=\"right\"><b>Taxes:</b></td><td align=\"right\">".str_replace("USD","$",money_format('%i',$tax))."</td></tr>");
echo("<tr><td colspan=\"4\" align=\"right\"><b>Order Total:</b></td><td align=\"right\">".str_replace("USD","$",money_format('%i',$purchasePrice))."</td></tr>");

echo("</table>");

//echo("<h3 align='center'><a href=\"placeOrder.php\">Complete Order</a></h3>");
} else{
echo("<H1 align='center'>Your shopping cart is empty!</H1>");
}
 ?>
<input type="submit" name="submit" value="Place Order">
</form>

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