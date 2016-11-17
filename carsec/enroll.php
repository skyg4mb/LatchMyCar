<?php
 ob_start();
 session_start();

 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }

 $error = false;

 include_once 'dbconnect.php';

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $vehicle = trim($_POST['vehicle']);
  $vehicle = strip_tags($vehicle);
  $vehicle = htmlspecialchars($vehicle);
  
  $serial = trim($_POST['serial']);
  $serial = strip_tags($serial);
  $serial = htmlspecialchars($serial);
  
  $paircode = trim($_POST['paircode']);
  $paircode = strip_tags($paircode);
  $paircode = htmlspecialchars($paircode);

  $userid = $_SESSION['user'];
  

  // basic vehicle validation
  if (empty($vehicle)) {
   $error = true;
   $vehicleError = "Please enter the vehicle.";
  } else if (strlen($vehicle) < 3) {
   $error = true;
   $vehicleError = "Vehicle name must have atleat 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$vehicle)) {
   $error = true;
   $vehicleError = "Vehicle must contain alphabets and space.";
  }

  // basic serial validation
  if (empty($serial)) {
   $error = true;
   $serialError = "Please enter the serial.";
  } else if (strlen($serial) < 3) {
   $error = true;
   $serialError = "Serial must have atleat 3 characters.";
  } else if (!preg_match("/^[\w]+$/",$serial)) {
   $error = true;
   $serialError = "Serial should not contain special characters.";
  }
  
  // basic pair code validation
  if (empty($paircode)) {
   $error = true;
   $paircodeError = "Please enter the pair code.";
  } else if (strlen($paircode) < 3) {
   $error = true;
   $paircodeError = "Pair code must have atleat 3 characters.";
  } else if (!preg_match("/^[\w]+$/",$paircode)) {
   $error = true;
   $paircodeError = "Serial should not contain special characters.";
  }
  
  if( !$error ) {

   $command = 'python latch/MyCar.py ' .$paircode;

   exec($command, $output, $ret_code);

   $accountId = $output[0];


   if ($ret_code == 0){
    
    $query = "UPDATE users SET latchAccountId = '$accountId' WHERE userId = '$userid';";
    $res = mysql_query($query);
         
    $query = "INSERT INTO vehicles(userid,name,serial,date) VALUES('$userid','$vehicle','$serial',NOW());";
    $res = mysql_query($query);
        
    if ($res) {
        $errTyp = "success";
        $errMSG = "Successfully registered, vehicle Ok";
        unset($vehicle);
        unset($serial);
        unset($paircode);
    } else {
        $errTyp = "danger";
        $errMSG = "Something went wrong, try again later..."; 
    } 
        
   } 
   else{
        $errTyp = "danger";
        $errMSG = "Invalid pair code, please try again...";  
   }

    /*
    */
  }
  
 }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CarSec - Suscript Car</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<?php include ("header.php");?>

<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h2 class="">Subscribe your device.</h2>
            </div>
        
         <div class="form-group">
             <hr />
            </div>
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="text" name="vehicle" class="form-control" placeholder="Vehicle" maxlength="40" value="<?php echo $vehicle ?>" />
                </div>
                <span class="text-danger"><?php echo $vehicleError; ?></span>
            </div>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="text" name="serial" class="form-control" placeholder="Device serial number" maxlength="40" value="<?php echo $serial ?>" />
                </div>
                <span class="text-danger"><?php echo $serialError; ?></span>
            </div>            
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="text" name="paircode" class="form-control" placeholder="Latch pair code" maxlength="40" value="<?php echo $paircode ?>" />
                </div>
                <span class="text-danger"><?php echo $paircodeError; ?></span>
            </div>

            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Enroll</button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
        
        </div>
   
    </form>
    </div> 

</div>

    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>
</html>
<?php ob_end_flush(); ?>
