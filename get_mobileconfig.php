<?php
$origin_file = "device.mobileconfig";
$signed_file = "device-signed.mobileconfig";

/**
 * sign mobileconfig
 * https://stackoverflow.com/questions/31575019/sign-mobileconfig-on-a-php-server
 */
exec("openssl smime -sign -signer /etc/letsencrypt/live/tanghengzhi.com/cert.pem -inkey /etc/letsencrypt/live/tanghengzhi.com/privkey.pem -certfile /etc/letsencrypt/live/tanghengzhi.com/fullchain.pem -nodetach -outform der -in {$origin_file} -out {$signed_file}");

if( file_exists($signed_file) ) {
	$file = fopen($signed_file, "r");
	if ($file === false) {
		echo "Unable to open file!";
		die;
	}
	header("Content-type: application/x-apple-aspen-config; chatset=utf-8");
	header("Content-Disposition: attachment; filename=\"{$signed_file}\"");
	echo fread($file,filesize($signed_file));
}else{
	echo "File Not Found.";
	die;
}