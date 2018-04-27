<?php
include 'includes.php';

function Register($inFirstName, $inLastName, $inUserName, $inEmail, $inPass){
	global $mysqli;
	$emptyS = "";

	//make sure that inputs are steralized
	$preFirstName = mysqli_real_escape_string($mysqli, $inFirstName);
	$preLastName = mysqli_real_escape_string($mysqli, $inLastName);
	$preUserName = ltrim(mysqli_real_escape_string($mysqli, $inUserName), "@");
	$preEmail = mysqli_real_escape_string($mysqli, $inEmail);

	//validate input!!
	$validate = ValidateReg($preFirstName, $preLastName, $preUserName, $preEmail);
	if ($validate == "code"){
		//send error message
		return;

	}else if ($validate == "length"){
		//send error message
    return;
	}

	//prepare statements

	$safuwel = $mysqli->prepare("SELECT * FROM `users` WHERE UPPER(email) LIKE ?");
	$safuwel->bind_param("s", $preEmail);

	$safuwue = $mysqli->prepare("SELECT * FROM `users` WHERE `username` = ?");
	$safuwue->bind_param("s", $preUserName);


	//check for email
	$safuwel->execute();
	$query = $safuwel->get_result();
	if (mysqli_num_rows($query) != 0)
	{
		//send error message
		return; //return if email taken
	}

	//check for username
	$safuwue->execute();
	$query = $safuwue->get_result();

	if (mysqli_num_rows($query) != 0){
		//send error message
		return; //return if username is taken
	}

	//Get down to work
	
	//add: verificarion;

	//add: url maker
	$genUrl = "";

	//hash password
	$options = ['cost' => 12,];
	$passHash = password_hash($inPass, PASSWORD_BCRYPT, $options);
	
	
	//final query
	$finalQuery = $mysqli->prepare("INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `url`, `email`, `pass_hash`, `bio`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
	$finalQuery->bind_param("sssssss", $preFirstName, $preLastName, $preUserName, $genUrl, $preEmail, $passHash, $emptyS);

	//execute
	if ($finalQuery->execute()){
		//if worked: login
		Login($inEmail, $inUserName, $inPass);
	}
}

function Login($inEmail=null, $inUserName=null, $inPass){
	global $mysqli;

	$preEmail = mysqli_real_escape_string($mysqli, $inEmail);
	$preUserName = ltrim(mysqli_real_escape_string($mysqli, $inUserName), "@");

	//prepare
	$safuwel = $mysqli->prepare("SELECT * FROM `users` WHERE UPPER(email) LIKE ?");
	$safuwel->bind_param("s", $preEmail);

	$safuwue = $mysqli->prepare("SELECT * FROM `users` WHERE `username` = ?");
	$safuwue->bind_param("s", $preUserName);

	//check users
	if (!empty($preEmail)){
		$safuwel->execute();
		$query = $safuwel->get_result();
	} else {
		$safuwue->execute();
		$query = $safuwue->get_result();
	}
	if (mysqli_num_rows($query) == 0)
	{
		//send error message
		return; //return if account not registered
	}


	//get user info
	$row = mysqli_fetch_assoc($query);
	//check password
	$userPassHash = $row['pass_hash'];
	if (password_verify($inPass, $userPassHash)){
		session_start();
		//$_SESSION[] = thing 
		header("Location:");
		exit();
	} else {
		//send error message
		return;
	}
}

function Logout(){
	session_start();
	unset($_SESSION[]);
	session_destroy();
}

function ValidateReg($inFirstName, $inLastName, $inUsername, $inEmail){
  //check for length or tags/funtions
	if (strlen($inFirstName) > 255) {  return "length"; }
	if (strlen($inLastName) > 255) { return "length"; }
	if (strlen($inUsername) > 32) { return "length"; }
	if (strlen($inEmail) > 255) {return "length"; }
	if ($inFirstName != strip_tags($inFirstName)){return "code";}
	if ($inLastName != strip_tags($inLastName)){return "code";}
	if ($inUsername != strip_tags($inUsername)){return "code";}
	if ($inEmail != strip_tags($inEmail)){return "code";}
	return true;
}
?>
