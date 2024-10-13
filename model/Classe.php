<?php
declare(strict_types=1);
namespace model;

require_once 'Connexion.php';
require_once 'Matiere.php';
require_once 'School.php';
require_once 'Evaluation.php';
require_once 'Absence.php';
/**
 *
 * @author ndele
 *        
 */
class Classe extends Connexion
{
    private $codeclasse;
    private $nomclasse;
    private $niveau;
    private $cycles;
    private $serie;
    private $statut;
    private $annee;
    private $sectionc;
    private $school;
    
    /**
     * @return mixed
     */
    public function getCodeclasse():string
    {
        return $this->codeclasse;
    }

    /**
     * @return mixed
     */
    public function getNomclasse():string
    {
        return $this->nomclasse;
    }

    /**
     * @return mixed
     */
    public function getNiveau():int
    {
        return $this->niveau;
    }

    /**
     * @return mixed
     */
    public function getCycles():int
    {
        return $this->cycles;
    }

    /**
     * @return mixed
     */
    public function getSerie():string
    {
        return $this->serie;
    }

    /**
     * @return mixed
     */
    public function getStatut():string
    {
        return $this->statut;
    }

    /**
     * @return mixed
     */
    public function getAnnee():string
    {
        return $this->annee;
    }

    /**
     * @return mixed
     */
    public function getSectionc():string
    {
        return $this->sectionc;
    }

    /**
     * @return mixed
     */
    public function getSchool():School
    {
        return $this->school;
    }

    /**
     */
    public function __construct(string $codeclasse, string $annee, School $school)
    {
        $req="select nomclasse,niveau,cycles,serie,statut,sectionc from classe where codeclasse=:codeclasse and nomannee=:annee and matriculeetab=:matriculeetab";
        $tabp=array("codeclasse"=>$codeclasse, "annee"=>$annee, "matriculeetab"=>$school->getMatriculeetab());
        $tabT=$this->executeReq($req, $tabp, "Classe.php", 0, 0);
        $this->codeclasse=$codeclasse;
        $this->nomclasse=$tabT[0]["nomclasse"];
        $this->niveau=$tabT[0]["niveau"];
        $this->cycles=$tabT[0]["cycles"];
        $this->serie=$tabT[0]["serie"];
        $this->statut=$tabT[0]["statut"];
        $this->annee=$annee;
        $this->sectionc=$tabT[0]["sectionc"];
        $this->school=$school;
    }
    
    public function getAllEleveClasse(string $codeclasse, string $annesco, string $matriculeEtab):array {
        $req="select matricule, numero, Nomeleve, sexe, datenaiss, lieunaiss, redoublant from eleve where codeclasse=:codeclasse and nomannee=:annesco and matriculeetab=:matriculeetab order by numero,Nomeleve";
        $tabp=array("codeclasse"=>$codeclasse, "annesco"=>$annesco, "matriculeetab"=>$matriculeEtab);
        $tabT=$this->executeReq($req, $tabp, "Classe.php", 0, 0);
        //print_r($tabT); exit();
        $listeEleve=array();
        for ($i = 0; $i < count($tabT); $i++) {
            $listeEleve[]=array($tabT[$i]["matricule"], $tabT[$i]["numero"],$tabT[$i]["Nomeleve"],$tabT[$i]["sexe"],$tabT[$i]["datenaiss"],$tabT[$i]["lieunaiss"],$tabT[$i]["redoublant"]);
        }
        return $listeEleve;
    }
    
