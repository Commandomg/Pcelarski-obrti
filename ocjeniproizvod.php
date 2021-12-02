<?php require("zaglavlje.php"); ?>
		<div>
		<?php
		otvoriBP();
		$proizvodid=$_GET["proizvodid"];
		$ocjena=$_GET["ocjena"];
		
		$sql="insert into ocjena (korisnik_id,proizvod_id,ocjena,datum) values (\"$aktivni_korisnik_id\",\"$proizvodid\",\"$ocjena\",CURRENT_TIMESTAMP)";
		$ex = izvrsiBP($sql);
		header("Location: regkorocijenjeniproizvodi.php");
			?>
		</div>
	</div>
<?php require("podnozje.php"); ?>