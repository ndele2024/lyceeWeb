<?php
if ($_SESSION['access']!="oui") {header("Location:../index_login.php");}
 function addslashes1($entrer)
 {
	$rech=array("'",'"');
	$n=count($rech);
	$mat=array();
	for ($i=0;$i<$n;$i++)
	{
		//echo "$rech[$i]<br>";
	//	$test=str_replace($rech[$i],"'\\'.$rech[$i]",$entrer);
		$mat=explode($rech[$i],$entrer);
		$nn=count($mat);
		if($nn>1)
		{
			$com="'".$rech[$i];
			$entrer=implode($com,$mat);
		}
	}
	return $entrer;
 }
 