<?php

 class BaseUrl
 {

	static private $_MYSERVER = NULL;

 	private function __construct()
 	{
 		# code...
 	}

 	static public function getServer()
 	{

 		if(self::$_MYSERVER == NULL){
 			
 			self::$_MYSERVER = 'http://' . $_SERVER['HTTP_HOST'];
 		}

 		return self::$_MYSERVER;
 	}
 } 


 ?>