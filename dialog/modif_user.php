<?php
use model\School;

require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';

session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);

$passactuel = $prof->getPassword();
$useractuel = $prof->getUsername();

$muser=$_GET["muser"];
$mpass=$_GET["mpass"];
$c1=""; $c2="";
//if ($muser=="oui") {$d1=""; $d3="";} else {$d1="disabled='disabled'"; $d3="background-color:gainsboro; color:dimgray;";}
//if ($mpass=="oui") {$d2=""; $d4="";} else {$d2="disabled='disabled'"; $d4="background-color:gainsboro; color:dimgray;";}
if (($muser=="oui")AND($mpass=="non")) {$c1=""; $c2="cache"; }
if (($muser=="non")AND($mpass=="oui")) {$c1="cache"; $c2=""; }
//if (($muser=="oui")AND($mpass=="oui")) {$c1="";$c2="";}

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
            $text=file_get_contents("contenu/modif_user_francais.txt");
            $cont=explode("-", "$text");
            $b1="Annuler"; $b2="Enregistrer"; $b3="RETOUR"; $im1="RETOUR_0.png"; $im2="RETOUR_1.png";
            $te0="Les deux noms utilsateurs sont différents! vérifier";
            $te1="Les deux mots de passe sont différents! vérifier";
            $te2="Nom utilisateur incorrect";
            $te3="Mot de passe incorrect";
            $te4="Ce login exixte déja";
        }
        else {
            $text=file_get_contents("contenu/modif_user_anglais.txt");
            $cont=explode("-", "$text");
            $b1="Cancel"; $b2="Save"; $b3="BACK"; $im1="BACK_0.png"; $im2="BACK_1.png";
            $te0="The two username are different ! check";
            $te1="The two passwords are different ! check";
            $te2="Incorrect username";
            $te3="Incorrect password";
            $te4="This login already exist";
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
                    	<input type="hidden" name="useractuel" value="<?php echo $useractuel; ?>" />
						<input type="hidden" name="passactuel" value="<?php echo $passactuel; ?>" />
						
                        <div class="container border-start border-end border-2 border-light mt-4 pt-3 <?php echo $c1;?>">
                            <div class="row">
                                <div class="col-12 bg-light mb-2 text-center">
                                    <?php echo"$cont[0]"; ?>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-6">
                                    <label for="formerusername"><?php echo"$cont[1]"; ?> </label>
                                </div>
                                <div class="col-sm-6 d-flex  align-items-center">
                                    <input type="text" name='user1' onblur="verifier_userpass(this.value, 'useractuel', 'userbout', 'zoneereur0', 'non')" 
                                    	value='<?php if (empty($_POST["user1"])) {echo "";} else {echo $_POST["user1"];} ?>' id="formerusername"
                                        class="form-control form-text" aria-label="former login" maxlength="25"
                                        placeholder="actual login" required />
                                    <div id="zoneereur0" style="display:none;" class="rouge">
                                		<?php echo $te2; ?>
                                	</div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-6">
                                    <label for="newusername"><?php echo"$cont[2]"; ?></label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <input type="text" name='user2' value='<?php if (empty($_POST["user2"])) {echo "";} else {echo $_POST["user2"];} ?>' 
                                    onchange="verifie_user(this.value, '<?php echo $prof->getEtab()->getMatriculeetab(); ?>', 'verifieUserUnique')" id="newusername"
                                        class="form-control form-text" aria-label="new login" maxlength="25"
                                        placeholder="new login" required />
                                    <div class="cache rouge" id="zoneresult"><?php echo $te4; ?></div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-6">
                                    <label for="newusernameconfirm"><?php echo"$cont[3]"; ?></label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <input type="text" name='user3' onkeyup="verifier_userpass(this.value, 'user2', 'userbout', 'zoneereur1', 'oui')" 
                                    	id="newusernameconfirm"
                                        class="form-control form-text" aria-label="confirm login" maxlength="25"
                                        placeholder="confirme new login" required />
                                    <div id="zoneereur1" class="rouge" style="display:none;"><?php echo $te0; ?></div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <button class="btn btn-success d-block w-100" type="submit" 
                                   			name="valider_modif_user" id="userbout" value="<?php echo"$b2"; ?>">
                                        Ok
                                    </button>
                                </div>
                            </div>

                        </div>

                    <hr />

                        <div class="container border-start border-end border-2 border-light mt-4 pt-3 <?php echo $c2;?>">
                            <div class="row">
                                <div class="col-12 bg-light mb-2 text-center">
                                    <?php echo"$cont[8]"; ?>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-6">
                                    <label for="formerpassword"><?php echo"$cont[9]"; ?></label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <input type="password" name='password1' onblur="verifier_userpass(this.value, 'passactuel', 'passbout', 'zoneereur3', 'non')" 
                                    	id="formerpassword"
                                        class="form-control form-text" aria-label="former password" maxlength="25"
                                        placeholder="actual password" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required />
                                    <span class="input-group-text" id="inputGroupPrepend3">
                                            <img src="../ressources/hidden-12115.png" width="20" id="imageToggleView1" alt="View or hide password" />
                                    </span>
                                    <div id="zoneereur3" style="display:none;" class="rouge">
                                		<?php echo $te3; ?>                               		
                                	</div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-6">
                                    <label for="newpassword"><?php echo"$cont[10]"; ?></label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <input type="password" name="password2" id="newpassword"
                                        class="form-control form-text" aria-label="nouveau password" maxlength="25"
                                        placeholder="new password" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required />
                                    <span class="input-group-text" id="inputGroupPrepend3">
                                            <img src="../ressources/hidden-12115.png" width="20" id="imageToggleView2" alt="View or hide password" />
                                    </span> 
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-6">
                                    <label for="newpasswordconfirm"><?php echo"$cont[11]"; ?></label>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center">
                                    <input type="password" name='password3' onkeyup="verifier_userpass(this.value, 'password2', 'passbout', 'zoneereur2', 'oui')" 
                                    	id="newpasswordconfirm"
                                        class="form-control form-text" aria-label="confirm password" maxlength="25"
                                        placeholder="confirm new password" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required />
                                    <span class="input-group-text" id="inputGroupPrepend3">
                                            <img src="../ressources/hidden-12115.png" width="20" id="imageToggleView3" alt="View or hide password" />
                                    </span>
                                    <div id="zoneereur2" style="display:none;" class="rouge">
                                		<?php echo $te1; ?>                             		
                                	</div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <button class="btn btn-success d-block w-100" type="submit" 
                                    		name="valider_modif_pass" id='passbout'>
                                        <?php echo"$b2"; ?>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                    
					<?php 
                    	
                    	if (isset($_GET["er"])) {
                    	    switch ($_GET["er"]) {
                    	        case 1:
                    	            echo "<div class='classe1' align='center'>$te2</div>";
                    	            break;
                    	            
                    	        case 2:
                    	            echo "<div class='classe1' align='center'>$te3</div>";
                    	            break;
                    	            
                    	        case 3:
                    	            echo "<script language='javascript'> alert('Effectué / Done'); </script>";
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
    <script type="text/javascript" src="../js/scriptModifPassword.js"></script>
	
</body>
</html>
	
