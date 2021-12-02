<?php require("zaglavlje.php"); 

otvoriBP();

?>
		<div>
		
		<h2>Pretraga prosječnih cijena po proizvodima</h2>
			<form action="adminproizvodi.php" method="POST" class="storeinfo" id="pretraga">
					<label>Obrt</label>
					<select name="obrt" id="obrt">
					<?php
					$sql="select obrt_id, naziv from obrt";
					$ex=izvrsiBP($sql);
					while(list($id,$nazivobrt)=mysqli_fetch_array($ex)){
						echo "<option value='$id'>$nazivobrt</option>";
					}
					?>
				</select>
					<label>Datum vrijeme od:</label>
					<input type="text" name="DateFrom" id="DateFrom" placeholder="<?php echo date("d.m.Y H:i:s"); ?>">
					<label>Datum vrijeme do:</label>
					<input type="text" name="DateTo" id="DateTo" placeholder="<?php echo date("d.m.Y H:i:s"); ?>">
					<input type="submit" name="PretragaPoDatumuOcjene" value="Pretraži">
					<label id="PopisGresaka"></label>
				</form>
		
		<?php
		
		$sql="SELECT ob.naziv,p.proizvod_id,p.naziv,avg(oc.ocjena), p.slika, p.video FROM 
proizvod p 
LEFT join ocjena oc
on p.proizvod_id = oc.proizvod_id
INNER JOIN obrt ob
ON p.obrt_id = ob.obrt_id where p.proizvod_id <> 0";
	if(isset($_POST["PretragaPoDatumuOcjene"])){
	$DateFrom=$_POST["DateFrom"];
	$DateTo=$_POST["DateTo"];
	$obrt=$_POST["obrt"];
		if(!empty($DateFrom) && !empty($DateTo)){
			$DateFrom=date("Y-m-d H:i:s",strtotime($DateFrom));
			$DateTo=date("Y-m-d H:i:s",strtotime($DateTo));
			$sql .= " and oc.datum BETWEEN '$DateFrom' AND '$DateTo'";
		}
		if(!empty($obrt)){
			$sql .= " and ob.obrt_id = '$obrt'";
		}
	}
$sql.=" GROUP BY p.proizvod_id";

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
		
		echo "<h3>Popis svih proizvoda ";
		           	if(isset($_POST["PretragaPoDatumuOcjene"])){		
			echo "ocjenjenih između datuma ".$_POST["DateFrom"]." i ".$_POST["DateTo"]." za obrt ".PopisSvihObrta()[$obrt].":";
			echo "</h3>";
				}
		echo "<table id=\"tablica\">";
				echo "<thead>";
				  echo "<tr>";
					echo "<th>Obrt</th><th>Proizvod</th><th>Ocjena</th><th>Slika</th><th>Video</th><th>Admin</th>";
				  echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
				
				while(list($obrtnaziv,$proizvodid,$proizvodnaziv,$ocjena,$slika,$video)=mysqli_fetch_array($ex)){
					if($ocjena==null || $ocjena==""){
						$ocjena=0;
					}
					$azur="<a href=\"proizvod.php?azurirajproizvod=$proizvodid\">Ažuriraj</a>";
				echo "<tr>";
			    echo "<td>$obrtnaziv</td><td>$proizvodnaziv</td><td class=\"center\">$ocjena</td><td class=\"center\"><img src='$slika' width='90' height='100'></td>";
				echo "<td class=\"center\">";
				if($video != "")
				{
					if(strpos($video,"youtube")>0){ 
						$youtubevideo="https://www.youtube.com/embed/videouid";
						$poz=strpos($video,"=");
						$video_id = substr($video,$poz+1,strlen($video));
						$video=str_replace("videouid",$video_id,$youtubevideo); 
						echo "<iframe width=\"150\" height=\"100\" src=\"$video\"></iframe>";
					}
					if(substr($video,-3)=="mp4"){
						echo "<video width='150' height='100' controls>";
						echo "<source src='$video' type='video/mp4'>";
						echo "<source src='$video' type='video/webm'>";
						echo "</video>";
					}
				}
				echo "</td>";
				echo "<td>$azur</td>";
				echo "</tr>";
				}
				 echo "<tr>";
				 echo "<td colspan='6' class='zadnji'>";
				 echo "Stranice: ";
				 for($str=1;$str<=$broj_str;$str++){
					 echo " <a href='adminproizvodi.php?str=$str'>$str</a>";
				 }
				 echo "</td>";
				 echo "</tr>";
				echo "</tbody>";
			  echo "</table>";
			  echo "<p class='azuriraj'><a href='proizvod.php?novi=1&obrtid=$obrtmodid'>Dodaj novi proizvod</a></p>";
			 echo "<p><a href='javascript:history.back(-1)'>Natrag</a></p>";
			?>
		</div>
	</div>
<?php require("podnozje.php"); ?>