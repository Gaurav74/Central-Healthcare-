<html>
<head>
<meta charset="utf-8"/>
<title>PATIENT ENTRY</title>
<link rel="stylesheet" href="pat.css"/>

</head>
<body>
<?php

mysqli_report(MYSQLI_REPORT_ALL);
//error_reporting(0);
$admin="localhost";
$user="myuser";
$pass="Pass@123";
$dbName= "healthcare";

function test_input($data)
{
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}


function genderverify($data)
{
    $gen="";
    if (empty($data)) {
        $gen="";
    }
    if ($data=="Male") {
        $gen="MALE";
    } elseif ($data=="Female") {
        $gen="FEMALE";
    } elseif ($data=="Others") {
        $gen="OTHERS";
    } else {
        $gen="";
    }
    return $gen;
}

$Aadharerror=$nameerror=$panerror=$phoneerror=$fathernameerror=$dateerror=$emailerror=$houseerror=$townerror="";
$addresserror=$districterror=$stateerror=$pincodeerror=$medicalerror=$passworderror=$imgerror=$gendererror="";
$run=0;

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST["dataButton"])) {
        try {

            //aadhar input
            if (empty($_POST["Aadhar"])) {
                $Aadharerror="Invalid Aadhar Number";
                $run=1;
            } else {
                $Aadhar=test_input($_POST["Aadhar"]);
                if (!is_numeric($Aadhar)) {
                    $Aadharerror="Invalid Aadhar Number";
                    $run=1;
                }
            }


            //name input
            if (empty($_POST["name"])) {
                $nameerror="Name is required";
                $run=1;
            } else {
                $name = test_input($_POST["name"]);
                $name=strtoupper($name);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                    $nameerror = "Only letters and white space allowed";
                    $run=1;
                }
            }


            //gender input
            $gender="";
            $gender=genderverify($_POST["gender"]);
            if ($gender==null) {
                $run=1;
                $gendererror="CHOOSE A VALUE";
            }

            //email input
            if (empty($_POST["email"])) {
                $emailerror="Invalid Email";
                $run=1;
            } else {
                $email=test_input($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailerror="Invalid Email";
                    $run=1;
                }
            }
            //password input...password sha1 encryption
            if (empty($_POST["password"])) {
                $passworderror="Password is required";
                $run=1;
            } else {
                $password=$_POST["password"];
                // check if name only contains letters and whitespace
                if (preg_match("/^[ ]*$/", $name)) {
                    $passworderror= "No white space allowed";
                    $run=1;
                } else {
                    $enc_password=sha1($password);
                }
            }

            //phone input
            if (empty($_POST["phone"])) {
                $phoneerror="Invalid Phone Number";
                $run=1;
            } else {
                $phone=test_input($_POST["phone"]);
                if (strlen($phone)==10) {
                    if (!preg_match("/^[0-9]*$/", $phone)) {
                        $phoneerror="Invalid Phone Number";
                        $run=1;
                    }
                }
            }

            //date entry
            if (empty($_POST["date"])) {
                $dateerror="Enter the Date";
            } else {
                $date = strtotime($_POST['date']);
                if ($date!= false) {
                    $date = date('Y-m-d', $date);
                    if (strtotime($date)> strtotime('now')) {
                        $dateerror="INVALID DATE";
                        $run=1;
                    }
                } else {
                    $dateerror="Invalid date";
                    $run=1;
                }
            }

            //house entry

            if (empty($_POST["house"])) {
                $houseerror="HouseName is required";
                $run=1;
            } else {
                $house= test_input($_POST["house"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z0-9 ]*$/", $house)) {
                    $houseerror= "Only letters,Numeric and white space allowed";
                    $run=1;
                } else {
                    $house=strtoupper($house);
                }
            }


            //town entry
            if (empty($_POST["town"])) {
                $townerror="Town is required";
                $run=1;
            } else {
                $town=test_input($_POST["town"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $town)) {
                    $townerror = "Only letters and white space allowed";
                    $run=1;
                }
                $town=strtoupper($town);
            }

            //address entry
            if (empty($_POST["address"])) {
                $addresserror="Address is required";
            } else {
                $address=test_input($_POST["address"]);
                if (!preg_match("/^[a-zA-Z ]*$/", $address)) {
                    $addresserror="Numeric value not accepted";
                    $run=1;
                } else {
                    $address=strtoupper($address);
                }
            }

            //district
            if (empty($_POST["district"])) {
                $districterror="District name required";
            } else {
                $district=test_input($_POST["district"]);
                if (!preg_match("/^[a-zA-Z ]*$/", $district)) {
                    $districterror="Numeric value not accepted";
                    $run=1;
                } else {
                    $district=strtoupper($district);
                }
            }

            //state entry
            $state="";
            $state=test_input($_POST["state"]);
            if ($state=="CHOOSE A STATE" || $state=="") {
                $stateerror="CHOOSE A VALUE";
            }

            //pincode entry
            if (empty($_POST["pincode"])) {
                $pincodeerror="Invalid pincode Number";
                $run=1;
            } else {
                $pincode=test_input($_POST["pincode"]);
                if (strlen($pincode)==6) {
                    if (!preg_match("/^[0-9]*$/", $pincode)) {
                        $pincodeerror="Invalid Pincode Number";
                        $run=1;
                    }
                } else {
                    $pincodeerror="Invalid Pincode";
                }
            }

            //father entry
            if (empty($_POST["fathername"])) {
                $fathernameerror="Name is required";
                $run=1;
            } else {
                $fathername=test_input($_POST["fathername"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $fathername)) {
                    $fathernameerror = "Only letters and white space allowed";
                    $run=1;
                }
                $fathername=strtoupper($fathername);
            }
            //image
            $file_type=$_FILES['image']['type'];
            $allowed=array("image/jpeg","image/jpg","image/png");
            $pic=$_FILES['image']['tmp_name'];

            if ($pic!=null) {
                if (!in_array($file_type, $allowed)) {
                    $imgerror="Only jpg, gif, and jpeg files are allowed.";
                    $run=1;
                } else {
                    $img=addslashes(file_get_contents($pic));
                }
            }
            //ends
            else {
                $imgerror="Upload pic";
            }

            //  echo "entering";
            if ($run == 0) {
                //  echo " entered";
                $con = mysqli_connect($admin, $user, $pass, $dbName, 3306);
                if (!$con) {
                    echo "<script>alert('Connection not set.');</script>";
                    die("Connection Not Set OR Insecure.");
                }

                //  echo "after connect ";
                $sql="insert into healthcare.patient_detail_entry(aadhar_id, p_name, phone_no, father_name, gender, date_of_birth, security_code, email_id, house_no, address1, address2, district, state, pincode, patient_pic) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                //echo "before prepare ";

                if ($stmt = mysqli_prepare($con, $sql)) {
                    //  echo "top1";
                    mysqli_stmt_bind_param(
                        $stmt,
                        "isissssssssssis",
                    $Aadhar,
                        $name,
                        $phone,
                        $fathername,
                        $gender,
                        $date,
                        $enc_password,
                        $email,
                     $house,
                        $town,
                        $address,
                    $district,
                        $state,
                        $pincode,
                        $img
                    );

                    //  echo "prepared";
                    if (!mysqli_execute($stmt)) {
                        //    echo " not execute";
                        die(mysqli_stmt_error($stmt));
                    }
                    //  echo "executed";
                    $check=0;
                    $check = mysqli_stmt_affected_rows($stmt);
                    if ($check) {
                        echo "<script>alert('DATA ENTERED');</script>";
                    } else {
                        echo '<script type="text/javascript">alert("SORRY...SERVER IS DOWN");</script>';
                    }
                } else {
                    //  echo "failed";
                    echo "<script>alert('QUERY PREPARE FAILED');</script>";
                }
            } else {
                echo '<script type="text/javascript">alert("SORRY....CHECK INPUT");</script>';
            }
        }  //try
        catch (Exception $e) {
            try {
                echo '<script type="text/javascript">alert("TECHNICAL ERROR OR DATA EXISTS..");</script>';
                $error=$e->getMessage();
                $page="patient_detail_entry";
                $sqlerror="insert into debug(error,page) values(?,?)";
                $stmterror = mysqli_prepare($con, $sqlerror);
                mysqli_stmt_bind_param($stmterror, "ss", $error, $page);
                mysqli_stmt_execute($stmterror);
                //echo '<script type="text/javascript">location.reload();</script>';
                $run=0;
            } catch (Exception $e) {
                echo '<script type="text/javascript">alert("TECHNICAL ERROR..");</script>';
            }
        }
    }
}

