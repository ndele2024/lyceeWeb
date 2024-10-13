<?php
require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';
session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);
$matetab=$sequence->getMatriculeetab();
$annee=$sequence->getNomannee();
$trimestre=$sequence->getNumtrim();
$userAgent=$_SERVER ['HTTP_USER_AGENT'];
//print_r($sequence); exit();
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
            $c3="Télécharger";
            $c5="Le fichier a été créé";
            $c6="Le fichier a été créé, vous pouvez le télécharger maintenant";
            $c7 = "comment voulez vous charger les données sur votre serveur local";
            $c8="Manuellement"; 
            $c9="Automatiquement";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt"); 
            $cont=explode("-", "$text"); $b1="cancel"; $b2="Save"; $b3="BACK"; 
            $im1="BACK_0.png"; $im2="BACK_1.png"; 
            $c3="Download";
            $c5="The file have been created";
            $c6="The file have been created, you can download it now";
            $c7="How do you want to laod datas on your local server";
            $c8="Manually";
            $c9="Automatically";
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
                    
                    
                    <div class="my-5 text-center container" id='zone1'>
                    	<div class="row my-4">
                    		<div class="col-12 bg-light">
                    			<?php echo "$c5<br>$c7"; ?>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-6">
                    			<?php echo "<label for='modeload1'>$c8</label>
                                            <input type='radio' name='modeload' id='modeload1' value='manuel' class='' onclick='afficheLoad(this.value)'>"; ?>
                    		</div>
                    		<div class="col-md-6">
                    			<?php echo "<label for='modeload2'>$c9</label>
                                            <input type='radio' name='modeload' id='modeload2' value='auto' class='' onclick='afficheLoad(this.value)'>"; ?>
                    		</div>
                    	</div>
                        
                    </div>

                    <div class="my-5 bg-light text-center" id='zone2'>
                        <?php echo $c6; ?>
                    </div>

                    <div class="buttondatelimite col-md-12" id='zone3'>
                    	<a href='<?php echo "../data/webToLocalSygbuss$matetab.ry"; ?>'>
                        <button type="submit" class="btn btn-success d-block w-50 m-auto"><?php echo $c3; ?></button>
                        </a>
                    </div>

                </div>

            </div>
        </div>
        <input type="hidden" id="matetab" name="matetab" value="<?php echo $matetab ?>">
        <input type="hidden" id="annee" name="annee" value="<?php echo $annee ?>">
        <input type="hidden" id="trim" name="trim" value="<?php echo $trimestre ?>">
    </main>
 <script src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>

<script language="javascript" type="text/javascript"> 
		userAgent = navigator.userAgent;
		if(userAgent.indexOf("SYGBUSS_androidWeb")!=-1) {
			document.getElementById("zone2").style.display="none";
			document.getElementById("zone3").style.display="none";
		}
		else{
			document.getElementById("zone1").style.display="none";
		}
		
		function afficheLoad(x){
			if(x=="manuel"){
				document.getElementById("zone3").style.display="block";
			}
			else{
				document.getElementById("zone3").style.display="none";
                matetab=document.getElementById("matetab").value;
                annee=document.getElementById("annee").value;
                trim=document.getElementById("trim").value;
                location.href="download_data_auto.php?etab="+matetab+"&annee="+annee+"&trimestre="+trim+"&automate=oui";
				//location.href="automate.2lycee.syg";
			}
		}
</script>
</body>
</html>

