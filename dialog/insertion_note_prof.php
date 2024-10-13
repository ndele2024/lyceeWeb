<?php
use model\Classe;
use model\Evaluation;

require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once '../model/Classe.php';
require_once 'boutonretour.php';

session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);
$matiere=$_SESSION["codematiere"];
$codeclasse=$_SESSION["classe"];
$numerodevoir=$_SESSION['nbnote'];
$tabeleve=$_SESSION["eleve"];
$tabEleveAvecNote=$_SESSION["deuxderniereleve"];
//print_r($sequence); exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>SYGBUSS / YAKOO</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" /> 
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../style/styleInsererNotes.css">
    <link rel="stylesheet" href="../style/styleshare.css">
    
	<script language="javascript" type="text/javascript" src="js/objetxhr.js"> </script>
	<script language="javascript" type="text/javascript" src="js/ajax.js"> 
	
	</script>

</head>
<body onload="donnefocus()">
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
            $text1="vous n'avez saisi aucune note";
            $text2="La note n'a pas été enregistré, vérifiez!";
            $text3="Enregistrement terminé";
            $te3="Vous êtes sur le point d\'entrer les notes du devoir";
            $te4="Modifier";
            $text4="Vous pouvez mofidifier les notes que vous venez d'insérer içi";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt"); 
            $cont=explode("-", "$text"); $b1="cancel"; $b2="Save"; $b3="BACK"; 
            $im1="BACK_0.png"; $im2="BACK_1.png"; 
            $text1="You have not type any mark";
            $text2="This Mark connot been saved. verify it!";
            $text3="Saving terminated";
            $te3="Vous êtes sur le point d\'entrer les notes du devoir";
            $te4="Modify";
            $text4="You can modify the marks that you have already insert";
        }
    ?>

<main>
	<form name="formulaire" method="post" action='<?php echo"../control/firstcontrol.php"; ?>'>
        <div class="lastnotes">
        <?php 
    		//print_r($tabEleveAvecNote); exit();
    		if(count($tabEleveAvecNote)>0){
    		    echo "<div class='titre'>$text4</div>";
    		?>
                <table width="100%">
                    <thead>
                        <tr align="center">
                            <th width="10%"><?php $cont[33] ?></th>
                            <th width="25%"><?php $cont[34] ?></th>
                            <th width="12%"><?php $cont[35] ?></th>
                            <th width="13%"><?php $cont[36] ?></th>
                            <th width="10%">TRIM</th>
                            <th width="10%">N° DEV.</th>
                            <th width="10%"><?php $cont[37] ?></th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php 
				for ($i = 0; $i < count($tabEleveAvecNote); $i++) {
				    $note=$tabEleveAvecNote[$i][7];
        		      if($note==0) {
        		          $tabDonneEleveEval=Evaluation::getDonneeEvaluation($sequence->getNomannee(), $tabEleveAvecNote[$i][0], $matiere, $sequence->getNumtrim(), $numerodevoir, $sequence->getMatriculeetab());
        		          $app=$tabDonneEleveEval[2];
        		          if ($app=="MALADE") {
        		              $note="m";
        		          }
        		      }
        		      $nom=utf8_decode($tabEleveAvecNote[$i][2]);
        		      echo "<tr align=\"center\">";
        		      echo " <input type=\"hidden\" name=\"matricule$i\" value='".$tabEleveAvecNote[$i][0]."' size=\"6\" readonly>";
        		      echo "<td class='numero'> ".$tabEleveAvecNote[$i][1]." </td>"; 
        		      echo "<td> $nom </td>";
        		      echo "<td> $codeclasse </td>";
        		      echo "<td> $matiere </td>";
        		      echo "<td> ".$sequence->getNumtrim()." </td>";
        		      echo "<td>$numerodevoir</td>
                            <td> <input type='tel' name='note$i' id='notemodif$i' class='nbre' value='$note' maxlength='5' class='form-control-sm d-block w-100' resuired onkeyup='verif_note_correcte(\"note$i\", this.value, \"erreurnote$i\", \"valider_modif_note$i\")'>
                                <div id='erreurnote$i' style='display:none; color:red; font-size:18px'>Note éronée <br /> Bad marck</div>
                            </td>";
        		      echo "<td class='bouton'>
                                <button type='button' name='valider_modif_note$i' class='btn btn-success btn-sm d-block w-100' id='boutonmodif$i' onclick='modifNoteDansInsert($i, \"modifnoteDansInsert\")'>
                                    $te4
                                </button>
                            </td>";
        		      echo "</tr>";
        		  }
        		  
        		?>                      
                    </tbody>
                </table>
			<?php
    		  }
        	?>
        </div>
        <hr />
        <div class="zoneInsert">
                <div class="card text-center cardNote">
                    <div class="card-header">
                       <?php echo"$cont[16] $matiere $cont[17] $codeclasse"; ?>
                    </div>
                    <div class="card-body">
                    <?php           
                        $seq=$sequence->getNumtrim();
                        $nome=$tabeleve[2];
                        $matricule=$tabeleve[0];
                        $numeroel=$tabeleve[1];
                        //$photo_eleve=$matricule."_".$sequence->getNomannee();
            			echo "<input type=\"hidden\" name=\"matricule\" value=\"$matricule\" size=\"6\" readonly> 
            			<input type=\"hidden\" name=\"numero\" value=\"$numeroel\" size=\"3\" readonly>
            			<input type=\"hidden\" name=\"seq\" value=\"$seq\" size=\"2\" readonly>";
	                ?>
                        <h5 class="card-title"><?php echo $cont[18]; ?> </h5>
                        <p class="container">
                        <div class="row">
                            <div class="col-6">
                                <?php echo "$cont[20] : $matricule"; ?>
                            </div>
                            <div class="col-6">
                                <?php echo "$cont[21] : $numeroel"; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 nomeleve">
                                <?php echo "$nome"; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <input type='tel' name='note' id ='note' size='4' tabindex='1' class="form-control form-text text-center" placeholder="Note" value='' onkeyup='verif_note_correcte("note", this.value, "erreurnote", "valider_notes")' />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <button type="submit" name="valider_notes" id='validerNotes' class="btn btn-primary d-block w-100">
                                    Ok
                                </button>
                            </div>
                        </div>
                        
                        <div id='erreurnote' style='display:none;' class='rouge'>
                        	<?php echo $cont[23]; ?> 
                        </div>
                        
                        </p>

                    </div>
                </div>
            
            <div class="leftButton m-4">
                <?php  echo boutonretour("gestion_notes.php?hez=1", $langue); ?>
            </div>
            
             <?php
       
        if (isset($_GET["er"])) {
            switch ($_GET["er"]) {
                case 1:
                    echo "<div class='rouge' align='center'>$text1</div>";
                break;
                
                case 2:
                    echo "<div class='rouge' align='center'>$text2</div>";
                    break;
                    
                case 3:
                    echo "<script language='javascript'> alert('$text3'); location.href='gestion_notes.php?hez=1';</script>";
                    break;
                    
                default:
                    ;
                break;
            }
        }
     ?>
        </div>
        </form>

    </main>

    <script src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
     
</body>
</html>

