<?php
include 'db_connection.php';
session_start();
//User Dashboard
$id = $_SESSION['user_id'];
//Get Client Info
$query = "SELECT firstname, lastname FROM customer WHERE id='$id'";
$result = mysqli_query($db, $query);
$fetch = mysqli_fetch_assoc($result);
//Get Checking account info if any
$Checkingquery = "SELECT account.balance FROM account join customer on account.cust_id=customer.id
where account.acc_type='checking' AND customer.id='$id'";
$Checkingget = mysqli_query($db, $Checkingquery);
$Checkingfetch = mysqli_fetch_array($Checkingget);
//Get Savings account info if any
$Savingsquery = mysqli_query($db, "SELECT account.balance FROM account join customer on account.cust_id=customer.id
where account.acc_type='savings' AND customer.id='$id'");
$Savingsfetch = mysqli_fetch_array($Savingsquery);
//Get Deposit transaction info if any
$DepositQuery = mysqli_query($db, "SELECT SUM(tr_amount) as earnings FROM transaction where tr_type = 'deposit' and cust_id = '$id'
GROUP BY 'cust_id'");
$Depositfetch = mysqli_fetch_array($DepositQuery);
//Get Withdraw transaction info if any
$WithdrawQuery = mysqli_query($db, "SELECT SUM(tr_amount) as earnings FROM transaction where tr_type = 'withdraw' and cust_id = '$id'
GROUP BY cust_id");
$Withdrawfetch = mysqli_fetch_array($WithdrawQuery);
$earnings;

//Get Credit Card account info if any
$creditCardquery= mysqli_query($db, "SELECT account.balance FROM account join customer on account.cust_id=customer.id
where account.acc_type='Credit' AND customer.id='$id'");
$CreditCardFetch = mysqli_fetch_array($creditCardquery);

//Loan info
$loanQuery = mysqli_query($db, "SELECT loan.balance FROM loan join customer on loan.cust_id=customer.id where customer.id = '$id'");
$loanFetch = mysqli_fetch_array($loanQuery);
//Earnings info
if($Depositfetch['earnings'] === NULL){
  $earnings = $Withdrawfetch['earnings'];
}
else {
  $earnings = $Depositfetch['earnings'] + $Withdrawfetch['earnings'];
}

$transquery = mysqli_query($db, "SELECT count(*) FROM transaction where cust_id = '$id'");
$transfetch = mysqli_fetch_array($transquery);

$translistquery = mysqli_query($db, "SELECT tr_acc_no, tr_type, tr_amount, tr_datetime from transaction
where cust_id = '$id'");

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Loaded Bank</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search 
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>-->

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="login.php">
                <span class="mr-2 d-none d-lg-inline text-danger ">Log Out</span>
                
              </a>
              <!-- Dropdown - User Information -->
             
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="transform.php">
                <span class="mr-2 d-none d-lg-inline text-primary ">Add Transaction</span>
                
              </a>
              <!-- Dropdown - User Information -->
             
            </li>
			
			      <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="addaccount.php">
                <span class="mr-2 d-none d-lg-inline text-primary ">Add Account</span>
                
              </a>
             
            </li>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="creditform.php">
                <span class="mr-2 d-none d-lg-inline text-primary ">Credit Card Application</span>
              </a>
            </li>
            <!--Apply for loan-->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="loanform.php">
                <span class="mr-2 d-none d-lg-inline text-primary ">Apply for Loan</span>
              </a>
            </li>



            

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="userdisplay.php">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $fetch["firstname"];?> <?php echo $fetch["lastname"];?></span>
                
              </a>
              <!-- Dropdown - User Information -->
             
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
           
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Checking Balance -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Checking Balance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php if($Checkingfetch['balance'] === NULL){echo "N/A";}
                      else {
                        echo $Checkingfetch['balance'];
                      }
                      
                      ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo $earnings ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!--# of Transactions -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"># Of Transactions</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $transfetch['count(*)'] ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Savings Balance -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Savings Balance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php if($Savingsfetch['balance'] === NULL){echo "N/A";}
                      else {
                        echo $Savingsfetch['balance'];
                      }?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

              <!-- CC Balance -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Credit Card Balance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php if($CreditCardFetch['balance'] === NULL){echo "N/A";}
                      else {
                        echo $CreditCardFetch['balance'];
                      }?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Loan balance-->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Loan Owe Amount</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php if($loanFetch['balance'] === NULL){echo "N/A";}
                      else {
                        echo $loanFetch['balance'];
                      }
                      ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            

            <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Transactions</h1>
<p class="mb-4">All Transactions in all accounts.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Transactions</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Account Number</th>
            <th>Transaction Type</th>
            <th>Transaction Amount</th>
            <th>Date & Time</th>
            
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Account Number</th>
            <th>Transaction Type</th>
            <th>Transaction Amount</th>
            <th>Date & Time</th>
            
          </tr>
        </tfoot>
        <tbody>
          
          <?php
          while($translistfetch = mysqli_fetch_array($translistquery)){
            echo"
            <tr>
            <td>".$translistfetch['tr_acc_no']."</td>
            <td>".$translistfetch['tr_type']."</td>
            <td>$".$translistfetch['tr_amount']."</td>
            <td>".$translistfetch['tr_datetime']."</td>
            </tr>";
          };
          ?>
          
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Loaded Bank</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
