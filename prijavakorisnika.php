<?php
require("dBConn.php");

if(session_id()==""){
session_start();	
}
otvoriBP();
	if(isset($_POST["UserLogin"])){

		$korisnickoime=$_POST["korisnickoime"]; 
		$lozinka=$_POST["lozinka"];

		if(!empty($korisnickoime) && !empty($lozinka)){
			$sql="SELECT 
			k.korisnik_id,
			k.tip_id,
			k.korisnicko_ime,
			k.ime,
			k.prezime,
			k.slika,
			tk.naziv 
			FROM korisnik k inner join tip_korisnika tk on 
			k.tip_id = tk.tip_id 
			WHERE k.korisnicko_ime='$korisnickoime' AND k.lozinka='$lozinka'";
			$rs = izvrsiBP($sql);
			if(mysqli_num_rows($rs)>0){
				
				list($idkor,$idtip,$korime,$ime,$prezime,$slika,$nazivtip)=mysqli_fetch_row($rs);
				
				$_SESSION["aktivni_korisnik"]=$korime;
				$_SESSION["aktivni_korisnik_ime"]=$ime." ".$prezime;
				$_SESSION["aktivni_korisnik_id"]=$idkor;
				$_SESSION["aktivni_korisnik_tip"]=$idtip;
				$_SESSION["aktivni_korisnik_slika"]=$slika;
				$_SESSION["aktivni_korisnik_tipnaziv"]=$nazivtip;										
				$_SESSION["logiran"]=true;										
				
				
				if($idtip==1){
					$sql2 = "select obrt_id,naziv,certificiran from obrt where moderator_id=".$idkor;
					$rs2 = izvrsiBP($sql2);
					
					if(mysqli_num_rows($rs2)>0){
						list($obrtid,$obrtnaziv,$certificiran)=mysqli_fetch_row($rs2);
						$_SESSION["aktivni_korisnik_obrtid"]=$obrtid;	
						$_SESSION["aktivni_korisnik_obrtnaziv"]=$obrtnaziv;	
						$_SESSION["aktivni_korisnik_obrtcertificiran"]=$certificiran;	
					}
					else
					{
						$_SESSION["aktivni_korisnik_obrtid"]=0;	
						$_SESSION["aktivni_korisnik_obrtnaziv"]="";							
						$_SESSION["aktivni_korisnik_obrtcertificiran"]=2;							
					}
				}
			}
			else
			{
				setcookie("OBAVIJEST","Neispravni podaci za prijavu!",time()+1);
				header("Location: index.php");
				exit();
			}
			zatvoriBP();
		}
		else
		{
				setcookie("OBAVIJEST","Niste unijeli nikakve podatke!",time()+1);
				header("Location: index.php");
		}
		zatvoriBP();
		header("Location:index.php");
	} 
?>