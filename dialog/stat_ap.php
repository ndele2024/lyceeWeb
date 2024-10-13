<?php

use model\Classe;

require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';
session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);                                      
//print_r($tabSerie); exit();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
    <title>SYGBUSS YAKOO</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" /> 
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.css" />
    <link rel="stylesheet" href="../style/styleshare.css" />
    <link rel="stylesheet" href="../style/styleGestionNotes.css" />
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
            $text1="PREVISIONS STATISTIQUES ANNUELLES";
            $text2="SELECTIONNER LE NIVEAU";
            $text3="Sélectionner la matière";
            $text4="Leçons théoriques prévues";
            $text5="Leçons pratiques prévues";
            $text6="Heures prévues";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt"); 
            $cont=explode("-", "$text"); $b1="cancel"; $b2="Save"; $b3="BACK"; 
            $im1="BACK_0.png"; $im2="BACK_1.png"; 
            $text1="ANNUAL PREVISIONNAL STATISTICS";
            $text2="SELECT LEVEL";
            $text3="Selectla subject";
            $text4="Theoretical lessons previewed";
            $text5="Practical lessons previewed";
            $text6="Hours previewed";
        }
    ?>

    <main>
        <div class="container mainpart">
            <div class="row">
                <div class="col-md-5 leftpart">

                </div>

                <div class="col-md-7 rightpart">
                    <div class="mb-2">
                        <?php echo boutonretour("accueil_prof.php", $langue); ?>
                    </div>
                    <hr />

                    <form name="formulaire" method="post" action="../control/firstcontrol.php" id="formu">
						<div class="mb-3 bg-light text-center">
                            <?php echo $text1; ?>
                        </div>
                        <div class="container mt-3">
                            <div class="row mt-2">
                                <div class="col-sm-6">
                                    <label for="classe"> <?php echo $text2; ?></label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <select name="niveau" id="niveau" class="form-select"
                                        aria-label="selectionner le niveau" onchange="get_serie_server(this.value, 'allserie')" required >
                                        <?php
                                            //afichage dynamique des codes classes à selectionner
                                            $tabSerie=Classe::getAllNiveau($sequence->getMatriculeetab(),$sequence->getNomannee());                                         
                                            $n=count($tabSerie);
                                            echo "<option value=''>--$cont[8]--</option>";
                                            for ($i=0; $i<$n; $i++) {
                                            echo "<option value=\"$tabSerie[$i]\" id=\"\"> $tabSerie[$i] </option>";
                                            }                                        
                                        ?>
                                    </select>
                                
                                </div>
                            </div>

                            <div class="row mt-3" id="mesclasses">
                           
                            </div>

                            <div class="row mt-3" id="zonemat">
                            
                            </div>

                            <div class="row text-center mt-3" id="zonestat">
                            
                            </div>

                        </div>

					</form>

                    <?php
        
                        if(isset($_GET["er"])) {
                            switch ($_GET["er"]) {
                                case 1:
                                    echo "<script language='javascript'> alert('Effectué / Done');</script>";
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