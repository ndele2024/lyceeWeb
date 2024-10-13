<?php
//sélection de la séquence active
$numerosequence=$sequence->getNumtrim();
$annesco=$sequence->getNomannee();
$matriculeEtab=$prof->getEtab()->getMatriculeetab();
//sélection des classes enseignées par l'enseignant
$tabclasseProf=$prof->getClasseProf($annesco);
$nbreClasse=count($tabclasseProf);
$rr=0; $tabstat1=array();
for ($i=1; $i<=$nbreClasse; $i++)
{
    $pp=$i-1;
    $classe=$tabclasseProf[$pp];
    $tabmatiereProf=$prof->getMatiereProf($classe, $annesco);
    $nbreMatiere=count($tabmatiereProf);
    for ($j=0; $j<$nbreMatiere; $j++)
    {
        //$ligne4=pg_fetch_array($result4,$pp,PGSQL_NUM);
        $codemat=$tabmatiereProf[$j][0];
        $nommat=$tabmatiereProf[$j][1];
        $req5="select * from statfait where (codeclasse='$classe')AND(numeroseq='$numerosequence')AND (codematiere='$codemat')AND(nomannee='$annesco')AND(matriculeetab='$matriculeEtab')";
        $st=$prof->executeReq($req5, array(), "verifnoteaccueil.php", 0, 1);
        //$res5=pg_query($idcom,$req5);
        //$st=pg_num_rows($res5);
        if($st==0){$tabstat[$rr]=$classe; $tabstat1[$rr]=$codemat; $rr++;}
        $requette6="SELECT matricule from eleve where (codeclasse='$classe')AND (nomannee='$annesco')AND(matriculeetab='$matriculeEtab')";
        $d = $prof->executeReq($requette6, array(), "verifnoteaccueil.php", 0, 1);
        $tt=0;
        $tabi=array();
        //sélection des matières enseignées par l'enseignant dans chaque classe
        $reqc="SELECT nombrenotes FROM competences WHERE (codematiere='$codemat') AND (codeclasse='$classe') AND (trimestre='$numerosequence') AND (nomannee='$annesco')AND(matriculeetab='$matriculeEtab')";
        $lc = $prof->executeReq($reqc, array(), "verifnoteaccueil.php", 0, 0);
        $nnc = count($lc);
        for ($ei=1; $ei<=$d; $ei++)
        {
            if(($lc[0]["nombrenotes"]==0)OR($nnc==0))
            {
                $ndv=1;
            }
            elseif($lc[0]["nombrenotes"]==1)
            {
                $ndv=2;
            }
            else
            {
                $ndv=2;
            }
            $requette5="SELECT evaluation.matricule, Codeclasse, codematiere, numeroseq, note FROM eleve, evaluation where ((eleve.matricule=evaluation.matricule)AND(evaluation.codematiere='$codemat')AND(numeroseq='$numerosequence')AND(eleve.Codeclasse='$classe')AND(evaluation.nomannee='$annesco')AND(eleve.nomannee='$annesco')AND(eleve.matriculeetab='$matriculeEtab')AND(evaluation.matriculeetab='$matriculeEtab')AND(eleve.numero='$ei')AND(numerodevoir='$ndv'))";
            $c = $prof->executeReq($requette5, array(), "verifnoteaccueil.php", 0, 1);
            if ($c==0)
            {
                $tabi[$tt]=$ei;
                $tt++;
            }
        }
        
        $r1=utf8_decode($classe);
        $r2=utf8_decode($nommat);
        //affichage des informations
        $nbei=count($tabi);
        if($ndv==1)
        {
            if($nbei==$d)
            {
                echo "<span class=\"rouge\">$cont[2] 1 $te1 2 $te2 $r2 $cont[3] $r1</span><br />";
            }
            elseif(($nbei>0)and($nbei<$d))
            {
                echo "<span class=\"bleu\">$cont[4] &nbsp;";
                //$o=$d-$c;
                foreach ($tabi as $kl)
                {
                    //$num=$c+$k;
                    echo $kl." , &nbsp;";
                }
                echo " EN $r2 $r1 $te3 1</span><br />";
                
            }
            else
            {echo "<span class=\"bleu\">$cont[5]: EVALUATION 1 $r2 $cont[3] $r1 $te4 2</span><br />";} //UTILISER PLUTOT UN TABLEAU
        }
        else
        {
            if($nbei==$d)
            {
                echo "<span class=\"bleu\">$cont[5]: EVALUATION 1 $r2 $cont[3] $r1 $te4 2</span><br />";
            }
            elseif(($nbei>0)and($nbei<$d))
            {
                echo "<span class=\"bleu\">$cont[4] &nbsp;";
                //$o=$d-$c;
                foreach ($tabi as $kl)
                {
                    //$num=$c+$k;
                    echo $kl." , &nbsp;";
                }
                echo " EN $r2 $r1 $te3 2</span><br />";
                
            }
            else
            {echo "<span class=\"\">$cont[5]: EVALUATION 1 $te1 2 $r2 $cont[3] $r1</span>";} //UTILISER PLUTOT UN TABLEAU
        }
        
    }
}

