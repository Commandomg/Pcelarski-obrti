<?php require("zaglavlje.php"); ?>
		<div>
		<?php
		otvoriBP();			
		echo "<h3>Informacije o mom obrtu</h3>";

		
		
		$sql="select obrt_id,moderator_id,naziv,opis,kontakt_informacije,certificiran from obrt where moderator_id = ".$aktivni_korisnik_id;
		$rs=izvrsiBP($sql);
		
		if(mysqli_num_rows($rs)>0){
		
		echo "<h4>Obrt</h4>";
		list($obrtid,$moderator,$naziv,$opis,$kontakt_info,$certificiran)=mysqli_fetch_array($rs);
		$kontakt_br = str_replace(";","<br>",$kontakt_info);
		echo "<p><b>Naziv:</b> ".$naziv."</p>";		
		echo "<p><b>Opis:</b> ".$opis."</p>";		
		echo "<p><b>Certificiran:</b> ".$certificiran."</p>";		
		echo "<p><b>Kontakt informacije:</b> <br><i>".$kontakt_br."</i></p>";		
				
		echo "<p class='azuriraj'><a href='moderatorobrt.php?azurirajkontakt=$obrtid'>Ažuriraj kontakt informacije</a></p>";
		echo "<p class='azuriraj'><a href='proizvod.php?novi=1&obrtid=$obrtid'>Dodaj novi proizvod</a></p>";
		}
		else
		{
			echo "<p><b>Nemate još kreiranog obrta</b></p>";
		}
		if($obrtmodid==0){
			echo "<p class='azuriraj'><a href='moderatorobrt.php?dodajnovi=0'>Dodaj obrt</a></p>";
		}	
		
		if(isset($_GET["azurirajkontakt"])){
			$obrtid=$_GET["azurirajkontakt"];
			$sql="select obrt_id,kontakt_informacije from obrt where obrt_id = ".$obrtid;
			$rs=izvrsiBP($sql);
			list($obrtid,$kontakt_info)=mysqli_fetch_array($rs);
			$sviobrti = PopisSvihObrta();
			echo "<h3>Ažuriranje kontakt informacija obrta \"".$sviobrti[$obrtid]."\"</h3>";

			?>
			
			<form action="moderatorobrt.php" method="POST" class="storeinfo" id="moderatorobrt" enctype="multipart/form-data">
					<input type="hidden" name="obrtid" id="obrtid" value="<?php echo $obrtid; ?>">					
					<label for="kontakt_info">Kontakt informacije:</label>
					<textarea name="kontakt_info" id="kontakt_info" cols="30" rows="10"><?php echo $kontakt_info; ?></textarea>				
					<input type="submit" name="ObrtAzur" value="Ažuriraj">
					<label id="CheckErrors"></label>
				</form>
			
			<?php
			
		}
		
		if(isset($_POST["ObrtAzur"])){
				$id = $_POST['obrtid'];
				$kontakt_info = $_POST['kontakt_info'];	
				
				$sql="update obrt set kontakt_informacije = \"$kontakt_info\" where obrt_id=".$id;
				$rs=izvrsiBP($sql);
				header("Location: moderatorobrt.php");
			
		}
		
		
	if(isset($_GET["dodajnovi"]) || isset($_GET["azuriraj"])){
	
	
	if(isset($_GET["azuriraj"])){
		$gumb="Ažuriranje postojećeg obrta";
		$obid=$_GET["azuriraj"];
		
		$sql="select * from obrt where obrt_id = ".$obid;
		$ex = izvrsiBP($sql);
		
		list($obrtid,$moderator,$naziv,$opis,$kontakt_info,$certificiran)=mysqli_fetch_array($ex);
		
	}
	else
	{
		$obrtid=0;
		$naziv="";
		$opis="";
		$moderator=0;
		$kontakt_info="";
		$gumb="Unos novog obrta";
	}
	
	?>
		<form action="moderatorobrt.php" method="POST" class="storeinfo">
				<input type="hidden" name="obrtid" id="obrtid" value="<?php echo $obrtid; ?>"/>
				<?php
				if($aktivni_korisnik_tip==0){
					?>
				<label for="moderatori">Moderatori:</label>
				<select name="moderator" id="moderator">
						<?php
						$sql="select korisnik_id, ime, prezime from korisnik where tip_id = 1 and korisnik_id not in (select moderator_id from obrt) union all 
						select korisnik_id, ime, prezime from korisnik where tip_id = 1 and korisnik_id = (select moderator_id from obrt where obrt_id = ".$obrtid.")";
						$rsmod=izvrsiBP($sql);
						if(mysqli_num_rows($rsmod)>0){
							while(list($id,$ime,$prezime)=mysqli_fetch_array($rsmod)){
								
								echo "<option value='$id'";
									if($moderator==$id){
										echo " selected";
									}
								echo ">$ime $prezime</option>";
							}
						}
						else
						{
							echo "<option value='0'>Nema slobodnih moderatora</option>";
						}
					?>
				</select>					
				<?php	
				}
				
				?>
					<label for="naziv">Naziv:</label>
					<input type="text" name="naziv" id="naziv" value="<?php echo $naziv; ?>"/>				
					<label for="opis">Opis:</label>
					<textarea name="opis" id="opis" cols="30" rows="10"><?php echo $opis; ?></textarea>
					<label for="kontakt">Konakt informacije:</label>
					<textarea name="kontaktinfo" id="kontaktinfo" cols="30" rows="10"><?php echo $kontakt_info; ?></textarea>					
					<input type="submit" name="ObrtUnos" value="<?php echo $gumb; ?>">
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
		
		if(isset($_POST["ObrtUnos"])){
	
				$obrtid = $_POST["obrtid"];
				$naziv = $_POST["naziv"];
				$opis = $_POST["opis"];
				$moderator = $_POST["moderator"];
				if($moderator>0){
					$aktivni_korisnik_id=$moderator;
				}
				$kontaktinfo = $_POST["kontaktinfo"];
				
				if(empty($naziv) || empty($opis) || empty($kontaktinfo) || $moderator==0){
					$_SESSION["valid"]="Niste unijeli sva obavezna polja!";
					header("Location: moderatorobrt.php?dodajnovi=0");
					return false;
				}
				
				if($obrtid==0){
					$sql = "insert into obrt (moderator_id,naziv,opis,kontakt_informacije,certificiran) values (\"$aktivni_korisnik_id\",\"$naziv\",\"$opis\",\"$kontaktinfo\",0)";
					$ex=izvrsiBP($sql);
					$_SESSION["aktivni_korisnik_obrtid"]=mysqli_insert_id($kon);	
					$_SESSION["aktivni_korisnik_obrtnaziv"]=$naziv;	
				}
				else
				{
					$sql = "update obrt set  naziv=\"$naziv\", opis=\"$opis\", kontakt_informacije=\"$kontaktinfo\" where obrt_id=".$obrtid;
					$ex=izvrsiBP($sql);
				}
				
				header("Location: moderatorproizvodi.php");
		}
		
		
		echo "<p><a href='javascript:history.back(-1)'>Natrag</a></p>";
			?>
			
			
		</div>
	</div>
<?php require("podnozje.php"); ?>