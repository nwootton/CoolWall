<?php
 	require_once dirname(__FILE__) . '/../classes/cardClass.php';
	require_once dirname(__FILE__) . '/../services/cardServices.php';
	
	//MUST BE AFTER Classes are loaded	
	session_start();	

	//Retrieve filters if in URL passed
	$action				= $_REQUEST['process'];
	
	if(isset($_REQUEST["cardID"]) AND $_REQUEST["cardID"] != null) {
		$cardID			= $_REQUEST["cardID"];
	}
	
	$cardTitle			= $_REQUEST["cardTitle"];
	$cardDescription	= $_REQUEST["cardDescription"];
	$userID				= $_REQUEST["userID"];
	$boardID			= $_REQUEST["boardID"];
	
	switch ($action) {
		case 'add':
			$result = addNewCard($cardTitle, $cardDescription, $userID, $boardID, rand(2,8));
			break;
		case 'edit':
			$result = updateCard($cardID, $cardTitle, $cardDescription, $userID, $boardID);
			break;
		case 'delete':
			$result = deleteCard($cardID);
			break;
	}
	
	
	
	//echo $result;
	
	header("location: /index.php");
?>