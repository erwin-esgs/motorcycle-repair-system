<?php
	function switchstatus($value){
		switch($value){
			case 1 : return "Baru"; break;
			case 2 : return "Dikerjakan"; break;
			case 3 : return "Konf.Admin"; break;
			case 4 : return "Selesai"; break;
			default : return "Ditolak";break;
		}
	}
	
	function serviceType($value){
		switch($value){
			case 1 : return "Ringan"; break;
			case 2 : return "Sedang"; break;
			case 3 : return "Berat"; break;
		}
	}
	
	function servicePrice($value){
		switch($value){
			case 1 : return 30000; break;
			case 2 : return 50000; break;
			case 3 : return 150000; break;
		}
	}
?>