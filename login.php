<?php
include 'db_connection.php';
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
  // username and password sent from form 
  
  $myusername = mysqli_real_escape_string($db,$_POST['username']);
  $mypassword = mysqli_real_escape_string($db,$_POST['login']); 
  
  $sql = "SELECT id FROM bank2.customer WHERE user = '$myusername' and pass = '$mypassword'";
  $result = mysqli_query($db,$sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  $id = $row['id'];
  
  $count = mysqli_num_rows($result);
  
  // If result matched $myusername and $mypassword, table row must be 1 row

  if($count == 1) {
     
     $_SESSION['login_user'] = $myusername;
     $_SESSION['user_id'] = $id;
     
     header("location: index.php");
  }else {
     $error = "Your Login Name or Password is invalid";
	 echo '<h2 class= "text-center text-danger" >Invalid login credentials!</h2>';
  }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="style.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <i class="fas fa-user"></i>
    <span>Sign In</span>
    </div>

    <!-- Login Form -->
    <form action="" method="POST">
      <input type="text" id="username" class="fadeIn second" name="username" placeholder="Login">
      <!--<input type="password" class="fadeIn third" name="password" placeholder="password"> -->
      <input type="text" class="fadeIn third" name="login" id="login" placeholder="password">
      <input type="submit" class="fadeIn fourth" value=" Submit ">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
    <div>
      <a class="underlineHover d-inline-block" href="updatepass.php" >Forgot Password?</a>
    </div>
    <div>
      <a class="underlineHover d-inline-block" href="registration.php" >Create User</a>
    </div>
    </div>

  </div>
</div>
</body>
</html>

<?php

?>