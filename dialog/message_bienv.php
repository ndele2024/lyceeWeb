<?php
$annesco=$sequence->getNomannee();
$datelimite=$sequence->getDatelimite();
if(!empty($datelimite)) {
    $timejour=time();
    $par=explode("-", $datelimite);
    $timelimit=mktime(0,0,0,$par[1],$par[2],$par[0]);
    if($timelimit<$timejour) {
        $jourRestant=0;
        $_SESSION["jourRestatnt"]=$jourRestant;
    }
    else {
        $jourRestant=($timelimit-$timejour)/(3600*24);
        $jourRestant=ceil($jourRestant);
    }
    if ($langue=="F") {
        $msgnote="Date limite $jourRestant jours restants";
    }
    else {
        $msgnote="Limit date $jourRestant days remaining";
    }
}
else {
    $msgnote="";
}

if ($langue=="F")
{
	echo "<h4 class='msgbienv'>Année scolaire : $annesco Trimestre ".$sequence->getNumtrim()." &nbsp;&nbsp;&nbsp; $msgnote </h4>";
}
else
{
    echo "<h4 class='msgbienv'>School year : $annesco Trimestre ".$sequence->getNumtrim()." &nbsp;&nbsp;&nbsp; $msgnote </h4>";
}

?>