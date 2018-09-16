<?php
session_start();
if (!isset($_SESSION["flag"]) && !($_SESSION["position"]=="PRIMARY")) {
    header("location:http://localhost/HOSPITAL/done/login.php");
    exit();
}
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
    }
}
// check already login
if (isset($_SESSION["flag"]) && $_SESSION["position"]!="PRIMARY") {
    page($_SESSION["position"]);
}
?>
<html>
<head>
<meta charset="utf-8"/>
<title>PRIMARY CENTERS</title>
<link rel="stylesheet" href="pri.css"/>
</head>
<body>
<?php
mysqli_report(MYSQLI_REPORT_ALL);
//error_reporting(0);

function test_input($data)
{
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}

$admin="localhost";
$user="myuser";
$pass="Pass@123";
$dbName= "healthcare";
//initialize errors
$aadharerror=$doctoriderror=$primaryiderror=$diseaseerror=$remarkerror=$referror=$refererror="";$run=0;
//ref yes or no function
function referverify($data)
{
    $ref="";
    if (empty($data)) {
        $ref="";
    }
    if ($data=="yes") {
        $ref="yes";
    } elseif ($data=="no") {
        $ref="no";
    }
    return strtoupper($ref);
}
//to where refer function
function refertoverify($data)
{
    $temp="";
    if (empty($data)) {
        $temp="null";
    } else {
        if ($data=="distcare") {
            $temp="distcare";
        } elseif ($data=="headcare") {
            $temp="headcare";
        }
    }
    return $data;
}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    try {
        if (isset($_POST["ok"])) {

    //aadhar input
            if (empty($_POST["aadhar"])) {
                $aadharerror="Invalid Aadhar Number";
                $run=1;
            } else {
                $aadhar=test_input($_POST["aadhar"]);
                if (!is_numeric($aadhar)) {
                    $aadharerror="Invalid Aadhar Number";
                    $run=1;
                }
            }

            //doctor id

            $doctorid=$_SESSION["id"];
            //primar cre center id
            /*if(empty($_POST["primaryid"])){
                    $primaryiderror="Invalid  Primary ID";$run=1;
                }
                else{
                    $primaryid=test_input($_POST["primaryid"]);
                }*/
            //Disease
            if (empty($_POST["disease"])) {
                $diseaseerror="Disease Name is required";
                $run=1;
            } else {
                $disease= test_input($_POST["disease"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $disease)) {
                    $diseaseerror = "Only letters and white space allowed";
                    $run=1;
                }
                $disease=strtoupper($disease);
            }
            //remark
            $remark="";
            $remark=test_input($_POST["remark"]);
            //refer
            $ref=referverify($_POST["ref"]);
            if ($ref=="") {
                $referror="Please choose a value";
                $run=1;
            } else {
                $ref=strtoupper($ref);
            }
            //refer to which hospital
            $refer=refertoverify($_POST["refer"]);


            // enter the data to database
            if ($run==0) {
                $con=mysqli_connect($admin, $user, $pass, $dbName, 3306);
                if (!$con) {
                    echo "<script>alert('Connection not set.');</script>";
                }
                $sql="insert into primary_data(aadhar_id, disease_name, remark, reffer, reffer_to, doctor_id) values(?,?,?,?,?,?)";
                if ($stmt = mysqli_prepare($con, $sql)) {
                    mysqli_stmt_bind_param($stmt, "isssss", $aadhar, $disease, $remark, $ref, $refer, $doctorid);
                    if (!mysqli_stmt_execute($stmt)) {
                        echo "not execute";
                        die(mysqli_stmt_error($stmt));
                    }
                    echo "execute";
                    $check=0;
                    $check = mysqli_stmt_affected_rows($stmt);
                    if ($check) {
                        echo "<script>alert('DATA ENTERED');</script>";
                    } else {
                        echo '<script type="text/javascript">alert("SORRY...SERVER IS DOWN");</script>';
                    }
                }
            } else {
                echo '<script type="text/javascript">alert("CHECK YOUR DATA");</script>';
            }
        } elseif (isset($_POST["signout"])) {
            echo '<script type="text/javascript">alert("LOGGED OUT SUCCESSFULLY")</script>';
            session_unset();
            session_destroy();
            header("location:http://localhost/HOSPITAL/done/login.php");
            exit();
        }
    } catch (Exception $e) {
        try {
            echo '<script alert("TECHNICAL ERROR..."")</script>';
            $error=$e->getMessage();
            $page="primary record";
            $sqlerror="insert into debug(error,page) values(?,?)";
            $stmterror = mysqli_prepare($con, $sqlerror);
            mysqli_stmt_bind_param($stmterror, "ss", $error, $page);
            mysqli_stmt_execute($stmterror);

            $run=0;
        } catch (Exception $e) {
            echo '<script alert("TECHNICAL ERROR..."")</script>';
        }
    }
}


?>
<div class="bc1"></div>
<header>
<h1>PRIMARY CENTERS</h1>
</header>
<form action="" method="post" enctype="multipart/form-data">
	<div id="b1">
		<b>Aadhar No.</b>
			<input type="text"  size="12" name="aadhar" placeholder="" maxlength="12"><span>*</span>
			<br><?php echo $aadharerror; ?>
</div>
<!--
	<div id="b8">
		<b>Primary Centers ID.</b>
			<input type="text"  size="10" name="primaryid" placeholder=""><span>*</span>
	<br>
	<?php// echo $primaryiderror; ?>
	</div>
-->
	<div id="b2">
		<b>Disease Name</b>
			<input type="text"  size="10" name="disease" placeholder=""><span>*</span>
	<br>  <?php echo $diseaseerror; ?>
	</div>
	<div id="b3">
		<b>Remark</b>
			<input type="text"  size="10" name="remark" placeholder=""><span>*</span>
	<br> <?php echo $remarkerror; ?>
	</div>
		<div id="b5">
		<b>Refer</b>
	<div class="gen">
		<b>Yes</b>
			<input type="radio" name="ref" value="yes">
		<b>No</b>
			<input type="radio" name="ref" value="no"><span>*</span>
			<br>
			</div>  <?php echo $referror; ?></div>
	<div id="b6">
		<b>Refer to</b>
			<select name="refer">
			<option value="null" selected="">SELECT CARE-CENTER</option>
				<option value="distcare">DISTRICT CARE-CENTER</option>
				<option value="headcare">HEAD CARE-CENTER</option>
			</select><span>*</span>
	<br> <?php echo $refererror; ?>
	</div>

	<br><br>
	<div id="ok">
	<input type="submit" value="Submit" name="ok" style="font-size: 20px;margin-left:50%;">
	<input type="submit" name="signout" value="LOG OUT" style="font-size: 20px;margin-left:75%;">
		 </div>
		 </form>

		 <footer>
		 	<br>
<p><b><em>* fields are mandatroy</em></b></p>
		 </footer>
</body>
</html>
