<?php

use model\Evaluation;
use model\Statfait;
use model\StatPrevue;
use model\Teacher;
use model\Absence;

@session_start();

include_once '../model/Evaluation.php';
include_once '../model/Statfait.php';
include_once '../model/StatPrevue.php';
include_once '../model/Teacher.php';
include_once '../model/Sequences.php';
include_once '../model/Absence.php';

include_once '../control/fonction_cypher.php';

$prof = unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);
$matetab=$sequence->getMatriculeetab();

$xml=new XMLWriter();
$xml->openUri("../data/donneesWebToLocalSygbuss$matetab.xml");
$id=1;
$xml->setIndent(true);
$xml->startElement("lycee");
$xml->writeAttribute("id", $id);

//selection donne etablissement
$id++;
$xml->startElement("etablissement");
$xml->writeAttribute("id", $id);
$xml->writeElement("matriculeetab", $sequence->getMatriculeetab());
$xml->writeElement("nomannee", $sequence->getNomannee());
$xml->endElement();

//données évaluation
$id++;
$xml->startElement("listeEvaluation");
$xml->writeAttribute("id", $id);
$tabeval=Evaluation::getAllEvaluation($sequence->getNomannee(), $sequence->getMatriculeetab());
$id++;
for ($i = 0; $i < count($tabeval); $i++) {
    $xml->startElement("evaluation");
    $xml->writeAttribute("id", $id);
    $xml->writeElement("nomannee", $tabeval[$i][0]);
    $xml->writeElement("matricule", $tabeval[$i][1]);
    $xml->writeElement("codematiere", $tabeval[$i][2]);
    $xml->writeElement("numeroseq", $tabeval[$i][3]);
    $xml->writeElement("note", $tabeval[$i][4]);
    $xml->writeElement("appreciation", $tabeval[$i][5]);
    $xml->writeElement("numerodevoir", $tabeval[$i][6]);
    $xml->endElement();
    $id++;
}
$xml->endElement();

//données compétences
$xml->startElement("listeCompetence");
$xml->writeAttribute("id", $id);
$tabcomp=Evaluation::getAllDonneeCompetence($sequence->getNomannee(), $sequence->getMatriculeetab());
$id++;
for ($i = 0; $i < count($tabcomp); $i++) {
    $xml->startElement("competenceProf");
    $xml->writeAttribute("id", $id);
    $xml->writeElement("codeperso", explode("%%", $tabcomp[$i][0])[0]);
    $xml->writeElement("codeclasse", $tabcomp[$i][1]);
    $xml->writeElement("codematiere", $tabcomp[$i][2]);
    $xml->writeElement("competence", $tabcomp[$i][3]);
    $xml->writeElement("trimestre", $tabcomp[$i][4]);
    $xml->writeElement("nombrenotes", $tabcomp[$i][5]);
    $xml->writeElement("nomannee", $tabcomp[$i][6]);
    $xml->endElement();
    $id++;
}
$xml->endElement();

//données stat fait
$xml->startElement("listeStatfait");
$xml->writeAttribute("id", $id);
$tabstatfait=Statfait::getAllStatfait($sequence->getNomannee(), $sequence->getMatriculeetab());
$id++;
for ($i = 0; $i < count($tabstatfait); $i++) {
    $xml->startElement("statfait");
    $xml->writeAttribute("id", $id);
    $xml->writeElement("nomannee", $tabstatfait[$i][0]);
    $xml->writeElement("codeclasse", $tabstatfait[$i][1]);
    $xml->writeElement("codematiere", $tabstatfait[$i][2]);
    $xml->writeElement("numeroseq", $tabstatfait[$i][3]);
    $xml->writeElement("codeperso", explode("%%", $tabstatfait[$i][4])[0]);
    $xml->writeElement("lecontheof", $tabstatfait[$i][5]);
    $xml->writeElement("leconpraf", $tabstatfait[$i][6]);
    $xml->writeElement("heuref", $tabstatfait[$i][7]);
    $xml->writeElement("nhad", $tabstatfait[$i][8]);
    $xml->endElement();
    $id++;
}
$xml->endElement();

//données stat prevu
$xml->startElement("listeStatprevu");
$xml->writeAttribute("id", $id);
$tabstatprevu=StatPrevue::getAllStatPrevue($sequence->getNomannee(), $sequence->getMatriculeetab());
$id++;
for ($i = 0; $i < count($tabstatprevu); $i++) {
    $xml->startElement("statprevu");
    $xml->writeAttribute("id", $id);
    $xml->writeElement("nomannee", $tabstatprevu[$i][0]);
    $xml->writeElement("codeclasse", $tabstatprevu[$i][1]);
    $xml->writeElement("codematiere", $tabstatprevu[$i][2]);
    $xml->writeElement("numeroseq", $tabstatprevu[$i][3]);
    $xml->writeElement("leconpt", $tabstatprevu[$i][4]);
    $xml->writeElement("leconpp", $tabstatprevu[$i][5]);
    $xml->writeElement("heurep", $tabstatprevu[$i][6]);

    $xml->endElement();
    $id++;
}
$xml->endElement();

//données email pesonnel
$xml->startElement("listePersonnel");
$xml->writeAttribute("id", $id);
$tabperso=Teacher::getAllEmailprof($sequence->getMatriculeetab());
$id++;
for ($i = 0; $i < count($tabperso); $i++) {
    $xml->startElement("personnel");
    $xml->writeAttribute("id", $id);
    $xml->writeElement("codepeso", explode("%%", $tabperso[$i][0])[0]);
    $xml->writeElement("email", $tabperso[$i][1]);
    $xml->endElement();
    $id++;
}
$xml->endElement();

//données absence
$xml->startElement("listeAbsence");
$xml->writeAttribute("id", $id);
$tabAbsence = Absence::getAllDonneeAbsence($sequence->getNomannee(), $sequence->getNumtrim(), $sequence->getMatriculeetab());
$id++;
for ($i = 0; $i < count($tabAbsence); $i++) {
    $xml->startElement("absence");
    $xml->writeAttribute("id", $id);
    $xml->writeElement("nomannee", $tabAbsence[$i][0]);
    $xml->writeElement("matricule", $tabAbsence[$i][1]);
    $xml->writeElement("numeroseq", $tabAbsence[$i][2]);
    $xml->writeElement("nbreheure", $tabAbsence[$i][3]);
    $xml->writeElement("jour_exclusion", $tabAbsence[$i][4]);
    $xml->endElement();
    $id++;
}
$xml->endElement();


$xml->endElement();//fin balise lycee
$xml->flush();

$inputFile = "../data/donneesWebToLocalSygbuss$matetab.xml";
$outputFile = "../data/webToLocalSygbuss$matetab.ry";
crypte($inputFile, $outputFile);

header("location:telecharger_donnee_web.php");

