<?php require("zaglavlje.php"); ?>
		<div>
		<?php
		otvoriBP();
		$sql="select obrt_id,moderator_id,naziv,opis,kontakt_informacije,certificiran, ime, prezime from obrt inner join korisnik on moderator_id = korisnik_id";

		$ex = izvrsiBP($sql);
		$broj_redaka = mysqli_num_rows($ex);
		$broj_str = ceil($broj_redaka / $vel_str);  
		echo "<h3>Popis svih obrta</h3>";
		echo "<table id=\"tablica\">";
				echo "<thead>";
				  echo "<tr>";
					echo "<th>Naziv</th><th>Opis</th><th>Moderator</th><th>Certificiran</th><th>Opcija</th>";
				  echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
				
				
				while(list($obrtid,$moderator,$naziv,$opis,$kontakt_info,$certificiran,$ime,$prezime)=mysqli_fetch_array($ex)){
				$klasa="";
				$odaberi="<strong><a href=\"proizvodiobrta.php?obrtid=$obrtid\">Detalji</a></strong>";
				$azuriraj = "<a href='moderatorobrt.php?azuriraj=$obrtid'>Ažuriraj</a>";
				$certifikacija="<strong><a href=\"certifikacija.php?obrtid=$obrtid&certificiran=$certificiran\">Certifikacija</a></strong>";
				if($certificiran==0){
					$klasa="necertificirani";
				}
				echo "<tr class=\"$klasa\">";
			    echo "<td>$naziv</td><td>$opis</td><td>$ime $prezime</td><td class=\"center\">$certificiran</td><td>$odaberi | $certifikacija | $azuriraj</td>";
				echo "</tr>";
				}
				 echo "<tr>";
				 echo "<td colspan='5' class='zadnji'>";
				 echo "Stranice: ";
				 for($str=1;$str<=$broj_str;$str++){
					 echo "<a href='adminobrti.php?str=$str'>$str</a>";
				 }
				 echo "</td>";
				 echo "</tr>";
				echo "</tbody>";
			  echo "</table>";
			  
			  if($aktivni_korisnik_tip == 1){
				  echo "<p><a href='moderatorobrt.php'>Moj obrt</a></p>";
			  }
			  echo "<p class='azuriraj'><a href='moderatorobrt.php?dodajnovi=0'>Dodaj obrt</a></p>";
			?>
		</div>
	</div>
<?php require("podnozje.php"); ?>