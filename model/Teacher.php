<?php
declare(strict_types=1);
namespace model;
require_once 'School.php';
require_once 'Connexion.php';
require_once 'Classe.php';

/**
 *
 * @author ndele
 *        
 */
class Teacher extends Connexion
{
    /**
     * 
     */
    private $codeTeacher;
    private $nomTeacher;
    private $sex;
    private $fonction;
    private $username;
    private $password;
    private $sauvegarder_base;
    private $email;
    private $ap;
    private $departement;
    private $etab;
    private $langue;
    private $contact;
    private $listeEtab;
    
    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @return mixed
     */
    public function getListeEtab()
    {
        return $this->listeEtab;
    }

    /**
     * @param Ambigous <\model\School, unknown> $etab
     */
    public function setEtab($etab)
    {
        $this->etab = $etab;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @param mixed $listeEtab
     */
    public function setListeEtab($listeEtab)
    {
        $this->listeEtab = $listeEtab;
    }

    /**
     * @return mixed
     */
    public function getCodeTeacher():string
    {
        return $this->codeTeacher;
    }

    /**
     * @return mixed
     */
    public function getNomTeacher():string
    {
        return $this->nomTeacher;
    }

    /**
     * @return mixed
     */
    public function getSex():string
    {
        return $this->sex;
    }

    /**
     * @return mixed
     */
    public function getFonction():string
    {
        return $this->fonction;
    }

    /**
     * @return mixed
     */
    public function getLangue():string
    {
        return $this->langue;
    }

    /**
     * @param mixed $langue
     */
    public function setLangue(string $langue):void
    {
        $this->langue = $langue;
        $req="update personnel set langue=:langue where codeperso=:codeperso AND matriculeetab=:matriculeetab";
        $tabp=array("langue"=>$langue, "codeperso"=>$this->getCodeTeacher(), "matriculeetab"=>$this->getEtab()->getMatriculeetab());
        $res = $this->executeReq($req, $tabp, "Teacher.php", 0, 3);
    }

    /**
     * @return mixed
     */
    public function getUsername():string
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword():string
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getSauvegarder_base():string
    {
        return $this->sauvegarder_base;
    }

    /**
     * @return mixed
     */
    public function getEmail():string
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getAp() :string
    {
        return $this->ap;
    }

    /**
     * @return mixed
     */
    public function getDepartement():string
    {
        return $this->departement;
    }

    /**
     * @return mixed
     */
    public function getEtab():School
    {
        return $this->etab;
    }

    /**
     * @param mixed $username
     */
    public function setUsername(string $username, string $matriculeetab):void
    {
        $req="update personnel set username=:username where codeperso=:codeperso AND matriculeetab=:matriculeetab";
        $tabp=array("username"=>$username, "codeperso"=>$this->getCodeTeacher(), "matriculeetab"=>$matriculeetab);
        $res = $this->executeReq($req, $tabp, "Teacher.php", 0, 3);
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword(string $password, string $matriculeetab):void
    {
        $req="update personnel set password=:password where codeperso=:codeperso AND matriculeetab=:matriculeetab";
        $tabp=array("password"=>$password, "codeperso"=>$this->getCodeTeacher(), "matriculeetab"=>$matriculeetab);
        $res = $this->executeReq($req, $tabp, "Teacher.php", 0, 3);
        $this->password = $password;
    }

    /**
     * @param mixed $sauvegarder_base
     */
    public function setSauvegarder_base(string $sauvegarder_base):void
    {
        $this->sauvegarder_base = $sauvegarder_base;
        $req="update personnel set sauvegarder_base=:sauvegarder_base where codeperso=:codeperso AND matriculeetab=:matriculeetab";
        $tabp=array("sauvegarder_base"=>$sauvegarder_base, "codeperso"=>$this->getCodeTeacher(), "matriculeetab"=>$this->getEtab()->getMatriculeetab());
        $res = $this->executeReq($req, $tabp, "Teacher.php", 0, 3);
    }

    /**
     * @param mixed $email
     */
    public function setEmail(string $email, string $matriculeetab):void
    {
        $req="update personnel set email=:email where codeperso=:codeperso AND matriculeetab=:matriculeetab";
        $tabp=array("email"=>$email, "codeperso"=>$this->getCodeTeacher(), "matriculeetab"=>$matriculeetab);
        $res = $this->executeReq($req, $tabp, "Teacher.php", 0, 3);
        $this->email = $email;
    }

    public function __construct($codeTeacher, $nomTeacher, $sex, $fonction, $username, $password, $sauvegarder_base, $email, $ap, $departement, $etab)
    {
        $this->codeTeacher = $codeTeacher;
        $this->nomTeacher = $nomTeacher;
        $this->sex = $sex;
        $this->fonction = $fonction;
        $this->username = $username;
        $this->password = $password;
        $this->sauvegarder_base = $sauvegarder_base;
        $this->email = $email;
        $this->ap = $ap;
        $this->departement = $departement;
        $this->etab = $etab;
    }
    
    public function getTeacherByEmail(string $email, School $etab):bool {
        $req="select codeperso, nomperso, sexe, fonction, username, password, sauvegarder_base, email, ap, departement, matriculeetab,langue, contact from personnel where email=:email and matriculeetab=:matriculeetab";
        $tabp=array("email"=>$email, "matriculeetab"=>$etab->getMatriculeetab());
        $tabT = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
         //$teacher = new Teacher ($tabT[$i]["codeperso"], $tabT[$i]["nomperso"]." ".$tabT[$i]["prenomperso"], $tabT[$i]["sexe"], $tabT[$i]["fonction"], $tabT[$i]["username"], $tabT[$i]["password"], $tabT[$i]["sauvegarder_base"], $tabT[$i]["email"], $tabT[$i]["ap"], $tabT[$i]["departement"], $etab);
        if (count($tabT)==0) {
            return false;
        }
        else {
            $this->codeTeacher = $tabT[0]["codeperso"];
            $this->nomTeacher = $tabT[0]["nomperso"];
            $this->sex = $tabT[0]["sexe"];
            $this->fonction = $tabT[0]["fonction"];
            $this->username = $tabT[0]["username"];
            $this->password = $tabT[0]["password"];
            $this->sauvegarder_base = $tabT[0]["sauvegarder_base"];
            $this->email = $tabT[0]["email"];
            $this->ap = $tabT[0]["ap"];
            $this->departement = $tabT[0]["departement"];
            $this->langue = $tabT[0]["langue"];
            $this->contact = $tabT[0]["contact"];
            $this->etab = $etab;
            return TRUE;
        }
        
    }
    
    public function getTeacherByContact(string $contact, School $etab):bool {
        $req="select codeperso, nomperso, sexe, fonction, username, password, sauvegarder_base, email, ap, departement, matriculeetab,langue, contact from personnel where contact=:contact and matriculeetab=:matriculeetab";
        $tabp=array("contact"=>$contact, "matriculeetab"=>$etab->getMatriculeetab());
        $tabT = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
        //$teacher = new Teacher ($tabT[$i]["codeperso"], $tabT[$i]["nomperso"]." ".$tabT[$i]["prenomperso"], $tabT[$i]["sexe"], $tabT[$i]["fonction"], $tabT[$i]["username"], $tabT[$i]["password"], $tabT[$i]["sauvegarder_base"], $tabT[$i]["email"], $tabT[$i]["ap"], $tabT[$i]["departement"], $etab);
        if (count($tabT)==0) {
            return false;
        }
        else {
            $this->codeTeacher = $tabT[0]["codeperso"];
            $this->nomTeacher = $tabT[0]["nomperso"];
            $this->sex = $tabT[0]["sexe"];
            $this->fonction = $tabT[0]["fonction"];
            $this->username = $tabT[0]["username"];
            $this->password = $tabT[0]["password"];
            $this->sauvegarder_base = $tabT[0]["sauvegarder_base"];
            $this->email = $tabT[0]["email"];
            $this->ap = $tabT[0]["ap"];
            $this->departement = $tabT[0]["departement"];
            $this->langue = $tabT[0]["langue"];
            $this->contact = $tabT[0]["contact"];
            $this->etab = $etab;
            return TRUE;
        }
        
    }

    public function getTeacherByCode(string $codeprof, School $etab):bool {
        $req="select codeperso, nomperso, sexe, fonction, username, password, sauvegarder_base, email, ap, departement, matriculeetab, langue, contact from personnel where codeperso=:codeperso and matriculeetab=:matriculeetab";
        $tabp=array("codeperso"=>$codeprof, "matriculeetab"=>$etab->getMatriculeetab());
        $tabT = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
        //$teacher = new Teacher ($tabT[$i]["codeperso"], $tabT[$i]["nomperso"]." ".$tabT[$i]["prenomperso"], $tabT[$i]["sexe"], $tabT[$i]["fonction"], $tabT[$i]["username"], $tabT[$i]["password"], $tabT[$i]["sauvegarder_base"], $tabT[$i]["email"], $tabT[$i]["ap"], $tabT[$i]["departement"], $etab);
        if (count($tabT)==0) {
            return false;
        }
        else {
            $this->codeTeacher = $tabT[0]["codeperso"];
            $this->nomTeacher = $tabT[0]["nomperso"];
            $this->sex = $tabT[0]["sexe"];
            $this->fonction = $tabT[0]["fonction"];
            $this->username = $tabT[0]["username"];
            $this->password = $tabT[0]["password"];
            $this->sauvegarder_base = $tabT[0]["sauvegarder_base"];
            $this->email = $tabT[0]["email"];
            $this->ap = $tabT[0]["ap"];
            $this->departement = $tabT[0]["departement"];
            $this->langue = $tabT[0]["langue"];
            $this->contact = $tabT[0]["contact"];
            $this->etab = $etab;
            return TRUE;
        }
    }
    
    public function getTeacherByUser(string $username, School $etab):bool {
        $req="select codeperso, nomperso, sexe, fonction, username, password, sauvegarder_base, email, ap, departement, matriculeetab, langue, contact from personnel where username=:username and matriculeetab=:matriculeetab";
        $tabp=array("username"=>$username, "matriculeetab"=>$etab->getMatriculeetab());
        $tabT = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
        //$teacher = new Teacher ($tabT[$i]["codeperso"], $tabT[$i]["nomperso"]." ".$tabT[$i]["prenomperso"], $tabT[$i]["sexe"], $tabT[$i]["fonction"], $tabT[$i]["username"], $tabT[$i]["password"], $tabT[$i]["sauvegarder_base"], $tabT[$i]["email"], $tabT[$i]["ap"], $tabT[$i]["departement"], $etab);
        if (count($tabT)==0) {
            return false;
        }
        else {
            $this->codeTeacher = $tabT[0]["codeperso"];
            $this->nomTeacher = $tabT[0]["nomperso"];
            $this->sex = $tabT[0]["sexe"];
            $this->fonction = $tabT[0]["fonction"];
            $this->username = $tabT[0]["username"];
            $this->password = $tabT[0]["password"];
            $this->sauvegarder_base = $tabT[0]["sauvegarder_base"];
            $this->email = $tabT[0]["email"];
            $this->ap = $tabT[0]["ap"];
            $this->departement = $tabT[0]["departement"];
            $this->langue = $tabT[0]["langue"];
            $this->contact = $tabT[0]["contact"];
            $this->etab = $etab;
            return TRUE;
        }
    }
    
    public function getTeacherByEmailOnly(string $email, $matriculeEtab):bool {
        $req="select codeperso, nomperso, sexe, fonction, username, password, sauvegarder_base, email, ap, departement, matriculeetab, langue, contact from personnel where email=:email and matriculeetab=:matriculeetab";
        $tabp=array("email"=>$email, "matriculeetab"=>$matriculeEtab);
        $tabT = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
        //$teacher = new Teacher ($tabT[$i]["codeperso"], $tabT[$i]["nomperso"]." ".$tabT[$i]["prenomperso"], $tabT[$i]["sexe"], $tabT[$i]["fonction"], $tabT[$i]["username"], $tabT[$i]["password"], $tabT[$i]["sauvegarder_base"], $tabT[$i]["email"], $tabT[$i]["ap"], $tabT[$i]["departement"], $etab);
        if (count($tabT)==0) {
            return false;
        }
        else {
            /* $this->codeTeacher = $tabT[0]["codeperso"];
            $this->nomTeacher = $tabT[0]["nomperso"];
            $this->sex = $tabT[0]["sexe"];
            $this->fonction = $tabT[0]["fonction"];
            $this->password = $tabT[0]["password"];
            $this->sauvegarder_base = $tabT[0]["sauvegarder_base"];
            $this->ap = $tabT[0]["ap"];
            $this->departement = $tabT[0]["departement"];
            $this->langue = $tabT[0]["langue"]; */
            $this->email = $tabT[0]["email"];
            $this->contact = $tabT[0]["contact"];
            $this->username = $tabT[0]["username"];
            //*******************************************************
            //test si plusieurs établissement
            //$listeEtab=$this->getListeEtabByEmail($email);
            //$etab = new School($tabT[0]["matriculeetab"]);
            /*if (count($listeEtab)>1) {
                $this->etab = $listeEtab[0];
            }
            else {
                $this->etab = new School($tabT[0]["matriculeetab"]);
            }*/
            $this->listeEtab = NULL;
            return true;
        }
        
    }
    
    public function getTeacherByUserOnly(string $username, $matriculeEtab):bool {
        $req="select codeperso, nomperso, sexe, fonction, username, password, sauvegarder_base, email, ap, departement, matriculeetab, langue, contact from personnel where username=:username and matriculeetab=:matriculeetab";
        $tabp=array("username"=>$username, "matriculeetab"=>$matriculeEtab);
        $tabT = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
        //$teacher = new Teacher ($tabT[$i]["codeperso"], $tabT[$i]["nomperso"]." ".$tabT[$i]["prenomperso"], $tabT[$i]["sexe"], $tabT[$i]["fonction"], $tabT[$i]["username"], $tabT[$i]["password"], $tabT[$i]["sauvegarder_base"], $tabT[$i]["email"], $tabT[$i]["ap"], $tabT[$i]["departement"], $etab);
        //*******************************************************
        //test si plusieurs établissement
        //$etab = new School($tabT[0]["matriculeetab"]);
        if (count($tabT)==0) {
            return false;
        }
        else {
            /* $this->codeTeacher = $tabT[0]["codeperso"];
            $this->nomTeacher = $tabT[0]["nomperso"];
            $this->sex = $tabT[0]["sexe"];
            $this->fonction = $tabT[0]["fonction"];
            $this->password = $tabT[0]["password"];
            $this->sauvegarder_base = $tabT[0]["sauvegarder_base"];
            $this->ap = $tabT[0]["ap"];
            $this->departement = $tabT[0]["departement"];
            $this->langue = $tabT[0]["langue"]; */
            $this->username = $tabT[0]["username"];
            $this->email = $tabT[0]["email"];
            $this->contact = $tabT[0]["contact"];
            //$listeEtab=$this->getListeEtabByUsername($username);
            //$etab = new School($tabT[0]["matriculeetab"]);
            /*if (count($listeEtab)>1) {
                $this->etab = $listeEtab[0];
            }
            else {
                $this->etab = new School($tabT[0]["matriculeetab"]);
            }*/
            $this->listeEtab = NULL;
            return true;
        }
            
    }
    
    public function getTeacherByContactOnly(string $contact, $matriculeEtab):bool {
        $req="select codeperso, nomperso, sexe, fonction, username, password, sauvegarder_base, email, ap, departement, matriculeetab, langue, contact from personnel where contact=:contact and matriculeetab=:matriculeetab";
        $tabp=array("contact"=>$contact, "matriculeetab"=>$matriculeEtab);
        $tabT = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
        //$teacher = new Teacher ($tabT[$i]["codeperso"], $tabT[$i]["nomperso"]." ".$tabT[$i]["prenomperso"], $tabT[$i]["sexe"], $tabT[$i]["fonction"], $tabT[$i]["username"], $tabT[$i]["password"], $tabT[$i]["sauvegarder_base"], $tabT[$i]["email"], $tabT[$i]["ap"], $tabT[$i]["departement"], $etab);
        //*******************************************************
        //test si plusieurs établissement
        //$etab = new School($tabT[0]["matriculeetab"]);
        if (count($tabT)==0) {
            return false;
        }
        else {
            /* $this->codeTeacher = $tabT[0]["codeperso"];
            $this->nomTeacher = $tabT[0]["nomperso"];
            $this->sex = $tabT[0]["sexe"];
            $this->fonction = $tabT[0]["fonction"];
            $this->password = $tabT[0]["password"];
            $this->sauvegarder_base = $tabT[0]["sauvegarder_base"];
            $this->ap = $tabT[0]["ap"];
            $this->departement = $tabT[0]["departement"]; 
            $this->langue = $tabT[0]["langue"]; */
            /*$listeEtab=$this->getListeEtabByContact($contact);
            if (count($listeEtab)>1) {
                $this->etab = $listeEtab[0];
            }
            else {
                $this->etab = new School($tabT[0]["matriculeetab"]);
            }*/
            $this->listeEtab = NULL;
            $this->contact = $tabT[0]["contact"];
            $this->username = $tabT[0]["username"];
            $this->email = $tabT[0]["email"];
            return true;
        }
        
    }
    
    public function getListeEtabByUsername(string $username)  {
        $req = "select matriculeetab, contact from personnel where username=:username";
        $tabp=array("username"=>$username);
        //$req = "select matriculeetab from etablissement";
        $tabE = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
        //$school = new School($tabE[0]["matriculeetab"]);
        $listeEtab=array();
        //$tabmatriculeetab=explode(",", $tabE[0]["matriculeetab"]);
        if(count($tabE)>1) {
            $listeEtab[0] = new School($tabE[0]["matriculeetab"]);
            for ($i = 1; $i < count($tabE); $i++) {
                if (($tabE[0]["contact"]==$tabE[$i]["contact"])) {
                    $listeEtab[$i] = new School($tabE[$i]["matriculeetab"]);
                }
            }
        }
        elseif (count($tabE)==1) {
            $listeEtab[0] = new School($tabE[0]["matriculeetab"]);
        }
        else {
            $listeEtab=array();
        }
        
        return $listeEtab;
    }
    
    public function getListeEtabByEmail($email) {
        $req = "select matriculeetab from personnel where email=:email";
        $tabp=array("email"=>$email);
        $tabE = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
        $listeEtab=array();
        //$tabmatriculeetab=explode(",", $tabE[0]["matriculeetab"]);
        for ($i = 0; $i < count($tabE); $i++) {
            $listeEtab[] = new School($tabE[$i]["matriculeetab"]);
        }
        return $listeEtab;
    }
    
    public function getListeEtabByContact($contact) {
        $req = "select matriculeetab from personnel where contact=:contact";
        $tabp=array("contact"=>$contact);
        $tabE = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
        $listeEtab=array();
        //$tabmatriculeetab=explode(",", $tabE[0]["matriculeetab"]);
        for ($i = 0; $i < count($tabE); $i++) {
            $listeEtab[] = new School($tabE[$i]["matriculeetab"]);
        }
        return $listeEtab;
    }
    
    public function getClasseProf(string $annesco):array {
        $req = "SELECT distinct Codeclasse  FROM enseignement WHERE (codeprof=:codeTeacher)AND(nomannee=:annesco)AND(matriculeetab=:matriculeEtab) order by codeclasse";
        $tabp=array("codeTeacher"=>$this->codeTeacher, "annesco"=>$annesco, "matriculeEtab"=>$this->etab->getMatriculeetab());
        $tabE = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
        $listeClasse=array();
        for ($i = 0; $i < count($tabE); $i++) {
            $listeClasse[] = ($tabE[$i]["Codeclasse"]);
        }
        return $listeClasse;
    }
    
    public function getMatiereProf(string $codeclasse, string $annesco):array {
        $req = "SELECT enseignement.codematiere as codemat, matiere.nommatiere as nommat FROM enseignement, matiere 
                WHERE (enseignement.codematiere=matiere.codematiere) AND (enseignement.codeprof=:codeTeacher) AND (enseignement.codeclasse=:codeclasse) AND (enseignement.nomannee=:annesco) AND (matiere.matriculeetab=:matriculeEtab) and (enseignement.matriculeetab=:matriculeEtab)";
        $tabp=array("codeTeacher"=>$this->codeTeacher, "codeclasse"=>$codeclasse, "annesco"=>$annesco, "matriculeEtab"=>$this->etab->getMatriculeetab());
        $tabE = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
        $listeMatiere=array();
        for ($i = 0; $i < count($tabE); $i++) {
            $listeMatiere[] = array($tabE[$i]["codemat"], $tabE[$i]["nommat"]);
        }
        return $listeMatiere;
    }
    
    public static function insererDonneeProf($codeTeacher, $nomTeacher, $sex, $fonction, $username, $password, $sauvegarder_base, $infotel, $email, $ap, $departement, $matriculeetab, $langue, $contact) {
        $req="insert into personnel values
              ('$codeTeacher', '$nomTeacher', '$sex', '$fonction', '$username', '$password', '$sauvegarder_base', '$infotel', '$email', '$ap', '$departement', '$matriculeetab', '$langue', '$contact')";
        //$tabp=array("codeTeacher"=>$codeTeacher, "nomTeacher"=>$nomTeacher, "sex"=>$sex, "fonction"=>$fonction, "username"=>$username, "password"=>$password, "sauvegarder_base"=>$sauvegarder_base, "email"=>$email, "ap"=>$ap, "departement"=>$departement, "matriculeetab"=>$matriculeetab, "langue"=>$langue);
        $tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Teacher.php", 0, 2);
    }
    
    public static function deleteProf($matriculeetab) {
        $req="delete from personnel where matriculeetab=:matriculeetab and fonction<>'RIEN'";
        $tabp=array("matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Teacher.php", 0, 2);
    }
    
    public static function getNombreProf($matriculeetab) {
        $req="select codeperso from personnel where matriculeetab=:matriculeetab and fonction<>'RIEN'";
        $tabp=array("matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Teacher.php", 0, 1);
    }
    
    public static function insererDonneeEnseignement($nomannee, $codeclasse, $codematiere, $codeprof, $modifierNote, $duree, $verifModifier, $matriculeetab) {
        $req="insert into enseignement value
              ('$nomannee','$codeclasse','$codematiere','$codeprof','$modifierNote','$duree','$verifModifier','$matriculeetab')";
        //$tabp=array("nomannee"=>$nomannee, "codeclasse"=>$codeclasse, "codematiere"=>$codematiere, "codeprof"=>$codeprof, "modifiernote"=>$modifierNote, "duree"=>$duree, "verifmodifier"=>$verifModifier, "matriculeetab"=>$matriculeetab);
        $tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Teacher.php", 0, 2);
    }
    
    public static function deleteEseignement($nomannee, $matriculeetab) {
        $req="delete from enseignement where matriculeetab=:matriculeetab and nomannee=:nomannee";
        $tabp=array("matriculeetab"=>$matriculeetab, "nomannee"=>$nomannee);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Teacher.php", 0, 2);
    }
    
    public static function getNombreCour($nomannee, $matriculeetab) {
        $req="select * from enseignement where matriculeetab=:matriculeetab and nomannee=:nomannee";
        $tabp=array("matriculeetab"=>$matriculeetab, "nomannee"=>$nomannee);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Teacher.php", 0, 1);
    }
    
    public static function getPersoAdmin($matriculeEtab) {
        $req="select codeperso, nomperso, email, fonction from personnel 
              where sauvegarder_base='oui' and matriculeetab=:matriculeetab
              Order by nomperso";
        $tabp=array("matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        $tabR=$con->executeReq($req, $tabp, "Teacher.php", 0, 0);
        $tabRes=array();
        if(count($tabR)==0){
            $req="select nomperso, email from personnel where fonction='PROVISEUR' and matriculeetab=:matriculeetab";
            $tabp=array("matriculeetab"=>$matriculeEtab);
            $con = new Connexion();
            $tabRes=$con->executeReq($req, $tabp, "Teacher.php", 0, 0);
        }
        else {
            $tabRes=$tabR;
        }
        return $tabRes;
    }
    
    public static function isNotUniqueUser($username, $matriculeEtab) {
        $req="select codeperso from personnel where username=:username";
        $tabp=array("username"=>$username);
        $con = new Connexion();
        $nbu=$con->executeReq($req, $tabp, "Teacher.php", 0, 1);
        if($nbu>0) {
            return true;
        }
        else {
            return false;
        }
    }
    public static function isNotUniqueUserEtab($username, $matriculeEtab) {
        $req="select codeperso from personnel where username=:username and matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeEtab, "username"=>$username);
        $con = new Connexion();
        $nbu=$con->executeReq($req, $tabp, "Teacher.php", 0, 1);
        if($nbu>0) {
            return true;
        }
        else {
            return false;
        }
    }
    
    public static function getAllEmailprof($matriculeEtab) {
        $req="select codeperso, email from personnel where matriculeetab=:matriculeetab";
        $tabp=array("matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        $tabE= $con->executeReq($req, $tabp, "Teacher.php", 0, 0);
        $liste=array();
        for ($i = 0; $i < count($tabE); $i++) {
            $liste[$i] = array($tabE[$i]["codeperso"], $tabE[$i]["email"]);
        }
        return $liste;
    }
    
    public static function getTeacherByCode1(string $codeprof, School $etab) {
        $req="select codeperso, nomperso, sexe, fonction, username, password, sauvegarder_base, email, ap, departement, matriculeetab, langue, contact from personnel where codeperso=:codeperso and matriculeetab=:matriculeetab";
        $tabp=array("codeperso"=>$codeprof, "matriculeetab"=>$etab->getMatriculeetab());
        $con = new Connexion();
        $tabT = $con ->executeReq($req, $tabp, "Teacher.php", 0, 0);
        //$teacher = new Teacher ($tabT[$i]["codeperso"], $tabT[$i]["nomperso"]." ".$tabT[$i]["prenomperso"], $tabT[$i]["sexe"], $tabT[$i]["fonction"], $tabT[$i]["username"], $tabT[$i]["password"], $tabT[$i]["sauvegarder_base"], $tabT[$i]["email"], $tabT[$i]["ap"], $tabT[$i]["departement"], $etab);
        $tabInfoEtab = array("matriculeEtab"=>$etab->getMatriculeetab(), "nomEtabfR"=>$etab->getNomSchoolFr($etab->getMatriculeetab()), "nomEtabAng"=>$etab->getNomSchoolAng($etab->getMatriculeetab()));
        //array_push($tabT, $tabInfoEtab);
        return array("infoPersonnel"=>$tabT[0], "etablissement"=>$tabInfoEtab);
    }
    /*public function getListTeacherDepartement($departement, $annee, $matriculeetab) {
        $req = "select DISTINCT codeperso,nomperso,prenomperso,fonction from personnel,enseignement 
                where enseignement.nomannee='$annesco' and codeprof=codeperso and 
                codematiere in (select codematiere from matiere, ap where ap.departement=matiere.departement and 
                ap.departement='$dep' and ap.nomannee='$annesco') order by nomperso";
        $tabp=array("codeTeacher"=>$this->codeTeacher, "codeclasse"=>$codeclasse, "annesco"=>$annesco, "matriculeEtab"=>$this->etab->getMatriculeetab());
        $tabE = $this->executeReq($req, $tabp, "Teacher.php", 0, 0);
        $listeProf=array();
        for ($i = 0; $i < count($tabE); $i++) {
            $listeMatiere[] = array($tabE[$i]["codemat"], $tabE[$i]["nommat"]);
        }
        return $listeProf;
    }*/

}

