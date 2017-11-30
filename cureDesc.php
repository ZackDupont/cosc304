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

    <title>Cure Description</title>

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
<style>
#submitReviewForm{
     background:none!important;
     color:inherit;
     border:none;
     padding:0!important;
     font: inherit;
     cursor: pointer;
}
#submitReviewForm:hover{
  text-decoration:underline;
  color:#4091a0;
}


</style>


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
            $pname = "";
            // include database connection
            include 'dbConnection.php';

            // Get current user's id
            $stmt = $connection->prepare("SELECT cure_id, cure_name, injection_site, injection_timing, num_injections, special_reqs, cure_desc, price, cure_image, cat_name FROM Cure, Category WHERE Cure.cat_id = Category.cat_id AND cure_id = ?");
            $stmt->bind_param( "s", $id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10);


            while($stmt->fetch()){
              $pname = $col2;
              echo("<h1 align='center'>". $col2 ."</h1><p></p>");
              echo("<h1 align='center'><img src='".$col9."' /></h1><p></p>");
            }
            echo("<table class='table table-striped'>");
            echo("<tr><thead><th>Description</th></thead></tr><tr><td colspan='4'>" . $col7 ."</td></tr>");
            echo("<tr><thead><th>Injection Site</th></thead></tr><tr><td colspan='4'>" . $col3 ."</td></tr>");
            echo("<tr><thead><th>Injection Timing</th></thead></tr><tr><td colspan='4'>" . $col4 ."</td></tr>");
            echo("<tr><thead><th>Number of Injections</th></thead></tr><tr><td colspan='4'>" . $col5 ."</td></tr>");
            echo("<tr><thead><th>Special Requirements</th></thead></tr><tr><td colspan='4'>" . $col6 ."</td></tr>");
            echo("<tr><thead><th>Category</th></thead></tr><tr><td colspan='4'>" . $col10 ."</td></tr>");
            echo("</table>");

            
            echo("<h3 align='center'><a style='text-decoration:none' href='addToCart.php?id=" .$col1. "&name=" .$col2. "&price=" .$col8. "'>Add&nbsp;To&nbsp;Cart</a></h3>");




            // Reviews
            $username = $_SESSION['username'];
            $uid = "";
            // Get current user's id
            $stmt = $connection->prepare("SELECT user_id FROM Users WHERE user_name = ?");
            $stmt->bind_param( "s", $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($col1);

            while($stmt->fetch()){
              $uid = $col1;
            }

            // Get reviews
            $stmt = $connection->prepare("SELECT review_date,review_rating,review_desc, Review.user_id, cure_id, user_name FROM Review, Users WHERE Review.user_id = Users.user_id AND cure_id = ?");
            $stmt->bind_param( "i", $id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6);
            $rows = $stmt->num_rows;

            echo("<hr />");
            echo("<h1 align='center'>Reviews</h1>");
            if($rows > 0){
            echo("<table class='table'>");
            echo("<thead><tr><th>Review Date</th><th>Rating</th><th>Review Description</th><th>User</th></tr></thead>");
            while($stmt->fetch()){
              echo("<tr><td>".$col1."</td><td>".$col2."/5</td><td>".$col3."</td><td>".$col6."</td></tr>");
            }
            echo("</table>");
          }else{
            echo("<h3 align='center'>There Are No Reviews Yet!</h3>");
          }
            echo("<div class='form-group'>
                    <form name='reviewForm' method='GET' action='submitReview.php'>
                    <h3 align='center'>Write a Review</h3>
                      <input type='hidden' name='id' value='".$id."'/>
                      Your Review
                      <input class='form-control' name='comment' placeholder='Write Review...'/>
                      Rating <br />
                      <input type='number' maxlength='1' name='rating' min='1' max='5' />
                      /5
                      <h4 align='center'><a id='submitReviewForm' onclick='reviewForm.submit()'>Submit Post</a></h4>
                      </form>
                  </div><hr />");

          } else{
          	header('Location: shop.php');
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