    public function getAllEleveClasseAvecNote(string $codeclasse, String $codematiere, int $numtrim, int $numdevoir, string $annesco, string $matriculeEtab):array {
        $req="select eleve.matricule, numero, Nomeleve, sexe, datenaiss, lieunaiss, redoublant, note from eleve, evaluation 
             where eleve.matricule=evaluation.matricule and codeclasse=:codeclasse and eleve.nomannee=:annesco 
             and eleve.matriculeetab=:matriculeetab and evaluation.nomannee=:annesco and evaluation.matriculeetab=:matriculeetab 
             and codematiere=:codematiere and numeroseq=:numeroseq and numerodevoir=:numerodevoir
             order by numero,Nomeleve";
        $tabp=array("codeclasse"=>$codeclasse, "codematiere"=>$codematiere, "numeroseq"=>$numtrim, "numerodevoir"=>$numdevoir, "annesco"=>$annesco, "matriculeetab"=>$matriculeEtab);
        $tabT=$this->executeReq($req, $tabp, "Classe.php", 0, 0);
        //print_r($tabT); exit();
        $listeEleve=array();
        for ($i = 0; $i < count($tabT); $i++) {
            $listeEleve[]=array($tabT[$i]["matricule"], $tabT[$i]["numero"],$tabT[$i]["Nomeleve"],$tabT[$i]["sexe"],$tabT[$i]["datenaiss"],$tabT[$i]["lieunaiss"],$tabT[$i]["redoublant"], $tabT[$i]["note"]);
        }
        return $listeEleve;
    }
    
    public function eleveSuivant($codematiere, $codeclasse, $numtrim, $numerodevoir, $annee, $matriculeetab):array {
       $tabeleve = $this->getAllEleveClasse($codeclasse, $annee, $matriculeetab);
       $i=0;
       while (evaluation::verifnoteexisteleve($tabeleve[$i][0], $numtrim, $numerodevoir, $codematiere, $annee, $matriculeetab)) {
               $i++;  
       }
       return $tabeleve[$i];
    }
    
    public function getAllEleveClasseAvecAbsence($codeclasse, $numtrim, $annesco, $matriculeEtab) {
        $listeEleve=$this->getAllEleveClasse($codeclasse, $annesco, $matriculeEtab);
        $absence = new Absence();
        $listeEleveAbsence = array();        
        for ($i = 0; $i < count($listeEleve); $i++) {
            $tabdonneeabsence=$absence->getDonneeAbsenceEleve($annesco, $listeEleve[$i][0], $numtrim, $matriculeEtab);
            if (count($tabdonneeabsence)==0) {
                $listeEleveAbsence[$i] = array($listeEleve[$i][0], $listeEleve[$i][1], $listeEleve[$i][2], 0, 0);
            }
            else {
                $listeEleveAbsence[$i] = array($listeEleve[$i][0], $listeEleve[$i][1], $listeEleve[$i][2], $tabdonneeabsence[0], $tabdonneeabsence[1]);
            }
        }
        return $listeEleveAbsence;
    }
    
    public  static function insertDoneeClasse($codeclasse, $nomclasse, $niveau, $cycles, $serie, $statut, $annee, $sectionc, $matriculeEtab) {
        $req="insert into classe values
               ('$codeclasse', '$nomclasse', '$niveau', '$cycles', '$serie', '$statut', '$annee', '$sectionc', '$matriculeEtab')";
        //$tabp=array("codeclasse"=>$codeclasse, "nomclasse"=>$nomclasse, "niveau"=>$niveau, "cycles"=>$cycles, "serie"=>$serie, "statut"=>$statut, "annee"=>$annee, "section"=>$sectionc, "matriculeetab"=>$matriculeEtab);
        $tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Classe.php", 0, 2);
    }
    
    public static function deleteClasse($annee, $matriculeEtab) {
        $req="delete from classe where nomannee=:annee and matriculeetab=:matriculeetab";
        $tabp=array("annee"=>$annee, "matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Classe.php", 0, 2);
    }
    
    public  static function insertDoneeClassemat($codeclasse, $codematiere, $coeficient, $annee, $matiereopt, $matriculeEtab) {
        $req="insert into classemat values
               ('$codeclasse', '$codematiere', '$coeficient', '$annee', '$matiereopt', '$matriculeEtab')";
        //$tabp=array("codeclasse"=>$codeclasse, "codematiere"=>$codematiere, "coeficient"=>$coeficient, "annee"=>$annee, "matiereopt"=>$matiereopt, "matriculeetab"=>$matriculeEtab);
        $tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Classe.php", 0, 2);
    }
    
    public static function deleteClassemat($annee, $matriculeEtab) {
        $req="delete from classemat where nomannee=:annee and matriculeetab=:matriculeetab";
        $tabp=array("annee"=>$annee, "matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Classe.php", 0, 2);
    }
    
