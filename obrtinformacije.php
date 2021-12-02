<?php require("zaglavlje.php"); ?>
		<div>
		<?php
		echo "<h3>Informacije o obrtu i proizvodu</h3>";
		$obrtid=$_GET["obrtid"];
		$proizvodid=$_GET["proizvodid"];
		otvoriBP();
		
		$sql="select obrt_id,moderator_id,naziv,opis,kontakt_informacije,certificiran from obrt where obrt_id = ".$obrtid;
		$rs=izvrsiBP($sql);
		
		echo "<h4>Obrt</h4>";
		list($obrtid,$moderator,$naziv,$opis,$kontakt_info,$certificiran)=mysqli_fetch_array($rs);
		$kontakt_br = str_replace(";","<br>",$kontakt_info);
		echo "<p>Kontakt informacije: ".$kontakt_br."</p>";
		
		
		$sql="select p.proizvod_id,p.naziv,p.slika,p.opis, p.video from proizvod p where p.proizvod_id =".$proizvodid;
		$rs=izvrsiBP($sql);
		
		echo "<h4>Proizvod</h4>";
		list($proizvodid,$naziv,$slika,$opis,$video)=mysqli_fetch_array($rs);
		echo "<p>Naziv: ".$naziv."</p>";
		echo "<p>Opis: ".$opis."</p>";
		echo "<p>Slika: <br><img src=".$slika." class=\"slika\" width=\"300\" height=\"300\"></p>";
		echo "<p>Video: <br>";
		if($video != "")
		{
			if(strpos($video,"youtube")>0){ 
				$youtubevideo="https://www.youtube.com/embed/videouid";
				$poz=strpos($video,"=");
				$video_id = substr($video,$poz+1,strlen($video));
				$video=str_replace("videouid",$video_id,$youtubevideo); 
				echo "<iframe width=\"300\" height=\"300\" src=\"$video\"></iframe>";
			}
			if(substr($video,-3)=="mp4"){
				echo "<video width='300' height='300' controls>";
				echo "<source src='$video' type='video/mp4'>";
				echo "<source src='$video' type='video/webm'>";
				echo "</video>";
			}
		}
		echo "</p>";
		
		if(OcjenjenProizvod($aktivni_korisnik_id,$proizvodid)==0){
		
		echo "<p>Ocjeni proizvod: <br>";
		for($ocjena=1;$ocjena<=5;$ocjena++){
			echo " <a href=\"ocjeniproizvod.php?proizvodid=$proizvodid&ocjena=$ocjena\" title=\"$ocjena\"><img src=\"images/star.png\" width=\"32\" height=\"32\" onmouseover=\"this.src='images/star_hover.png'\" onmouseout=\"this.src='images/star.png'\"></a>";
		}
		echo "</p>";
		}
		else
		{
			echo "<p>Već ste ocijenili proizvod</p>";
		}
		echo "<p><a href='javascript:history.back(-1)'>Natrag</a></p>";
			?>
		</div>
	</div>
<?php require("podnozje.php"); ?>