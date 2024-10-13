<?php
namespace model;

use mysqli;

require_once 'ErrorManage.php';

class Connexion extends ErrorManage
{
    
    protected function connex($base,$param)
    {
        include_once($param.".inc.php");
        $dsn="mysql:host=".HOST.";dbname=".$base;
        $user=USER;
        $pass=PASS;
        try
        {
            $idcom = new \PDO($dsn,$user,$pass);
            //$idcom = mysqli(HOST,$user,$pass,$base);
            return $idcom;
        }
        catch(\PDOException $e)
        {
            print_r($e->getMessage()); exit();
            //$this->displayerror($e->getMessage(), 0);
            //echo"Échec de la connexion",$e->getMessage();
            return FALSE;
            exit();
        }
    }
    
    /**
     * this function execute query 
     * $req : query you want to execute
     * $tabparam : array of parameter of the query
     * $fich : php file which contain query
     * $mod : the way when you want to display error (0 or 1)
     * $param : type of result you want to get after query execution (0 or 1)
     */
    public function executeReq($req, $tabparam, $fich, $mod, $param)
    {
        $idcom=$this->connex("lycee", "myparam");
        $reqprepa=$idcom->prepare($req);
        $tt=$reqprepa->execute($tabparam);

        if(!$tt) {
            $taberror=$reqprepa->errorInfo();
            $this->saveerror($taberror[2], $fich, $req);
           return $this->displayerror($taberror[2], $mod);
            
        }
        else {
            switch ($param) {
                case 0:
                    return $reqprepa->fetchAll(\PDO::FETCH_ASSOC);
                    break;
                case 1:
                    return $reqprepa->rowCount();
                    break;
                default:
                    return true;
                    break;
            }
        }
        
        $reqprepa->closeCursor();
        $idcom=null;
    }
    
    
}

