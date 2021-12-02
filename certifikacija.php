  <?php
  require("zaglavlje.php");
otvoriBP();
if(isset($_GET["certificiran"])){
	
	$obrtid=$_GET["obrtid"];
	$certificiran=$_GET["certificiran"];
	
	if($certificiran==0){
		$sql="update obrt set certificiran = 1 where obrt_id=".$obrtid;
	}
	else
	{
		$sql="update obrt set certificiran = 0 where obrt_id=".$obrtid;
	}
	
	$ex=izvrsiBP($sql);
	
	header("Location: adminobrti.php");
}

?>