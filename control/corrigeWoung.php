<?php
use model\Evaluation;

include_once '../model/Evaluation.php';

$cs = simplexml_load_file("../data/datatoloadWoung.xml");

$matriculeEtab="LSWEBA00010";
foreach ($cs->listeCompetence as $listeCompetence) {
    foreach ($listeCompetence->competenceProf as $competence) {
       $codeperso=$competence->codeperso;
       $codeclasse=$competence->codeclasse;
       $codematiere=$competence->codematiere;
       $comp=addslashes($competence->competence);
       $trimestre=$competence->trimestre;
       $nombrenotes=$competence->nombrenotes;
       $nomannee=$competence->nomannee;

       $rep=Evaluation::insertCompetence($codeperso, $codeclasse, $codematiere, $comp, $trimestre, $nombrenotes, $nomannee, $matriculeEtab);
        echo "reponse : $rep <br>";
    }
}

