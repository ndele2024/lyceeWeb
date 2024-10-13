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
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/stylemenu.css" media="screen" />
    <style type="text/css" > 
        .msg {color:white; font-size:35px; font-family:candara; font-weight:bold;}
        div {color:royalblue; font-size:35px; font-family:candara; font-weight:bold;}
        .classe0 {color:royalblue; font-size:30px; font-family:candara; font-weight:bold;}
        .classe1 {color:red; font-size:40px; font-weight:bold; font-family:courier new; text-align:center; font-style:italic}
        .classe2 {background-color:lightblue; color:olive; font-size:30px; font-weight:bold; font-family:candara;}
        .classe3 {background-color:lightblue; color:olive; font-size:30px; font-weight:bold; font-family:candara;}
        .foot {position:fixed; top:95%; width:100%; background-color:lightblue; color:seagreen; font-size:30px; font-weight:bold; font-family:candara; text-align:center}
        #msg {font-size:25px;}
        marquee {font-size:25px; color:royalblue; font-family:candara; font-weight:bold; background-color:lightgray;}
        #reponse{display: none;}
    </style>
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
            $te1="Je n'ai pas d'adresse Email";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt");
            $cont=explode("-", "$text");
            $b1="delete"; $b2="Save"; $b3="BACK"; $im1="BACK_0.png"; $im2="BACK_1.png";
            $te1="I don't have Email adress";
        }
    ?>
	<hr />
	<br />
	<table width="100%" border="0">
        <tr>
        	<td align="center" valign="middle" rowspan="" width="70%">
                <?php //message de bienvenue
                	include("message_bienv.php");
                	//update du fichier tmp des notes
                	//include("update_tmp_notes.php");
                ?>
        	</td>
        	<td align="right" width="30%"><?php //include("boutton2.php") ?></td>
        </tr>
	</table>
	<form name="formulaire" method="post" action="../control/firstcontrol.php" id="formu">
    <table border="0" width="95%" align="center" valign="middle">
    	<tr>
    		<td>
    			<div class="classe2">
    				<fieldset>
        				<legend>
        					<b class="classe2"> Saisir votre adresse Email / Enter your Email adress</b>
        				</legend>
    
        				<table align="center" width="90%" cellspacing="20">
                        	<tr>
                        	<td class="classe0">Adresse Email / Email Adress  :</td> 
                        	<td><input type="text" name="email" id="emailprof" style="width:400px;" onkeyup="verifEmail(this.value, 'validerEmail', 'zoneerreur')" /></td>
                        	</tr>
                        	<?php 
                        	if(($prof->getSauvegarder_base()!="oui")AND($prof->getFonction()!="PROVISEUR")) {
                        	?>
                            	<tr>
                            	<td class="classe0">&nbsp;</td> 
                            	<td><input type="checkbox" name="pasemail" id="pasemail" onclick="pasemailprof(this.name, 'validerEmail')" /> <label for="pasemail"> <?php echo $te1; ?></label></td>
                            	</tr>
                        	<?php 
                        	}
                        	?>
                        	<tr>
                        		<td colspan="2" align="center">
                        		<input type="submit" name="validerEmail" value="  OK  " id="okemail" disabled="disabled" />
                        		</td>
                        	</tr>
        				</table>
        				<br />
        				<div id="zoneerreur" class="classe1" style="display:none">Adresse Email incorecte / invalid email adress</div>
    				</fieldset>
    			</div>
    		</td>
    	</tr>
    </table>
    </form>
    <br /><hr /><br />
    </body>
    </html>
<?php 
if(isset($_GET["er"])) {
    if ($_GET["er"]=="1") {
        echo "<script language='javascript'> alert('Effectué / Done');</script>";
        echo boutonretour("accueil_prof.php", $langue);
    }
    else {
        ;
    } 
}
?>


