<?php
use model\School;
use model\Teacher;

require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';

session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);

$school = $prof->getEtab();
$taballTeacher = $school->getAllTeacher($school->getMatriculeetab());

//print_r($taballTeacher); exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>SYGBUSS YAKOO</title>
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
        //$param="?imei=$tabinfo[0]&serial=$tabinfo[1]&id=$tabinfo[2]&model=$tabinfo[3]&fabriquant=$tabinfo[4]&deconn=oui";
        //menu
        include("menu.php");
        
        if ($langue=="F") {
            $text=file_get_contents("contenu/prof1_francais.txt");
            $cont=explode("-", "$text");
            $b1="supprimer"; $b2="Enregistrer"; $b3="RETOUR"; $im1="RETOUR_0.png"; $im2="RETOUR_1.png";
            $te1="Sélectionner l'enseignant";
            $te2="Réinitialiser";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt");
            $cont=explode("-", "$text");
            $b1="delete"; $b2="Save"; $b3="BACK"; $im1="BACK_0.png"; $im2="BACK_1.png";
            $te1="Select teacher";
            $te2="Reinitialise";
        }
    ?>
	
	<main>

        <div class="container mainpart">

            <div class="row">

                <div class="col-md-5 leftpart">

                </div>

                <div class="col-md-7 rightpart">

                    <div class="">
                        <?php echo boutonretour("accueil_prof.php", $langue); ?>
                    </div>
                    <hr />

                    <form name="formulaire" method="post" action="../control/firstcontrol.php" id="formu">
                        <div class="container border-start border-end border-2 border-light mt-4 pt-3">
                            <div class="row">
                                <div class="col-12 bg-light mb-4 text-center">
                                    Réinitialiser un compte / reinitialize an account
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <label for="personnel"><?php echo $te1 ?> </label>
                                </div>
                                <div class="col-sm-6 d-flex  align-items-center">                                	: 
                                    <select name="teacher" id="personnel" class="form-select" required>
                                        <?php 
                                		  for ($i = 0; $i < count($taballTeacher); $i++) {
                                		      $codeteacher=$taballTeacher[$i]->getCodeTeacher();
                                		      $nameTeacher=$taballTeacher[$i]->getNomTeacher();
                                		      echo "<option value='$codeteacher'>$nameTeacher</option>";
                                		  }
                                		
                                		?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-sm-12">
                                    <button class="btn btn-success d-block w-100" type="submit" name="valider_reinitialise">
                                        <?php echo"$te2"; ?>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>

                    <hr />
					<?php 
                	   if (isset($_GET["nomT"])) {
                	?>
                    <div class="container text-danger w-100 mt-4 p-0 fs-4">
                        <div class="row">
                            <div class="col-6">
                                Réinitialisation du compte de :
                            </div>
                            <div class="col-6 my-auto">
                                <?php echo $_GET["nomT"]; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                Nouveau login :
                            </div>
                            <div class="col-6 my-auto">
                                <?php echo $_GET["userT"]; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                Nouveau mot de passe :
                            </div>
                            <div class="col-6 my-auto">
                                <?php echo $_GET["passT"]; ?>
                            </div>
                        </div>
                    </div>
					<?php 
        					
                	   }
                	   
					?>
                </div>

            </div>

        </div>

    </main>

	<script language="javascript">
		document.getElementById("formu").style.setProperty("disabled", "disabled");
		document.getElementById("formu").style.removeProperty("disabled");
		document.querySelector(".aaaa").addEventListener("click", function () {
			
		})
	</script>
</body>
</html>


