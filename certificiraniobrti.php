<?php require("zaglavlje.php"); ?>
		<div>
		<?php
		otvoriBP();
		$sql="select obrt_id,moderator_id,naziv,opis,kontakt_informacije,certificiran from obrt where certificiran = 1";

		$ex = izvrsiBP($sql);
		$broj_redaka = mysqli_num_rows($ex);
		$broj_str = ceil($broj_redaka / $vel_str);  
		echo "<h2>Popis svih certificiranih obrta</h2>";
		echo "<table id=\"tablica\">";
				echo "<thead>";
				  echo "<tr>";
					echo "<th>Naziv</th><th>Opis</th><th>Opcija</th>";
				  echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
				
				while(list($obrtid,$moderator,$naziv,$opis,$kontakt_info,$certificiran)=mysqli_fetch_array($ex)){
				$odaberi="<strong><a href=\"proizvodiobrta.php?obrtid=$obrtid\">Detalji</a></strong>";
				echo "<tr>";
			    echo "<td>$naziv</td><td>$opis</td><td>$odaberi</td>";
				echo "</tr>";
				}
				 echo "<tr>";
				 echo "<td colspan='3' class='zadnji'>";
				 echo "Stranice: ";
				 for($str=1;$str<=$broj_str;$str++){
					 echo "<a href='obrti.php?str=$str'>$str</a>";
				 }
				 echo "</td>";
				 echo "</tr>";
				echo "</tbody>";
			  echo "</table>";
			  
			  if($aktivni_korisnik_tip == 1 || $aktivni_korisnik_tip == 0){
				  echo "<p><a href='moderatorobrt.php'>Moj obrt</a></p>";
			  }
			?>
		</div>
	</div>
<?php require("podnozje.php"); ?>