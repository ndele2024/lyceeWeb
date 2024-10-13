<?php
require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';
session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);
//print_r($sequence); exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
            $text1="Sélecionner la classe pour entrer ou modifier les heures d'absence";
            $te5="Vous avez déja entré les heures d'absence dans cette classe. Vous pouvez allez modifier";

        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt"); 
            $cont=explode("-", "$text"); $b1="cancel"; $b2="Save"; $b3="BACK"; 
            $im1="BACK_0.png"; $im2="BACK_1.png"; 
            $text1="select class to enter or update students absence time";
            $te5="You have already entered the absence time. you can update it now";
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

                    <form name="formulaire" method="post" action='../control/firstcontrol.php'>
                        <div class="my-2 bg-light text-center">
                            <?php echo $text1; ?>
                        </div>
                        <div class="mb-2 mt-4">
                            <label for="personnel"><?php echo $cont[7]; ?></label>
                        </div>
                        <div class="mb-5">
                            <select name="classe" id="classe" onchange="gestionValidationAbsence(this.value, 'ok_abs')" class="form-select" require>
                                <?php
                                    //afichage dynamique des codes classes à selectionner
                            	   $tabclasseProf=$prof->getEtab()->getAllClasse($sequence->getMatriculeetab(), $sequence->getNomannee());
                                    $n=count($tabclasseProf);
                                    echo "<option value=''>--$cont[8]--</option>";
                                    for ($i=0; $i<$n; $i++) {
                                        $cc=utf8_decode($tabclasseProf[$i]);
                                    echo "<option value=\"$tabclasseProf[$i]\" id=\"classe$i\"> $cc</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="buttondatelimite col-md-12 mb-4">
                            <button type="submit" name="valider_gestion_absence" id="ok_abs" class="btn btn-success d-block w-50 m-auto">Ok</button>
                        </div>
                    </form>
					<?php
        
                        if(isset($_GET["err"])) {
                            switch ($_GET["err"]) {
                                case 1:
                                    echo "<h1 class=\"rouge\">$cont[9] $te2</h1>";
                                    break;
                                case 2:
                                    echo"<div class='rouge'>$te5</div>";
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

  