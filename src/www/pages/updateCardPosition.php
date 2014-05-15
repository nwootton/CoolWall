<?php
 	require_once dirname(__FILE__) . '/../services/cardServices.php';
	
	//MUST BE AFTER Classes are loaded	
	session_start();	

	//Retrieve filters if in URL passed
	$intCardID		= $_REQUEST["intCardID"];
	$intX			= $_REQUEST["X"];
	$intY			= $_REQUEST["Y"];
	
	positionCard($intCardID, $intX, $intY);
?>