<?php
namespace model;

require_once 'Connexion.php';
require_once 'School.php';

/**
 *
 * @author ndele
 *        
 */
class Matiere extends Connexion
{

    /**
     */
    private $codematiere;
    private $nommatiere;
    private $sectionm;
    private $typem;
    private $departement;
    private $school;
    
    public function __construct($codematiere, $nommatiere, $sectionm, $typem, $departement, $school) {
        $this->codematiere=$codematiere;
        $this->nommatiere=$nommatiere;
        $this->sectionm=$sectionm;
        $this->typem=$typem;
        $this->departement=$departement;
        $this->school=$school;
    }
    
    /**
     * retourne les info de la matiere dont le code est $codematiere
     * @param $codematiere
     * @return array
     */
    public function getMatiereByCode(string $codematiere):array {
        
        $req="select * from matiere where codematiere=:codematiere";
        $tabp=array("codematiere"=>$codematiere);
        $tabMatiere = $this->executeReq($req, $tabp, "Matiere.php", 0, 0);
        return $tabMatiere[0];
    }
    /**
     * @return mixed
     */
    public function getCodematiere():string
    {
        return $this->codematiere;
    }

    /**
     * @return mixed
     */
    public function getNommatiere():string
    {
        return $this->nommatiere;
    }

    /**
     * @return mixed
     */
    public function getSectionm():string
    {
        return $this->sectionm;
    }

    /**
     * @return mixed
     */
    public function getTypem():string
    {
        return $this->typem;
    }

    /**
     * @return mixed
     */
    public function getDepartement():string
    {
        return $this->departement;
    }
    
    public  static function insertDonneeMatiere($codematiere, $nommatiere, $sectionm, $typem, $departement, $matriculeEtab) {
        $req="insert into matiere values
              ('$codematiere', '$nommatiere', '$typem', '$sectionm', '$departement', '$matriculeEtab')";
        //$tabp=array("codematiere"=>$codematiere, "nommatiere"=>$nommatiere, "sectionm"=>$sectionm, "typem"=>$typem, "departement"=>$departement, "matriculeetab"=>$matriculeEtab);
        $tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Matiere.php", 0, 2);
    }

