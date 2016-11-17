<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }
 // select loggedin users detail
 $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['userEmail']; ?></title>

<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />

<link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.css">
<script src="assets/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
$('#example').dataTable( {
 "aProcessing": true,
 "aServerSide": true,
"ajax": "server-response.php",
} );
} );

</script>


</head>
<body>


<?php include ("header.php");?>

 <div id="wrapper">

 <div class="container">
    
     <div class="page-header">
     <h3>Registered vehicles</h3>

     </div>
        
        <div class="row">
        <div class="col-lg-12">

          <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                <th>name</th>
                <th>serial</th>
                <th>date</th>
              </tr>
            </thead>
          </table>  

        </div>
        </div>
    
    </div>
    
    </div>
    
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>