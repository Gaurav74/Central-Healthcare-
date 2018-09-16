<?php
session_start();
if (!isset($_SESSION["flag"]) && !($_SESSION["position"]=="DISTRICT_SURGERY")) {
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
    }else
  	if($data=="DISTRICT_DATA"){
  		header("location:http://localhost/HOSPITAL/done/district_data.php");
  		exit();
  	}else
  	if($data=="HEAD_DATA"){
  		header("location:http://localhost/HOSPITAL/done/headquarter_data.php");
  		exit();
  	}
}
// check already login
if (isset($_SESSION["flag"])&& $_SESSION["position"]!="DISTRICT_SURGERY") {
    page($_SESSION["position"]);
}
?>
<html>
<head>
<meta charset="utf-8"/>
<title>DISTRICT SURGERY</title>
<link rel="stylesheet" href="dist_surgery.css"/>
</head>
<body>
<div class="bc1"></div>
<header>
<h1>DISTRICT SURGERY</h1>
</header>
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
$aadharerror=$doctoriderror=$primaryiderror=$headverifyerror=$remarkerror=$opiderror=$refererror=$verifyerror=$operationerror="";$run=0;
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

function operation($data)
{
    $temp="";
    if ($data==null || $data=="select") {
        return $temp;
    } else {
        if ($data=="hand") {
            $temp="HAND SURGERY";
        } elseif ($data=="heart") {
            $temp="CARDIAC";
        } elseif ($data=="endocrine") {
            $temp="ENDOCRINE SURGERY";
        } elseif ($data=="neuro") {
            $temp="NEUROSURGERY";
        }
    }
    return strtoupper($temp);
}
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    try {
        if (isset($_POST["ok"])) {
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

            //remark of operation
            $remark="";
            $remark=test_input($_POST["remark"]);
            //patient verification
            $patientverify=referverify(test_input($_POST["verifybool"]));
            if ($patientverify=="") {
                $verifyerror="Please select value";
                $run=1;
            }

            //operation id
            $operationid=operation($_POST["operatefor"]);
            if ($operationid=="") {
                $opiderror="Select O.P ID";
                $run=1;
            }
            //doctor id
            $doctorid=$_SESSION["id"];

            //forward to hq
            $headverify=referverify(test_input($_POST["head"]));
            if ($headverify=="") {
                $headverifyerror="Please select value";
                $run=1;
            }

            //end
            if ($run==0) {
                $con=mysqli_connect($admin, $user, $pass, $dbName, 3306);
                if (!$con) {
                    echo "<script>alert('Connection not set.');</script>";
                }
                $sql="insert into district_surgery(aadhar_id, operation_remark, operation_verify, operation_id, forward_to_headquarter, doctor_id)"."values(?,?,?,?,?,?)";
                if ($stmt=mysqli_prepare($con, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ississ", $aadhar, $remark, $patientverify, $operationid, $headverify, $doctorid);
                    if (!mysqli_execute($stmt)) {
                        die(mysqli_stmt_error($stmt));
                    }
                    $check=0;
                    $check = mysqli_stmt_affected_rows($stmt);
                    if ($check) {
                        echo "<script>alert('DATA ENTERED');</script>";
                    } else {
                        echo '<script type="text/javascript">alert("SORRY...SERVER IS DOWN");</script>';
                    }
                }
            } else {
                echo '<script type="text/javascript">alert("PLEASE ENTER THE DATA");</script>';
            }//end if
        } elseif (isset($_POST["signout"])) {
            echo '<script type="text/javascript">alert("LOGGED OUT SUCCESSFULLY")</script>';
            session_unset();
            session_destroy();
            header("location:http://localhost/HOSPITAL/done/login.php");
            exit();
        }
    } catch (Exception $e) {
        try {
            echo '<script type="text/javascript">alert("DATA EXISTS OR TECHNICAL ERROR..")</script>';
            $error=$e->getMessage();
            $page="district_surgery";
            $sqlerror="insert into debug(error,page) values(?,?)";
            $stmterror = mysqli_prepare($con, $sqlerror);
            mysqli_stmt_bind_param($stmterror, "ss", $error, $page);
            mysqli_stmt_execute($stmterror);
            //echo '<script type="text/javascript">location.reload();</script>';
            $run=0;
        } catch (Exception $e) {
            echo '<script type="text/javascript">alert("TECHNICAL ERROR..")</script>';
        }
    }
}



?>
<form action="" method="post" enctype="multipart/form-data">
	<div id="b1">
		<b>Aadhar No.</b>
			<input type="text" name="aadhar" size="12" placeholder="" maxlength="12"><span>*</span><br>
			<?php echo "$aadharerror"; ?>
	</div>
	<div id="b2">
		<b>Operation Remark</b>
			<input type="text" name="remark" size="10" placeholder="50 character most" maxlength="50"><span>*</span>
	</div>
	<div id="b5">
		<b>Patient Verified</b>
	<div id="gen">
		<b>Yes</b>
			<input type="radio" name="verifybool" value="yes">
		<b>No</b>
			<input type="radio" name="verifybool" value="no"><span>*</span>
			</div><br>
			<?php echo "$verifyerror"; ?>
	</div>
	<div id="b8">
		<b>Operation ID</b>
			<div>
				<select name="operatefor">
				<option value="select" selected="">SELECT SURGERY</option>
					<option value="heart">CARDIAC</option>
					<option value="endocrine">ENDOCRINE SURGERY</option>
					<option value="hand">HAND SURGERY</option>
					<option value="neuro">NEUROSURGERY</option>
				</select><span>*</span><br>
				<?php echo "$opiderror"; ?>
			</div>

	</div>

	<div id="b4">
		<b>Forward to HQ</b>
			<div id="hq">
		<b>Yes</b>
			<input type="radio" name="head" value="yes">
		<b>No</b>
			<input type="radio" name="head" value="no"><span>*</span>
			</div><br>
			<?php echo "$headverifyerror";  ?>
	</div>
	<div id="ok">
		<input type="submit" name="ok" value="SUBMIT" style="font-size: 20px;margin-left:0%;">
		<input type="submit" name="signout" value="SIGNOUT" style="font-size: 20px;margin-left:40%;">
	</div><br>
	</div></form>
		<p><b><em>* fields are mandatroy</em></b></p>
</body>
<br><br><br><br>
</html>
