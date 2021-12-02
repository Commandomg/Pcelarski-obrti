<?php require("zaglavlje.php"); ?>
		<div>
		<?php
		otvoriBP();
		$obrtid=$_GET["obrtid"];
		$sql="select p.proizvod_id,p.naziv,p.slika,p.opis from proizvod p where p.obrt_id =".$obrtid;
		$rs=izvrsiBP($sql);
		$lista=1;
		$proizvoda=0;
		$sviobrti = PopisSvihObrta();
		echo "<h3>Galerija proizvoda za obrt \"".$sviobrti[$obrtid]."\"</h3>";
		
		if(mysqli_num_rows($rs)>0){
			while(list($proizvodid,$naziv,$slika,$opis)=mysqli_fetch_array($rs)){
				if($lista%3==1){
					echo "<ul>";
				}
				$proizvoda++;
			?>			
					<li>
						<a href="obrtinformacije.php?obrtid=<?php echo $obrtid; ?>&proizvodid=<?php echo $proizvodid; ?>"><img src="<?php echo $slika; ?>" title="<?php echo $opis; ?>" width="292" height="220"></a>
						<a href="#"><?php echo $naziv; ?></a>
					</li>

					<?php
				if($lista%3==0){
					echo "</ul>";
					$proizvoda=0;
				}
				$lista++;
			}
		}
		else
		{
			echo "<p>Obrt \"".$sviobrti[$obrtid]."\" nema nijednog proizvoda još</p>";
		}
		echo "<p><a href='javascript:history.back(-1)'>Natrag</a></p>";
			?>
			
		</div>
	</div>
<?php require("podnozje.php"); ?>