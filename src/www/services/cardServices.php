<?php

	require_once dirname(__FILE__) . '/../config/config.php';
	require_once dirname(__FILE__) . '/../classes/cardClass.php';
	
	require_once dirname(__FILE__) . '/miscServices.php';

	$strHost	= $config['db']['DB_SERVER'];
	$strUser	= $config['db']['DB_USERNAME'];
	$strPass	= $config['db']['DB_PASSWORD'];
	$database	= $config['db']['DB_DATABASE'];	

	
	$connect 	= mysql_connect($strHost, $strUser, $strPass) or die(mysql_error());
	$database 	= mysql_select_db($database) or die(mysql_error());		
	
	
function getTitles($intBoardID = 1) {
	try {
  		
			//Define query
			$qryTitles	 	= "	SELECT  t.TitleID, t.TitleText, t.X, t.Y "
							. " FROM    HeatMap.Titles t "
        					. " INNER JOIN HeatMap.BoardTitles bt ON bt.TitleID = t.TitleID "
							. " WHERE   bt.BoardID =" . $intBoardID .";";

			//Extract results
			$titleList = mysql_query( $qryTitles );
			
			$jsonString = convertResult($titleList,"json","AllTitles"); // json encoded string
		
			return $jsonString;

	}
	catch (Exception $e) {
		die("there was a problem in the getTitles function: " . $e);
	}	
}	
	
function getCards($intBoardID = 1) {
	try {
  		
			//Define query
			$qryCards	 	= "SELECT  c.CardID, c.CardName, c.CardDescription, c.ColourID, u.UserID, u.UserName, p.X, p.Y, bc.BoardID FROM HeatMap.Card c INNER JOIN HeatMap.UserInfo u ON u.UserID = c.UserID INNER JOIN HeatMap.CardPosition p ON p.CardID = c.CardID INNER JOIN HeatMap.BoardCard bc ON bc.CardID = c.CardID WHERE   bc.BoardID = ". $intBoardID .";";
			
			//Extract results
			$cardList = mysql_query( $qryCards );
			
			$jsonString = convertResult($cardList,"json","AllCards"); // json encoded string
		
			return $jsonString;

	}
	catch (Exception $e) {
		die("there was a problem in the getCards function: " . $e);
	}	
}

function getSingleCard($intCardID) {
	try {

		//Define query
		$qryCards	 	= "SELECT  c.CardID, c.CardName, c.CardDescription, u.UserID, u.UserName, p.X, p.Y, bc.BoardID FROM HeatMap.Card c INNER JOIN HeatMap.UserInfo u ON u.UserID = c.UserID INNER JOIN HeatMap.CardPosition p ON p.CardID = c.CardID INNER JOIN HeatMap.BoardCard bc ON bc.CardID = c.CardID WHERE   c.CardID = ". $intCardID .";";
		
		//Extract results
		$cardList = mysql_query( $qryCards );
			
		$jsonString = convertResult($cardList,"json","CardDetails"); // json encoded string

		return $jsonString;

	}
	catch (Exception $e) {
		die("there was a problem in the getCards function: " . $e);
	}
}

function positionCard($intCardID, $intX, $intY) {
	try {
		//See if new position is within board boundary! If not DELETE
		if($intX < 1920 && $intY < 1080) {
			$result = moveCard($intCardID, $intX, $intY);
			//updateLog('move');
		}
		else {
			$result = deleteCard($intCardID);
			//updateLog('delete');
		}
  		
  		return $result;
	}
	catch (Exception $e) {
		die("there was a problem in the positionCard function: " . $e);
	}	
}

function moveCard($intCardID, $intX, $intY) {
	try {
		
		$sql = "UPDATE `HeatMap`.`CardPosition` SET `Y` = ". $intY . ", `X` = ". $intX ." WHERE `CardPosition`.`CardID` = ". $intCardID.";";
		
		$result = mysql_query( $sql );
  		
  		return $result;
	}
	catch (Exception $e) {
		die("there was a problem in the moveCard function: " . $e);
	}	
}

function deleteCard($intCardID) {
	try {
		//Define query
		$sql = "DELETE FROM `HeatMap`.`BoardCard` WHERE `CardID` = " .$intCardID . "; ";
		$result = mysql_query( $sql );

		$sql2 = "DELETE FROM `HeatMap`.`CardPosition` WHERE `CardID` = " .$intCardID . "; ";
		$result2 = mysql_query( $sql2 );

		$sql3 = "DELETE FROM `HeatMap`.`Card` WHERE `CardID` = " .$intCardID . "; ";
		$result3 = mysql_query( $sql3 );

		return $result3;
	}
	catch (Exception $e) {
		die("there was a problem in the deleteCard function: " . $e);
	}
}

function getAllUsers() {
	try {
			//Define query
			$sql = "SELECT `UserID`, `UserName` FROM `HeatMap`.`UserInfo` ORDER BY `UserName` LIMIT 0, 30 ";
			
			//Extract results
			$userList = mysql_query( $sql );
			
			$jsonString = convertResult($userList,"json","AllUsers"); // json encoded string
		
			return $jsonString;
	}
	catch (Exception $e) {
		die("there was a problem in the getAllUsers function: " . $e);
	}		
}

function addNewCard($strCardName, $strCardDesc, $intUserID, $intBoardID=null, $cardColourID) {
	try {
			//Define query
			$sql = "INSERT INTO `HeatMap`.`Card` (`CardID`, `CardName`, `CardDescription`, `UserID`, `ColourID`) VALUES (NULL, '" . $strCardName . "', '".$strCardDesc."', ".$intUserID.", " .$cardColourID.");";
			
			//Extract results
			$result = mysql_query( $sql );
			$intID = mysql_insert_id();
			
			if(strlen($intBoardID)) {
				$sql2 = "INSERT INTO `HeatMap`.`BoardCard` (`BoardCardID`, `CardID`, `BoardID`) VALUES (NULL, " . $intID . ", ".$intBoardID.");";
				$result2 = mysql_query( $sql2 );
			}
				
			return $result;
	}
	catch (Exception $e) {
		die("there was a problem in the addNewCard function: " . $e);
	}	
}

function updateCard($intCardID, $strCardName, $strCardDesc, $intUserID, $intBoardID=null) {
	try {
		//Define query
		$sql = "UPDATE `HeatMap`.`Card` SET `CardName` = '" . $strCardName . "', `CardDescription` = '" . $strCardDesc . "', `UserID`='" . $intUserID . "' WHERE `CardID` = '" . $intCardID ."';";
		$result = mysql_query( $sql );
		
		$sql2 = "UPDATE `HeatMap`.`BoardCard` SET `BoardID`= '".$intBoardID."' WHERE `CardID`= '" . $intCardID . "';";
		$result2 = mysql_query( $sql2 );
		
		return $result;
	}
	catch (Exception $e) {
		die("there was a problem in the updateCard function: " . $e);
	}
}

function getBoards() {
	try {
  		
			//Define query
			$qry	 	= "	SELECT  `BoardID`, `BoardName` FROM `HeatMap`.`Board`; ";

			//Extract results
			$data = mysql_query( $qry );
			
			$jsonString = convertResult($data,"json","AllBoards"); // json encoded string
		
			return $jsonString;

	}
	catch (Exception $e) {
		die("there was a problem in the getBoards function: " . $e);
	}	
	

	
}