?>
<div class="bc1"></div>
<header>
<h1>PATIENT ENTRY</h1>
</header>
<form method="post" action="" enctype="multipart/form-data">
<br style="clear:both">
<aside>

	<div id="b1">
		<b>Aadhar No.</b>
			<input type="text"  size="12" placeholder="" name="Aadhar" maxlength="12"><span>* </span><br>
			<?php echo "$Aadharerror";?>
	</div>
	<div id="b2">
		<b>Patient Name</b>
			<input type="text"  size="12" placeholder="" name="name"><span>*</span><br>
			<?php echo "$nameerror"; ?>
	</div>
	<br>
	<div id="b4">
		<b>Phone No.</b>
			<input type="text"  size="12" placeholder="" name="phone" maxlength="10"><span>*</span><br>
	<?php echo "$phoneerror"; ?>
	</div>
	<div id="b5">
		<b>Father Name</b>
			<input type="text"  size="10" placeholder="" name="fathername"><span>*</span><br>
	<?php echo "$fathernameerror"; ?>
	</div>
	<div id="b6">
		<b>Gender</b>
		<div class="gen"> <b>Male</b>
			<input type="radio" name="gender" value="Male">
		<b>Female</b>
			<input type="radio" name="gender" value="Female">
     <b>Others</b>
     <input type="radio" name="gender" value="Others">
	</div><span><?php echo $gendererror;?></span>
	</div>
	<div id="b7">
		<b>Date of Birth</b>
			<input type="date"  size="10"  name="date"><span>*</span><br>
	<?php echo "$dateerror"; ?>
	</div>
	<div id="b15">
		<b>Password</b>
			<input type="password" size="10" placeholder="" name="password"><span>*</span><br>
	<?php echo "$passworderror"; ?>
	</div>
	<div id="b16">
		<b>Email-id</b>
			<input type="email" size="10" placeholder="abc@xyz.com" name="email"><span>*</span><br>
			<?php echo "$emailerror";?>
	</div>
	</aside>
	<div id="vertical"></div>
	<div id="right">
	<div id="b8">
		<b>House no.</b>
			<input type="text"  size="10" placeholder="" name="house"><span>*</span><br>
	<?php echo "$houseerror"; ?>
	</div>
	<div id="b9">
		<b>Town/Vill</b>
			<input type="text"  size="10" placeholder="" name="town"><span>*</span><br>
	<?php echo "$townerror"; ?>
	</div>
	<div id="b10">
		<b>Address 1</b>
			<input type="text"  size="10" placeholder="" name="address"><span>*</span><br>
	<?php echo "$addresserror"; ?>
	</div>
	<div id="b11">
		<b>District</b>
			<input type="text"  size="10" placeholder="" name="district"><span>*</span><br>
	<?php echo "$districterror"; ?><br>
	</div>
	<div id="b12">
		<b>State</b>
			<select name="state">
			<OPTION value="" SELECTED>CHOOSE A STATE</OPTION>
				<option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
				<OPTION VALUE="ARUNACHAL PRADESH">ARUNACHAL PRADESH</OPTION>
				<OPTION VALUE="ASSAM">ASSAM</OPTION>
				<OPTION VALUE="BIHAR">BIHAR</OPTION>
				<OPTION VALUE="CHATTISGARH">CHATTISGARH</OPTION>
				<OPTION VALUE="DELHI">DELHI</OPTION>
				<OPTION VALUE="GOA">GOA</OPTION>
				<OPTION VALUE="GUJARAT">GUJARAT</OPTION>
				<OPTION VALUE="HARYANA">HARYANA</OPTION>
				<OPTION VALUE="HIMACHAL PRADESH">HIMACHAL PRADESH</OPTION>
				<OPTION VALUE="JAMMU&KASHMIR">JAMMU-KASHMIR</OPTION>
				<OPTION VALUE="JHARKHAND">JHARKHAND</OPTION>
				<OPTION VALUE="KARNATAKA">KARNATAKA</OPTION>
				<OPTION VALUE="KERELA">KERELA</OPTION>
				<OPTION VALUE="MADHYA PRADESH">MADHYA PRADESH</OPTION>
				<OPTION VALUE="MAHARASHTRA">MAHARASHTRA</OPTION>
				<OPTION VALUE="MANIPUR">MANIPUR</OPTION>
				<OPTION VALUE="MEGHALAYA">MEGHALAYA</OPTION>
				<OPTION VALUE="MIZORAM">MIZORAM</OPTION>
				<OPTION VALUE="NAGALAND">NAGALAND</OPTION>
				<OPTION VALUE="ODDISHA">ODDISHA</OPTION>
				<OPTION VALUE="PUNJAB">PUNJAB</OPTION>
				<OPTION VALUE="RAJASTHAN">RAJASTHAN</OPTION>
				<OPTION VALUE="SIKKIM">SIKKIM</OPTION>
				<OPTION VALUE="TAMIL NADU">TAMIL NADU</OPTION>
				<OPTION VALUE="TELENGANA">TELENGANA</OPTION>
				<OPTION VALUE="TRIPURA">TRIPURA</OPTION>
				<OPTION VALUE="UTTAR PRADESH">UTTAR PRADESH</OPTION>
				<OPTION VALUE="UTTARAKHAND">UTTARAKHAND</OPTION>
				<OPTION VALUE="WEST BENGAL">WEST BENGAL</OPTION>
			</select><span>*</span><br>
	<?php echo "$stateerror"; ?>
	</div>
	<div id="b13">
		<b>Pincode</b>
			<input type="text"  size="10" placeholder="" name="pincode" maxlength="6"><span>*</span><br>
	<?php echo "$pincodeerror"; ?>
	</div>

	<div id="b17">
		<b>Patient pic</b>
	</div>
	<div id="b18">

			<label for="file"><b>Choose a file:</b></label>
			<input type="file" name="image"  accept="image/png,image/jpeg,image/jpg"><br>
		<?php echo $imgerror;?><br>
	</div>
</div><br><br><br><br>
	<input type="submit" name="dataButton" value="SUBMIT" style="font-size: 20px;margin-left:80%;">
	</form>
	<script type="text/javascript">
		function myrefresh(){
			var x=location.href;
		//	alert(x);
			location.assign(x);
		}
	</script>
	<input type="submit" name="refresh" value="refresh" onclick="myrefresh()" style="font-size: 20px;margin-left: 20%;">
	<footer>
		<br><br><br>
	</footer>

</body>
</html>
