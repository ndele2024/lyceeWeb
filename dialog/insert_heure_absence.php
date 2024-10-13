<?php

require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';

session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);
$tabeleve=$_SESSION["listeEleveAbsence"];
$codeclasse=$_SESSION["classe"];
$seq = $sequence->getNumtrim();
//print_r($tabeleve); exit();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>SYGBUSS YAKOO</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.css" />
    <link rel="stylesheet" href="../style/styleAfficherNotes.css" />
    <link rel="stylesheet" href="../style/styleshare.css" />
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
            $cont=explode("-", "$text"); 
            $b1="La modification ne s'est pas effectuée";
            $b2="Modifier";
            $b3="RETOUR";
            $im1="RETOUR_0.png";
            $im2="RETOUR_1.png";
            $te1="heure d'absence";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt"); 
            $cont=explode("-", "$text"); 
            $b1="The modification is not execute";
            $b2="Modify";
            $b3="BACK";
            $im1="BACK_0.png";
            $im2="BACK_1.png";
            $te1="Absence hour";
        }
    ?>
	
	<main>
        <div class="zonebouton">
            <div class="leftButton">
                <?php echo boutonretour("gestion_absence.php", $langue); ?>
            </div>
        </div>
        
        <form name="formulaire" method="post" action='../control/firstcontrol.php'>
            <div class="zoneTableau d-flex justify-content-center">
                <table width="100%">
                    <thead>
                        <tr class="ligneHead">
                            <th class="numero"width="10%"><?php echo $cont[33]; ?></th>
                            <th class=""width="50%"><?php echo $cont[34]; ?></th>
                            <th class=""width="10%"><?php echo $cont[36]; ?></th>
                            <th class=""width="10%">Trim</th>
                            <th class=""width="20%"><?php echo $te1; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                		for ($i = 0; $i < count($tabeleve); $i++) {
                		      $note=$tabeleve[$i][3];
                		      
                		      $nom=utf8_decode($tabeleve[$i][2]);
                		      echo "<tr class=\"ligneBody\">";
                		      echo " <input type=\"hidden\" name=\"matricule$i\" value='".$tabeleve[$i][0]."' size=\"6\" readonly>";
                		      echo "<td class='numero'> ".$tabeleve[$i][1]." </td>"; 
                		      echo "<td> $nom </td>";
                		      echo "<td> $codeclasse </td>";
                		      echo "<td> $seq </td>";
                		      echo "<td> <input type='text' name='note$i' class='form-control-sm d-block w-100' value='$note' maxlength='3' onkeyup='verif_heure_correcte(\"note$i\", this.value, \"erreurnote$i\", \"valider_insert_heure\")' require>
                                        <div id='erreurnote$i' style='display:none; color:red; font-size:16px'>valeur éronée <br /> Bad value</div>
                                    </td>";
                		      echo "</tr>";
                		  }
                		  
                	?>
    
                    </tbody>
    
                </table>
            </div>
            <div class="mt-3 mx-auto w-50 text-center">
                <button type="submit" name="valider_insert_heure" class="btn btn-success d-block w-100 fs-5">
                    Modifier
                </button>
            </div>
        </form>
		
		<?php
            if (isset($_GET["er"])) {
                switch ($_GET["er"]) {
                    case 1:
                        echo "<script language='javascript'> alert('Effectué / Done'); </script>";
                    break;
                    
                    case 2:
                        echo "<div class='rouge' align='center'>$b1</div>";
                        break;
                        
                    case 3:
                        ;
                        break;
                        
                    default:
                        ;
                    break;
                }
            }
         ?>

    </main>
	<script src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
	
	</body>
</html>
	
	
	