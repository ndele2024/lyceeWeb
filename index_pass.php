<?php 
use model\School;
include_once './model/School.php';
require_once 'model/Teacher.php';

session_start();

$prof = unserialize($_SESSION["prof"]);
$matetab=$_SESSION["matetab"];
//echo"$matetab"; exit();
//$school= new School($matetab);

//print_r($listeEtab); exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <link rel="icon" href="dialog/images/favicon.ico" type="image/x-icon" /> 
    <link rel="shortcut icon" href="dialog/images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYGBUSS / login</title>
    <link href="dialog/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" />
    <link rel="stylesheet" href="./bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&family=Updock&display=swap"
        rel="stylesheet">
   
</head>

<body>
    <header>
        <div class="container" id="head">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2" id="logo1">
                    <img src="./ressources/logo1.png" alt="logo" id="imgindex1">
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8" id="textanimindex">
                    <h1 class="tracking-in-expand">SYGBUSS YAKOO</h1>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2" id="logo2">
                    <img src="./ressources/logo1.png" alt="logo" id="imgindex2">
                </div>
            </div>
        </div>

    </header>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 m-0 leftpart">

            </div>
            <div class="col-sm m-0">
                <main>
                    <div class="mainpart p-4">
                        <form class="row g-3" name="formulaire" method="post" action="control/firstcontrol.php" id="formu">
                            <div class="col-12">
                                <label for="etablissement">Sélectionner l'établissement/Select your school</label>
                            </div>
                            <div class="col-12 mb-3">
                               <select name="etablissement" class="form-select" aria-label="selectionner l'établissement" required id="etablissement">
                                   <option value="<?php echo $matetab; ?>">
                                <?php 
                    			    echo $prof->getEtab()->getNomSchoolFr($matetab);
                    			?>
                                    </option>
                               </select>
                            </div>
                            
                            <div class="col-12">
                                <label for="validationServerUsername" class="form-label">Password</label>
                                <div class="input-group has-validation">
               		                 <input type="password" name="password" class="form-control"
                                        id="pwd" placeholder="password" maxlength="25"
                                        aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required />
									<span class="input-group-text" id="inputGroupPrepend3">
                                            <img src="./ressources/hidden-12115.png" width="30" id="imageToggleView" alt="View or hide password" />
                                    </span>
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        Please enter password.
                                    </div>
                                </div>
                            </div>
                            <div class="my-4">
                                <button class="btn btn-success w-100" name="validerpass" type="submit" id="bouton_index">Suivant</button>
                            </div>
                            <?php 
                                if(isset($_GET["errpass"])) {
                                    if ($_GET["errpass"]=="1") {
                                        echo "<div class='rouge'>Vous devez entrer le mot de passe et sélectionner l'établissement / You should enter your password and select your school</div>";
                                    }
                                    elseif ($_GET["errpass"]=="2") {
                                        echo "<div class='rouge'>Mot de passe incorrect / Incorrect password</div>";
                                    }
                                    else {
                                        ;
                                    }
                                    
                                }
                             ?>
                             <div>
                                <small><a href="control/firstcontrol.php?route=forget_password"><i><u>Mot de passe oublié / Forgot your password</u></i></a></small>
                            </div>
                        </form>

                    </div>
                </main>
            </div>
        </div>
    </div>
    
     <script type="text/javascript" src="./js/scriptPass.js">
    	
    </script>
</body>
</html>



