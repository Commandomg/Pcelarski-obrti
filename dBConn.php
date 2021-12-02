<?php

$vel_str = 5;

$kon=null;
function otvoriBP() {
global $kon;
	$kon = mysqli_connect('localhost', 'iwa_2019', 'foi2019','iwa_2019_sk_projekt');
	if(!$kon){
		die("Greška kod spajanja na bazu <strong>iwa_2019_sk_projekt</strong>: ".mysqli_connect_error());
	}

    $setutf=mysqli_set_charset($kon,"utf8");
    return $kon;
}


function izvrsiBP($sql) {
	global $kon;
	$rs = mysqli_query($kon,$sql);
	if(!$rs) {
		die("Greška kod izvršavanja <strong>mysql upita</strong>: ".mysqli_error($kon));
	}
	return $rs;
}
	
function zatvoriBP(){
	global $kon;
	if(is_resource($kon)){
	mysqli_close($kon);
	}
}


function PopisSvihObrta(){
	
	$sql = "select obrt_id, naziv from obrt";
	$ex = izvrsiBP($sql);
	$sviobrti = [];
	while(list($id,$naziv)=mysqli_fetch_row($ex)){
		
		$sviobrti[$id]=$naziv;
	}
	
	return $sviobrti;
}

function PopisSvihCertificiranihObrta(){
	
	$sql = "select obrt_id, naziv from obrt where certificiran = 1";
	$ex = izvrsiBP($sql);
	$sviobrti = [];
	while(list($id,$naziv)=mysqli_fetch_row($ex)){
		
		$sviobrti[$id]=$naziv;
	}
	
	return $sviobrti;
}

function PopisSvihProizvoda(){
	
	$sql = "select proizvod_id, naziv from proizvod";
	$ex = izvrsiBP($sql);
	$sviproizvodi = [];
	while(list($id,$naziv)=mysqli_fetch_row($ex)){
		
		$sviproizvodi[$id]=$naziv;
	}
	
	return $sviproizvodi;
}


function OcjenjenProizvod($korid,$proizvodid){
	
	$sql = "select * from ocjena where korisnik_id=".$korid." and proizvod_id=".$proizvodid;
	$ex = izvrsiBP($sql);

	return mysqli_num_rows($ex);
}

?>