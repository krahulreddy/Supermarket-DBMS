
<?php
	session_start();

	$con = mysqli_connect("127.0.0.1","root","");
	mysqli_select_db($con, "supermarket");

	$name = $_POST['name'];
	$Sid = $_POST['Sid'];
	$hno = $_POST['hno'];
	$street = $_POST['street'];
	$pincode = $_POST['pincode'];
	$pass = $_POST['pass'];

	$q = "select * from employee where Employee_Name = '$name' and Home_number = '$hno' and Street = '$street' and Pincode = '$pincode'";

	$result = mysqli_query($con, $q);

	$n = mysqli_num_rows($result);

	if($n != 0)
	{
		echo "Employee already Registered. Please go back and Login!!";
	}
	else
	{
		
		$pass = hash('sha1', $pass);
		if($Sid == "")
		{
			$q = "INSERT INTO `employee`(`Employee_Name`, `Home_Number`, `Street`, `Pincode`, `Password`) VALUES ('$name', '$hno', '$street', '$pincode', '$pass')";
		}
		else
		{
			$q = "INSERT INTO `employee`(`Employee_Name`, `Supervisor_ID`, `Home_Number`, `Street`, `Pincode`, `Password`) VALUES ('$name', '$Sid', '$hno', '$street', '$pincode', '$pass')";
		}
		
		if(mysqli_query($con, $q))
		{
			$sql = "SELECT Employee_ID FROM employee WHERE Employee_Name = '$name' and Home_number = '$hno' and Street = '$street' and Pincode = '$pincode' limit 1";
			$result = mysqli_query($con, $sql);
			$value = $result->fetch_assoc();
			echo "Registration Complete. Remember your Employee ID:".$value['Employee_ID']."!! Go back to Login!!";
		}
		else
		{
			echo "Registration could not be done!! Check your SID";
		}

	}
?>