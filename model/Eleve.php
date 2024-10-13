<?php
namespace model;

require_once ('Connexion.php');

/**
 *
 * @author ndele
 *        
 */
class Eleve extends Connexion
{
    private $matricule;
    private $numero;
    private $nomEleve;
    private $sexe;
    private $datenaiss;
    private $lieunaiss;
    private $classe;
    private $redoublant;
    private $numparent;
    private $nomannee;
    private $matiereopt;
    private $matriculeetab;
    
    /**
     */
    public function __construct()
    {
        
    }
    
    public static function insererDoneeEleve($matricule, $numero, $nomEleve, $sexe, $datenaiss, $lieunaiss, $codeclasse, $redoublant, $numparent, $nomannee, $matiereopt, $matriculeetab) {
        $req="insert into eleve values
              ('$matricule','$numero','$nomEleve','$sexe','$datenaiss','$lieunaiss','$codeclasse','$redoublant','$numparent','$nomannee','$matiereopt','$matriculeetab')";
        //$tabp=array("matricule"=>$matricule, "numero"=>$numero, "nomEleve"=>$nomEleve, "sexe"=>$sexe, "datenaiss"=>$datenaiss, "lieunaiss"=>$lieunaiss, "codeclasse"=>$codeclasse, "redoublant"=>$redoublant, "numparent"=>$numparent, "nomannee"=>$nomannee, "matiereopt"=>$matiereopt, "matriculeetab"=>$matriculeetab);
        $tabp=array();
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Eleve.php", 0, 2);
    }
    
    public static function deleteEleve($nomannee, $matriculeetab) {
        $req="delete from eleve where nomannee=:nomannee and matriculeetab=:matriculeetab";
        $tabp=array("nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Eleve.php", 0, 2);
    }
    
    public static function getNombreEleve($nomannee, $matriculeetab) {
        $req="select matricule from eleve where nomannee=:nomannee and matriculeetab=:matriculeetab";
        $tabp=array("nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab);
        $con = new Connexion();
        return $con->executeReq($req, $tabp, "Eleve.php", 0, 1);
    }

    public static function getEleveClasse($nomannee, $matriculeetab, $codeclasse) {
        $req="select matricule, nomeleve from eleve where nomannee=:nomannee and matriculeetab=:matriculeetab and codeclasse=:codeclasse";
        $tabp=array("nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab, "codeclasse"=>$codeclasse);
        $con = new Connexion();
        $tabE = $con->executeReq($req, $tabp, "Eleve.php", 0, 0);
        $tabeleve=array();
        for ($i=0; $i < count($tabE); $i++) { 
            $tabeleve[]=array($tabE[$i]["matricule"], $tabE["nomeleve"]);
        }
        return $tabeleve;
    }

    public static function getEleveNiveau($nomannee, $matriculeetab, $niveau) {
        $req="select matricule, nomeleve from eleve, classe where eleve.nomannee=:nomannee and eleve.matriculeetab=:matriculeetab and eleve.nomannee=classe.nomannee and eleve.matriculeetab=classe.matriculeetab and eleve.codeclasse=classe.codeclasse and niveau=:niveau";
        $tabp=array("nomannee"=>$nomannee, "matriculeetab"=>$matriculeetab, "niveau"=>$niveau);
        $con = new Connexion();
        $tabE = $con->executeReq($req, $tabp, "Eleve.php", 0, 0);
        $tabeleve=array();
        for ($i=0; $i < count($tabE); $i++) { 
            $tabeleve[]=array($tabE[$i]["matricule"], $tabE[$i]["nomeleve"]);
        }
        return $tabeleve;
    }

}

