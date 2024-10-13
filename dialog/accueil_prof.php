<?php 
require_once '../model/Teacher.php';
require_once '../model/Sequences.php';

session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);
//print_r($sequence); exit();
//echo "email : ".$prof->getEmail(); exit();
if(empty($prof->getEmail())) {
    header("location:modif_email_prof.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>SYGBUSS YAKOO</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" /> 
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style/styleshare.css">
    <link rel="stylesheet" href="../style/styleaccueil.css">
	<script language="javascript" type="text/javascript" src="js/objetxhr.js"> </script>
	<script language="javascript" type="text/javascript" src="js/ajax.js"> 
		
	</script>

</head>
<body onload="">
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
            $te1="ET"; $te2="DE"; $te3="POUR LE DEVOIR"; $te4="VOUS POUVEZ INSERER POUR LE DEVOIR";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt");
            $cont=explode("-", "$text");
            $b1="delete"; $b2="Save"; $b3="BACK"; $im1="BACK_0.png"; $im2="BACK_1.png";
            $te1="AND"; $te2="OF"; $te3="FOR EVALUATION"; $te4="YOU CAN INSERT MARKS FOR EVLUATION";
        }
    ?>
	
	<main>
        <div class="container mainpart">
            <div class="row">
                <div class="col-md-4 mainmenu">
                    <div class="dropend">
                        <button class="zoneimage dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../ressources/gestionNotes.png" alt="logo gestion des notes" class="form-image" />
                            <div class="texte-image"> 
                            <?php 
                                echo $textNote;
                            ?>
                            </div>
                        </button>
                        
                        <ul class="dropdown-menu" id="position">
                           <?php 
                                echo'<li><a class="dropdown-item" href="gestion_notes.php?hez=1" title="">'.$text2.'</a></li>
                                <li><a class="dropdown-item" href="gestion_notes.php?hez=2" title="">'.$text3.'</a></li>
                                <li><a class="dropdown-item" href="gestion_notes.php?hez=3" title="">'.$text4.'</a></li>';
                                if (($prof->getSauvegarder_base()=="oui")OR($prof->getFonction()=="PROVISEUR")) {
                                    echo '<li><a class="dropdown-item" href="recap_notes.php" title="">'.$text5.'</a></li>
                                          <li><a class="dropdown-item" href="modif_datelimite.php" title="">'.$text6.'</a></li>';
                                }
                                if($prof->getFonction()=="SURVEILLANT GENERAL"){
                                    echo '<li><a class="dropdown-item" href="gestion_absence.php" title="">'.$text9.'</a></li>';
                                }
                           ?>
                        </ul>
                    </div>

                    <div class="dropend">
                        <button class="zoneimage dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../ressources/statistique.png" alt="logo statistiques" class="form-image" />
                        <div class="texte-image">
                        	<?php echo"$t1[0]"; ?>
						</div>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" id="position">
                            <?php 
                            if ($prof->getAp()=="oui")
                            {
                              echo'<li><a class="dropdown-item" href="stat_ap.php" title="">'.$t1[2].'</a></li>';
                              //à travailler plus tard
                              //echo'<li><a href="modif_stat_censeur.php" title="">'.$t1[5].'</a></li>';
                            }
                            echo'<li><a class="dropdown-item" href="stat_prof.php" title="">'.$t1[1].'</a></li>'; 
                            echo'<li><a class="dropdown-item" href="imprimer_fiche_stat.php" title="">'.$text15.'</a></li>';
                         ?>
                        </ul>
                    </div>

                    <div class="dropend">
                        <button class="zoneimage dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../ressources/parametres.png" alt="logo paramètre" class="form-image" />
                            <div class="texte-image">
                            	<?php echo"$t3[0]"; ?>
                            </div>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" id="position">
                            <?php
                                echo'<li><a class="dropdown-item" href="session_out.php" title="">'.$t3[1].'</a></li>
                                <li><a class="dropdown-item" href="modif_user.php?muser=non&mpass=oui" title="">'.$t3[3].'</a></li>
                                <li><a class="dropdown-item" href="modif_user.php?muser=oui&mpass=non" title="">'.$t3[2].'</a></li>';
                                if ($prof->getFonction()=="PROVISEUR") {
                                    echo '<li><a class="dropdown-item" href="ajouter_admin.php">'.$text7.'</a></li>';
                                }
                                if (($prof->getSauvegarder_base()=="oui")OR($prof->getFonction()=="PROVISEUR")) {
                                    echo'<li><a class="dropdown-item" href="reinitialiser_compte.php">'.$t3[8].'</a></li>
                                         <li><a class="dropdown-item" href="download_data.php">'.$t5[1].'</a></li>
                                         <li><a class="dropdown-item" href="upload_data.php">'.$t5[2].'</a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="col-md-8 rapport-accueil">
                    <div class="rapport-note" id="rapnote">         
                        <?php
                            //affichage des informations sur l'insertion des notes des élèves dans les classes
                            include '../control/verifnoteaccueil.php';
                        ?>
                    </div>
                    <div class="button">
                        <button class="btn btn-success" id="affichetout1">Voir plus...</button>
                    </div>
                    <div class="rapport-stat" id="rapstat">
                        <?php 
                    	   $cs=count($tabstat1);
                    	   if ($cs==0)
                        	{
                        	    echo "<div class=\"\">$cont[50]</div>";
                        	}
                        	else
                        	{
                        	    $chain="";
                        	    for($ii=0; $ii<$cs; $ii++)
                        	    {
                        	        $chain.=$tabstat1[$ii]."($tabstat[$ii]), ";
                        	    }
                        	    echo "<div class=\"rouge\">$cont[51] $chain</div>";
                        	}  
                    	
                    	?>
                    </div>
                    <div class="button">
                    	<?php if ($cs!=0) { ?>
                        <button class="btn btn-success" id="affichetout2">Voir plus...</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
	
	<script src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../js/allscript.js"></script>
</body>
</html>


