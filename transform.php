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
//echo $id;
$errors = array();

$userget = "SELECT user FROM bank2.customer WHERE id = '$id'";
$userrun = mysqli_query($db, $userget);
$userfetch = mysqli_fetch_assoc($userrun);
$user = $userfetch['user'];
$flag = true;
//echo $user;
$accget = mysqli_query($db,"SELECT acc_no, acc_type FROM bank2.account WHERE cust_id in (SELECT id FROM bank2.customer WHERE user = '$user')");
    
    
    

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $tr_type = mysqli_real_escape_string($db, $_POST['tr_type']);
    $tr_amount = mysqli_real_escape_string($db, $_POST['tr_amount']);
    $tr_acc_no = mysqli_real_escape_string($db, $_POST['tr_acc_no']);
    

    
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($tr_type)) { array_push($errors, "Username is required"); }
    if (empty($tr_amount)) { array_push($errors, "Email is required"); }
    if (empty($tr_acc_no)) { array_push($errors, "Password is required"); }
    
    
    
     
    

    
  
    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        
        if ($tr_type == "Deposit") {
            //echo $tr_type;
            //echo $tr_amount;
            //echo $tr_acc_no;
            mysqli_query($db,"INSERT INTO bank2.transaction (cust_id,tr_type,tr_amount,tr_acc_no) VALUES ('$id','$tr_type','$tr_amount','$tr_acc_no')");
            mysqli_query($db,"UPDATE account SET balance = balance + $tr_amount where acc_no = $tr_acc_no");
            
        }

        if ($tr_type == "Withdraw") {
            //echo $tr_type;
            //echo $tr_amount;
            //echo $tr_acc_no;
            $tr_amount2 = -1 * $tr_amount;
            
            $balanceget = mysqli_query($db,"SELECT balance FROM account WHERE acc_no = $tr_acc_no");
            $balancefetch = mysqli_fetch_array($balanceget);
            $balance = $balancefetch['balance'];
            //echo $balance;
            if($balance >= $tr_amount){
              mysqli_query($db,"INSERT INTO bank2.transaction (cust_id,tr_type,tr_amount,tr_acc_no) VALUES ('$id','$tr_type','$tr_amount2','$tr_acc_no')");
              mysqli_query($db,"UPDATE account SET balance = balance - $tr_amount where acc_no = $tr_acc_no");
            }
            else{
				$flag = false;
            }
            //mysqli_query($db,"UPDATE account SET balance = balance - $tr_amount where acc_no = $tr_acc_no");
            
        }
        
        //$query = "INSERT INTO CIS421.customer (ssn,user,pass,branch_id,firstname,lastname,age,street,city,state_1) VALUES ('$ssn','$username','$password_1','$branch_id','$firstname','$lastname','$age','$street','$city','$state')";
        
        //mysqli_query($db, $query);
        //$query = "SELECT * FROM CIS421.customer WHERE user='$username'";
        //$test= mysqli_fetch_assoc($result);
        //echo $test['user'];
        //echo "WE HERE";
        
        //echo "DONE!!!";
		if($flag)
		{
			header('location: index.php');
		}
		else{
			echo '<h2 class= "text-center text-danger" >Not enough money in the account</h2>';
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
    <span>Add Transaction</span>
    </div>

    <!-- Transaction Form -->
    <form action="" method="POST">
      <select name="tr_type" class="btn dropdown-toggle selectclass">
        <option value="Deposit">Deposit</option>
        <option value="Withdraw">Withdraw</option>
      </select>
      <input type="number" id="username" min="0" class="fadeIn second" name="tr_amount" placeholder="Amount">
      
      <select name="tr_acc_no" class="btn dropdown-toggle selectclass">
        <?php
        while($accfetch = mysqli_fetch_array($accget)) {
            
            echo "<option value =" .$accfetch['acc_no'].">".$accfetch['acc_no']." -> ".$accfetch['acc_type']."</option>";
        } ?>
        
      </select>

      

      
      
      
      <input type="submit" class="fadeIn fourth" value=" Submit " name="reg_user">
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