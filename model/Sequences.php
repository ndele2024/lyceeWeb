<?php
declare(strict_types=1);
namespace model;

require_once ('Connexion.php');

/**
 *
 * @author ndele
 *
 */
class Sequences extends Connexion
{
    private $nomannee;
    private $numtrim;
    private $statafternote;
    private $matriculeetab;
    private $datelimite;
    /**
     * @return mixed
     */
    public function getDatelimite()
    {
        return $this->datelimite;
    }

    /**
     * @param mixed $datelimite
     */
    public function setDatelimite($datelimite)
    {
        $req="update sequences set datelimite=:datelimite where matriculeetab=:matriculeetab and nomannee=:annee";
        $tabp=array("datelimite"=>$datelimite, "matriculeetab"=>$this->matriculeetab, "annee"=>$this->nomannee);
        $this->executeReq($req, $tabp, "Sequences.php", 0, 2);
        $this->datelimite = $datelimite;
    }

    /**
     * @return mixed
     */
    public function getMatriculeetab():string
    {
        return $this->matriculeetab;
    }

    /**
     * @return mixed
     */
    public function getNomannee():string
    {
        return $this->nomannee;
    }
    
    /**
     * @return mixed
     */
    public function getNumtrim():int
    {
        return (int) $this->numtrim;
    }
    
    /**
     * @return mixed
     */
    public function getStatafternote():string
    {
        return $this->statafternote;
    }
    
    /**
     */
    public function __construct($matriculeetab)
    {
        //$annee=$this->getNomannee();
        $req="select numtrim, nomannee, statafternote, matriculeetab, datelimite from sequences where matriculeetab=:matriculeetab order by nomannee desc, numtrim desc limit 1";
        $tabp=array("matriculeetab"=>$matriculeetab);
        $tabT=$this->executeReq($req, $tabp, "School.php", 0, 0);
        if(empty($tabT)) {
            $this->numtrim = 0;
            $this->nomannee = "";
            $this->statafternote = "non";
            $this->matriculeetab = $matriculeetab;
            $this->datelimite = "";
        }
        else {
            $this->numtrim = $tabT[0]["numtrim"];
            $this->nomannee = $tabT[0]["nomannee"];
            $this->statafternote = $tabT[0]["statafternote"];
            $this->matriculeetab = $matriculeetab;
            $this->datelimite = $tabT[0]["datelimite"];
        }
        
    }
    
    public static function insertDonneeSequence(int $numtrim, string $nomannee, string $statafternote, string $matriculeetab, $datelimite) {
       $req="insert into sequences values (:numtrim, :annee, :statafternote, :matriculeetab, :datelimite)";
        //$numtrim = $numtrim+0;
        if (empty($datelimite)) {
            $tabp=array("numtrim"=>$numtrim, "annee"=>$nomannee, "statafternote"=>$statafternote, "matriculeetab"=>$matriculeetab, "datelimite"=>NULL);
        }
        else {
            $tabp=array("numtrim"=>$numtrim, "annee"=>$nomannee, "statafternote"=>$statafternote, "matriculeetab"=>$matriculeetab, "datelimite"=>$datelimite);
        }
        //$tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Sequences.php", 0, 2);
    }
    
    public static function deleteSequences($matriculeEtab, $annee) {
        $req="delete from sequences where matriculeetab=:matriculeetab and nomannee=:nomannee";
        $tabp=array("matriculeetab"=>$matriculeEtab, "nomannee"=>$annee);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Sequences.php", 0, 2);
    }
}

