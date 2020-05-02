<?php
define('DB_SERVER', '127.0.0.1:3360');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'bank2');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
//echo $id;
session_start();
$id = $_SESSION['user_id'];
$errors = array();
//echo $user;
// REGISTER USER
if (isset($_POST['add_acc'])) 
{// receive all input values from the form
    $acc_type = mysqli_real_escape_string($db, $_POST['acc_type']);
    $acc_balance = mysqli_real_escape_string($db, $_POST['balance']);
    
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($acc_type)) { array_push($errors, "Accounttype is required"); }
    if (empty($acc_balance)) { array_push($errors, "Account Balance is required"); }
    
   //CHECK IF USER ALREADY HAS A SAVINGS ACCOUNT, OR A CHECKING ACCOUNT! FIX ME IN THE MORNING!!!!!!!!!!!!!!!
	$result = mysqli_query($db,"SELECT acc_type FROM bank2.account WHERE cust_id = '$id' AND acc_type = '$acc_type'");
	$acc_rows = mysqli_num_rows($result);
    // Finally, add account if there are no errors in the form
    if (count($errors) == 0) {
		if($acc_rows < 1)
		{
			if ($acc_type == "checking") {
           
				mysqli_query($db,"INSERT INTO bank2.account (cust_id,acc_type,balance) VALUES ('$id','$acc_type','$acc_balance')");
            
			}

			if ($acc_type == "savings") {
			
				mysqli_query($db,"INSERT INTO bank2.account (cust_id,acc_type,balance) VALUES ('$id','$acc_type','$acc_balance')");
			}
			header('location: index.php');
		}
		else
		{
			if($acc_type == 'savings')
			{
				echo '<h2 class= "text-center text-danger" >You already have an account of that type</h2>';
			}
			if ($acc_type == 'checking')
			{
				echo '<h2 class= "text-center text-danger" >You already have an account of that type</h2>';
			}
		}
		
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
    

    <!-- Icon -->
    <div class="fadeIn first">
      <i class="fas fa-user"></i>
    <span>New Account</span>
    </div>

    <!-- Add account Form -->
    <form action="" method="POST">
      <select name="acc_type" class="btn dropdown-toggle selectclass">
        <option value="checking">Checking</option>
        <option value="savings">Savings</option>
      </select>
      <input type="number" id="username" min="0" class="fadeIn second" name="balance" placeholder="Initial Amount">
      
	<input type="submit" class="fadeIn fourth" value=" Submit " name="add_acc">
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