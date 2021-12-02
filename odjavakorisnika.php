<?php

if(session_id()==""){
session_start();	
}
		if(isset($_SESSION['logiran'])){
			session_destroy();	
		}	
		
		
		header("Location: index.php");

?>