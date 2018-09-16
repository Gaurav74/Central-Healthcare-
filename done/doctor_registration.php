<html>
<head>
<meta charset="utf-8"/>
<title>DOCTOR ENTRY</title>
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
    if ($data=="male") {
        $gen="MALE";
    } elseif ($data=="female") {
        $gen="FEMALE";
    } elseif ($data=="others") {
        $gen="OTHERS";
    } else {
        $gen="";
    }
    return $gen;
}

//position
function position($data)
{
    $temp="";
    if (empty($data) || $data=="") {
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
        }elseif ($data=="ddata") {
            $temp="DISTRICT_DATA";
        }elseif ($data=="hdata") {
            $temp="HEAD_DATA";
        }
    }
    return strtoupper($temp);
}

$Aadharerror=$nameerror=$phoneerror=$fathernameerror=$dateerror=$emailerror=$houseerror=$townerror=$experienceerror=$positionerror="";
$addresserror=$districterror=$stateerror=$pincodeerror=$medicalerror=$passworderror=$imgerror=$gendererror=$qualificationerror="";
$run=0;

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST["dataButton"])) {
        //	echo "in button";
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
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                    $nameerror = "Only letters and white space allowed";
                    $run=1;
                }
                $name=strtoupper($name);
            }


            //gender input
            if (empty(genderverify($_POST["gender"])) || (genderverify($_POST["gender"])=="")) {
                $run=1;
                $gendererror="CHOOSE A VALUE";
            } else {
                $gender=genderverify($_POST["gender"]);
            }

            //email input
            if (empty($_POST["email"])) {
                $emailerror="Invalid Email";
                $run=1;
            } else {
                $email=test_input($_POST["email"]);
                //default email check
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
                if (preg_match("/^[ ]*$/", $password)) {
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
                $date = strtotime($_POST["date"]);

                $date = date('Y-m-d', $date);
                if (strtotime($date)> strtotime('now')) {
                    $dateerror="INVALID DATE";
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
            if (empty($_post["address"])) {
                $addresserror="";
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
                $run=1;
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
            //experience

            if (empty($_POST["experience"])) {
                $experienceerror="Experience is compulsary";
                $run=1;
            } else {
                $experience=test_input($_POST["experience"]);

                if (!preg_match("/^[0-9]*$/", $experience)) {
                    $experienceerror="Invalid Experience";
                    $run=1;
                }
            }


            // qualification

            if (empty($_POST["qualification"])) {
                $qualificationerror="QUALIFICATION is required";
                $run=1;
            } else {
                $qualification=test_input($_POST["qualification"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $qualification)) {
                    $qualificationerror= "Only letters and white space allowed";
                    $run=1;
                }
                $qualification=strtoupper($qualification);
            }

            //position
            if (position($_POST["position"])=="") {
                $positionerror="Invalid Position";
                $run=1;
            } else {
                $position= strtoupper(position($_POST["position"]));
            }
            //image
            $file_type=$_FILES['image']['type'];
            $allowed=array("image/jpeg","image/jpg","image/png");
            $pic=$_FILES['image']['tmp_name'];

            if ($pic!=null) {
                if (!in_array($file_type, $allowed)) {
                    $imgerror="Only jpg, gif, and jpeg files are allowed.";
                } else {
                    $img=addslashes(file_get_contents($pic));
                }
            }
            //ends
            else {
                $imgerror="Upload pic";
            }

            //echo "outside";
            if ($run==0) {
                //echo "inside";
                $con=mysqli_connect($admin, $user, $pass, $dbName, 3306);
                if (!$con) {
                    echo "<script>alert('Connection not set.');</script>";
                }
                $sql="insert into doctor_registration_detail(aadhar_id, d_name, phone_no, father_name, gender, date_of_birth, security_code, email_id, experience, house_no, address1, address2, district, state, pincode, education_qualify, position, doctor_pic)"."values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                if ($stmt=mysqli_prepare($con, $sql)) {
                    mysqli_stmt_bind_param($stmt, "isisssssisssssisss", $Aadhar, $name, $phone, $fathername, $gender, $date, $enc_password, $email, $experience, $house, $town, $address, $district, $state, $pincode, $qualification, $position, $img);
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
                echo '<script type="text/javascript">alert("SORRY.....CHECK INPUT");</script>';
                $run=0;
                //echo "error";
            }
        } //try
        catch (Exception $e) {
            try {
                echo '<script type="text/javascript">alert("TECHNICAL ERROR OR DATA ALREADY EXISTS..");</script>';
                $error=$e->getMessage();
                $page="doctor_registration_detail";
                $sqlerror="insert into debug(error,page) values(?,?)";
                $stmterror = mysqli_prepare($con, $sqlerror);
                mysqli_stmt_bind_param($stmterror, "ss", $error, $page);
                mysqli_stmt_execute($stmterror);

                $run=0;
            } catch (Exception $ex) {
                echo '<script type="text/javascript">alert("TECHNICAL ERROR..");</script>';
            }
        }
    }
}
?>
<div class="bc1"></div>
<header>
<h1>DOCTOR ENTRY</h1>
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
		<b>Doctor Name</b>
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
			<input type="radio" name="gender" value="male">
		<b>Female</b>
			<input type="radio" name="gender" value="female">
     <b>Others</b>
     <input type="radio" name="gender" value="others">
	</div><span><?php echo $gendererror;?></span>
	</div>
	<div id="b7">
		<b>Date of Birth</b>
			<input type="date"  size="10" name="date"><span>*</span><br>
	<?php echo "$dateerror"; ?>
	</div>
	<div id="b15">
		<b>Password</b>
			<input type="password" size="10" placeholder="" name="password"><span>*</span><br>
	<?php echo "$passworderror"; ?>
	</div>
	<div id="b16">
		<b>Email-id</b>
			<input type="email" size="30" placeholder="abc@xyz.com" name="email"><span>*</span><br>
			<?php echo "$emailerror";?>
	</div>
	<div id="exp">
		<b>Experience</b>
		<input type="text" name="experience" placeholder="NUMBER IN YEARS" size="10" maxlength="2"><span>*</span>
     <br>
		<?php echo $experienceerror; ?>
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
			<input type="text"  size="8" placeholder="" name="pincode" maxlength="6"><span>*</span><br>
	<?php echo "$pincodeerror"; ?>
	</div>

  <div id="qualify">
  	<b>Qualification</b>
  	<input type="text" name="qualification" size="10"><span>*</span><br>
  	<?php echo $qualificationerror; ?>
  </div>
<div id="position">
  	<b>Position</b>
  	<select name="position" >
  	     <option value="" selected="">SELECT</option>
  		<option value="primary">PRIMARY CARE</option>
  		<option value="district">DISTRICT CARE</option>
  		<option value="head">HEADQUARTER</option>
  		<option value="dsurgery">DISTRICT SURGERY</option>
  		<option value="hsurgery">HEAD SURGERY</option>
      	<option value="ddata">DISTRICT DATA</option>
        	<option value="hdata">HEAD DATA</option>
  	</select>
  	<span>*</span>
  	<br>
  	<?php echo $positionerror; ?>
  </div>

	<div id="b17">
		<b>Doctor pic</b>
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
			location.assign(x);
		}
	</script>
	<input type="submit" name="refresh" value="refresh" onclick="myrefresh()" style="font-size: 20px;margin-left: 20%;">
	<footer>
		<br><br><br>
	</footer>

</body>
</html>
