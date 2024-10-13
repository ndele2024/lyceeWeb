<?php
require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';
session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);
$annee=$sequence->getNomannee();
$a1=explode(" ", $annee)[0];
$a2=$a1+2;

//print_r($sequence); exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>lyc&eacute;e / accueil professeur</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" /> 
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.css" />
    <link rel="stylesheet" href="../style/styleshare.css" />
    <link rel="stylesheet" href="../style/styleGestionNotes.css" />
    <link rel="stylesheet" href="../style/styleUploadDonnee.css" />
	<script language="javascript" type="text/javascript" src="objetxhr.js"> </script>
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
            $text7="Date limite pour l'entrer des notes";
            $text8="Charger le fichier des données";
            $text9="SELECTIONNER LE FICHIER";
            $text6="Comment voulez-vous charger les données";
            $text5="Chargement Manuel";
            $text4="Chargement automatique";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt"); 
            $cont=explode("-", "$text"); $b1="cancel"; $b2="Save"; $b3="BACK"; 
            $text7="Limit date for entering marks";
            $text8="Upload file data";
            $text9="SELECT FILE";
            $text6="How do you want to load data";
            $text5="Manual loading";
            $text4="Automatic loading";
        }
    ?>
    
    <main>
        <div class="container mainpart">
            <div class="row">
                <div class="col-md-5 leftpart">

                </div>

                <div class="col-md-7 rightpart">
                    <div class="mb-2">
                        <?php  echo boutonretour("accueil_prof.php", $langue); ?>
                    </div>
                    <hr />
					<form name="formulaire" method="post" action="../control/firstcontrol.php" class="classe2" enctype="multipart/form-data">
						<div id="zone1" class="my-5">
                            <div class="bg-light text-center">
                                <?php echo $text6; ?>
                            </div>
        
                            <div class="modechargement my-5">
                                <div class="auto inactive" onclick="afficheLoad('automatique')">Chargement automatique</div>
                                <div class="manuel inactive" onclick="afficheLoad('manuel')">Chargement manuel</div>
                            </div>
                        </div>
                        <div class="modemanuel container" id="zone2">
                            <div class="row mb-4">
                                <div class="labinput col-md-6">
                                    <label for="validationdatelimite" class="form-label"><?php echo $text9; ?></label>
                                </div>
    
                                <div class="col-md-6">
                                    <input type="file" name='datafile' id='image' class="form-control" id="validationdatelimite"
                                        placeholder="yy-mm-aaa" maxlength="8"
                                        aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="labinput col-md-6">
                                    <label for="validationdatelimite" class="form-label">
                                        Date limite pour l'entrer des
                                        notes
                                    </label>
                                </div>
    
                                <div class="col-md-6">
                                    <input type="date" name="datelimite" class="form-control" id="validationdatelimite"
                                        placeholder="yy-mm-aaa" maxlength="8"
                                        aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required />
                                </div>
                            </div>
                            
                            <div class="buttondatelimite col-md-12 mb-5">
                            	<button type='submit' name='valider_upload_data' class="btn btn-success d-block w-50 m-auto">Ok</button>
                        	</div>
                        
                        </div>
                        
					</form>
					<?php
                        if(isset($_GET["err"])){
                            if ($_GET["err"]==1) {
                                echo "<div class='rouge'> Aucun fichier n'a &eacute;t&eacute; charg&eacute;</div>";
                            }
                            elseif ($_GET["err"]==2) {
                                echo "<div class='rouge'>Problème : erreur fichier</div>";
                            }
                            elseif ($_GET["err"]==3) {
                                echo "<div class='rouge'>Problème : Impossible de déplacer le fichier dans son répertoire de destination</div>";
                            }
                            else {
                                echo "<div class='rouge'>Ce fichier de données n'est pas celui de votre établissement</div>";
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
    
<script language="javascript" type="text/javascript"> 
		userAgent = navigator.userAgent;
		if(userAgent.indexOf("SYGBUSS_androidWeb")==-1) {
			document.getElementById("zone2").style.display="none";
		}
		else{
			document.getElementById("zone1").style.display="none";
		}
		
		function afficheLoad(x){
			manuel=document.querySelector(".manuel");
			auto=document.querySelector(".auto");
			if(x=="manuel"){
				document.getElementById("zone2").style.display="block";
				manuel.classList.remove("inactive");
				auto.classList.add("inactive");
			}
			else{
				document.getElementById("zone2").style.display="none";
				auto.classList.remove("inactive");
				manuel.classList.add("inactive");
				location.href="automate.1lycee.syg";
			}
		}
</script>
</body>
</html>




