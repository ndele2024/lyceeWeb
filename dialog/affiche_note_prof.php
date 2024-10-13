<?php
use model\Evaluation;

require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once 'boutonretour.php';
session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);
$matiere=$_SESSION["codematiere"];
$codeclasse=$_SESSION["classe"];
$seq=$_SESSION['seq'];
$numerodevoir=$_SESSION['numdevoir'];
$tabeleve=$_SESSION["eleve"];
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
            $b1="Terminer";
            $b2="Modifier";
            $b3="Modifier notes";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt"); 
            $cont=explode("-", "$text"); 
            $b1="Finish";
            $b2="Modify";
            $b3="Update Marks";
        }
    ?>	
    
	<main>
        <div class="zonebouton">
            <div class="leftButton">
                <?php echo boutonretour("accueil_prof.php", $langue); ?>
            </div>
            <div class="rightButton">
                <a href="./modif_note_prof.php">
                    <button class="btn btn-success btn-lg" id="buttonModifier">
                       <?php echo $b3; ?>
                    </button>
                </a>
            </div>
        </div>
        
        <div class="zoneTableau d-flex justify-content-center">
            <table width="100%">
                <thead>
                    <tr class="ligneHead">         
                        <th class="matri"width="10%"><?php echo $cont[32]; ?></th>
                        <th class="numero"width="10%"><?php echo $cont[33]; ?></th>
                        <th class=""width="26%"><?php echo $cont[34]; ?></th>
                        <th class=""width="10%"><?php echo $cont[35]; ?></th>
                        <th class=""width="14%"><?php echo $cont[36]; ?></th>
                        <th class=""width="10%">Trim</th>
                        <th class=""width="10%">N° dev.</th>
                        <th class=""width="10%"><?php echo $cont[37]; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                      for ($i=0; $i<count($tabeleve); $i++) {
                          echo "<tr class=\"ligneBody\">";
                          $note=$tabeleve[$i][7];
                          if($note==0) {
                              $tabDonneEleveEval=Evaluation::getDonneeEvaluation($sequence->getNomannee(), $tabeleve[$i][0], $matiere, $seq, $numerodevoir, $sequence->getMatriculeetab());
                              $app=$tabDonneEleveEval[2];
                              if ($app=="MALADE") {
                                  $note="/";
                              } 
                          }
                          $nom=utf8_decode($tabeleve[$i][2]);
                          echo "<td class='matri'> ".$tabeleve[$i][0]." </td>";
                          echo "<td class='numero'>".$tabeleve[$i][1]." </td>"; 
                          echo "<td align='left'> $nom </td>";
                          echo "<td> $codeclasse</td>";
                          echo "<td> $matiere  </td>";
                          echo "<td> $seq </td>";
                          echo "<td> $numerodevoir </td>";
                          echo "<td> $note </td>";
                          echo "</tr>";
                      }
                      
                   ?>                

                </tbody>

            </table>
        </div>


    </main>
	<script src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>


