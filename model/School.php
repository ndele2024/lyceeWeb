<?php
declare(strict_types=1);
namespace model;
require_once 'Connexion.php';
require_once 'Teacher.php';
require_once 'Matiere.php';
/**
 *
 * @author ndele
 *        
 */
class School extends Connexion
{
    /**
     */
    private $matriculeetab;
    private $nomSchoolFr;
    private $nomSchoolAng;
    private $miseajour;
    private $miseajourdejafaite;
    private $codeschool;
    /**
     * @return mixed
     */
    public function getMiseajour()
    {
        $req="select miseajour from etablissement where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$this->matriculeetab);
        $tabT=$this->executeReq($req, $tabp, "School.php", 0, 0);
        
        if(empty($tabT[0]["miseajour"])){
            return "non";
        }
        else {
            return $tabT[0]["miseajour"];
        }       
    }

    /**
     * @param mixed $miseajour
     */
    public function setMiseajour($miseajour)
    {
        $this->miseajour = $miseajour;
        $req="update etablissement set miseajour=:miseajour where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$this->matriculeetab, "miseajour"=>$miseajour);
        $res=$this->executeReq($req, $tabp, "School.php", 0, 2);
    }
    
    public function getMiseajourdejafaite()
    {
        $req="select miseajourdejafaite from etablissement where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$this->matriculeetab);
        $tabT=$this->executeReq($req, $tabp, "School.php", 0, 0);
        
        if(empty($tabT[0]["miseajourdejafaite"])){
            return "non";
        }
        else {
            return $tabT[0]["miseajourdejafaite"];
        }
    }
    
    /**
     * @param mixed $miseajour
     */
    public function setMiseajourdejafaite($miseajour)
    {
        $this->miseajourdejafaite = $miseajour;
        $req="update etablissement set miseajourdejafaite=:miseajour where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$this->matriculeetab, "miseajour"=>$miseajour);
        $res=$this->executeReq($req, $tabp, "School.php", 0, 2);
    }
    
    /**
     * @return mixed
     */
    public function getNomSchoolFr(string $matriculeetab):string
    {
        $req="select nometabfr from etablissement where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeetab);
        $tabT=$this->executeReq($req, $tabp, "School.php", 0, 0);
        return $tabT[0]["nometabfr"];
    }

    /**
     * @return mixed
     */
    public function getNomSchoolAng(string $matriculeetab):string
    {
        $req="select nometabang from etablissement where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeetab);
        $tabT=$this->executeReq($req, $tabp, "School.php", 0, 0);
        return $tabT[0]["nometabang"];
    }

    /**
     * @return mixed
     */
    public function getMatriculeetab():string
    {
        return $this->matriculeetab;
    }

    public function __construct($matriculeetab)
    {
        $this->matriculeetab=$matriculeetab;
        $this->nomSchoolFr=null;
        $this->nomSchoolAng=null;
        $this->miseajour=null;
        $this->miseajourdejafaite=null;
    }
    
    /**
     * get matricule by code
     */
    public static function getMatriculeByCode($code) {
        $req="select matriculeetab from etablissement where codeschool=:code";
        $tabp=array("code"=>$code);
        $con=new connexion();
        $tabT=$con->executeReq($req, $tabp, "School.php", 0, 0);
        if(empty($tabT)){
            $mat="";
        }
        else{
            $mat=$tabT[0]["matriculeetab"];
        }
        return $mat;
    }
    /**
     * retourne la liste des enseignants
     * @param $code
     * @return mixed
     */
    public function getAllTeacher(string $code):Array {
        $req="select codeperso, nomperso, sexe, fonction, username, password, sauvegarder_base, email, ap, departement, matriculeetab from personnel 
              where matriculeetab=:matriculeetab and fonction<>'RIEN'
              Order by nomperso";
        $tabp=array("matriculeetab"=>$code);
        $tabT=$this->executeReq($req, $tabp, "School.php", 0, 0);
        $listeTeacher=array();
        for ($i = 0; $i < count($tabT); $i++) {
            $listeTeacher[]= new Teacher ($tabT[$i]["codeperso"], $tabT[$i]["nomperso"], $tabT[$i]["sexe"], $tabT[$i]["fonction"], $tabT[$i]["username"], $tabT[$i]["password"], $tabT[$i]["sauvegarder_base"], $tabT[$i]["email"], $tabT[$i]["ap"], $tabT[$i]["departement"], $this);
        }
        return $listeTeacher;
    }
    
