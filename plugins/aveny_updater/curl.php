<?php

	try{
		$ch = curl_init("http://hagersten.r2d2.atroxhost.com/wp-cron.php");

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
	}
	catch(Exception $e){
		print $e->getMessage();
	}
?>