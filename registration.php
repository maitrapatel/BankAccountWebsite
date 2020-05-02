<?php
session_start();
define('DB_SERVER', '127.0.0.1:3360');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'bank2');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);


$username = "";
$email    = "";
$errors = array();

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['login']);
    $branch_id = mysqli_real_escape_string($db, $_POST['branch_id']);
	$phone_num = mysqli_real_escape_string($db, $_POST['phone']);
    $firstname = mysqli_real_escape_string($db, $_POST['fname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lname']);
    $age = mysqli_real_escape_string($db, $_POST['age']);
    $street = mysqli_real_escape_string($db, $_POST['street']);
    $city = mysqli_real_escape_string($db, $_POST['city']);
    $state = mysqli_real_escape_string($db, $_POST['state']);
    $ssn = mysqli_real_escape_string($db, $_POST['ssn']);
    $acc_type = mysqli_real_escape_string($db, $_POST['acc_type']);
    $inidep = mysqli_real_escape_string($db, $_POST['inidep']);
   
  
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    
  
    // first check the database to make sure 
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM bank2.customer WHERE user='$username' OR ssn='$ssn' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    
    
    if ($user) { // if user exists
      
      if ($user['user'] === $username) {
        array_push($errors, "Username already exists");
      
      }
      if ($user['ssn'] === $ssn) {
        array_push($errors, "Social Security Doesn't Exist");
        
        
      }
      
      
    }
    
    
  
    // Finally, register user if there are no errors in the form
    
    if (count($errors) == 0) {
        
        $query = "INSERT INTO bank2.customer (branch_id,ssn,user,pass,firstname,lastname,age,street,city,state) VALUES ('$branch_id','$ssn','$username','$password_1','$firstname','$lastname','$age','$street','$city','$state')";
        
        mysqli_query($db, $query);
        $query = "SELECT * FROM bank2.customer WHERE user='$username'";
        $result = mysqli_query($db, $query);
        $test = mysqli_fetch_assoc($result);
        $user_id = $test['id'];
        
        
        $query2 = "INSERT INTO bank2.account (cust_id,acc_type,balance) VALUES ('$user_id','$acc_type','$inidep')";
        mysqli_query($db, $query2);
        //echo $test['user'];
		
		$query3 = "INSERT INTO bank2.cust_phone (cust_id, phone_num) VALUES ('$user_id', '$phone_num')";
		mysqli_query($db, $query3);
        
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        //echo "DONE!!!";
        header('location: login.php');
        
        
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
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <i class="fas fa-user"></i>
    <span>Register</span>
    </div>

    <!-- Login Form -->
    <form action="" method="POST">
    

      <input type="text" id="username" class="fadeIn second" name="username" placeholder="Login">
      <!--<input type="password" class="fadeIn third" name="password" placeholder="password"> -->
      <input type="text" class="fadeIn third" name="login" id="login" placeholder="Password">
      <input type="email" class="fadeIn third" name="email" id="login" placeholder="Email">
	  <input type="text" class="fadeIn third" name="phone" id="phone" placeholder="Phone#(10 Digits)" pattern = "[0-9]{10}">
      <input type="text" class="fadeIn third" name="fname" id="login" placeholder="First Name">
      <input type="text" class="fadeIn third" name="lname" id="login" placeholder="Last Name">
      <input type="text" class="fadeIn third" name="ssn" id="login" placeholder="SSN">
      <select name="branch_id" class="btn dropdown-toggle selectclass">
        <option value="1">Livonia</option>
        <option value="3">Dearborn</option>
        <option value="2">RedFord</option>
		<option value="4">Canton</option>
		<option value="5">Plymouth</option>
		<option value="6">Detroit</option>
		<option value="7">Ann Arbor</option>
      </select>
      <select name="age" class="btn dropdown-toggle selectclass">
      <?php
        for ($i=18; $i<=100; $i++)
        {
      ?>
        <option value="<?php echo $i;?>"><?php echo $i;?></option>
      <?php
        }
      ?>
      </select>
      <select name="acc_type" class="btn dropdown-toggle selectclass">
        <option value="checking">Checking</option>
        <option value="savings">Savings</option>
      </select>
      <input type="number" class="fadeIn third" name="inidep" id="login" placeholder="Initial Deposit"> 
      <input type="text" class="fadeIn third" name="street" id="login" placeholder="Street">
      <input type="text" class="fadeIn third" name="city" id="login" placeholder="City">
      <select name="state" class="btn dropdown-toggle selectclass">
        <option value="AL">AL</option>
	      <option value="AK">AK</option>
	      <option value="AR">AR</option>	
	      <option value="AZ">AZ</option>
	      <option value="CA">CA</option>
	      <option value="CO">CO</option>
	      <option value="CT">CT</option>
	      <option value="DC">DC</option>
	      <option value="DE">DE</option>
	      <option value="FL">FL</option>
	      <option value="GA">GA</option>
	      <option value="HI">HI</option>
	      <option value="IA">IA</option>	
	      <option value="ID">ID</option>
	      <option value="IL">IL</option>
	      <option value="IN">IN</option>
	      <option value="KS">KS</option>
	      <option value="KY">KY</option>
	      <option value="LA">LA</option>
	      <option value="MA">MA</option>
	      <option value="MD">MD</option>
	      <option value="ME">ME</option>
	      <option value="MI">MI</option>
	      <option value="MN">MN</option>
	      <option value="MO">MO</option>	
	      <option value="MS">MS</option>
	      <option value="MT">MT</option>
	      <option value="NC">NC</option>	
	      <option value="NE">NE</option>
	      <option value="NH">NH</option>
	      <option value="NJ">NJ</option>
	      <option value="NM">NM</option>			
	      <option value="NV">NV</option>
	      <option value="NY">NY</option>
	      <option value="ND">ND</option>
	      <option value="OH">OH</option>
	      <option value="OK">OK</option>
	      <option value="OR">OR</option>
	      <option value="PA">PA</option>
	      <option value="RI">RI</option>
	      <option value="SC">SC</option>
	      <option value="SD">SD</option>
	      <option value="TN">TN</option>
	      <option value="TX">TX</option>
	      <option value="UT">UT</option>
	      <option value="VT">VT</option>
	      <option value="VA">VA</option>
	      <option value="WA">WA</option>
      	<option value="WI">WI</option>	
	      <option value="WV">WV</option>
	      <option value="WY">WY</option>
    </select>	

      
      
   
      <input type="submit" class="fadeIn fourth" value=" Submit " name="reg_user">
    </form>

   

    

  </div>
</div>
</body>
</html>

<?php

?>