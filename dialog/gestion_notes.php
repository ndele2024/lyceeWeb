<?php
require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';
session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);
$action=$_GET["hez"];
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
            $text1="Vous n\'avez pas encore entrer les statistiques de cette matière\\n Veuillez entrer les statistiques avant d\'entrer les notes";
            $te5="Vous avez déja entré les notes des devoirs prévus pour ce trimestre. vous pouvez uniquement modifier les notes";
            $te2="et saisir la compétence";
            $te3="Vous êtes sur le point d\'entrer les notes du devoir";
            $te4="Vous ne pouvez plus entrer les notes la date limite est dépassée";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt"); 
            $cont=explode("-", "$text"); $b1="cancel"; $b2="Save"; $b3="BACK"; 
            $im1="BACK_0.png"; $im2="BACK_1.png"; 
            $text1="Vous n\'avez pas encore entrer les statistiques de cette matière\\n Veuillez entrer les statistiques avant d\'entrer les notes";
            $te5="You have already entered the homework marks for this quarter. you can only edit the marks";
            $te2="and enter the skill";
            $te3="Vous êtes sur le point d\'entrer les notes du devoir";
            $te4="You cannot enter the marks. the limit date is expired";
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
                                <?php echo $cont[6]; ?>
                            </legend>

                            <div class="container">
                            
                            	<div class="mt-2">
                            		<?php
                                        //affichage de la séquence/trimestre active
                                        $numtrim=$sequence->getNumtrim();
                                        echo"<input type='radio' name='seq' value='$numtrim' checked><b class='classe2'>Trimestre $numtrim</b>";
                                        echo "<input type='hidden' name='action' value='$action'>";
                                    ?>
                            	</div>                            		

                                <div class="row mt-2">

                                    <div class="col-sm-6">
                                        <label for="classe"> <?php echo $cont[7]; ?></label>
                                    </div>
                                    <div class="col-sm-6 d-flex align-items-center">
                                        <select name="classe" id="classe" class="form-select"
                                            aria-label="selectionner la classe" onchange="get_matiere_prof(this.value, 'gestion_notes')" required >
                                            <?php
                                                //afichage dynamique des codes classes à selectionner
                                                $tabclasseProf=$prof->getClasseProf($sequence->getNomannee());                                         
                                                $n=count($tabclasseProf);
                                                echo "<option value=''>--$cont[8]--</option>";
                                                for ($i=0; $i<$n; $i++) {
                                                    $cc=utf8_decode($tabclasseProf[$i]);
                                                echo "<option value=\"$tabclasseProf[$i]\" id=\"classe$i\"> $cc</option>";
                                                }                                        
                                            ?>
                                        </select>
                                        
                                    </div>
                                </div>

                                <div class="row mt-3" id="mesclasses">
                                    
                                </div>
                                
                                <div class="mt-3" id="mescomp">
                                
                                </div>                           

                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success d-block w-100" type="submit" name="valider_gestion_note" id="ok_note">
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
                                        echo"<div class='rouge'>Vous n'avez pas sélectionner le devoir / You have not selected evaluation</div>";
                                        break;
                                    
                                    case 4:
                                        echo"<div class='rouge'>Vous n'avez pas entré les notes de tous les élèves / You have not entered all the marks of students</div>";
                                        break;
                                    
                                    case 5:
                                        echo"<div class='rouge'> $te4 </div>";
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
    
    