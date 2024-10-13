<?php
namespace model;

require_once ('Connexion.php');

/**
 *
 * @author ndele
 *        
 */
class Statfait extends Connexion
{
    private $nomannee;
    private $codeclasse;
    private $codematiere;
    private $numeroseq;
    private $codeperso;
    private $lecontheof;
    private $leconpraf;
    private $heuref;
    private $nhad;
    private $matriculeetab;
    
    /**
     */
    public function __construct()
    {}
    
    public static function insererDonneeStatfait($nomannee, $codeclasse, $codematiere, $numeroseq, $codeperso, $lecontheof, $leconpraf, $heuref, $nhad, $matriculeetab) {
        $req="insert into statfait values
              (:nomannee, :codelasse, :codematiere, :numeroseq, :codeperso, :lecontheof, :leconpraf, :heuref, :nhad, :matriculeetab)";
        $tabp=array("nomannee"=>$nomannee, "codelasse"=>$codeclasse, "codematiere"=>$codematiere, "numeroseq"=>$numeroseq, "codeperso"=>$codeperso, "lecontheof"=>$lecontheof, "leconpraf"=>$leconpraf, "heuref"=>$heuref, "nhad"=>$nhad, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Statfait.php", 0, 2);
    }
    
    public static function deleteStatfait($nomannee, $matriculeEtab, $trimestre) {
        $req="delete from statfait where nomannee=:nomannee and matriculeetab=:matriculeetab and numeroseq=:numeroseq";
        $tabp=array("nomannee"=>$nomannee, "matriculeetab"=>$matriculeEtab, "numeroseq"=>$trimestre);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Statfait.php", 0, 2);
    }
    
    public function getStatfait($classe, $numerosequence, $codematiere, $annesco, $matriculeEtab) {
        $req="select * from statfait where (codeclasse=:classe)AND(numeroseq=:numerosequence)AND (codematiere=:codematiere)AND(nomannee=:annesco)AND(matriculeetab=:matriculeEtab)";
        $tabp=array("classe"=>$classe, "numerosequence"=>$numerosequence, "codematiere"=>$codematiere, "annesco"=>$annesco, "matriculeEtab"=>$matriculeEtab);
        $tabR=$this->executeReq($req, $tabp, "Statfait.php", 0, 0);
        //$tabcomp=array();
        /*for ($i = 0; $i < count($tabR); $i++) {
            $tabcomp[$i]=array($tabR[$i]["nomannee"], $tabR[$i]["codeclasse"], $tabR[$i]["codematiere"], $tabR[$i]["numeroseq"], $tabR[$i]["codeperso"], $tabR[$i]["lecontheof"], $tabR[$i]["leconpraf"], $tabR[$i]["heuref"], $tabR[$i]["nhad"]);
        }*/
        if (count($tabR)==0) {
            return array();
        }
        else {
            return $tabR[0];
        }
        //return $tabcomp;
    }
    
    public static function getAllStatfait($annesco, $matriculeEtab) {
        $req="select nomannee,codeclasse,codematiere,numeroseq,codeperso,lecontheof,leconpraf,heuref,nhad 
                from statfait where (nomannee=:annesco)AND(matriculeetab=:matriculeEtab)
                order by codeclasse, codematiere";
        $tabp=array("annesco"=>$annesco, "matriculeEtab"=>$matriculeEtab);
        $con = new Connexion();
        $tabR=$con->executeReq($req, $tabp, "Statfait.php", 0, 0);
        $tabstat=array();
        for ($i = 0; $i < count($tabR); $i++) {
            $tabstat[$i]=array($tabR[$i]["nomannee"], $tabR[$i]["codeclasse"], $tabR[$i]["codematiere"], $tabR[$i]["numeroseq"], $tabR[$i]["codeperso"], $tabR[$i]["lecontheof"], $tabR[$i]["leconpraf"], $tabR[$i]["heuref"], $tabR[$i]["nhad"]);
        }
        return $tabstat;
    }
    
    public static function updateStatfait($codeclasse, $codematiere, $numeroseq, $nomannee, $matriculeEtab, $lecontheof, $leconpraf, $heuref, $nhad) {
        $req="update statfait set lecontheof=:lecontf, leconpraf=:leconpf, heuref=:heuref, nhad=:nhad
              where codeclasse=:codeclasse and codematiere=:codematiere and numeroseq=:numeroseq and nomannee=:nomannee and matriculeetab=:matriculeetab";
        $tabp=array("lecontf"=>$lecontheof, "leconpf"=>$leconpraf, "heuref"=>$heuref, "nhad"=>$nhad, "codeclasse"=>$codeclasse, "codematiere"=>$codematiere, "numeroseq"=>$numeroseq, "nomannee"=>$nomannee, "matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Statfait.php", 0, 2);
    }
    
    public static function getStatFaitNiveau($niveau, $numerosequence, $codematiere, $annesco, $matriculeEtab) {
        $req="select niveau, SUM(lecontheof) as ltf, SUM(leconpraf) as lpf, SUM(heuref) as hf from statfait, classe where statfait.nomannee=classe.nomannee and statfait.nomannee=:annesco and statfait.codeclasse=classe.codeclasse and niveau=:niveau and codematiere=:codematiere and statfait.matriculeetab=classe.matriculeetab and statfait.matriculeetab=:matriculeEtab group by niveau";
        
        $tabp=array("niveau"=>$niveau, "codematiere"=>$codematiere, "annesco"=>$annesco, "matriculeEtab"=>$matriculeEtab);
        $con = new Connexion();
        $tabR=$con->executeReq($req, $tabp, "StatFait.php", 0, 0);
        $tabstat=array();
        for ($i = 0; $i < count($tabR); $i++) {
            $tabstat[$i]=array($tabR[$i]["niveau"], $tabR[$i]["ltf"], $tabR[$i]["lpf"], $tabR[$i]["hf"]);
        }
        return $tabstat;
        //return $this->executeReq($req, $tabp, "StatPrevue.php", 0, 0)[0];
    }
}


