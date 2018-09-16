<?php
session_start();
if (!isset($_SESSION["flag"]) && !($_SESSION["position"]=="HEADQUARTER")) {
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
if (isset($_SESSION["flag"]) && $_SESSION["position"]!="HEADQUARTER") {
    page($_SESSION["position"]);
}
?>
<html>
<head>
<meta charset="utf-8"/>
<title>HEADQUARTER RECORD</title>
<link rel="stylesheet" href="dis.css"/>
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
$aadharerror=$doctoriderror=$primaryiderror=$diseaseerror=$remarkerror=$referror=
$refererror=$operateerror=$operationforerror="";$run=0;
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
//to number of operation function
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
  /*          if (empty($_POST["primaryid"])) {
                $primaryiderror="Invalid  Primary ID";
                $run=1;
            } else {
                $primaryid=test_input($_POST["primaryid"]);
            }
*/
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

          /*  //operation remark
            $operationremark="";
            $operationremark=test_input($_POST["opremark"]);
*/

            //operate or not
            $operate=referverify($_POST["operate"]);
            if ($operate=="") {
                $operateerror="Please choose a value";
                $run=1;
            } else {
                $operate=strtoupper($operate);
            }
            //enter the no of data uploaded
            if (empty($_POST["datarecord"]) && $_POST["datarecord"] !=0 ) {
                $dataerror="Invalid data Number";
                $run=1;
            } else {
                $datanum=test_input($_POST["datarecord"]);
                if (!is_numeric($datanum)) {
                    $dataerror="Invalid data Number";
                    $run=1;
                }
            }

            //what type of surgery
            $operationfor=operation($_POST["operatefor"]);
if($operate=='YES'){
            if ($operationfor=="") {
                $operationforerror="Select an Option";
                $run=1;
            } }

            // enter the data to database
            if ($run==0) {
                $con=mysqli_connect($admin, $user, $pass, $dbName, 3306);
                if (!$con) {
                    echo "<script>alert('Connection not set.');</script>";
                }
                $sql="insert into headquarter_detail(aadhar_id, disease_name, remark, doctor_id, number_of_recorded_data, operation_detail, operation_id) values(?,?,?,?,?,?,?)";
                if ($stmt=mysqli_prepare($con, $sql)) {
                    mysqli_stmt_bind_param($stmt, "issiiss", $aadhar, $disease, $remark, $doctorid, $datanum, $operate, $operationfor);
                    if (!mysqli_execute($stmt)) {
                        die(mysqli_stmt_error($stmt));
                    }
                    $check=0;
                    $check = mysqli_stmt_affected_rows($stmt);
                    if ($check) {
                        echo "<script>alert('DATA ENTERED');</script>";
                    } else {
                        echo '<script type="text/javascript">alert("PLESE ENTER THE DATA");</script>';
                    }
                }
            } else {
                echo '<script type="text/javascript">alert("PLEASE ENTER THE DATA ");</script>';
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
            $error=$e->getMessage();
            $page="headquarter_record";
            $sqlerror="insert into debug(error,page) values(?,?)";
            $stmterror = mysqli_prepare($con, $sqlerror);
            mysqli_stmt_bind_param($stmterror, "ss", $error, $page);
            mysqli_stmt_execute($stmterror);
            //echo '<script type="text/javascript">location.reload();</script>';
            $run=0;
        } catch (Exception $e) {
        }
    }
}
?>
<div class="bc1"></div>
<header>
<form action="" method="post" enctype="multipart/form-data">
<h1>HEADQUARTER RECORD</h1>
</header>
	<div id="b1">
		<b>Aadhar No.</b>
			<input type="text" name="aadhar" size="12" placeholder="" maxlength="12"><span>*</span>
   <?php echo $aadharerror; ?><br>
	</div>

	<div id="b2">
		<b>Disease Name</b>
			<input type="text" name="disease" size="10" placeholder=""><span>*</span>
  <?php echo $diseaseerror; ?><br>
	</div>
<!--	<div id="b10">
		<b>Primary Centers ID.</b>
			<input type="text" name="primaryid" size="10" placeholder=""><span>*</span>
  <?php// echo $primaryiderror; ?><br>
</div> -->
	<div id="b3">
		<b>Remark</b>
			<input type="text" name="remark" size="10" placeholder=""><span>*</span>
      <?php echo $remarkerror; ?><br>
	</div>
<!--	<div id="b10">
		<b>Operation Remark</b>
			<input type="text" name="opremark" size="10" placeholder=""><span>*</span>
<?php// echo $refererror; ?><br>
	</div>
-->
	<div id="b6">
		<b>No. of data recorded</b>
			<input type="text" name="datarecord" size="10" placeholder=""><span>*</span>
<?php echo $dataerror; ?><br>
	</div>
	<div id="b7">
		<b>SURGERY</b>
			<div >
		<b>YES</b>
			<input type="radio" name="operate" value="yes">
			<b>NO</b>
			<input type="radio" name="operate" value="no"><span>*</span>
			<?php echo $operateerror; ?>
		</div>
<br>
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
				</select><span>*</span>
<?php echo $operationforerror; ?>
			</div>
</div>


	<br>
	<div id="ok">
	<input type="submit" name="ok" value="SUBMIT"  style="font-size: 20px;margin-left: 20%;" >
	<input type="submit" name="signout" value="SIGNOUT"  style="font-size: 20px;margin-left: 55%;">

	</div>
	</form>
		 <p><b><em>* fields are mandatroy</em></b></p>
</body>
</html>
