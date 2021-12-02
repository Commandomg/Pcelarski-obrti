<?php require("zaglavlje.php"); ?>
		<div>
		<?php
		otvoriBP();
		$sql="select ob.obrt_id,ob.naziv, p.proizvod_id,p.naziv,p.slika,p.opis,avg(o.ocjena),COUNT(o.ocjena) from proizvod p left join ocjena o on p.proizvod_id = o.proizvod_id 
		inner join obrt ob on p.obrt_id = ob.obrt_id 
		where ob.moderator_id=".$aktivni_korisnik_id." group by p.proizvod_id";

		$ex = izvrsiBP($sql);
		$broj_redaka = mysqli_num_rows($ex);
		$broj_str = ceil($broj_redaka / $vel_str);  
		
		
		$sql.=" limit ".$vel_str;
		if (isset($_GET['str'])){
		$sql = $sql . " OFFSET " . (($_GET['str'] - 1) * $vel_str);
		$aktivna = $_GET['str'];
		} else {
			$aktivna = 1;
		}		
		$ex = izvrsiBP($sql);
		
		echo "<h3>Popis svih proizvoda iz mog obrta:</h3>";
		echo "<table id=\"tablica\">";
				echo "<thead>";
				  echo "<tr>";
					echo "<th>Obrt</th><th>Proizvod</th><th>Ocjena</th><th>Ocjenjen puta</th><th>Mogućnosti</th>";
				  echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
				
				while(list($obrtid,$obrtnaziv,$proizvodid,$proizvodnaziv,$slika,$opis,$ocjena,$ocjenjenputa)=mysqli_fetch_array($ex)){
					$azur="<a href=\"proizvod.php?azurirajproizvod=$proizvodid\">Ažuriraj</a>";
					if($ocjena==null || $ocjena==""){
						$ocjena=0;
					}
				echo "<tr>";
			    echo "<td>$obrtnaziv</td><td>$proizvodnaziv</td><td class=\"center\">$ocjena</td><td class=\"center\">$ocjenjenputa</td><td class=\"center\">$azur</td>";
				echo "</tr>";
				}
				 echo "<tr>";
				 echo "<td colspan='6' class='zadnji'>";
				 echo "Stranice: ";
				 for($str=1;$str<=$broj_str;$str++){
					 echo " <a href='moderatorproizvodi.php?str=$str'>$str</a>";
				 }
				 echo "</td>";
				 echo "</tr>";
				echo "</tbody>";
			  echo "</table>";
			  
			 echo "<p><a href='javascript:history.back(-1)'>Natrag</a></p>";
			 if($obrtmodid>0 && $certificiran==1){
			 echo "<p class='azuriraj'><a href='proizvod.php?novi=1&obrtid=$obrtmodid'>Dodaj novi proizvod</a></p>";
			 }
			 
			 echo "<p class='azuriraj'><a href='moderatorgalerija.php'>Galerija proizvoda</a></p>";
			?>
		</div>
	</div>
<?php require("podnozje.php"); ?>