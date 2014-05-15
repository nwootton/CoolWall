<?php 
	require_once dirname(__FILE__) . '/config/config.php';
	require_once dirname(__FILE__) . '/services/cardServices.php';
	
	session_start();

	if (isset($_REQUEST['BoardID']) AND ($_REQUEST['BoardID'] != null) ) { 
		$_SESSION['BoardID']	= $_REQUEST['BoardID'];
		$intBoardID				= $_REQUEST['BoardID'];
	}else{
		if ( isset($_SESSION['BoardID']) AND ($_SESSION['BoardID'] != null) ) {	
			$intBoardID = $_SESSION['BoardID'];
		}
		else {
			$_SESSION['BoardID']	= 1;
			$intBoardID				= 1;			
		}
	}
	
	$arrCards = json_decode(getCards($intBoardID), true);
	
	$arrTitles = json_decode(getTitles($intBoardID), true);
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="refresh" content="60"/> 
		
		<!-- IOS Webclip -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
				
		<meta name="viewport" content="width=device-width, user-scalable=yes" />
		
		<title>PRG Heat Map</title>
		
		<!-- Local: Load JS Libraries -->
	    <script type="text/javascript" src="js/jquery-1.7.1.min.js" ></script>
	    
		<script type="text/javascript" src="js/jquery-ui-1.8.16/core/jquery-ui-core-1.8.16.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16/core/jquery-ui-widget-1.8.16.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16/core/jquery-ui-mouse-1.8.16.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16/interactions/jquery-ui-draggable-1.8.16.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16/interactions/jquery-ui-droppable-1.8.16.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16/widgets/jquery-ui-dialog-1.8.16.js"></script>
		
		<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
		
		<link rel="stylesheet" type="text/css" href="/css/jquery-ui-1.8.16.custom.css" media="screen"/>
		<link rel="stylesheet" type="text/css" href="/css/heatmap.css" media="screen"/>		
	
	</head>
	
	<body>
		<script type="text/javascript">

			$(document).ready(
				function(){
					
					<?php 
						foreach ($arrCards AS $cards) {
							foreach ($cards as $card) {
								echo "$('#ticket_" . $card['CardID'] . "').dblclick(function() { editCard(".$card['CardID']."); }); \n";
								echo "$('#ticket_" . $card['CardID'] . "').draggable({stop: function(event, ui) {updatePosition(".$card['CardID'].", ui.offset.left, ui.offset.top) }}); \n" ;
							}
						};
					?>

					$("#addCard").click(function() {
						$("#addCardForm").load("pages/addCard.php", 
												function(){ 
													$('#addCardForm').dialog('open')
												} 
											);
					});
					
					$("#addCardForm").dialog({
						resizable: true,
						autoOpen:false,
						modal: true,
						width:600,
						height:480,
						show: "fade",
						hide: "fade",
						closeOnEscape: true
					});//end dialog

					$("#editCardForm").dialog({
						resizable: true,
						autoOpen:false,
						modal: true,
						width:600,
						height:480,
						show: "fade",
						hide: "fade",
						closeOnEscape: true
					});//end dialog
					
				}
			);


			function updatePosition(intCardID, X, Y){
				$.post(
						"/pages/updateCardPosition.php",
						{intCardID: intCardID, X: X, Y: Y }
				);
			};

			function editCard(intCardID){
				console.log('clicked to edit ' + intCardID );				
				
				$("#editCardForm").load("pages/editCard.php?CardID="+ intCardID , 
						function(){ 
							$('#editCardForm').dialog('open')
						} 
					);			
			
			};
			
		</script>
		
		<div class="board-outline">
		
			<div id="board">
				<navigation>
			<img src="/assets/add.png" width="50px" height="50px" id="addCard">
			
			<?php 
				foreach ($arrTitles as $titles) {
					
					foreach ($titles as $title) {
							
					    echo '<div class="title" style="left: ' . $title['X'] . 'px; top:' . $title['Y'] . 'px;">';
					 	echo '<h3>' . $title['TitleText'] . '</h3>';
						echo '</div>';			 	
					}
				};
			?>			
			
		</navigation>
				<div id="board-doodles"></div>
				<div id="content">
				<?php 
					
					foreach ($arrCards as $cards) {
						
						foreach ($cards as $card) {
								
						    echo '<div class="card' . $card['ColourID']  . '" id="ticket_' . $card['CardID'] . '" style="left: ' . $card['X'] . 'px; top:' . $card['Y'] . 'px;">';
						 	echo '<h3>' . $card['CardName'] . '</h3>';
							echo '<div class="content">' . $card['CardDescription'] . '</div>';
							echo '<div class="owner">' . $card['UserName'] . '</div>';
							echo '</div>';			 	
						}
					};
				
				?>
				</div>
			</div>

		</div>

		


		<div id="addCardForm" title="Add Card"></div>
		<div id="editCardForm" title="Edit Card"></div>				
	</body>
</html>