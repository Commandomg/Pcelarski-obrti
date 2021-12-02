<?php require("zaglavlje.php"); ?>
		<div>
		<?php
		otvoriBP();
		$sql="SELECT ob.naziv,p.proizvod_id,p.naziv,oc.ocjena, oc.datum FROM 
proizvod p 
inner join ocjena oc
on p.proizvod_id = oc.proizvod_id
INNER JOIN obrt ob
ON p.obrt_id = ob.obrt_id
WHERE oc.korisnik_id =".$aktivni_korisnik_id;

		$ex = izvrsiBP($sql);
		$broj_redaka = mysqli_num_rows($ex);
		$broj_str = ceil($broj_redaka / $vel_str);  
		
		
		$sql.=" order by oc.datum desc limit ".$vel_str;
		if (isset($_GET['str'])){
		$sql = $sql . " OFFSET " . (($_GET['str'] - 1) * $vel_str);
		$aktivna = $_GET['str'];
		} else {
			$aktivna = 1;
		}		
		$ex = izvrsiBP($sql);
		
		echo "<h3>Popis svih proizvoda koje sam ocjenio:</h3>";
		echo "<table id=\"tablica\">";
				echo "<thead>";
				  echo "<tr>";
					echo "<th>Obrt</th><th>Proizvod</th><th>Ocjena</th><th>Datum ocjene</th>";
				  echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
				
				while(list($obrtnaziv,$proizvodid,$proizvodnaziv,$ocjena,$datum)=mysqli_fetch_array($ex)){
					$datum=date("d.m.Y H:i:s",strtotime($datum));
				echo "<tr>";
			    echo "<td>$obrtnaziv</td><td>$proizvodnaziv</td><td class=\"center\">$ocjena</td><td>$datum</td>";
				echo "</tr>";
				}
				 echo "<tr>";
				 echo "<td colspan='4' class='zadnji'>";
				 echo "Stranice: ";
				 for($str=1;$str<=$broj_str;$str++){
					 echo " <a href='regkorocijenjeniproizvodi.php?str=$str'>$str</a>";
				 }
				 echo "</td>";
				 echo "</tr>";
				echo "</tbody>";
			  echo "</table>";
			  
			 echo "<p><a href='javascript:history.back(-1)'>Natrag</a></p>";
			?>
		</div>
	</div>
<?php require("podnozje.php"); ?>