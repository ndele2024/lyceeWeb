<?php
$filepath="../data/";

$namef=basename($_FILES['uploaded_SYGBUSS']['name']);

$filepath.=$namef;

if(move_uploaded_file($_FILES['uploaded_SYGBUSS']['tmp_name'], $filepath))
{
	//header("location:upload_donnee1.php?namef=$namef");
	exec("sudo php -f lireXML_and.php $namef");
}
else
{
	echo "TRANSFERT ECHOUE";
}

