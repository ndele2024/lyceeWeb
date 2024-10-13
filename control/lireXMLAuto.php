<?php

use model\Sequences;
use model\Classe;
use model\Matiere;
use model\Evaluation;
use model\Eleve;
use model\Teacher;
use model\Statfait;
use model\StatPrevue;

//session_start();

include_once '../model/Eleve.php';
include_once '../model/Evaluation.php';
include_once '../model/Matiere.php';
include_once '../model/Classe.php';
include_once '../model/Statfait.php';
include_once '../model/StatPrevue.php';
include_once '../model/Sequences.php';
include_once 'fonction_cypher.php';

//$sequences=unserialize($_SESSION["sequence"]);

//fichier xml à lire
if(isset($_GET["fichierXml"])) {
    $nomfichier=$_GET["fichierXml"];
    $annee=$_GET["annee"];
    $matriculeEtab=$_GET["matetab"];
    $trimestre=$_GET["trimestre"];
}
else{
    echo"echec";
    exit();
}

//suppression des dnnées de l'établissement
//$annee=$sequences->getNomannee();
//$matriculeEtab=$sequences->getMatriculeetab();

$tabdonneXML=array(0,0,0,0,0,0,0,0,0,0,0); //(classe,matiere,serie,departement,personnel,eleve,coursClasse,CoursProf,statPrevue,matriculeetab,annee)
$tabuserModif=array();

