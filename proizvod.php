<?php require("zaglavlje.php"); ?>
		<div>
		<?php
		otvoriBP();			
		echo "<h3>Administracija proizvoda</h3>";

		if(isset($_GET["novi"]) || isset($_GET["azurirajproizvod"])){
	
			if(isset($_GET["azurirajproizvod"])){
				$proizvodid=$_GET["azurirajproizvod"];
				$gumb="Ažuriraj postojeći proizvod";
				$sql="select * from proizvod where proizvod_id=".$proizvodid;
				$ex = izvrsiBP($sql);
				list($proizvodid,$obrtid,$naziv,$opis,$slika,$video)=mysqli_fetch_array($ex);
				
			}
			else
			{
				$gumb="Unesi novi proizvod";
				$proizvodid=0;
				$obrtid=0;
				$naziv="";
				$opis="";
				$slika="";
				$video="";
			}
	
	?>
		<form action="proizvod.php" method="POST" class="storeinfo">
				<input type="hidden" name="proizvodid" id="proizvodid" value="<?php echo $proizvodid; ?>"/>
				<?php
				if($aktivni_korisnik_tip==0){
					?>
				<label for="obrti">Obrti:</label>
				<select name="obrt" id="obrt">
						<?php
						$sviobrti=PopisSvihCertificiranihObrta();
						
							foreach($sviobrti as $id=>$nazivobr){
								
								echo "<option value='$id'";
									if($obrtid==$id){
										echo " selected";
									}
								echo ">$nazivobr</option>";
							}
					?>
				</select>					
				<?php	
				}
				?>
					<label for="naziv">Naziv:</label>
					<input type="text" name="naziv" id="naziv" value="<?php echo $naziv; ?>"/>				
					<label for="opis" class="parafodmak">Opis:</label>
					<textarea name="opis" id="opis" cols="30" rows="10"><?php echo $opis; ?></textarea>
					<label for="lokacija">URL slike:</label>
					<input type="text" name="slikaurl" id="slikaurl" value="<?php echo $slika; ?>">
					<label for="sirina">URL video:</label>
					<input type="text" name="videourl" id="videourl" value="<?php echo $video; ?>">
					<input type="submit" name="ProizvodUnos" value="<?php echo $gumb; ?>">
					<label id="CheckErrors">
					<?php
					if(isset($_SESSION["valid"])){
						echo $_SESSION["valid"];
						unset($_SESSION["valid"]);
					}
					?>
					</label>
				</form>
<?php
	
		}
		
		
		if(isset($_POST["ProizvodUnos"])){
	
			$proizvodid = $_POST["proizvodid"];
			if($aktivni_korisnik_tip==0){
			$obrtmodid = $_POST["obrt"];
			}
			$naziv = $_POST["naziv"];
			$opis = $_POST["opis"];
			$urlslika = $_POST["slikaurl"];
			$urlvideo = $_POST["videourl"];
			
			if(empty($naziv) || empty($opis) || empty($urlslika) || empty($urlvideo)){
					$_SESSION["valid"]="Niste unijeli sva obavezna polja!";
					header("Location: proizvod.php?novi=0");
					return false;
				}

			
				$sqlmaxproizvod="select max(proizvod_id)+1 from proizvod";
				$ex = izvrsiBP($sqlmaxproizvod);
				list($sljedeciidproizvod)=mysqli_fetch_array($ex);
			
			if($proizvodid==0){
				$sql = "insert into proizvod (proizvod_id,obrt_id,naziv,opis,slika,video) values (\"$sljedeciidproizvod\",\"$obrtmodid\",\"$naziv\",\"$opis\",\"$urlslika\",\"$urlvideo\")";
			}
			else
			{
				$sql = "update proizvod set obrt_id=\"$obrtmodid\", naziv=\"$naziv\",opis=\"$opis\",slika=\"$urlslika\",video=\"$urlvideo\" where proizvod_id = ".$proizvodid;
			}
			
			$ex = izvrsiBP($sql);
			
			header("Location: moderatorproizvodi.php");
	
}
		
		
			?>
			
			
		</div>
	</div>
<?php require("podnozje.php"); ?>