<?php
use model\School;

$filepath="../data/";

$namef=basename($_FILES['uploaded_SYGBUSS']['name']);

$filepath.=$namef;

if(move_uploaded_file($_FILES['uploaded_SYGBUSS']['tmp_name'], $filepath))
{
    //header("location:upload_donnee1.php?namef=$namef");
    $matriculeetab=$_GET["matri"];
    $school = new School($matriculeetab);
    $school->setMiseajourdejafaite("oui");
}
else
{
    echo "TRANSFERT ECHOUE";
}

