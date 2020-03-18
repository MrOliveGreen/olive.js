<?php
require_once("config.php");
session_start();

function getIds()
{
	// Try and connect using config.php data above.
	$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	if ( mysqli_connect_errno() ) {
		// If there is an error with the connection, stop the script and display the error.
		die ('Failed to connect to MySQL: ' . mysqli_connect_error());
	}

	$sql = "SELECT id FROM settings ORDER BY id";
	$result = mysqli_query($con, $sql);

	// Fetch all
	//mysqli_fetch_array($result, MYSQLI_NUM);
	//$ids = mysqli_fetch_array($result);

	return $result;
}

function getNames()
{
	// Try and connect using config.php data above.
	$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	if ( mysqli_connect_errno() ) {
		// If there is an error with the connection, stop the script and display the error.
		die ('Failed to connect to MySQL: ' . mysqli_connect_error());
	}

	$sql = "SELECT name FROM settings ORDER BY id";
	$result = mysqli_query($con, $sql);

	// Fetch all
	//mysqli_fetch_array($result, MYSQLI_NUM);
	//$ids = mysqli_fetch_array($result);

	return $result;
}

function getSettings($setting_id)
{
	// Try and connect using config.php data above.
	$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	if ( mysqli_connect_errno() ) {
		// If there is an error with the connection, stop the script and display the error.
		die ('Failed to connect to MySQL: ' . mysqli_connect_error());
	}

	// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
	$sql = 'SELECT * FROM settings';
	if($setting_id != 0)
		$sql = $sql.' WHERE id=?';

	if ($stmt = $con->prepare($sql)) {
		if($setting_id != 0)
			$stmt->bind_param('i', $setting_id);

		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows > 0) {
			$stmt->bind_result($id, $overlay_mode, $overlay_url, $redirect_mode, $redirect_sec, $redirect_url, $exit_mode, $exit_url, $name);
			$stmt->fetch();
			//Store all data to an array and return
			$result = array();
			$result['id'] = $id;
			$result['name'] = $name;
			$result['overlayMode'] = $overlay_mode;
			$result['overlayURL'] = $overlay_url;
			$result['redirectMode'] = $redirect_mode;
			$result['redirectSec'] = $redirect_sec;
			$result['redirectURL'] = $redirect_url;
			$result['exitMode'] = $exit_mode;
			$result['exitURL'] = $exit_url;
			return $result;
		} 
		else
		{
			echo 'Failed to get setting data...';
		}

		$stmt->close();
	}
}

function saveSettings($name, $overlay_mode, $overlay_url, $redirect_mode, $redirect_sec, $redirect_url, $exit_mode, $exit_url, $id)
{
	// Try and connect using config.php data above.
	$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	if ( mysqli_connect_errno() ) {
		// If there is an error with the connection, stop the script and display the error.
		die ('Failed to connect to MySQL: ' . mysqli_connect_error());
	}

	$setting = getSettings($id);
	
	$stmt = $con->prepare("UPDATE settings SET name=?, overlay_mode=?, overlay_url=?, redirect_mode=?, redirect_sec=?, redirect_url=?, exit_mode=?, exit_url=? WHERE id=?");

	$setting_id = $setting['id'];
	if($id != 0)
		$setting_id = $id;
	$stmt->bind_param('sisiisisi', $name, $overlay_mode, $overlay_url, $redirect_mode, $redirect_sec, $redirect_url, $exit_mode, $exit_url, $setting_id);
	
	$status = $stmt->execute();

	if($status === false)
		return false;
	else
		return true;
}

function newSettings()
{
	// Try and connect using config.php data above.
	$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	if ( mysqli_connect_errno() ) {
		// If there is an error with the connection, stop the script and display the error.
		die ('Failed to connect to MySQL: ' . mysqli_connect_error());
	}

	$query_insert = 'INSERT INTO settings SET name = "Redirect", overlay_mode = 0, overlay_url = "google.com", redirect_mode = 0, redirect_sec = 15, redirect_url = "google.com", exit_mode = 0, exit_url = "google.com"';

	$result_insert = mysqli_query($con, $query_insert) or die(mysqli_error());

	if($result_insert)
	{
		$sql = "SELECT id FROM settings ORDER BY id DESC";
		$result = mysqli_query($con, $sql);

		$max = mysqli_fetch_assoc($result);
		return $max['id'];
	}
	else
		return 0;
}
?>