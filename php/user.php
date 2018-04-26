<?php

class user
{
	public $id;
	public $firstName;
	public $lastName;
	public $username;
	public $url;
	public $email;
	public $bio;

	function __construct($mysqli, $inId=null, $inFirstName=null, $inLastName=null, $inUsername=null, $inUrl=null, $inEmail=null, $inBio=null)
	{
		if (!empty($inId))
		{
			$this->id = $inId;
		}
		if (!empty($inFirstName))
		{
			$this->firstName = $inFirstName;
		}
		if (!empty($inLastName))
		{
			$this->lastName = $inLastName;
		}
		if (!empty($inUsername))
		{
			$this->username = $inUsername;
		}
		if (!empty($inUrl)){
			$this->url = $inUrl;
		}
		if (!empty($inEmail)){
			$this->email = $inEmail;
		}
		if (!empty($inBio)){
			$this->bio = $inBio;
		}

		if (!empty($inId) && (empty($inFirstName) || empty($inLastName) || empty($inUsername)))
		{
			$query = mysqli_query($mysqli, "SELECT `first_name`, `last_name`, `username` FROM `users` WHERE id = " . $inId);
			$row = mysqli_fetch_assoc($query);
			$this->firstName = $row["first_name"];
			$this->lastName = $row["last_name"];
			$this->username = $row["username"];
			$this->Id = $inId;
		}
	}

}

?>
