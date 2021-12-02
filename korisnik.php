<?php require("zaglavlje.php"); ?>
		<div>
		<?php
		otvoriBP();			
		echo "<h3>Administracija korisnika</h3>";

		if(isset($_GET["korisnik"]) || isset($_GET["novi"])){
	
			if(isset($_GET["korisnik"])){					
				$id=$_GET["korisnik"];
				$sql="select * from korisnik where korisnik_id=".$id;
				$obradi=izvrsiBP($sql);
				list($idkor, $tip, $korime,$lozinka,$ime,$prezime,$email, $slika) = mysqli_fetch_array($obradi);
			}
			else
			{

				$idkor=0;
				$tip=2;
				$korime="";
				$lozinka="";
				$ime="";
				$prezime="";
				$email="";
				$slika="";
				$trenstr=1;
				
			}

	?>
		<form action="korisnik.php" method="POST" class="storeinfo" id="korisnik"  enctype="multipart/form-data">
					<input type="hidden" name="korisnikid" id="korisnikid" value="<?php echo $idkor; ?>">
					<input type="hidden" name="slikahidden" id="slikahidden" value="<?php echo $slika; ?>"/>
					<label>Tip korisnika</label>
					<select name="tip" id="tip">
					<?php
					$tipovi="select tip_id, naziv from tip_korisnika";
					$rs=izvrsiBP($tipovi);
					
					while(list($id,$naziv)=mysqli_fetch_array($rs)){

						echo "<option value=\"$id\"";
						if($tip==$id){
							echo " selected";
						}
						echo ">$naziv</option>";
					}
					?>
				</select>
					<label>Korisničko ime</label>
					<input type="text" name="korime" id="korime" value="<?php echo $korime; ?>" <?php if($idkor>0){ echo " readonly"; } ?>>
					<label>Ime</label>
					<input type="text" name="ime" id="ime" value="<?php echo $ime; ?>">
					<label>Prezime</label>
					<input type="text" name="prezime" id="prezime" value="<?php echo $prezime; ?>">
					<label>Lozinka</label>
					<input type="text" name="lozinka" id="lozinka" value="<?php echo $lozinka; ?>">
					<label>Email</label>
					<input type="text" name="email" id="email" value="<?php echo $email; ?>">	
					<label>Slika</label>
					<input type="file" name="slika" id="slika">					
					<input type="submit" name="KorisnikUnos" value="Potvrdi unos">
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


	if(isset($_POST['KorisnikUnos'])) {
			$id = $_POST['korisnikid'];					
			$korime = $_POST['korime'];							
			$ime = $_POST['ime'];
			$prezime = $_POST['prezime'];
			$lozinka = $_POST['lozinka'];
			$email = $_POST['email'];
			$tip = $_POST['tip'];
			
				if(empty($korime) || empty($ime) || empty($prezime) || empty($lozinka) || empty($email)){
					$_SESSION["valid"]="Niste unijeli sva obavezna polja!";
					header("Location: korisnik.php?novi=0");
					return false;
				}

			$postojeca = $_POST['slikahidden'];

			$mjesto = "korisnici/";	

			$ime_dat = basename($_FILES['slika']['name']);

			if($ime_dat != ""){
			$slika = $mjesto.$ime_dat;	
			$stavi = move_uploaded_file($_FILES['slika']['tmp_name'],$slika);
			}
			else
			{
				if($postojeca != ""){
					$slika = $postojeca;
				}
				else
				{
					$slika = "korisnici/nophoto.jpg";
				}						
			}
								
			if ($id == 0) {					
				$sql = "INSERT INTO korisnik (tip_id, korisnicko_ime, lozinka, ime, prezime, email, slika)
				VALUES ($tip, '$korime', '$lozinka', '$ime', '$prezime', '$email', '$slika')";
			} else {
				$sql = "UPDATE korisnik SET ime='$ime',prezime='$prezime',lozinka='$lozinka',email = '$email',tip_id = '$tip',slika = '$slika' 
				WHERE korisnik_id = '$id'";
			}
			$izvrsi = izvrsiBP($sql);
			header("Location: korisnici.php");					
			}
		
		
			?>
			
			
		</div>
	</div>
<?php require("podnozje.php"); ?>