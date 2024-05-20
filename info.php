<?php

//valuables
$Firstname = $_POST['Firstname'];
$Lastname = $_POST['Lastname'];
$Gender = $_POST['Gender'];
$Phone = $_POST['Phone'];
$Email = $_POST['Email'];

//code to check that the valuable is not empty.
If(isset($_REQUEST['submit'])!=''){
if (!empty($Firstname) || !empty($Lastname) || !empty($Gender) || !empty($Phone) || !empty($Email)){

	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbname = "info";

//connection
	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

	if (mysql_connect_error()){
		die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
	}else{ 
	$SELECT = "SELECT Email From personal_detail Where Email = ? Limit 1";
	$INSERT = "INSERT Into personal_detail (Firstname, Lastname, Gender, Phone, Email) values(?,?,?,?,?)";
	

//prepare statement
	$stmt = $conn->prepare($SELECT);
	$stmt->bind_param("s", $Email);
	$stmt->execute();
	$stmt->bind_result($Email);
	$stmt->store_result();
	$rnum = $stmt->num_rows;

	if ($rnum==0){
		$stmt->close();

		$stmt = $conn->prepare($INSERT);
		$stmt->bind_param("sssis", $Firstname, $Lastname, $Gender, $Phone, $Email);
		$stmt->execute();
		echo "New record inserted succefully";
	}else{
		echo "Email already exists";
	}
	$stmt->close();
	$conn->close();
	}

} else {
	echo "All fields required";
	die();
}
}
?>