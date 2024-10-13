<?php
namespace model;

require_once ('Connexion.php');

/**
 *
 * @author ndele
 *
 */
class StatPrevue extends Connexion
{
    private $nomannee;
    private $codeclasse;
    private $codematiere;
    private $numeroseq;
    private $codeperso;
    private $leconpt;
    private $leconpp;
    private $heurep;
    private $matriculeetab;
    
    /**
     */
    public function __construct()
    {}
    
    public static function insererDonneeStatPrevue($nomannee, $codeclasse, $codematiere, $numeroseq, $leconpt, $leconpp, $heurep, $matriculeetab) {
        $req="insert into statprevue values
              (:nomannee, :codelasse, :codematiere, :numeroseq, :leconpt, :leconpp, :heurep, :matriculeetab)";
        $tabp=array("nomannee"=>$nomannee, "codelasse"=>$codeclasse, "codematiere"=>$codematiere, "numeroseq"=>$numeroseq, "leconpt"=>$leconpt, "leconpp"=>$leconpp, "heurep"=>$heurep, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "StatPrevue.php", 0, 2);
    }
    
    public static function deleteStatPrevue($nomannee, $matriculeEtab) {
        $req="delete from statprevue where nomannee=:nomannee and matriculeetab=:matriculeetab";
        $tabp=array("nomannee"=>$nomannee, "matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "StatPrevue.php", 0, 2);
    }

    public static function updateStatprevue($nomannee, $matriculeEtab, $codeclasse, $codematiere, $numtrim, $tabdonnee) {
        $req="update statprevue set leconpt=:lpt, leconpp=:lpp, heurep=:hp where nomannee=:nomannee and matriculeetab=:matriculeetab and numeroseq=:trim and codeclasse=:codeclasse and codematiere=:codematiere";
        $tabp=array("nomannee"=>$nomannee, "matriculeetab"=>$matriculeEtab, "trim"=>$numtrim, "codeclasse"=>$codeclasse, "codematiere"=>$codematiere, "lpt"=>$tabdonnee[0], "lpp"=>$tabdonnee[1], "hp"=>$tabdonnee[2]);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "StatPrevue.php", 0, 2);
    }
    
    public function getStatPrevue($classe, $numerosequence, $codematiere, $annesco, $matriculeEtab) {
        $req="select * from statprevue where (codeclasse=:classe)AND(numeroseq=:numerosequence)AND (codematiere=:codematiere)AND(nomannee=:annesco)AND(matriculeetab=:matriculeEtab)";
        $tabp=array("classe"=>$classe, "numerosequence"=>$numerosequence, "codematiere"=>$codematiere, "annesco"=>$annesco, "matriculeEtab"=>$matriculeEtab);
        $tabR=$this->executeReq($req, $tabp, "StatPrevue.php", 0, 0);
        if (count($tabR)==0) {
            return array();
        }
        else {
            return $tabR[0];
        }
        //return $this->executeReq($req, $tabp, "StatPrevue.php", 0, 0)[0];
    }

    public static function getStatPrevueannee($niveau, $serie, $codematiere, $annesco, $matriculeEtab) {
        if($serie=="tout"){
            $req="select distinct leconpt, leconpp, heurep, numeroseq from statprevue, classe where (classe.codeclasse=statprevue.codeclasse) and (niveau=:niveau) AND (codematiere=:codematiere)AND(classe.nomannee=:annesco)AND(statprevue.nomannee=:annesco)AND(classe.matriculeetab=:matriculeEtab)AND(statprevue.matriculeetab=:matriculeEtab) order by numeroseq";
            $tabp=array("niveau"=>$niveau, "codematiere"=>$codematiere, "annesco"=>$annesco, "matriculeEtab"=>$matriculeEtab);
        }
        else{
            $req="select distinct leconpt, leconpp, heurep, numeroseq from statprevue, classe where (classe.codeclasse=statprevue.codeclasse)AND(niveau=:niveau)AND(serie=:serie)AND(codematiere=:codematiere)AND(classe.nomannee=:annesco)AND(statprevue.nomannee=:annesco)AND(classe.matriculeetab=:matriculeEtab)AND(statprevue.matriculeetab=:matriculeEtab) order by numeroseq";
            $tabp=array("niveau"=>$niveau, "codematiere"=>$codematiere, "annesco"=>$annesco, "matriculeEtab"=>$matriculeEtab, "serie"=>$serie);
        }
        
        $con = new Connexion();
        $tabR=$con->executeReq($req, $tabp, "StatPrevue.php", 0, 0);
        $donneprevue=array();
        for ($i=0; $i < count($tabR); $i++) { 
            $donneprevue[]=array($tabR[$i]["leconpt"], $tabR[$i]["leconpp"], $tabR[$i]["heurep"]);
        }
        return $donneprevue;
        //return $this->executeReq($req, $tabp, "StatPrevue.php", 0, 0)[0];
    }
    
    public static function getAllStatPrevue($annesco, $matriculeEtab) {
        $req="select nomannee,codeclasse,codematiere,numeroseq,leconpt,leconpp,heurep 
                from statprevue where (nomannee=:annesco)AND(matriculeetab=:matriculeEtab)
                order by codeclasse, codematiere";
        $tabp=array("annesco"=>$annesco, "matriculeEtab"=>$matriculeEtab);
        $con = new Connexion();
        $tabR=$con->executeReq($req, $tabp, "StatPrevue.php", 0, 0);
        $tabstat=array();
        for ($i = 0; $i < count($tabR); $i++) {
            $tabstat[$i]=array($tabR[$i]["nomannee"], $tabR[$i]["codeclasse"], $tabR[$i]["codematiere"], $tabR[$i]["numeroseq"], $tabR[$i]["leconpt"], $tabR[$i]["leconpp"], $tabR[$i]["heurep"]);
        }
        return $tabstat;
    }
    
    public static function getnobreStat($nomannee, $matriculeEtab) {
        $req="select * from statprevue where nomannee=:nomannee and matriculeetab=:matriculeetab";
        $tabp=array("nomannee"=>$nomannee, "matriculeetab"=>$matriculeEtab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Statfait.php", 0, 1);
    }

    public static function getStatPrevueNiveau($niveau, $numerosequence, $codematiere, $annesco, $matriculeEtab) {
        $req="select niveau, SUM(leconpt) as lpt, SUM(leconpp) as lpp, SUM(heurep) as hp from statprevue, classe where statprevue.nomannee=classe.nomannee and statprevue.nomannee=:annesco and statprevue.codeclasse=classe.codeclasse and niveau=:niveau and codematiere=:codematiere and statprevue.matriculeetab=classe.matriculeetab and statprevue.matriculeetab=:matriculeEtab group by niveau";
        
        $tabp=array("niveau"=>$niveau, "codematiere"=>$codematiere, "annesco"=>$annesco, "matriculeEtab"=>$matriculeEtab);
        $con = new Connexion();
        $tabR=$con->executeReq($req, $tabp, "StatPrevue.php", 0, 0);
        $tabstat=array();
        for ($i = 0; $i < count($tabR); $i++) {
            $tabstat[$i]=array($tabR[$i]["niveau"], $tabR[$i]["lpt"], $tabR[$i]["lpp"], $tabR[$i]["hp"]);
        }
        return $tabstat;
        //return $this->executeReq($req, $tabp, "StatPrevue.php", 0, 0)[0];
    }
    
}


