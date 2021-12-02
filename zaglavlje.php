<?php
if(session_id()==""){
session_start();	
}
	$aktivni_korisnik=0;
	$aktivni_korisnik_tip=-1;
	$aktivni_korisnik_id=0;		
	$obrtmodid=0;		
	$obrtmodnaziv="";		
	$certificiran=-1;		
	if(isset($_SESSION['aktivni_korisnik'])){
		$aktivni_korisnik=$_SESSION['aktivni_korisnik'];
		$aktivni_korisnik_id=$_SESSION["aktivni_korisnik_id"];
		$aktivni_korisnik_ime=$_SESSION['aktivni_korisnik_ime'];
		$aktivni_korisnik_tip=$_SESSION['aktivni_korisnik_tip'];
		$aktivni_korisnik_tipnaziv=$_SESSION['aktivni_korisnik_tipnaziv'];
		$aktivni_korisnik_slika=$_SESSION['aktivni_korisnik_slika'];

		if($aktivni_korisnik_tip==1){
			$obrtmodid=$_SESSION["aktivni_korisnik_obrtid"];
			$obrtmodnaziv=$_SESSION["aktivni_korisnik_obrtnaziv"];
			$certificiran=$_SESSION["aktivni_korisnik_obrtcertificiran"];
		}
	}
include("dBConn.php");
$tempFile = basename($_SERVER['SCRIPT_FILENAME']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Pčelarski obrti</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
	<div class="header">
		<div>
			<a href="index.php" id="logo"><img src="images/logo2.png" alt="logo"></a>
			<ul>
				<li <?php if($tempFile=="index.php"){ echo "class=\"selected\"";}?>><a href="index.php">Početna</a></li>
				<?php
				if($aktivni_korisnik_tip==2){
				?>
				<li <?php if($tempFile=="certificiraniobrti.php"){ echo "class=\"selected\"";}?>><a href="certificiraniobrti.php">Obrti</a></li>
				<li <?php if($tempFile=="regkorocijenjeniproizvodi.php"){ echo "class=\"selected\"";}?>><a href="regkorocijenjeniproizvodi.php">Ocjenjeni proizvodi</a></li>
				<?php
				}
				if($aktivni_korisnik_tip==1){
				?>
				<li <?php if($tempFile=="certificiraniobrti.php"){ echo "class=\"selected\"";}?>><a href="certificiraniobrti.php">Obrti</a></li>
				<li <?php if($tempFile=="regkorocijenjeniproizvodi.php"){ echo "class=\"selected\"";}?>><a href="regkorocijenjeniproizvodi.php">Ocjenjeni proizvodi</a></li>
				<?php
				}
				if($aktivni_korisnik_tip==0){
				?>
				<li <?php if($tempFile=="adminobrti.php"){ echo "class=\"selected\"";}?>><a href="adminobrti.php">Obrti</a></li>
				<li <?php if($tempFile=="adminproizvodi.php"){ echo "class=\"selected\"";}?>><a href="adminproizvodi.php">Proizvodi</a></li>
				<li <?php if($tempFile=="korisnici.php"){ echo "class=\"selected\"";}?>><a href="korisnici.php">Korisnici</a></li>
				<?php
				}
				?>
			</ul>
		</div>
	</div>
	<div id="login">
	<label class="korzona">Korisnička zona</label>
	<?php
	 if(!isset($_SESSION['logiran'])){
	 
	 $info="";
	 if(isset($_COOKIE["OBAVIJEST"])){
		 $info=$_COOKIE["OBAVIJEST"];
	 }
	?>
	
	<form action="prijavakorisnika.php" method="POST">
			<input type="text" name="korisnickoime" id="korisnickoime" placeholder="Korisničko ime" value=""> <input type="password" name="lozinka" id="lozinka" placeholder="Lozinka" value=""> 
			<input type="submit" name="UserLogin" value="Prijava" class="submitclass"> <label class="info"><?php echo $info; ?></label>
	</form>
	<?php
  }
  else
  {

	  echo "<label class=\"logiran\">Vi ste: ".$_SESSION['aktivni_korisnik'].", tip: ".$_SESSION['aktivni_korisnik_tipnaziv']." =>";
		if($aktivni_korisnik_tip==1){
			echo " Vaš obrt: ".$obrtmodnaziv." => ";
		}
	   echo "<a href=\"odjavakorisnika.php\">Odjava</a></label>";

  }				  
		  ?>
	</div>
	<div class="content">