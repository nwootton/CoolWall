<?php
   	//Convert seconds to hrs:mins;secs
	function sec2hms($sec, $padHours = false) 
  	{
	    // start with a blank string
	    $hms = "";
	    
	    // do the hours first: there are 3600 seconds in an hour, so if we divide
	    // the total number of seconds by 3600 and throw away the remainder, we're
	    // left with the number of hours in those seconds
	    $hours = intval(intval($sec) / 3600); 
	
	    // add hours to $hms (with a leading 0 if asked for)
	    $hms .= ($padHours) 
	          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
	          : $hours. ":";
	    
	    // dividing the total seconds by 60 will give us the number of minutes
	    // in total, but we're interested in *minutes past the hour* and to get
	    // this, we have to divide by 60 again and then use the remainder
	    $minutes = intval(($sec / 60) % 60); 
	
	    // add minutes to $hms (with a leading 0 if needed)
	    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";
	
	    // seconds past the minute are found by dividing the total number of seconds
	    // by 60 and using the remainder
	    $seconds = intval($sec % 60); 
	
	    // add seconds to $hms (with a leading 0 if needed)
	    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
	
	    // done!
	    return $hms;
	}   	

	//Round time to specified amount
	function minutes_round($hour, $minutes, $format = "H:i")
	{
	    $seconds = strtotime($hour);
	    $rounded = round($seconds / ($minutes * 60)) * ($minutes * 60);
	    return date($format, $rounded);
	}	

   	function getJSONFromURL($strURL) {
	   		
		$ch = curl_init($strURL);
			
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: graph.facebook.com'));
			
		$output = curl_exec($ch);
		curl_close($ch);	   		
	   		
		return $output;
   	} 

   	function convertResult($rs, $type, $jsonmain="") {
   		// http://www.barattalo.it/2010/01/25/10-php-usefull-functions-for-mysql-stuff/
		// receive a recordset and convert it to csv
		// or to json based on "type" parameter.
		$jsonArray = array();
		$csvString = "";
		$csvcolumns = "";
		$count = 0;
		while($r = mysql_fetch_row($rs)) {
			for($k = 0; $k < count($r); $k++) {
				$jsonArray[$count][mysql_field_name($rs, $k)] = $r[$k];
				$csvString.=",\"".$r[$k]."\"";
			}
			if (!$csvcolumns) for($k = 0; $k < count($r); $k++) $csvcolumns.=($csvcolumns?",":"").mysql_field_name($rs, $k);
			$csvString.="\n";
			$count++;
		}
		$jsondata = "{\"$jsonmain\":".json_encode($jsonArray)."}";
		$csvdata = str_replace("\n,","\n",$csvcolumns."\n".$csvString);
		
		return ($type=="csv"?$csvdata:$jsondata);
	}
   	
	
	//Debug Functions
	function displayArrayContentFunction($arrayname,$tab="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp",$indent=0) {
	 $curtab ="";
	 $returnvalues = "";
	 while(list($key, $value) = each($arrayname)) {
	  for($i=0; $i<$indent; $i++) {
	   $curtab .= $tab;
	   }
	  if (is_array($value)) {
	   $returnvalues .= "$curtab$key : Array: <br />$curtab{<br />\n";
	   $returnvalues .= displayArrayContentFunction($value,$tab,$indent+1)."$curtab}<br />\n";
	   }
	  else $returnvalues .= "$curtab$key => $value<br />\n";
	  $curtab = NULL;
	  }
	 return $returnvalues;
	}

	//Write logs
   	function updateLog($strContent) {
   		
   		$arrDate = getDate();
   		
   		$strLogFileName = $arrDate['year'] . "_" . $arrDate['mon'] . "_" . $arrDate['mday'];
   		
		$File 	= dirname(__FILE__) . '/../data/' . $strLogFileName .'_log.txt'; 
		$Handle = fopen($File, 'a');
 			
		$Data = "{Error: '" . $strContent . "'}\n"; 
 			
		fwrite($Handle, $Data); 
		fclose($Handle);
	}		
	
?>