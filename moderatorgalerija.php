<?php require("zaglavlje.php"); ?>
		<div>
		<?php
		otvoriBP();
		$sql="select p.proizvod_id,p.naziv,p.slika,p.opis,avg(o.ocjena) from proizvod p inner join ocjena o on p.proizvod_id = o.proizvod_id group by p.proizvod_id order by avg(o.ocjena) desc limit 15";
		$rs=izvrsiBP($sql);
		$lista=1;
		$proizvoda=0;
		echo "<h3>Galerija proizvoda</h3>";
		while(list($proizvodid,$naziv,$slika,$opis,$ocjena)=mysqli_fetch_array($rs)){
			if($lista%3==1){
				echo "<ul>";
			}
			$proizvoda++;
		?>			
				<li>
					<a href="#"><img src="<?php echo $slika; ?>" title="<?php echo $proizvoda."|".$lista; ?>" width="292" height="220"></a>
					<a href="#"><?php echo $naziv." => ".round($ocjena,2); ?></a>
				</li>

				<?php
			if($lista%3==0){
				echo "</ul>";
				$proizvoda=0;
			}
			$lista++;
		}
			?>
		</div>
	</div>
<?php require("podnozje.php"); ?>