    /**
     * retourne la liste des classes
     * @param $code
     * @return mixed
     */
    public function getAllClasse(string $code, string $annee):Array {
        $req="select codeclasse, niveau from classe
              where matriculeetab=:matriculeetab and nomannee=:annee
              Order by niveau,codeclasse";
        $tabp=array("matriculeetab"=>$code, "annee"=>$annee);
        $tabT=$this->executeReq($req, $tabp, "School.php", 0, 0);
        $listeClasse=array();
        for ($i = 0; $i < count($tabT); $i++) {
            $listeClasse[]= $tabT[$i]["codeclasse"];
        }
        return $listeClasse;
    }

    /**
     * retourne la liste des enseignants admin
     * @param $code
     * @return mixed
     */
    public function getAllTeacherAdmin(string $code):Array {
        $req="select codeperso, nomperso, sexe, fonction, username, password, sauvegarder_base, email, ap, departement, matriculeetab from personnel 
              where matriculeetab=:matriculeetab and fonction<>'RIEN' and sauvegarder_base='oui'
              Order by nomperso";
        $tabp=array("matriculeetab"=>$code);
        $tabT=$this->executeReq($req, $tabp, "School.php", 0, 0);
        for ($i = 0; $i < count($tabT); $i++) {
            $listeTeacher[]= new Teacher ($tabT[$i]["codeperso"], $tabT[$i]["nomperso"], $tabT[$i]["sexe"], $tabT[$i]["fonction"], $tabT[$i]["username"], $tabT[$i]["password"], $tabT[$i]["sauvegarder_base"], $tabT[$i]["email"], $tabT[$i]["ap"], $tabT[$i]["departement"], $this);
        }
        return $listeTeacher;
    }
    
    /**
     * retourne le nombre d'enseignants
     * @param $code
     * @return integer
     */
    public function getNbTeacher(string $code):int {
        $req="select codeperso, nomperso, sexe, fonction, username, password, sauvegarder_base, email, ap, departement, matriculeetab from personnel where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$code);
        return $this->executeReq($req, $tabp, "School.php", 0, 1);
    }
    
    /**
     * retourne la liste des Matieres
     * @param $code
     * @return array
     */
    public function getAllMatiere(string $code): Array {
        $req="select codematiere, nommatiere, typem, sectionm, departement, matriculeetab from matiere where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$code);
        $tabT=$this->executeReq($req, $tabp, "School.php", 0, 0);
        for ($i = 0; $i < count($tabT); $i++) {
            $listeMatiere[$i] = new Matiere($tabT[$i]["codematiere"], $tabT[$i]["nommatiere"], $tabT[$i]["typem"], $tabT[$i]["sectionm"], $tabT[$i]["departement"], $this);
        }
        return $listeMatiere;
    }
    
    public static function insertDonneeSchool($matriculeEtab, $nomSchoolFr, $nomSchoolAng, $email) {
        $req="insert into etablissement values ('$matriculeEtab', '$nomSchoolFr', '$nomSchoolAng', '$email')";
        //$tabp=array("matriculeetab"=>$matriculeEtab, "nomSchoolFr"=>$nomSchoolFr, "nomSchoolAng"=>$nomSchoolAng, "email"=>$email);
        $tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "School.php", 0, 2);
    }
    
    public static function deleteEtablissement($matriculeEtab) {
        $req="delete from etablissement where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "School.php", 0, 2);
    }
    
    public static function getSchoolExist($matriculeetab):bool {
        $req="select matriculeetab from etablissement where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        $nn = $con->executeReq($req, $tabp, "School.php", 0, 1);
        if ($nn>0) {
           return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    // Converti une string en binaire
    /*private function str2Hexa($str) {
        $sortie = '';
        $length = strlen($str);
        for ($i = 0; $i < $length; $i++){
            // On converti le code ASCII du char en binaire
            $convert = decbin(ord($str[$i]));
            
            // On complète avec les 0 pour faire 1 octet
            $convertbin = strrev(str_pad(strrev($convert), 8, '0'));
            //on convertit en hexadécimal
            $convertHex = bin2hex($convertbin);
            $sortie .= $convertHex;
        }
        return ($sortie);
    }
    // Converti du binaire en string
    private  function hexa2Str($hex){
        $str = '';
        $length = strlen($hex);
        for ($i = 0; $i < $length; $i++){
            $convert = hex2bin($hex[$i]);
        }
        $split = str_split($bin, 8);
        $count = count($split);
        for ($j = 0; $j < $count; $j++) {
            $str .= chr(bindec($split[$j]));
        }
        return ($str);
    }*/
    
    public function crypteUrl($admin) {
        $miseajour = $this->getMiseajour();
        $miseajourdeja = $this->getMiseajourdejafaite();
        $matEtab = $this->getMatriculeetab();
        $chaine="admin=$admin&miseajour=$miseajour&dejafaite=$miseajourdeja&matetab=$matEtab";
        return bin2hex($chaine);  
    }
    public function decrypteUrl($str) {
        return hex2bin($str);
    }
    
}

