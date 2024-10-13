<?php
namespace model;

class ErrorManage
{
    /**
     * this class manage sql error 
     */
    
    public function displayerror($erreur, $mode) {
        /**
         * this function dispaly error depending on $mode.
         * if mode equal 0 : error is displayed in web page
         * if mode equal 1 : error is displayed in Javascript dialog box
         */
        
        switch ($mode) {
            case 0:
                return "<h1 class='sqlerrortext'>$erreur</h1>";
            break;
            case 1:
                return "<h1 class='sqlerrordialog'> $erreur</h1>";
            break;
            default:
                return "<h1 class='sqlerrordefault'>$erreur</h1>";
            break;
        }
    }
    
    protected function saveerror($error, $fisource, $req) {
        /**
         * this function save error in logsql.txt file and write source file, req and generated error
         */
        
        if (file_exists("../data/logsql.txt")) {
            $idf=fopen("../data/logsql.txt", "a");
            fwrite($idf, "$fisource  $req  $error \n");
            fclose($idf);
        }
        else {
            $idf=fopen("../data/logsql.txt", "w");
            fwrite($idf, "$fisource  $req  $error \n");
            fclose($idf);
        }
    }
}

