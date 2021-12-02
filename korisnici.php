<?php require("zaglavlje.php"); ?>
		<div>
		<?php
		otvoriBP();
		$sql="select k.korisnik_id, k.tip_id,k.korisnicko_ime,k.ime,k.prezime,k.email,k.slika,t.naziv 
					from korisnik k inner join tip_korisnika t on k.tip_id = t.tip_id";

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
		
		echo "<h3>Popis svih korisnika</h3>";
		echo "<table id=\"tablica\">";
				echo "<thead>";
				  echo "<tr>";
					echo "<th>Ime i prezime</th><th>Korisničko ime</th><th>E-mail</th><th>Tip</th><th>Slika</th><th>Akcija</th>";
				  echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
				
				while(list($korisnikid, $tip, $korime,$ime,$prezime,$email,$slika,$tipime)=mysqli_fetch_array($ex)){
				$azur="<a href=\"korisnik.php?korisnik=$korisnikid\">Uredi</a>";
				echo "<tr>";
			    echo "<td>$ime $prezime</td><td>$korime</td><td>$email</td><td>$tipime</td><td class=\"center\"><img src=\"$slika\" width=\"100\" height=\"95\" ></td><td class=\"center\">$azur</td>";
				echo "</tr>";
				}
				 echo "<tr>";
				 echo "<td colspan='6' class='zadnji'>";
				 echo "Stranice: ";
				 for($str=1;$str<=$broj_str;$str++){
					 echo " <a href='korisnici.php?str=$str'>$str</a>";
				 }
				 echo "</td>";
				 echo "</tr>";
				echo "</tbody>";
			  echo "</table>";
			  
			 echo "<p><a href='javascript:history.back(-1)'>Natrag</a></p>";			 
			 echo "<p class='azuriraj'><a href='korisnik.php?novi=0'>Novi korisnik</a></p>";
			?>
		</div>
	</div>
<?php require("podnozje.php"); ?>