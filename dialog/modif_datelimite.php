<?php

use model\School;

require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';

session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);

$annee=$sequence->getNomannee();
$a1=explode(" ", $annee)[0];
$a2=$a1+2;
//print_r($tabEnseignant); exit();
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
    <link rel="stylesheet" href="../style/styleshare.css">
    <link rel="stylesheet" href="../style/styleGestionNotes.css">
    <link rel="stylesheet" href="../style/styleModifDatelimite.css">
    <script language="javascript" type="text/javascript" src="js/objetxhr.js"> </script>
	<script language="javascript" type="text/javascript" src="js/ajax.js"> 
	
	</script>
</head>

<body>
	<?php 
        //include("donnetmp.php");verification s'il est deja connecté sur un autre appareil
        //include_once("addslashes1.php");
        
        //information sur le telephone
        //$param="?imei=$tabinfo[0]&serial=$tabinfo[1]&id=$tabinfo[2]&model=$tabinfo[3]&fabriquant=$tabinfo[4]&deconn=oui";
        //menu
        include("menu.php");
        
        if ($langue=="F") {
            $text=file_get_contents("contenu/prof1_francais.txt");
            $cont=explode("-", "$text");
            $b1="supprimer"; $b2="Enregistrer"; $b3="RETOUR"; $im1="RETOUR_0.png"; $im2="RETOUR_1.png";
            $te1="Modifier la date limite d'entrée des notes";
            $te2="Sélectionner la date";
            $te3="Date éronée";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt");
            $cont=explode("-", "$text");
            $b1="delete"; $b2="Save"; $b3="BACK"; $im1="BACK_0.png"; $im2="BACK_1.png";
            $te1="Add or remove an administrator";
            $te2="Select Date";
            $te3="Bad date";
        }
    ?>
    
     <main>
        <div class="container mainpart">
            <div class="row">
                <div class="col-md-5 leftpart">

                </div>

                <div class="col-md-7 rightpart">

                    <div class="container w-75 p-3 text-center zonemodifdate">
                        <form name="formulaire" method="post" action="../control/firstcontrol.php" id="formu">
                            <div class="row mb-5">
                                <div class="col-12 fs-4 bg-light">
                                    <?php echo $te1; ?>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="labinput col-md-6">
                                    <label for="validationdatelimite" class="form-label"><?php echo $te2; ?></label>
                                </div>

                                <div class="col-md-6">
                                    <input type="date" name="datelimite" class="form-control" id="validationdatelimite"
                                        placeholder="yy-mm-aaa" maxlength="8"
                                        aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="buttondatelimite col-md-12">
                                    <button type="submit" name="validerModifDatelimite" class="btn btn-success d-block w-100">Ok</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <div class="my-4">
                       <?php echo boutonretour("accueil_prof.php", $langue); ?>
                    </div>
                    <?php                
                        if(isset($_GET["er"])) {
                            if ($_GET["er"]=="1") {
                                echo "<div align='center' class='rouge'>$te2</div>";
                            }
                            elseif ($_GET["er"]=="2") {
                                echo "<div align='center' class='rouge'>$te2</div>";
                            }
                            elseif ($_GET["er"]=="3") {
                                echo "<script language='javascript'> alert('Effectué / Done');</script>";
                            }
                            else {
                                ;
                            }
                        }
                    ?>
                    
                </div>
            </div>
        </div>
    </main>
    
      
    <script src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
    <script src="jquery.js"></script>
   <script src="jquery-ui-1.12.1/jquery-ui.js"></script>
    <script>
    $(document).ready(function(){
    	min=$("#datemin").val();
    	max=$("#datemax").val();
        $ ("#datepicker") .datepicker ({
        	dateFormat: "dd-mm-yy",
        	dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
        	 monthNamesShort: [ "Jan", "Fev", "Mar", "Avr", "Mai", "Juin", "Juil", "Aout", "Sep", "Oct", "Nov", "Dec" ],
        	 yearRange: min+":"+max,
        	changeMonth: true,
        	changeYear: true
        });
      });
    	//maxDate: new Date(max, 1 - 1, 1),
        //minDate: new Date(min, 1 - 1, 1),
    </script>
   </body>
   </html>
	
	
	