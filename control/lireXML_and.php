<?php
use model\Sequences;
use model\Classe;
use model\Matiere;
use model\Evaluation;
use model\Eleve;
use model\Teacher;
use model\Statfait;
use model\StatPrevue;

include_once '../model/Eleve.php';
include_once '../model/Evaluation.php';
include_once '../model/Matiere.php';
include_once '../model/Classe.php';
include_once '../model/Statfait.php';
include_once '../model/StatPrevue.php';
include_once '../model/Sequences.php';
include_once 'fonction_cypher.php';

//récupération tu fichier$filepath="../data/";
$filepath="../data/";
$namef=basename($_FILES['uploaded_SYGBUSS']['name']);

$filepath.=$namef;

if(move_uploaded_file($_FILES['uploaded_SYGBUSS']['tmp_name'], $filepath))
{
    $input="../data/datatoload.ry";
    $output="../data/datatoload.xml";
    decrypte($input, $output);
    $cs = simplexml_load_file('../data/datatoload.xml');
    
    $matriculeEtab="";
    $annee="";
    $numtrim="";
    
    foreach ($cs->etablissement as $etab) {
        $matriculeEtab=$etab->matriculeetab;
    }
    
    foreach ($cs->sequences as $seq) {
        $numtrim=$seq->numtrim;
        $annee=$seq->nomannee;
    }
    
    //suppression des dnnées de l'établissement
    
    Classe::deleteClasse($annee, $matriculeEtab);
    Classe::deleteClassemat($annee, $matriculeEtab);
    Matiere::deleteMatiere($matriculeEtab);
    Evaluation::deleteCompetence($annee, $matriculeEtab, $numtrim);
    Eleve::deleteEleve($annee, $matriculeEtab);
    Teacher::deleteEseignement($annee, $matriculeEtab);
    Evaluation::deleteEvaluation($annee, $matriculeEtab, $numtrim);
    Matiere::deleteDepart($matriculeEtab);
    Matiere::deleteSection($matriculeEtab);
    Matiere::deleteSerie($matriculeEtab);
    Teacher::deleteProf($matriculeEtab);
    Sequences::deleteSequences($matriculeEtab, $numtrim, $annee);
    Statfait::deleteStatfait($annee, $matriculeEtab, $numtrim);
    StatPrevue::deleteStatPrevue($annee, $matriculeEtab);
    
    $tabdonneXML=array(0,0,0,0,0,0,0,0,0,0,0); //(classe,matiere,serie,departement,personnel,eleve,coursClasse,CoursProf,statPrevue,matriculeetab,annee)
    $tabuserModif=array();
    
    
    foreach ($cs->sequences as $seq) {
        $numtrim=$seq->numtrim;
        $numtrim=intval($numtrim->__toString());
        $annee=$seq->nomannee;
        $statafternote=$seq->statafternote;
        $tabdonneXML[10]=(string) $annee;
        $datelimit=NULL;
        Sequences::insertDonneeSequence($numtrim, $annee, $statafternote, $matriculeEtab, $datelimit);
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
            Classe::insertDoneeClasse($codeclasse, $nomclasse, $niveau, $cycles, $serie, $statut, $annee, $sectionc, $matriculeEtab);
        }
    }
    
    foreach ($cs->listematiere as $listematiere) {
        foreach ($listematiere->matiere as $matiere) {
            $tabdonneXML[1]++;
            Matiere::insertDonneeMatiere($matiere->codematiere, $matiere->nommatiere, $matiere->sectionm, $matiere->typem, $matiere->departement, $matriculeEtab);
        }
    }
    
    
    foreach ($cs->listeserie as $listeserie) {
        foreach ($listeserie->serie as $serie) {
            $tabdonneXML[2]++;
            Matiere::insertDonneeSerie($serie->numserie, $serie->codeserie, $serie->sectiont, $matriculeEtab);
        }
    }
    
    foreach ($cs->listedepart as $listedepart) {
        foreach ($listedepart->departement as $departement) {
            $tabdonneXML[3]++;
            Matiere::insertDonneeDepart($departement->num, $departement->nomdepartement, $matriculeEtab);
        }
    }
    
    foreach ($cs->listepersonnel as $listepersonnel) {
        foreach ($listepersonnel->personnel as $personnel) {
            $username= (string) $personnel->username;
            $test=Teacher::isNotUniqueUser($username, $matriculeEtab);
            while($test) {
                $username=$username."1";
                $test=Teacher::isNotUniqueUser($username, $matriculeEtab);
            }
            if ($username!=$personnel->username) {
                $tabuserModif[]=array($personnel->nomperso, $username);
            }
            $tabdonneXML[4]++;
            $nomperso = addslashes($personnel->nomperso);
            $codeperso=(string) $personnel->codeperso;
            $codeperso=$codeperso."%%".$matriculeEtab;
            Teacher::insererDonneeProf($codeperso, $nomperso, $personnel->sexe, $personnel->fonction, $personnel->username, $personnel->password, $personnel->sauvegarder_base, $personnel->infotel, $personnel->email, $personnel->ap, $personnel->departement, $matriculeEtab, $personnel->langue, $personnel->contact);
        }
    }
    
    foreach ($cs->listeeleve as $listeeleve) {
        foreach ($listeeleve->eleve as $eleve) {
            $tabdonneXML[5]++;
            $nomEleve = addslashes($eleve->nomeleve);
            Eleve::insererDoneeEleve($eleve->matricule, $eleve->numero, $nomEleve, $eleve->sexe, $eleve->datenaiss, $eleve->lieunaiss, $eleve->codeclasse, $eleve->redoublant, $eleve->numparent, $eleve->nomannee, '', $matriculeEtab);
        }
    }
    
    foreach ($cs->listecours as $listecours) {
        foreach ($listecours->cours as $cours) {
            $tabdonneXML[6]++;
            Classe::insertDoneeClassemat($cours->codeclasse, $cours->codematiere, $cours->coeficient, $cours->nomannee, $cours->matiereopt, $matriculeEtab);
        }
    }
    
    foreach ($cs->listeenseignement as $listeenseignement) {
        foreach ($listeenseignement->enseignement as $enseignement) {
            $tabdonneXML[7]++;
            $codeperso=(string) $enseignement->codeprof;
            $codeperso=$codeperso."%%".$matriculeEtab;
            Teacher::insererDonneeEnseignement($enseignement->nomannee, $enseignement->codeclasse, $enseignement->codematiere, $codeperso, $enseignement->modifier_note, $enseignement->duree, $enseignement->verifModifier, $matriculeEtab);
        }
    }
    
    foreach ($cs->statprevue as $statprevue) {
        foreach ($statprevue->stat as $stat) {
            $tabdonneXML[8]++;
            StatPrevue::insererDonneeStatPrevue($stat->nomannee, $stat->codeclasse, $stat->codematiere, $stat->numeroseq, $stat->leconpt, $stat->leconpp, $stat->heurep, $matriculeEtab);
        }
    }
    
    //$_SESSION["donneexml"]=$tabdonneXML;
    //$_SESSION["usermodif"]=$tabuserModif;
    /*$tabdonnebase=array(Classe::getNombreclasse($tabdonneXML[9], $tabdonneXML[10]),
     Matiere::getNombreMatiere($tabdonneXML[9]),
     Matiere::getNobreSerie($tabdonneXML[9]),
     Matiere::getNombreDepart($tabdonneXML[9]),
     Teacher::getNombreProf($tabdonneXML[9]),
     Eleve::getNombreEleve($tabdonneXML[10], $tabdonneXML[9]),
     Classe::getNombreCour($tabdonneXML[9], $tabdonneXML[10]),
     Teacher::getNombreCour($tabdonneXML[10], $tabdonneXML[9]),
     StatPrevue::getnobreStat($tabdonneXML[10], $tabdonneXML[9])
     );*/
    $idf=fopen("../data/rep_webdata_$matriculeEtab", "w+");
    fwrite($idf, "1");
    fclose($idf);
}
else {
    $idf=fopen("../data/rep_webdata_$matriculeEtab", "w+");
    fwrite($idf, "E001");
    fclose($idf);
}