    public static function deleteMatiere($matriculeEtab) {
        $req="delete from matiere where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Matiere.php", 0, 2);
    }
    
    public static function getNombreMatiere($matriculeEtab) {
        $req="select codematiere from matiere where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Matiere.php", 0, 1);
    }
    
    public  static function insertDonneeSerie($numserie, $serie, $sectiont, $matriculeEtab) {
        $req="insert into listeserie values
              ('$numserie', '$serie', '$sectiont', '$matriculeEtab')";
        //$tabp=array("numserie"=>$numserie, "serie"=>$serie, "sectiont"=>$sectiont, "matriculeetab"=>$matriculeEtab);
        $tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Matiere.php", 0, 2);
    }
    
    public static function deleteSerie($matriculeEtab) {
        $req="delete from listeserie where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Matiere.php", 0, 2);
    }
    
    public static function getNobreSerie($matriculeEtab) {
        $req="select * from listeserie where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Matiere.php", 0, 1);
    }
    
    public  static function insertDonneeDepart($num, $departement, $matriculeEtab) {
        $req="insert into listedepart values
              ('$num', '$departement', '$matriculeEtab')";
        //$tabp=array("num"=>$num, "departement"=>$departement, "matriculeetab"=>$matriculeEtab);
        $tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Matiere.php", 0, 2);
    }
    
    public static function deleteDepart($matriculeEtab) {
        $req="delete from listedepart where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Matiere.php", 0, 2);
    }
    
    public static function getNombreDepart($matriculeEtab) {
        $req="select * from listedepart where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Matiere.php", 0, 1);
    }
    
    public  static function insertDonneeSection($numsection, $sectiont, $matriculeEtab) {
        $req="insert into listesection values
              ('$numsection', '$sectiont', '$matriculeEtab')";
        //$tabp=array("numsection"=>$numsection, "sectiont"=>$sectiont, "matriculeetab"=>$matriculeEtab);
        $tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Matiere.php", 0, 2);
    }
    
    public static function deleteSection($matriculeEtab) {
        $req="delete from listesection where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Matiere.php", 0, 2);
    }

    public static function getMatiereDepart($matriculeEtab, $codeperso, $annee, $niveau){
        $req = "SELECT distinct personnel.departement as depart, matiere.codematiere as codemat, nommatiere FROM personnel, matiere, classemat, classe WHERE (personnel.departement=matiere.departement) AND (codeperso=:codeperso)AND(classemat.codeclasse=classe.codeclasse)AND(classemat.codematiere=matiere.codematiere)AND(niveau=:niveau)AND(classemat.nomannee=:annee)AND(classe.nomannee=:annee)AND(personnel.matriculeetab=:matriculeetab)AND(classe.matriculeetab=:matriculeetab)AND(matiere.matriculeetab=:matriculeetab)AND(classemat.matriculeetab=:matriculeetab)
        ";
        $tabp=array("matriculeetab"=>$matriculeEtab, "codeperso"=>$codeperso, "niveau"=>$niveau, "annee"=>$annee);
        $con = new Connexion();
        $tabT = $con->executeReq($req, $tabp, "Matiere.php", 0, 0);
        $listeMatiereDepart = array();
        for ($i=0; $i < count($tabT); $i++) { 
            $listeMatiereDepart[] = array($tabT[$i]["depart"], $tabT[$i]["codemat"], $tabT[$i]["nommatiere"]);
        }
        return $listeMatiereDepart;
    }

    public static function getMatiereDepartSerie($matriculeEtab, $codeperso, $annee, $niveau, $serie){
        $req = "SELECT distinct personnel.departement as depart, matiere.codematiere as codemat, nommatiere FROM personnel, matiere, classemat, classe WHERE (personnel.departement=matiere.departement) AND (codeperso=:codeperso)AND(classemat.codeclasse=classe.codeclasse)AND(classemat.codematiere=matiere.codematiere)AND(niveau=:niveau)AND(serie=:serie)AND(classemat.nomannee=:annee)AND(classe.nomannee=:annee)AND(personnel.matriculeetab=:matriculeetab)AND(classe.matriculeetab=:matriculeetab)AND(matiere.matriculeetab=:matriculeetab)AND(classemat.matriculeetab=:matriculeetab)
        ";
        $tabp=array("matriculeetab"=>$matriculeEtab, "codeperso"=>$codeperso, "niveau"=>$niveau, "annee"=>$annee, "serie"=>$serie);
        $con = new Connexion();
        $tabT = $con->executeReq($req, $tabp, "Matiere.php", 0, 0);
        $listeMatiereDepart = array();
        for ($i=0; $i < count($tabT); $i++) { 
            $listeMatiereDepart[] = array($tabT[$i]["depart"], $tabT[$i]["codemat"], $tabT[$i]["nommatiere"]);
        }
        return $listeMatiereDepart;
    }

    public static function verifMatiereExist($matriculeEtab, $codematiere){
        $req="select codematiere from matiere where (matriculeetab=:matriculeetab)AND(codematiere=:codematiere)";
        $tabp=array("matriculeetab"=>$matriculeEtab, "codematiere"=>$codematiere);
        $con = new Connexion();
        $nbm=$con->executeReq($req, $tabp, "Matiere.php", 0, 1);
        if($nbm>0){
            return true;
        }
        else{
            return false;
        }
    }

    public static function getAllDepart($matriculeEtab) {
        $req="select departement from listedepart where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        $tabT = $con->executeReq($req, $tabp, "Matiere.php", 0, 0);
        $listeDepart = array();
        for ($i=0; $i < count($tabT); $i++) { 
            $listeDepart[] = $tabT[$i]["departement"];
        }
        return $listeDepart;
    }

    public static function getDepartProf($matriculeEtab, $codeperso) {//à revoir
        $req="select departement from listedepart where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        $tabT = $con->executeReq($req, $tabp, "Matiere.php", 0, 0);
        $listeDepart = array();
        for ($i=0; $i < count($tabT); $i++) { 
            $listeDepart[] = $tabT[$i]["departement"];
        }
        return $listeDepart;
    }

    public static function getProfDepartement($matriculeEtab, $departement) {//à revoir
        $req="select codeperso, nomperso from personnel where matriculeetab=:matriculeetab and departement=:departement";
        $tabp=array("matriculeetab"=>$matriculeEtab, "departement"=>$departement);
        $con = new Connexion();
        $tabT = $con->executeReq($req, $tabp, "Matiere.php", 0, 0);
        $donnee = array();
        for ($i=0; $i < count($tabT); $i++) { 
            $donnee = array($tabT[$i]["codeperso"], $tabT[$i]["nomperso"]);
        }
        return $donnee;
    }

}

