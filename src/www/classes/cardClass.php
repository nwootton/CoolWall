<?php

class card {
	function __construct($intCardID=null, $strCardName=null,$strCardDescription=null,$intUserID=null, $intX=null, $intY=null) {
		$this->id				= $intCardID;
		$this->title			= $strCardName;
		$this->description		= $strCardDescription;
		$this->userid			= $intUserID;
		$this->x				= $intX;
		$this->y				= $intY;
	}
	
	/**
	 * These functions would be better placed in a super class
	 * @param object $varName
	 * @return 
	 */
	public function __get($varName)
    {
    	if(method_exists($this,$MethodName='get_'.$varName)) {
        	return $this->$MethodName();
    	}
        else {
			trigger_error($varName.' is not avaliable .',E_USER_ERROR);
        }
    }

	public function __set($varName,$value)
	{
    	if(method_exists($this,$MethodName='set_'.$varName)) {
           	return $this->$MethodName($value);
        }
		else {
			trigger_error($varName.' is not avaliable .',E_USER_ERROR);
		}
                
	}	
	
		function set_id($newid) {
			$this->id = $newid;
		}       
		        
		function get_id() {    
			return $this->id;            
		}	

		function set_title($newtitle) {
			$this->title = $newtitle;
		}       
		        
		function get_title() {    
			return $this->title;            
		}			
	
		function set_description($newdescription) {
			$this->description = $newdescription;
		}       
		        
		function get_description() {    
			return $this->description;            
		}

		function set_userid($newuserid) {
			$this->userid = $newuserid;
		}       
		        
		function get_userid() {    
			return $this->userid;            
		}			
		
		function set_x($newx) {
			$this->x = $newx;
		}       
		        
		function get_x() {    
			return $this->x;            
		}
		
		function set_y($newy) {
			$this->y = $newy;
		}       
		        
		function get_y() {    
			return $this->y;            
		}		

		function set_position($newx,$newy) {
			$this->set_x($newx);
			$this->set_y($newy);
		}       
		        
		function get_position() {

			return 'hello';            
		}		

}