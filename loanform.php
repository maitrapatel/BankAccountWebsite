<?php
//include 'db_connection.php';
session_start();
define('DB_SERVER', '127.0.0.1:3360');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'bank2');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$user_id = $_SESSION['user_id'];

$username = "";
$email    = "";
$errors = array();

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $amount = mysqli_real_escape_string($db, $_POST['amount']);
    $years = mysqli_real_escape_string($db, $_POST['years']);
    $state = mysqli_real_escape_string($db, $_POST['state']);
    $ssn = mysqli_real_escape_string($db, $_POST['ssn']);
    $creditscore = mysqli_real_escape_string($db, $_POST['creditscore']);
    $interest = " ";

   
  
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($ssn)) { array_push($errors, "Social Security is required"); }
    if (empty($creditscore)) { array_push($errors, "Credit Score is required"); }
    if (empty($amount)) { array_push($errors, "Amount is required"); }
    if($creditscore > 850) {array_push($errors, "Invalid Credit Score. Must be between 720 - 850");}
    if($creditscore < 720) {array_push($errors, "Invalid Credit Score. Must be between 720 - 850");}
    if(count($errors) == 0)
    {
        if($creditscore < 750) {$interest = 0.05;}
        else if ($creditscore < 800) {$interest = 0.04;}
        else {$interest = 0.03;}
    }
    // first check the database to make sure 
    // a user does not already exist with the same username and/or email
  
    // Finally, register user if there are no errors in the form
    
    if (count($errors) == 0) {
        //Compute amount due after interest applied for years selected
        $balance = $amount + ($amount * $interest * $years);
        $query2 = "INSERT INTO bank2.loan (cust_id,balance,interest, years) VALUES ('$user_id','$balance','$interest', $years)";
        mysqli_query($db, $query2);
        header('location: index.php');
    }
    else{
      for ($i=0; $i<sizeof($errors); $i++)
        {
          echo($errors[$i]);
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
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <i class="fas fa-user"></i>
    <span>Personal Loan Application</span>
    <p style = "color: red">Interest varies based on credit score (3% - 5%)</p>
    </div>

    <!-- Login Form -->
    <form action="" method="POST">
    

      <input type="text" id="creditscore" class="fadeIn second" name="creditscore" placeholder="CreditScore">
      <!--<input type="password" class="fadeIn third" name="password" placeholder="password"> -->
      <input type="text" class="fadeIn third" name="ssn" id="login" placeholder="SSN">
      <select name="years" class="btn dropdown-toggle selectclass">
      <option value="0">Select years to pay off: </option>
      <?php
        for ($i=1; $i<=5; $i++)
        {
      ?>
        <option value="<?php echo $i;?>"><?php echo $i;?></option>
      <?php
        }
      ?>
      </select>
      <input type="text" class="fadeIn third" name="amount" id="login" placeholder="Amount">
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