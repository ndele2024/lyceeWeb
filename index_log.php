<?php 
use model\School;
include_once './model/School.php';

if(!isset($_SESSION["useragent"])) {
    //header("Location:./index.php");
}
session_start();
$matetab=$_SESSION["matetab"];
//echo"$matetab"; exit();
$school= new School($matetab);
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
    <script type="text/javascript">
    
    </script>
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
                        <form class="row g-3" name="formulaire" method="post" action="control/firstcontrol.php">
                            <div class="col-12">
                                <div class="my-3">
                                    <big>etablissement/School : <?php echo $school->getNomSchoolFr($matetab); ?></big>
                                </div>
                                <label for="validationServerUsername" class="form-label">Username</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text" id="inputGroupPrepend3">
                                    	<img src="./ressources/user-3295.png" width="36" alt="logo username">
                                    </span>
                                    <input type="text" name="user" class="form-control"
                                        id="validationServerUsername" placeholder="Login" maxlength="25"
                                        aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required>

                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        Please choose a username.
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-success w-100" name="validerindex" type="submit" id="bouton_index">Suivant</button>
                            </div>
                            <?php 
                                if(isset($_GET["errus"])) {
                                    if ($_GET["errus"]=="1") {
                                        echo "<div class='rouge'>vous devez entrer le nom d'utilisateur / you should enter your username</div>";
                                    }
                                    elseif ($_GET["errus"]=="2") {
                                        echo "<div class='rouge'>Nom d'utilisateur incorrect / Incorrect username </div>";
                                    }
                                    else {
                                        ;
                                    }
                                    
                                }
                            ?>
                        </form>

                    </div>
                </main>
            </div>
        </div>
    </div>

    <script src="./js/allscript.js"></script>

</body>
</html>



