<?php
	require("res/config.php");
	include_once("CAS.php");
//	include_once("essential2.php");

	phpCAS::client(CAS_VERSION_2_0,"login.iiit.ac.in",443,"/cas");
	phpCAS::setNoCasServerValidation();
	phpCAS::setExtraCurlOption(CURLOPT_SSLVERSION,1);
	phpCAS::forceAuthentication();

	$email = phpCAS::getUser();
	if(empty($email))
	{
		phpCAS::logout();
	}
	else
	{
	
	$_SESSION['user']=$email;
	$_SESSION['valid']=1;
	$ext=explode("@",$email);
	if($ext=="faculty.iiit.ac.in"){$_SESSION['fac']=1;}else{$_SESSION['fac']=0;}
	header("Location:indextemp.php");
	}

?>
