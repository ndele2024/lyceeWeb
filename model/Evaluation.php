<?php
namespace model;

require_once ('Connexion.php');

/**
 *
 * @author ndele
 *        
 */
class Evaluation extends Connexion
{

    /**
     */
    public function __construct()
    {}
    
    public static function verifNoteExist($numtrim, $nomannee, $matriculeetab):bool {
        $req="select * from evaluation where (numeroseq=:numeroseq) and (nomannee=:nomannee) and (matriculeetab=:matriculeetab)";
        $tabp=array("numeroseq"=>$numtrim, "nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        $ne=$con->executeReq($req, $tabp, "Evaluation.php", 0, 1);
        if($ne>0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public static function verifNoteExistEleve($matricule, $numtrim, $numerodevoir, $codematiere, $nomannee, $matriculeetab):bool {
        $req="select * from evaluation where matricule=:matricule and numeroseq=:numeroseq and numerodevoir=:numerodevoir and codematiere=:codematiere and nomannee=:nomannee and matriculeetab=:matriculeetab";
        $tabp=array("matricule"=>$matricule,"codematiere"=>$codematiere,"numerodevoir"=>$numerodevoir,"numeroseq"=>$numtrim, "nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        $ne=$con->executeReq($req, $tabp, "Evaluation.php", 0, 1);
        if($ne>0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function verifNoteMatiereClasse($codematiere, $codeclasse, $numerodevoir, $numtrim, $nomannee, $matriculeetab):bool {
        $req="select * from evaluation where codematiere=:codematiere and numerodevoir=:numerodevoir 
                    and numeroseq=:numeroseq and nomannee=:nomannee 
                    and matriculeetab=:matriculeetab 
                    and matricule in (select matricule from eleve 
                        where codeclasse=:codeclasse and nomannee=:nomannee 
                                and matriculeetab=:matriculeetab)";
        $tabp=array("codematiere"=>$codematiere,"numerodevoir"=>$numerodevoir,"numeroseq"=>$numtrim, "nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab, "codeclasse"=>$codeclasse);
        $ne=$this->executeReq($req, $tabp, "Evaluation.php", 0, 1);
        $req1="select matricule from eleve where codeclasse=:codeclasse and nomannee=:nomannee and matriculeetab=:matriculeetab";
        $tabp1=array("nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab, "codeclasse"=>$codeclasse);
        $ne1=$this->executeReq($req1, $tabp1, "Evaluation.php", 0, 1);
        if($ne==$ne1){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public static function insertDonneeEvaluation($nomannee,$matricule,$codematiere,$numeroseq,$note,$appreciation,$numerodevoir,$matriculeetab) {
        $req="insert into evaluation values
              ('$nomannee','$matricule','$codematiere','$numeroseq','$note','$appreciation','$numerodevoir','$matriculeetab')";
        //$tabp=array("nomannee"=>$nomannee, "matricule"=>$matricule, "codematiere"=>$codematiere, "numeroseq"=>$numeroseq, "note"=>$note, "appreciation"=>$appreciation, "numerodevoir"=>$numerodevoir, "matriculeetab"=>$matriculeetab);
        $tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Evaluation.php", 0, 2);
    }
    
    public static function deleteEvaluation($nomannee, $matriculeetab, $numeroseq) {
        $req="delete from evaluation where nomannee=:nomannee and matriculeetab=:matriculeetab and numeroseq=:numeroseq";
        $tabp=array("nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab, "numeroseq"=>$numeroseq);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Evaluation.php", 0, 2);
    }
    
    public static function getDonneeEvaluation($nomannee,$matricule,$codematiere,$numeroseq,$numerodevoir,$matriculeetab) {
        $req="select matricule, note, appreciation from evaluation where
              matricule=:matricule and numeroseq=:numeroseq and numerodevoir=:numerodevoir 
              and codematiere=:codematiere and nomannee=:nomannee and 
              matriculeetab=:matriculeetab";
        $tabp=array("matricule"=>$matricule,"codematiere"=>$codematiere,"numerodevoir"=>$numerodevoir,"numeroseq"=>$numeroseq, "nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        $tabC = $con->executeReq($req, $tabp, "Evaluation.php", 0, 0);
        if (count($tabC)==0) {
            $tabeval=array();
        }
        else {
            $tabeval=array($tabC[0]["matricule"], $tabC[0]["note"], $tabC[0]["appreciation"]);
        }
        return $tabeval;
    }
    
    public static function updateDonneeEvaluation($note, $apprec, $nomannee,$matricule,$codematiere,$numeroseq,$numerodevoir,$matriculeetab) {
        $req="update evaluation set note=:note, appreciation=:apprec where
              matricule=:matricule and numeroseq=:numeroseq and numerodevoir=:numerodevoir 
              and codematiere=:codematiere and nomannee=:nomannee and 
              matriculeetab=:matriculeetab";
        $tabp=array("note"=>$note, "apprec"=>$apprec, "matricule"=>$matricule,"codematiere"=>$codematiere,"numerodevoir"=>$numerodevoir,"numeroseq"=>$numeroseq, "nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Evaluation.php", 0, 2);
    }
    
    public static function getAllEvaluation($annee, $matriculeetab) {
        $req="select evaluation.nomannee as annee, evaluation.matricule as matri, codematiere, numeroseq, note, appreciation, numerodevoir, numero, codeclasse
                from evaluation, eleve
                where (evaluation.matricule=eleve.matricule)AND(evaluation.nomannee=:annee)
                AND(eleve.nomannee=:annee)AND(evaluation.matriculeetab=:matriculeetab)AND(eleve.matriculeetab=:matriculeetab)
                order by codeclasse,codematiere,numeroseq,numerodevoir,numero";
        $tabp=array("annee"=>$annee, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        $tabC = $con->executeReq($req, $tabp, "Evaluation.php", 0, 0);
        $tabeval=array();
        for ($i = 0; $i < count($tabC); $i++) {
            $tabeval[$i]=array($tabC[$i]["annee"], $tabC[$i]["matri"], $tabC[$i]["codematiere"], $tabC[$i]["numeroseq"], $tabC[$i]["note"], $tabC[$i]["appreciation"], $tabC[$i]["numerodevoir"]);
        }
        return $tabeval;
    }
    
    public static function nombreNoteClasse($codeclasse, $numtrim, $numerodevoir, $codematiere, $nomannee, $matriculeetab):int {
        $req="select * from evaluation where numeroseq=:numeroseq and numerodevoir=:numerodevoir and codematiere=:codematiere and nomannee=:nomannee and matriculeetab=:matriculeetab and matricule in (select matricule from eleve where codeclasse=:codeclasse and nomannee=:nomannee and matriculeetab=:matriculeetab)";
        $tabp=array("codeclasse"=>$codeclasse,"codematiere"=>$codematiere,"numerodevoir"=>$numerodevoir,"numeroseq"=>$numtrim, "nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        $nbnote = $con->executeReq($req, $tabp, "Evaluation.php", 0, 1);
        //print_r($nbnote); exit();
        return $nbnote;
    }

    public static function noteNiveau($niveau, $numtrim, $numerodevoir, $codematiere, $nomannee, $matriculeetab):array {
        $req="select matricule, note from evaluation where numeroseq=:numeroseq and numerodevoir=:numerodevoir and appreciation<>'MALADE' and codematiere=:codematiere and nomannee=:nomannee and matriculeetab=:matriculeetab and matricule in (select matricule from eleve, classe where niveau=:niveau and eleve.nomannee=:nomannee and eleve.matriculeetab=:matriculeetab and eleve.codeclasse=classe.codeclasse and eleve.nomannee=classe.nomannee and eleve.matriculeetab=classe.matriculeetab)";
        $tabp=array("niveau"=>$niveau,"codematiere"=>$codematiere,"numerodevoir"=>$numerodevoir,"numeroseq"=>$numtrim, "nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        $tabC = $con->executeReq($req, $tabp, "Evaluation.php", 0, 0);
        $tabnote=array();
        for ($i = 0; $i < count($tabC); $i++) {
            $matri=$tabC[$i]["matricule"];
            $tabnote[$matri]=$tabC[$i]["note"];
        }
        //print_r($nbnote); exit();
        return $tabnote;
    }
    
    public static function insertCompetence($codeperso, $codeclasse, $codematiere, $competence, $numtrim, $nombrenotes, $annee, $matriculeetab) {
        $req="insert into competences values
              ('$codeperso','$codeclasse','$codematiere','$competence','$numtrim','$nombrenotes','$annee','$matriculeetab')";
        //$tabp=array("codeperso"=>$codeperso, "codeclasse"=>$codeclasse, "codematiere"=>$codematiere, "competence"=>$competence, "numtrim"=>$numtrim, "nombrenotes"=>$nombrenotes, "annee"=>$annee, "matriculeetab"=>$matriculeetab);
        $tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Evaluation.php", 0, 2);
    }
    
    public static function deleteCompetence($nomannee, $matriculeetab, $trimestre) {
        $req="delete from competences where nomannee=:nomannee and matriculeetab=:matriculeetab and trimestre=:trimestre";
        $tabp=array("nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab, "trimestre"=>$trimestre);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Evaluation.php", 0, 2);
    }
    
    public function getDonneeCompetence($matiere, $codeperso, $codeclasse, $numtrim, $annee, $matriculeEtab): array {
        //selection de la compétence et du nbre de notes
        $req="SELECT competence, nombrenotes FROM competences 
                WHERE (codematiere=:matiere) AND (codeperso=:codeperso) AND (codeclasse=:classe) AND (trimestre=:numtrim) AND (nomannee=:annee) AND (matriculeetab=:matriculeetab)";
        $tabp=array("matiere"=>$matiere, "codeperso"=>$codeperso, "classe"=>$codeclasse, "numtrim"=>$numtrim, "annee"=>$annee, "matriculeetab"=>$matriculeEtab);
        $tabC = $this->executeReq($req, $tabp, "Evaluation.php", 0, 0);
        if (count($tabC)==0) {
            $donneComp = array();
        }
        else {
            $donneComp=array($tabC[0]["competence"], $tabC[0]["nombrenotes"]);
        }
        return $donneComp;
    }
    
    public static function getAllDonneeCompetence($annee, $matriculeEtab): array {
        $req="SELECT codeperso,codeclasse,codematiere,competence,trimestre,nombrenotes,nomannee FROM competences
                WHERE (nomannee=:annee) AND (matriculeetab=:matriculeetab)
                order by codeclasse,codematiere";
        $tabp=array("annee"=>$annee, "matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        $tabC = $con->executeReq($req, $tabp, "Evaluation.php", 0, 0);
        $donneComp = array();
        for ($i = 0; $i < count($tabC); $i++) {
            $donneComp[$i]=array($tabC[$i]["codeperso"], $tabC[$i]["codeclasse"], $tabC[$i]["codematiere"], $tabC[$i]["competence"], $tabC[$i]["trimestre"], $tabC[$i]["nombrenotes"], $tabC[$i]["nomannee"]);
        } 
        return $donneComp;
    }
    
    public function setDonneeCompetence($competence, $nbnote, $matiere, $codeperso, $classe, $numtrim, $annee, $matriculeEtab) {
        $req="update competences set competence=:competence, nombrenotes=:nombrenotes 
                where (codematiere=:matiere) AND (codeperso=:codeperso) AND (codeclasse=:classe) AND (trimestre=:numtrim) AND (nomannee=:annee) AND (matriculeetab=:matriculeetab)";
        $tabp=array("competence"=>$competence, "nombrenotes"=>$nbnote, "matiere"=>$matiere, "codeperso"=>$codeperso, "classe"=>$classe, "numtrim"=>$numtrim, "annee"=>$annee, "matriculeetab"=>$matriculeEtab);
        return $this->executeReq($req, $tabp, "Evaluation.php", 0, 2);
    }
    
    public static function appreciation($x):string {
        if ($x<=10) {$y="NON ACQUISE";}
        elseif ($x<14) {$y="EN COURS D ACQUISITION";}
        elseif ($x<17) {$y="ACQUISE";}
        else {$y="EXPERT";}
        return $y;
    }
    
    public static function appreciation1($x):string {
        if ($x<=10) {$y="NOT ACQUIRED";}
        elseif ($x<14) {$y="ON GOING ACQUISITION";}
        elseif ($x<17) {$y="ACQUIRED";}
        else {$y="EXPERT";}
        return $y;
    }
}

