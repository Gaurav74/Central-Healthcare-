<?php

$admin="127.0.0.1";
$user="myuser";
$pass="Pass@123";
$dbName= "healthcare";
        $con=mysqli_connect($admin, $user, $pass, $dbName, 3306);
if (!$con) {
    echo "<script>alert('Connection not set.');</script>";
    exit();
}

 ?>

<?php
session_start();
mysqli_report(MYSQLI_REPORT_ALL);
function page($data)
{
    if ($data=="PRIMARY") {
        header("location:http://localhost/HOSPITAL/done/primary_record.php");
        exit();
    } elseif ($data=="DISTRICT") {
        header("location:http://localhost/HOSPITAL/done/district_record.php");
        exit();
    } elseif ($data=="HEADQUARTER") {
        header("location:http://localhost/HOSPITAL/done/headquarter_record.php");
        exit();
    } elseif ($data=="DISTRICT_SURGERY") {
        header("location:http://localhost/HOSPITAL/done/district_surgery.php");
        exit();
    } elseif ($data=="HEAD_SURGERY") {
        header("location:http://localhost/HOSPITAL/done/headquarter_surgery.php");
        exit();
    } elseif ($data=="DISTRICT_DATA") {
        header("location:http://localhost/HOSPITAL/done/district_data.php");
        exit();
    } elseif ($data=="HEAD_DATA") {
        header("location:http://localhost/HOSPITAL/done/headquarter_data.php");
        exit();
    }
}
// check already login
if (isset($_SESSION["flag"])) {
    page($_SESSION["position"]);
}
?>

<html>

<head>
<meta charset='utf-8'>
<title>LOGIN</title>
<link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
<header>
<h1>LOGIN</h1>
</header>
<?php
function test_input($data)
{
    $data=trim($data);
    $data=stripcslashes($data);
    $data=htmlspecialchars($data);

    return $data;
}
//to change pages


function department($data)
{
    $temp="";
    if ($data==null || $data=="select") {
        return $temp;
    } else {
        if ($data=="primary") {
            $temp="PRIMARY";
        } elseif ($data=="district") {
            $temp="DISTRICT";
        } elseif ($data=="head") {
            $temp="HEADQUARTER";
        } elseif ($data=="dsurgery") {
            $temp="DISTRICT_SURGERY";
        } elseif ($data=="hsurgery") {
            $temp="HEAD_SURGERY";
        } elseif ($data=="ddata") {
            $temp="DISTRICT_DATA";
        } elseif ($data=="hdata") {
            $temp="HEAD_DATA";
        }
    }
    return strtoupper($temp);
}

$error=$iderror=$passerror=$poserror="";
$run=0;
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    try {
        if (empty(test_input($_POST["user"]))) {
            $iderror="Enter ID";
            $run=1;
        } else {
            $id=test_input($_POST["user"]);
            if (!is_numeric($id) || !(strlen($id)==12)) {
                $iderror="ID is wrong";
                $run=1;
                echo "id";
            }
        }
        //pass
        $pass=test_input($_POST["pass"]);
        if (empty($pass)) {
            $passerror="Enter Password";
            $run=1;
            echo "pass";
        }
        $pass_code=sha1($pass);
        // department
        $position=department($_POST["position"]);
        if ($position=="") {
            $poserror="Please Select the Position";
            $run=1;
            echo "pos";
        }
        //query
        if ($run==0) {
            $sql="select d_name from doctor_registration_detail where aadhar_id=".$id." and security_code="."'".$pass_code."'". "and position="."'".$position."'";
            $result=mysqli_query($con, $sql);
            if (mysqli_num_rows($result)==1) {
                $row= mysqli_fetch_assoc($result);
                $_SESSION["id"]=$id;
                $_SESSION['name']=$row["d_name"];
                $_SESSION["position"]=$position;
                $_SESSION["flag"]=1;
                page($_SESSION["position"]);
                exit();
            } else {
                echo '<script type="text/javascript">alert("SORRY...NO SUCH USER");</script>';
                $header = header("location:http://localhost/HOSPITAL/done/login.php");
                //exit();
            }
        } else {
            echo '<script type="text/javascript">alert("WRONG DATA ENTERED");</script>';
        }
    } catch (Exception $e) {
        try {
            $error=$e->getMessage();
            $page="login_page";
            $sqlerror="insert into debug(error,page) values(?,?)";
            $stmterror = mysqli_prepare($con, $sqlerror);
            mysqli_stmt_bind_param($stmterror, "ss", $error, $page);
            mysqli_stmt_execute($stmterror);
            $run=0;
        } catch (Exception $e) {
        }
    }
}

?>

<form action="" method="post" enctype="multipart/form-data">
<div id="b1">
		<b>Username</b>
			<input type="text" name="user" size="12" placeholder="" maxlength="12"><span>*</span></br>
			<?php echo "$iderror";  ?>
	</div>

	<div id="b2">
		<b>Password</b>
			<input type="password" name="pass" size="10" placeholder=""><span>*</span></br>
			<?php echo "$passerror";  ?>
	</div>



<br><br>
<div id="b8">
		<b>Select</b>
			<div>
				<select name="position">
				<option value="select" selected="">Select Department</option>
					<option value="primary">PRIMARY</option>
					<option value="district">DISTRICT</option>
					<option value="head">HEADQUARTER</option>
					<option value="dsurgery">DISTRICT SURGERY</option>
					<option value="hsurgery">HEAD SURGERY</option>
          <option value="ddata">DISTRICT DATA</option>
					<option value="hdata">HEAD DATA</option>
				</select><span>*</span>
	</div>
	<br><?php echo "$error"; ?><br>
</form>
	<div id="b10">
			<input type="submit" value="SUBMIT" name="ok"></div>
</body>
</html>
