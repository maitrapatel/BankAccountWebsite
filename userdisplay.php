<?php
define('DB_SERVER', '127.0.0.1:3360');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'bank2');
try{
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
}
catch(Exception $e){
    echo $e->errorMessage();
}
session_start();
$id = $_SESSION['user_id'];


$username = "";
$email    = "";
$errors = array();
$phoneNumber = "";

$userinfoquery = mysqli_query($db,"SELECT branch_name, firstname, lastname, ssn, age, CONCAT(street, ', ', city, ', ', state) as address
from customer, branch
where branch.id = customer.branch_id AND customer.id = '$id'");

$userPhonequery = mysqli_query($db, "SELECT phone_num
from cust_phone
where cust_phone.cust_id = '$id'");

$userinfofetch = mysqli_fetch_assoc($userinfoquery);
$userPhonefetch = mysqli_fetch_assoc($userPhonequery);

if($userPhonefetch == NULL) {
    $phoneNumber = "N/A";
     
  }else {
     $phoneNumber = $userPhonefetch['phone_num'];
  }

  
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="style.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="app.js"></script>
</head>
<body>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <i class="fas fa-user"></i>
    <span>User Info</span>
    </div>

    <!-- Login Form -->
    <form action="" method="POST">
    

      <span class="selectclass"><p class = "text-center"><?php echo $userinfofetch['firstname']?></p></span>
      <span class="selectclass"><p class = "text-center"><?php echo $userinfofetch['lastname']?></p></span>
      <span class="selectclass"><p class = "text-center"><?php echo $userinfofetch['branch_name']?></p></span>
      <span class="selectclass"><p class = "text-center"><?php echo $userinfofetch['ssn']?></p></span>
	  <span class="selectclass"><p class = "text-center"><?php echo $phoneNumber?></p></span>
      <span class="selectclass"><p class = "text-center"><?php echo $userinfofetch['age']?></p></span>
      <span class="selectclass"><p class = "text-center"><?php echo $userinfofetch['address']?></p></span>
      
      
      
   
      <div id="formFooter">
      <a class="underlineHover" href="index.php" >Go To Dashboard</a>
      </div>
    </form>

   

    

  </div>
</div>
</body>
</html>

<?php

?>