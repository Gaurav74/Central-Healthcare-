<?php
echo "inside";
$admin="localhost";
$user="myuser";
$pass="Pass@123";
$dbName="healthcare";

echo "1";

$con=mysqli_connect($admin, $user, $pass, $dbName, 3306);
if (!$con) {
    echo "<script>alert('Connection not set.');</script>";
    die("Connection Not Set OR Insecure.");
} else {
    echo "connection set";
}
$id="fun";
$name="trying";


$sql="insert into healthcare.debug values(?,?)";
if($stmt = mysqli_prepare($con,$sql)){
echo " prepared";}
else {
  echo " not praepared";
}

  echo " top1";
  $id=3;
  $name="kumar";
$boolv = mysqli_stmt_bind_param($stmt, "is", $id, $name);
    //$boolv=$stmt->bind_param('is',1,"gaurav");
    echo " binded  $boolv";

    if (!mysqli_execute($stmt)) {
        echo "didnt execute";
        //    die(mysqli_stmt_error($stmt));
    }
echo " execute";
    $check = mysqli_stmt_affected_rows($stmt);
    if ($check) {
        echo "<script>alert('DATA ENTERED');</script>";
    } else {
        echo '<script type="text/javascript">alert("SORRY...SERVER IS DOWN");</script>';
        mysqli_stmt_close($stmt);
    }



    -----------------------------
    