if(file_exists("../data/$nomfichier")){
    $input="../data/$nomfichier";
    $output="../data/datatoload$matriculeEtab.xml";
    decrypte($input, $output);
            
    $cs = simplexml_load_file("../data/datatoload$matriculeEtab.xml");
    foreach ($cs->etablissement as $etab) {
        $matriculeetab=$etab->matriculeetab;
        $matriculeetab=(string) $matriculeetab;
        $tabdonneXML[9]=$matriculeetab;
        $nometab=$etab->nomSchoolFr;
        if(!empty($nometab)){
            //suppression des données
            Classe::deleteClasse($annee, $matriculeEtab);
            Classe::deleteClassemat($annee, $matriculeEtab);
            Matiere::deleteMatiere($matriculeEtab);
            //Evaluation::deleteCompetence($annee, $matriculeEtab, $sequences->getNumtrim());
            Eleve::deleteEleve($annee, $matriculeEtab);
            Teacher::deleteEseignement($annee, $matriculeEtab);
            //Evaluation::deleteEvaluation($annee, $matriculeEtab, $sequences->getNumtrim());
            Matiere::deleteDepart($matriculeEtab);
            Matiere::deleteSection($matriculeEtab);
            Matiere::deleteSerie($matriculeEtab);
            Teacher::deleteProf($matriculeEtab);
            //Sequences::deleteSequences($matriculeEtab, $annee);
            //Statfait::deleteStatfait($annee, $matriculeEtab, $sequences->getNumtrim());
            //StatPrevue::deleteStatPrevue($annee, $matriculeEtab);
        }
        //School::insertDonneeSchool($etab->matriculeetab, $etab->nomSchoolFr, $etab->nomSchoolAng, $etab->email);
    }

    foreach ($cs->sequences as $seq) {
        $numtrim=$seq->numtrim;
        $numtrim=intval($numtrim->__toString());
        $annee=$seq->nomannee;
        $statafternote=$seq->statafternote;
        $tabdonneXML[10]=(string) $annee;
        if((!isset($_SESSION["datelimite"]))) {
            $datelimit=NULL;
        }
        else {
            $datelimit=implode("-", array_reverse(explode("/", $_SESSION["datelimite"])));
        }
        //echo "type de var numtrim ".gettype($numtrim); exit();
        Sequences::insertDonneeSequence($numtrim, $annee, $statafternote, $matriculeetab, $datelimit);
    }

    foreach ($cs->listeclasse as $listeclasse) {
        foreach ($listeclasse->classe as $classe) {
            $tabdonneXML[0]++;
            $codeclasse = $classe->codeclasse;
            $nomclasse = $classe->nomclasse;
            $niveau = (int) $classe->niveau;
            $cycles = (int) $classe->cycles;
            $serie = $classe->serie;
            $statut = $classe->statut;
            $annee = $classe->nomannee;
            $sectionc = $classe->sectionc;
            Classe::insertDoneeClasse($codeclasse, $nomclasse, $niveau, $cycles, $serie, $statut, $annee, $sectionc, $matriculeetab);
        }
    }

    foreach ($cs->listematiere as $listematiere) {
        foreach ($listematiere->matiere as $matiere) {
            $tabdonneXML[1]++;
            Matiere::insertDonneeMatiere($matiere->codematiere, $matiere->nommatiere, $matiere->sectionm, $matiere->typem, $matiere->departement, $matriculeetab);
        }
    }


    foreach ($cs->listeserie as $listeserie) {
        foreach ($listeserie->serie as $serie) {
            $tabdonneXML[2]++;
            Matiere::insertDonneeSerie($serie->numserie, $serie->codeserie, $serie->sectiont, $matriculeetab);
        }
    }

    foreach ($cs->listedepart as $listedepart) {
        foreach ($listedepart->departement as $departement) {
            $tabdonneXML[3]++;
            Matiere::insertDonneeDepart($departement->num, $departement->nomdepartement, $matriculeetab);
        }
    }

    foreach ($cs->listepersonnel as $listepersonnel) {
        foreach ($listepersonnel->personnel as $personnel) {
            $username= (string) $personnel->username;
            $test=Teacher::isNotUniqueUser($username, $matriculeetab);
        while($test) {
                $username=$username."1";
                $test=Teacher::isNotUniqueUser($username, $matriculeetab);
            }
            if ($username!=$personnel->username) {
                $tabuserModif[]=array($personnel->nomperso, $username, $personnel->codeperso);
            }
            $tabdonneXML[4]++;
            $nomperso = addslashes($personnel->nomperso);
            $codeperso=(string) $personnel->codeperso;
            $codeperso=$codeperso."%%".$matriculeetab;
            Teacher::insererDonneeProf($codeperso, $nomperso, $personnel->sexe, $personnel->fonction, $personnel->username, $personnel->password, $personnel->sauvegarder_base, $personnel->infotel, $personnel->email, $personnel->ap, $personnel->departement, $matriculeetab, $personnel->langue, $personnel->contact);
        }
    }

    foreach ($cs->listeeleve as $listeeleve) {
        foreach ($listeeleve->eleve as $eleve) {
            $tabdonneXML[5]++;
            $nomEleve = addslashes($eleve->nomeleve);
            Eleve::insererDoneeEleve($eleve->matricule, $eleve->numero, $nomEleve, $eleve->sexe, $eleve->datenaiss, $eleve->lieunaiss, $eleve->codeclasse, $eleve->redoublant, $eleve->numparent, $eleve->nomannee, '', $matriculeetab);
        }
    }

    foreach ($cs->listecours as $listecours) {
        foreach ($listecours->cours as $cours) {
            $tabdonneXML[6]++;
            Classe::insertDoneeClassemat($cours->codeclasse, $cours->codematiere, $cours->coeficient, $cours->nomannee, $cours->matiereopt, $matriculeetab);
        }
    }

    foreach ($cs->listeenseignement as $listeenseignement) {
        foreach ($listeenseignement->enseignement as $enseignement) {
            $tabdonneXML[7]++;
            $codeperso=(string) $enseignement->codeprof;
            $codeperso=$codeperso."%%".$matriculeetab;
            Teacher::insererDonneeEnseignement($enseignement->nomannee, $enseignement->codeclasse, $enseignement->codematiere, $codeperso, $enseignement->modifier_note, $enseignement->duree, $enseignement->verifModifier, $matriculeetab);
        }
    }

    foreach ($cs->statprevue as $statprevue) {
        foreach ($statprevue->stat as $stat) {
            $tabdonneXML[8]++;
            StatPrevue::insererDonneeStatPrevue($stat->nomannee, $stat->codeclasse, $stat->codematiere, $stat->numeroseq, $stat->leconpt, $stat->leconpp, $stat->heurep, $matriculeetab);
        }
    }

    foreach ($cs->statfait as $statfait) {
        foreach ($statfait->statf as $statf) {
            Statfait::insererDonneeStatfait($statf->nomannee, $statf->codeclasse, $statf->codematiere, $statf->numeroseq, $statf->codeperso, $statf->lecontheof, $statf->leconpraf, $statf->heuref, $statf->nhad, $matriculeetab);
        }
    }
    
    foreach ($cs->listeCompetence as $listeCompetence) {
        foreach ($listeCompetence->competenceProf as $comp) {
            //$tabdonneXML[8]++;
            $textCompetence = addslashes($comp->competence);
           Evaluation::insertCompetence($comp->codeperso, $comp->codeclasse, $comp->codematiere, $textCompetence, $comp->trimestre, $comp->nombrenotes, $comp->nomannee, $matriculeetab);
        }
    }

    foreach ($cs->listeevaluation as $listeevaluation) {
        foreach ($listeevaluation->evaluation as $eval) {
            //$tabdonneXML[8]++;
            Evaluation::insertDonneeEvaluation($eval->nomannee, $eval->matricule, $eval->codematiere, $eval->numeroseq, $eval->note, $eval->appreciation, $eval->numerodevoir, $matriculeEtab);
        }
    }
    

    $tabdonnebase=array(Classe::getNombreclasse($tabdonneXML[9], $tabdonneXML[10]),
        Matiere::getNombreMatiere($tabdonneXML[9]),
        Matiere::getNobreSerie($tabdonneXML[9]),
        Matiere::getNombreDepart($tabdonneXML[9]),
        Teacher::getNombreProf($tabdonneXML[9]),
        Eleve::getNombreEleve($tabdonneXML[10], $tabdonneXML[9]),
        Classe::getNombreCour($tabdonneXML[9], $tabdonneXML[10]),
        Teacher::getNombreCour($tabdonneXML[10], $tabdonneXML[9]),
        StatPrevue::getnobreStat($tabdonneXML[10], $tabdonneXML[9])
    );

    $donneeXml=implode("++", $tabdonneXML);
    $donneeBase=implode("++", $tabdonnebase);
    $idf=fopen("../data/usermodif$matriculeEtab", "w+");
    fwrite($idf, "$donneeXml%+$donneeBase");
    fclose($idf);

    if(count($tabuserModif)>0) {
        $idf=fopen("../data/usermodif$matriculeEtab", "a+");
        $cont="";
        for ($i=0; $i < count($tabuserModif); $i++) {
            if(empty($cont)){
                $cont="%*".$tabuserModif[$i][0]."%".$tabuserModif[$i][1]."%".$tabuserModif[$i][2];
            }
            else{
                $cont.="**".$tabuserModif[$i][0]."%".$tabuserModif[$i][1]."%".$tabuserModif[$i][2];
            }
        }
        fwrite($idf, $cont);
        fclose($idf);
    }

    echo"ok";

}
else {
    echo "echec";
}


