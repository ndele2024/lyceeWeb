<?php
namespace model;

require_once ('Connexion.php');

/**
 *
 * @author ndele
 *        
 */
class Absence extends Connexion
{
    private $nomannee;
    private $matricule;
    private $numeroseq;
    private $nbreheure;
    private $jour_exclusion;
    private $school;
    
    /**
     * @return mixed
     */
    public function getNomannee()
    {
        return $this->nomannee;
    }

    /**
     * @return mixed
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * @return mixed
     */
    public function getNumeroseq()
    {
        return $this->numeroseq;
    }

    /**
     * @return mixed
     */
    public function getNbreheure()
    {
        return $this->nbreheure;
    }

    /**
     * @return mixed
     */
    public function getJour_exclusion()
    {
        return $this->jour_exclusion;
    }

    /**
     */
    public function __construct()
    {}
    
    public static function insertDonneeAbsence($annee, $matricule, $trimestre, $heure, $jour, $matriculeetab) {
        $req = "insert into absence values (:annee, :matricule, :trimestre, :heure, :jour, :matriculeetab)";
        $tabp=array("annee"=>$annee, "matricule"=>$matricule, "trimestre"=>$trimestre, "heure"=>$heure, "jour"=>$jour, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Absence.php", 0, 2);
    }
    
    public static function deleteDonneeAbsence($annee, $trimestre, $matriculeetab) {
        $req = "delete from absence where nomannee=:annee and numeroseq=:trimestre and matriculeetab=:matriculeetab";
        $tabp=array("annee"=>$annee, "trimestre"=>$trimestre, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Absence.php", 0, 2);
    }
    
    public function getDonneeAbsenceEleve($annee, $matricule, $trimestre, $matriculeetab) {
        $req="select nbreheure, jour_exclusion from absence where nomannee=:annee and matricule=:matricule and numeroseq=:trimestre and matriculeetab=:matriculeetab";
        $tabp=array("annee"=>$annee, "matricule"=>$matricule, "trimestre"=>$trimestre, "matriculeetab"=>$matriculeetab);
        $tabR=$this->executeReq($req, $tabp, "Absence.php", 0, 0);
        if(count($tabR)==0){
            return array();
        }
        else {
            return array($tabR[0]["nbreheure"], $tabR[0]["jour_exclusion"]);
        }
    }
    
    public static function updateHeureAbsence($annee, $matricule, $trimestre, $matriculeetab, $heure, $jour) {
        $req="update absence set nbreheure=:heure, jour_exclusion=:jour where nomannee=:annee and matricule=:matricule and numeroseq=:trimestre and matriculeetab=:matriculeetab";
        $tabp=array("annee"=>$annee, "matricule"=>$matricule, "trimestre"=>$trimestre, "matriculeetab"=>$matriculeetab, "heure"=>$heure, "jour"=>$jour);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Absence.php", 0, 2);
    }
    
    public static function getAllDonneeAbsence($annee, $trimestre, $matriculeetab) {
        $req="select nomannee, matricule, numeroseq, nbreheure, jour_exclusion from absence where nomannee=:annee and numeroseq=:trimestre and matriculeetab=:matriculeetab";
        $tabp=array("annee"=>$annee, "trimestre"=>$trimestre, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        $tabR=$con->executeReq($req, $tabp, "Absence.php", 0, 0);
        $tabAbsence = array();
        for ($i = 0; $i < count($tabR); $i++) {
            $tabAbsence[$i] = array($tabR[$i]["nomannee"], $tabR[$i]["matricule"], $tabR[$i]["numeroseq"], $tabR[$i]["nbreheure"], $tabR[$i]["jour_exclusion"]);
        }
        
        return $tabAbsence; 
    }
    
}

