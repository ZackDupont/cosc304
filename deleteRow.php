<?php
  session_start();
  if(!isset($_SESSION['username'])){
    header('Location: index.php');
  }

  if(!empty($_SESSION["productList"])) {
		foreach($_SESSION["productList"] as $id => $prod) {
			if($_GET["id"] == $id)	unset($_SESSION["productList"][$id]);
			if(empty($_SESSION["productList"])) unset($_SESSION["productList"]);
		}
    header('Location: showCart.php');
	}else {
	   unset($_SESSION["productList"]);
     header('Location: showCart.php');
	}









?>
