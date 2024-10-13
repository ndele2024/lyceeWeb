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
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style/styleshare.css">
    <link rel="stylesheet" href="../style/styleGestionNotes.css">
    <link rel="stylesheet" href="../style/stylestatprof.css">
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
            $text=file_get_contents("contenu/prof2_francais.txt"); 
            $cont=explode("-", "$text"); $b1="annuler"; $b2="Enregistrer"; $b3="RETOUR"; 
            $im1="RETOUR_0.png"; $im2="RETOUR_1.png"; 
            $text1="Vous n'avez pas encore entrer les statistiques de cette matière\\n Veuillez entrer les statistiques avant d'entrer les notes";
        }
        else {
            $text=file_get_contents("contenu/prof2_anglais.txt"); 
            $cont=explode("-", "$text"); $b1="cancel"; $b2="Save"; $b3="BACK"; 
            $im1="BACK_0.png"; $im2="BACK_1.png"; 
            $text1="Vous n'avez pas encore entrer les statistiques de cette matière\\n Veuillez entrer les statistiques avant d'entrer les notes";
        }
    ?>
    
     <main>
        <div class="container mainpart">
            <div class="row">
                <div class="col-md-5 leftpart">

                </div>

                <div class="col-md-7 rightpart">
                    <div class="mb-2">
                         <?php
                            echo boutonretour("accueil_prof.php", $langue);
                         ?>
                    </div>
                    <hr />

                    <form name="formulaire" method="post" action='../control/firstcontrol.php'>
                    	<input type='hidden' name='action' value='5' />
                        <div class="container p-2 selectmatiereclasse">
                            <div class="row mb-4">
                                <div class="col-12 bg-light text-center titrestart">
                                    <?php echo $cont[0]; ?>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="labinput col-md-6">
                                    <label for="selectclasse" class="form-label"><?php echo $cont[2]; ?></label>
                                </div>

                                <div class="col-md-6">
                                    <select name="classe" id="classe" class="form-select" onchange="get_matiere_prof(this.value, 'gestion_notes')" required>
                                        <?php
                                            //afichage dynamique des codes classes à selectionner
                                            $tabclasseProf=$prof->getClasseProf($sequence->getNomannee());
                                            $n=count($tabclasseProf);
                                            echo "<option value=''>--$cont[3]--</option>";
                                            for ($i=0; $i<$n; $i++) {
                                                $cc=utf8_decode($tabclasseProf[$i]);
                                                echo "<option value=\"$tabclasseProf[$i]\" id=\"classe$i\"> $cc</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class='row mb-2' id="mesclasses">

                            </div>

                        </div>
                        <hr />
						
						<div class="" id="mescomp" align="">
						
                    	</div>
                        
                    </form>
					
					<?php
        
                        if(isset($_GET["er"])) {
                            switch ($_GET["er"]) {
                                case 1:
                                    echo"<div class='classe1'>$cont[4]</div>";
                                    break;
                                case 2:
                                    echo "<script language='javascript'> alert('Effectué / Done');</script>";
                                    break;
                                    
                                case 3:
                                    echo"<div class='classe1'>Non éffectué recommencer / No done try again</div>";
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
    
    