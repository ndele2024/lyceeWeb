<?php

use model\Matiere;

require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';
session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);
//$action=$_GET["hez"];
//print_r($sequence); exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>SYGBUSS YAKOO</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" /> 
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style/styleGestionNotes.css">
    <link rel="stylesheet" href="../style/styleshare.css">
    
	<script language="javascript" type="text/javascript" src="js/objetxhr.js"> </script>
	<script language="javascript" type="text/javascript" src="js/ajax.js"> 
	
	</script>

</head>
<body>
    <?php 
        //include("donnetmp.php");verification s'il est deja connecté sur un autre appareil
        include_once("addslashes1.php");
    
        //information sur le telephone
        //menu
        include("menu.php");
        
        if ($langue=="F") {
            $text=file_get_contents("contenu/prof1_francais.txt"); 
            $cont=explode("-", "$text"); $b1="annuler"; $b2="Enregistrer"; $b3="RETOUR"; 
            $im1="RETOUR_0.png"; $im2="RETOUR_1.png"; 
            $text0="Imprimer la fiche statistique";
            $text1="SELECTIONNER LE DEPARTEMENT";

        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt"); 
            $cont=explode("-", "$text"); $b1="cancel"; $b2="Save"; $b3="BACK"; 
            $im1="BACK_0.png"; $im2="BACK_1.png"; 
            $text0="Printing statistics";
            $text1="SELECT DEPARTMENT";
        }
    ?>
    
    <main>
        <div class="container mainpart">

            <div class="row">

                <div class="col-md-5 leftpart">

                </div>

                <div class="col-md-7 rightpart">
                    <form name="formulaire" method="post" action='../control/firstcontrol.php'>
                        <fieldset>
                            <legend>
                                <?php echo $text0; ?>
                            </legend>

                            <div class="container">
                            
                            	<div class="mt-2">
                            		<?php
                                        //affichage de la séquence/trimestre active
                                        $numtrim=$sequence->getNumtrim();
                                        echo"<input type='radio' name='seq' value='$numtrim' checked><b class='classe2'>Trimestre $numtrim</b>";
                                        //echo "<input type='hidden' name='action' value='$action'>";
                                    ?>
                            	</div>                            		

                                <div class="row mt-2">

                                    <div class="col-sm-6">
                                        <label for="departement"> <?php echo $text1; ?></label>
                                    </div>
                                    <div class="col-sm-6 d-flex align-items-center">
                                        <select name="departement" id="departement" class="form-select"
                                            aria-label="selectionner le departement" onchange="" required >
                                            <?php
                                                //afichage dynamique des codes classes à selectionner
                                                if(($prof->getFonction()=="CENSEUR")OR($prof->getFonction()=="PROVISEUR")OR($prof->getFonction()=="SURVEILLANT GENERAL")){
                                                    $tabDepartement=Matiere::getAllDepart($sequence->getMatriculeetab());                                  
                                                }
                                                else{
                                                    $tabDepartement=array($prof->getDepartement());
                                                }
                                                    
                                                $n=count($tabDepartement);
                                                echo "<option value=''>--$cont[8]--</option>";
                                                for ($i=0; $i<$n; $i++) {
                                                    $cc=utf8_decode($tabDepartement[$i]);
                                                echo "<option value=\"$tabDepartement[$i]\" id=\"classe$i\"> $cc</option>";
                                                }                                        
                                            ?>
                                        </select>
                                        
                                    </div>
                                </div>

                                <div class="row mt-3" id="mesclasses">
                                    
                                </div>             

                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success d-block w-100" type="submit" name="valider_print_stat" id="ok_print">
                                            Ok
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </fieldset>
                    </form>

                    <div class="my-4">
                        <?php   echo boutonretour("accueil_prof.php", $langue); ?>
                    </div>
                    
                        <?php
                        
                            if(isset($_GET["err"])) {
                                switch ($_GET["err"]) {
                                    case 1:
                                        echo "<div class=\"rouge\">$cont[9] $te2</div>";
                                        break;
                                    case 2:
                                        echo"<div class='rouge'>$te5</div>";
                                        break;
                                    case 3:
                                        echo"<div class='rouge'>OPTION ENCORE EN COURS DE REALISATION! REESSAYER PLUS TARD</div>";
                                        break;
                                    
                                    default:
                                        ;
                                    break;
                                }
                                
                            }
                            
                        ?>

                </div>

            </div>

        </div>

    </main>

    <script src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script> 
    </body>
    </html>
    
    