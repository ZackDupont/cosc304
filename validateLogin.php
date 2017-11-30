<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head></head>

  <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      if(isset($_POST["username"]) && isset($_POST["password"])){
        //handle the user inputted data
        $username= $_POST["username"];
        $pass = md5($_POST["password"]);
        // include database connection
        include 'dbConnection.php';

        // Check if admin
        $stmt = $connection->prepare("SELECT doc_name, doc_pass FROM Doctor WHERE doc_name=? AND doc_pass=?");
        $stmt->bind_param( "ss", $username,$pass);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;

        if($rows == 1){
          $_SESSION['username'] = $username;
          $_SESSION['admin'] = true;
          header('Location: index.php');
        }


        // query users
        $stmt = $connection->prepare("SELECT user_name, password FROM Users WHERE user_name=? AND password=?");
        $stmt->bind_param( "ss", $username,$pass);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;

        if($rows == 1){
          //user is found, set session variable and redirect to main page.
          $_SESSION['username'] = $username;
          header('Location: index.php');
          //username and password combo exist in database, redirect to index.php
        }
        else{
          $_SESSION['errMsg'] = "<p style='color:red' align='center'> Invalid username/password! </p>";
          //username and password combo do not exist, redirect to login.php
          header('Location: login.php');
        }
        mysqli_close($connection);
      }
      else{
        //username or password was not set, redirect back to the login password_get_info
        header('Location: login.php');
      }
    }
    else{
      //user is trying to access page indirectly, redirect to login page
      header('Location: login.php');
    }
  ?>
</body>
</html>
