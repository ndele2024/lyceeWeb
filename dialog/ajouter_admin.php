<?php

use model\School;

require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';

session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);

$school = new School($sequence->getMatriculeetab());
$tabEnseignant=$school->getAllTeacher($sequence->getMatriculeetab());
$tabAdmin=$school->getAllTeacherAdmin($sequence->getMatriculeetab());
//print_r($tabEnseignant); exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>lyc&eacute;e / accueil professeur</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" /> 
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style/styleshare.css">
    <link rel="stylesheet" href="../style/styleGestionNotes.css">
	<script language="javascript" type="text/javascript" src="js/objetxhr.js"> </script>
	<script language="javascript" type="text/javascript" src="js/ajax.js"> 
	</script>
	
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
            $te1="Ajouter ou supprimer un administrateur";
            $te2="Sélectionner l'enseignant";
            $te3="Ajouter comme administrateur";
            $te4="Liste des enseignants administrateurs";
            $te5="Supprimer";
            $te6="Ajouter comme administrateur";
            $te7="sélectionner l'enseignant";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt");
            $cont=explode("-", "$text");
            $b1="delete"; $b2="Save"; $b3="BACK"; $im1="BACK_0.png"; $im2="BACK_1.png";
            $te1="Add or remove an administrator";
            $te2="Select Teacher";
            $te3="Add as administrator";
            $te4="Teacher's administrator list";
            $te5="Delete";
            $te6="Add as administrator";
            $te7="Select teacher";
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
                    <div class="container">
                    
                        <div class="row mb-5 bg-light text-center">
                            <div class="col-sm-12 ">
                                <?php echo $te1; ?>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <label for="enseignant"></label><?php echo $te2; ?> :
                            </div>
                            <div class="col-sm-6">
                                <select name="enseignant" id="enseignant" class="form-select"
                                            aria-label="selectionner la classe" required>
                                    <option value="">Select</option>
                                    <?php
                                        for ($i=0; $i < count($tabEnseignant); $i++) { 
                                            $codep=$tabEnseignant[$i]->getCodeTeacher();
                                            $nomp=$tabEnseignant[$i]->getNomTeacher();
                                            echo"<option value='$codep'>$nomp</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-sm-12">
                                <button type="submit" name="validerAdmin" class="btn btn-success d-block w-100">
                                    <?php echo $te6; ?>
                                </button>
                            </div>
                        </div>
                        
                    </div>

                    <div>
                    <br />
                                <fieldset>
                                <br />
                                    <table width="70%" align="center" cellspacing="20px" border="1" class="table">
                                        <tr align="center">
                                            <th colspan="2"><?php echo $te4; ?></th>
                                        </tr>
                                        
                                        <?php
                                            for ($i=0; $i < count($tabAdmin); $i++) { 
                                                $codep=$tabAdmin[$i]->getCodeTeacher();
                                                $nomp=$tabAdmin[$i]->getNomTeacher();
                                                $fonct=$tabAdmin[$i]->getFonction();
                                                if ($fonct=="PROVISEUR") {
                                                    $sup="";
                                                }
                                                else {
                                                    $sup=$te5;
                                                }
                                                echo"<tr align='center'><td><input type='hidden' name='prof$i' value='$codep' />";
                                                echo "$nomp</td>";
                                                echo "<td><span id='prof$i' onclick='supprimeAdmin(this.id, \"suppAdmin\")' class='sup_admin' style='cursor:pointer; color:red; text-decoration:underline;'>$sup</span></td>
                                                    </tr>";
                                            }
                                        ?>
                                        
                                    </table>
                                    <br />
                                </fieldset>
                                <br />
                    </div>
                </form>
            </div>
        </div>      
    </div>

</main>    
    <?php
        
        if(isset($_GET["er"])) {
            if ($_GET["er"]=="1") {
                echo "<div align='center' class='classe1'>$te7</div>";
            }
            elseif ($_GET["er"]=="2") {
                echo "<script language='javascript'> alert('Effectué / Done');</script>";
            }
            elseif ($_GET["er"]=="3") {
                //echo "<div align='center' class='classe1'>$te4</div>";
                //echo boutonretour("session_out.php", $langue);
            }
            else {
                ;
            }
        }
    ?>
    <script src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>

</body>
</html>
	
	
	
