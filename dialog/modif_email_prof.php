<?php 
require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';

session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);

if (isset($_GET["param"])) {
    $param=$_GET["param"];
    $langue="F";
}
else {
    $param="";
}

//print_r($sequence); exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>SYGBUSS YAKOO</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" /> 
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
	if($param==""){
	    include("menu.php");
	}
        
        if ($langue=="F") {
            $text=file_get_contents("contenu/prof1_francais.txt");
            $cont=explode("-", "$text");
            $b1="supprimer"; $b2="Enregistrer"; $b3="RETOUR"; $im1="RETOUR_0.png"; $im2="RETOUR_1.png";
            $te1="Je n'ai pas d'adresse Email";
            $te2="Veuillez contacter votre administrateur pour la réinitialisation de votre compte";
            $te3="l'adresse email que vous avez saisie est différente de celle enregistrée! Contactez votre administrateur";
            $te4="Impossible d'envoyer le mail de réinitialisation du mot de passe";
            $te5="Un mail pour la réinitialisation du mot de passe à été envoyé";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt");
            $cont=explode("-", "$text");
            $b1="delete"; $b2="Save"; $b3="BACK"; $im1="BACK_0.png"; $im2="BACK_1.png";
            $te1="I don't have Email adress";
            $te2="please contact your administrator for the reitialisation of your account";
            $te3="The email adress that you have typed is not valid. Contact your administrator";
            $te4="Impossible to send Email of reinitilization of password for the moment";
            $te5="An email for the reinitialization of password have been sent";
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
                            <input type="hidden" name="param" value="<?php echo $param; ?>" />
                            <div class="row mb-5">
                                <div class="col-12 fs-4 bg-light">
                                    Saisir votre adresse Email / Enter your Email adress
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="labinput col-md-12">
                                    <label for="email" class="form-label">Adresse Email / Email adress</label>
                                </div>

                                <div class="col-md-12">
                                    <input type="email" name="email" id="emailprof" class="form-control" id="email"
                                        placeholder="email" maxlength="25"
                                        aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button name="validerEmail" type="submit" class="btn btn-success d-block w-100">Ok</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="my-4">
                         <?php 
                            if ($param!="") {
                                echo boutonretour("session_out.php", $langue);
                            }
                         ?>
                    </div>
                    <div id="zoneretour" style="display:none">
                        <?php 
                            if (isset($_GET["param"])) {
                                echo "<div align='center' class='classe1'>$te2</div>";
                                echo boutonretour("session_out.php", $langue); 
                            }
                            else {
                                echo boutonretour("accueil_prof.php", $langue);
                            }
                            
                        ?>
                     </div>
                        <?php 
                            if(isset($_GET["er"])) {
                                if ($_GET["er"]=="1") {
                                    echo "<script language='javascript'> alert('Effectué / Done'); location.href='accueil_prof.php'</script>";
                                    echo boutonretour("accueil_prof.php", $langue);
                                }
                                elseif ($_GET["er"]=="2") {
                                    echo "<div align='center' class='classe1'>$te3</div>";
                                    
                                }
                                elseif ($_GET["er"]=="3") {
                                    echo "<div align='center' class='classe1'>$te4</div>";
                                    //echo boutonretour("session_out.php", $langue);
                                }
                                elseif ($_GET["er"]=="4") {
                                    echo "<div align='center' class='classe1'>$te5</div>";
                                    //echo boutonretour("session_out.php", $langue);
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
    
    
    </body>
    </html>



