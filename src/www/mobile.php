<?php 
	require_once dirname(__FILE__) . '/config/config.php';
	require_once dirname(__FILE__) . '/services/cardServices.php';
	
	$arrCards = json_decode(getCards(), true);
	
	$arrTitles = json_decode(getTitles(), true);
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="refresh" content="360"/> 
		
			<!-- IOS Webclip 
			<meta name="apple-mobile-web-app-capable" content="yes">
			<meta name="apple-mobile-web-app-status-bar-style" content="black">
			<meta name="viewport" content="initial-scale=1">		
		-->
		<title>Nix Heat Map</title>
		
		<!-- Local: Load JS Libraries -->
	    <script type="text/javascript" src="js/zepto.min.js" ></script>
	    
		<script type="text/javascript" src="js/jquery.mobile-1.1.0.min.js"></script>
		
		<link rel="stylesheet" type="text/css" href="/css/jquery.mobile-1.1.0.css" media="screen"/>
		<link rel="stylesheet" type="text/css" href="/css/heatmap.css" media="screen"/>		
	
	</head>
	
	<body>
		<script type="text/javascript">
			function touchHandler(event) {
				 var touches = event.changedTouches,
				    first = touches[0],
				    type = "";
	
				     switch(event.type)
				{
				    case "touchstart": type = "mousedown"; break;
				    case "touchmove":  type="mousemove"; break;        
				    case "touchend":   type="mouseup"; break;
				    default: return;
				}
				var simulatedEvent = document.createEvent("MouseEvent");
				simulatedEvent.initMouseEvent(type, true, true, window, 1,
				                          first.screenX, first.screenY,
				                          first.clientX, first.clientY, false,
				                          false, false, false, 0/*left*/, null);
	
				first.target.dispatchEvent(simulatedEvent);
				event.preventDefault();
			};
	
			function init() {
			   document.addEventListener("touchstart", touchHandler, true);
			   document.addEventListener("touchmove", touchHandler, true);
			   document.addEventListener("touchend", touchHandler, true);
			   document.addEventListener("touchcancel", touchHandler, true);    
			};


			function updatePosition(intCardID, X, Y){
				$.post(
						"/pages/updateCardPosition.php",
						{intCardID: intCardID, X: X, Y: Y }
				);				
			
			};
			
			$(document).ready(
				function(){
					if ('ontouchstart' in document.documentElement) {
                        init();
					}
					
					<?php 
						foreach ($arrCards AS $cards) {
							foreach ($cards as $card) {
								echo "$('#ticket_" . $card['CardID'] . "').draggable({stop: function(event, ui) {updatePosition(".$card['CardID'].", ui.offset.left, ui.offset.top) }}); \n" ;
							}
						};
					?>

					$("#addCard").click(function() {
						$("#addCardForm").load("pages/addCard.php", function(){ $('#addCardForm').dialog('open')} );
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
					
				}
			);
		</script>
		
		
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
		
		<div id="content">
		<?php 
			
			foreach ($arrCards as $cards) {
				
				foreach ($cards as $card) {
						
				    echo '<div class="card'. $card['CategoryID'] .'" id="ticket_' . $card['CardID'] . '" style="left: ' . $card['X'] . 'px; top:' . $card['Y'] . 'px;">';
				 	echo '<h3>' . $card['CardName'] . '</h3>';
					echo '<div class="content">' . $card['CardDescription'] . '</div>';
					echo '<div class="owner">' . $card['UserName'] . '</div>';
					echo '</div>';			 	
				}
			};
		
		?>
		</content>
		
		<div id="addCardForm" title="Add Card"></div>
		</body>
</html>