    public static function getNombreclasse($matriculeEtab, $annee) {
        $req="select codeclasse from classe where nomannee=:annee and matriculeetab=:matriculeetab";
        $tabp=array("annee"=>$annee, "matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Classe.php", 0, 1);
    }
    
    public static function getNombreCour($matriculeEtab, $annee) {
        $req="select * from classemat where nomannee=:annee and matriculeetab=:matriculeetab";
        $tabp=array("annee"=>$annee, "matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Classe.php", 0, 1);
    }

    public static function getAllNiveau($matriculeEtab, $annee) {
        $req="select distinct niveau FROM classe where nomannee=:annee and matriculeetab=:matriculeetab order by niveau";
        $tabp=array("annee"=>$annee, "matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        $tabT = $con->executeReq($req, $tabp, "Classe.php", 0, 0);
        $listeNiveau = array();
        for($i=0; $i<count($tabT); $i++) {
            $listeNiveau[] = $tabT[$i]["niveau"]; 
        }
        return $listeNiveau;
    }

    public static function getAllSerie($matriculeEtab, $annee, $niveau) {
        $req="select distinct serie from classe where (niveau=:niveau)AND(serie<>'')AND(nomannee=:annee)AND(matriculeetab=:matriculeetab) order by serie";
        $tabp=array("annee"=>$annee, "matriculeetab"=>$matriculeEtab, "niveau"=>$niveau);
        $con = new Connexion();
        $tabT = $con->executeReq($req, $tabp, "Classe.php", 0, 0);
        $listeSerie = array();
        for($i=0; $i<count($tabT); $i++) {
            $listeSerie[] = $tabT[$i]["serie"]; 
        }
        return $listeSerie;
    }

    public static function getAllClasseNiveau($matriculeEtab, $annee, $niveau, $serie) {
        if(($serie=="")OR($serie=="tout")){
            $req="select codeclasse from classe where (niveau=:niveau)AND(nomannee=:annee)AND(matriculeetab=:matriculeetab)";
            $tabp=array("annee"=>$annee, "matriculeetab"=>$matriculeEtab, "niveau"=>$niveau);
        }
        else{
            $req="select codeclasse from classe where (niveau=:niveau)AND(serie=:serie)AND(nomannee=:annee)AND(matriculeetab=:matriculeetab)";
            $tabp=array("annee"=>$annee, "matriculeetab"=>$matriculeEtab, "niveau"=>$niveau, "serie"=>$serie);
        }
        $con = new Connexion();
        $tabT = $con->executeReq($req, $tabp, "Classe.php", 0, 0);
        $listeClasse = array();
        for($i=0; $i<count($tabT); $i++) {
            $listeClasse[] = $tabT[$i]["codeclasse"]; 
        }
        return $listeClasse;
    }

    public static function verifClasseExist($annee, $matriculeEtab, $codeclasse){
        $req="select codeclasse from classe where (nomannee=:annee)AND(matriculeetab=:matriculeetab)AND(codeclasse=:codeclasse)";
        $tabp=array("annee"=>$annee, "matriculeetab"=>$matriculeEtab, "codeclasse"=>$codeclasse);
        $con = new Connexion();
        $nbc = $con->executeReq($req, $tabp, "Classe.php", 0, 1);
        if($nbc>0){
            return true;
        }
        else {
            return false;
        }

    }
    public static function verifClassematExist($annee, $matriculeEtab, $codeclasse, $codematiere){
        $req="select codeclasse from classemat where (nomannee=:annee)AND(matriculeetab=:matriculeetab)AND(codeclasse=:codeclasse)AND(codematiere=:codematiere)";
        $tabp=array("annee"=>$annee, "matriculeetab"=>$matriculeEtab, "codeclasse"=>$codeclasse, "codematiere"=>$codematiere);
        $con = new Connexion();
        $nbc = $con->executeReq($req, $tabp, "Classe.php", 0, 1);
        if($nbc>0){
            return true;
        }
        else {
            return false;
        }

    }
    
}

