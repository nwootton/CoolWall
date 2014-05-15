<?php
 	require_once dirname(__FILE__) . '/../services/cardServices.php';
	
	//MUST BE AFTER Classes are loaded	
	session_start();	
	
	$intCardID = $_REQUEST['CardID'];

	$arrCard = json_decode(getSingleCard($intCardID));
	
	$arrDetails = $arrCard->CardDetails;
	$Card	= $arrDetails[0];
	
	$intCardID 		= $Card->CardID;
	$strCardName 	= $Card->CardName;
	$strDesc		= $Card->CardDescription;
	$intUserID		= $Card->UserID;
	$intBoardID		= $Card->BoardID;
		
	$arrAllUsers 	= json_decode(getAllUsers(), true);
	$arrAllBoards 	= json_decode(getBoards(), true);

?>
	
	<form action="/pages/processCard.php" id="editCardForm" method="post">
	<input type="hidden" name="process" value="edit" />
	<input type="hidden" name="cardID" value="<?php echo $intCardID; ?>" />
	
	<label for="cardTitle">Card title</label>
	<input type="text" name="cardTitle" value="<?php echo $strCardName;?>"/><br />
	
	<label for="cardDescription">Description</label>
	<textarea name="cardDescription" cols="50" rows="5"><?php echo $strDesc;?></textarea><br />
	
	<label for="userID">User</label>
	<select name="userID">
	<option value="0">-- Please Select --</option>
	<?php   
	foreach ($arrAllUsers AS $Users) {
		foreach ($Users AS $User) {
			$strOption = '<option value="'. $User['UserID'] .'"';
			
			if ($User['UserID'] == $intUserID ) {
				$strOption = $strOption . ' selected ';
			}
			
			$strOption = $strOption . '>' . $User['UserName'] . '</option>';
			
			echo $strOption;
		};
	};
	?>
		</select>
	
		<br />
	
		<label for="boardID">Initial Board</label>
		<select name="boardID">
			<option value="0">-- Please Select --</option>
			<?php 
				foreach ($arrAllBoards AS $Boards) {
					foreach ($Boards AS $Board) {
						
						$strOption = '<option value="'. $Board['BoardID'] .'"';
							
						if ($Board['BoardID'] == $intBoardID ) {
							$strOption = $strOption . ' selected ';
						}
							
						$strOption = $strOption . '>' . $Board['BoardName'] . '</option>';
							
						echo $strOption;
						
					};
				};
			?>	
		</select>
		
		<br />
		<input type="submit" >
	
	</form>	
	
	
	<hr />
	
	<form action="/pages/processCard.php" id="deleteCardForm" method="post">
	<input type="hidden" name="process" value="delete" />
	<input type="hidden" name="cardID" value="<?php echo $intCardID; ?>" />
	
	<br />
	<label for="deleteButton">Delete this card?</label>
	<input name="deleteButton" type="submit" value="Delete">
	
	</form>	
	
	