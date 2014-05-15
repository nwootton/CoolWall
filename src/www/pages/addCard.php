<?php
 	require_once dirname(__FILE__) . '/../services/cardServices.php';
	
	//MUST BE AFTER Classes are loaded	
	session_start();	
	
	$arrAllUsers 	= json_decode(getAllUsers(), true);
	$arrAllBoards 	= json_decode(getBoards(), true);
?>

<form action="/pages/processCard.php" id="newCardForm" method="post">
	<input type="hidden" name="process" value="add" />
	
	<label for="cardTitle">Card title</label>
	<input type="text" name="cardTitle" required/><br />
	
	<label for="cardDescription">Description</label>
	<textarea name="cardDescription" cols="50" rows="5"></textarea><br />
	
	<label for="userID">User</label>
	<select name="userID" required>
		<option value="">-- Please Select --</option>
		<?php 
			foreach ($arrAllUsers AS $Users) {
				foreach ($Users AS $User) {
					echo '<option value="'. $User['UserID']. '">' . $User['UserName'] . '</option>';
				};
			};
		?>	
	</select>

	<br />

	<label for="boardID">Initial Board</label>
	<select name="boardID" required>
		<option value="">-- Please Select --</option>
		<?php 
			foreach ($arrAllBoards AS $Boards) {
				foreach ($Boards AS $Board) {
					echo '<option value="'. $Board['BoardID']. '">' . $Board['BoardName'] . '</option>';
				};
			};
		?>	
	</select>
	
	<br />
	<input type="submit">

</form>

	