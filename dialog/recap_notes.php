<?php
use model\Classe;
use model\Evaluation;
use model\School;

require_once '../model/Teacher.php';
require_once '../model/Sequences.php';
require_once '../model/Classe.php';
require_once 'boutonretour.php';

session_start();
$prof=unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);

$school = new School($sequence->getMatriculeetab());
$tabTeacher = $school->getAllTeacher($school->getMatriculeetab());
$tabdonneprof1 = array();
$tabdonneprof2 = array();
$tabdonneclasse1=array();
$tabdonneclasse2=array();

for ($el = 1; $el <= 2; $el++) {
    for ($i = 0; $i < count($tabTeacher); $i++) {
        $codeperso = $tabTeacher[$i]->getCodeTeacher();
        $tabNomprof[$codeperso] = $tabTeacher[$i]->getNomTeacher();
        if($el==1){
            $tabdonneprof1[$codeperso] = array();
        }
        else {
            $tabdonneprof2[$codeperso] = array();
        }
        
        $tabListeClasseProf = $tabTeacher[$i]->getClasseProf($sequence->getNomannee());
        //$l=0;
        for ($j = 0; $j < count($tabListeClasseProf); $j++) {
            $classe = $tabListeClasseProf[$j];
            $tabMatiereProf = $tabTeacher[$i]->getMatiereProf($classe, $sequence->getNomannee());
            for ($k = 0; $k < count($tabMatiereProf); $k++) {
                $matiere = $tabMatiereProf[$k][0];
                $nomMatiere = $tabMatiereProf[$k][1];
                $eval = new Evaluation();
                if(! $eval->verifNoteMatiereClasse($matiere, $classe, $el, $sequence->getNumtrim(), $sequence->getNomannee(), $school->getMatriculeetab())) {
                    if($el==1){
                        $tabdonneprof1[$codeperso][] = "$classe ($nomMatiere)";
                        $nomprof = $tabTeacher[$i]->getNomTeacher();
                        $tabdonneclasse1[$classe][] = "$matiere ($nomprof)";
                        
                    }
                    else {
                        $tabdonneprof2[$codeperso][] = "$classe ($nomMatiere)";
                        $nomprof = $tabTeacher[$i]->getNomTeacher();
                        $tabdonneclasse2[$classe][] = "$matiere ($nomprof)";
                    }
                }
            }
        }
    }
}


//print_r($tabdonneclasse1); exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>SYGBUSS / YAKOO</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" /> 
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.css" />
    <link rel="stylesheet" href="../style/styleGestionNotes.css" />
    <link rel="stylesheet" href="../style/styleVerifNotes.css" />
    <link rel="stylesheet" href="../style/styleshare.css" />
	<script language="javascript" type="text/javascript" src="js/objetxhr.js"> </script>
	<script language="javascript" type="text/javascript" src="js/ajax.js"> 
	
	</script>

</head>
<body onload="">
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
            $text1="Recapitulatif de l'entrée des notes";
            $text2="Récapitulatif par enseignant";
            $text3="Récapitulatif par classe";
            $text4="Enseignant";
            $text5="Classe (Matière)";
            $text6="Classe";
            $text7="Matière (Enseignant)";
            $text8="Recap Evaluation 1";
            $text9="Recap Evaluation 2";
            $text10="Télécharger au format pdf";
        }
        else {
            $text=file_get_contents("contenu/prof1_anglais.txt"); 
            $cont=explode("-", "$text"); $b1="cancel"; $b2="Save"; $b3="BACK"; 
            $im1="BACK_0.png"; $im2="BACK_1.png"; 
            $text1="insertion mark's recap";
            $text2="Teacher's recap";
            $text3="Classe's recap";
            $text4="Teacher";
            $text5="Class (Subject)";
            $text6="Class";
            $text7="Subject (Teacher)";
            $text8="recap first evaluation";
            $text9="recap second evaluation";
            $text10="Download in pdf";
        }
    ?>
    
     <main>
        <div class="container mainpart">
            <div class="row">
                <div class="col-md-4 leftpart">

                </div>

                <div class="col-md-8 rightpart1">
                    <div class="leftButton">
                        <?php 
                    	   echo boutonretour("accueil_prof.php", $langue);
                    	?>		
                    </div>
                    <hr>
                    <div class="option">
                        <div class="parEnseignant" id="prof" onclick="afichezonerecap('zoneprof', 'zoneclasse','prof','classe')">
                            <?php echo $text2; ?>
                        </div>
                        <div class="parClasse inactive" id="classe" onclick="afichezonerecap('zoneclasse', 'zoneprof','classe','prof')">
                            <?php echo $text3; ?>
                        </div>
                    </div>
                    
                    <button class="btn btn-success btn-sm mt-4 text-decoration-underline"
                    		id="btnPdf"
                    >
                    	<?php echo $text10; ?>
                    </button>
                    
                    <span id="idZonePdf" style="display: none;">zoneprof</span>
                    
                    <div align="center" id="zoneprof">
                    	<div class="mt-4 mb-3 bg-light">
                    		<?php echo $text8; ?>
                    	</div>
                    	
                    	<table width="95%">
                            <thead >
                                <tr class="ligneHead">
                                    <th width="20%"><?php echo $text4; ?></th>
                                    <th width="80%"><?php echo $text5; ?></th>
                                </tr>
                            </thead>
                            
                            <tbody>
                            <?php 
                    			foreach ($tabdonneprof1 as $key=>$tabval){
                    			    $val=implode(", ", $tabval);
                    			
                			?>
                			<tr class="ligneBody">
                				<td>
                					<?php echo $tabNomprof[$key]; ?>
                				</td>
                				<td>
                					<?php echo $val; ?>
                				</td>
                			</tr>
                			<?php 
                                }
                			?>
                                
                            </tbody>
                    	</table>                           
                    	
                    	<div class="mt-5 mb-3 bg-light" id="page2el">
                    		<?php echo $text9; ?>
                    	</div>
                    	
                    	<table width="95%">
                            <thead >
                                <tr class="ligneHead">
                                    <th width="20%"><?php echo $text4; ?></th>
                                    <th width="80%"><?php echo $text5; ?></th>
                                </tr>
                            </thead>
                            
                            <tbody>
                            <?php 
                    			foreach ($tabdonneprof2 as $key=>$tabval){
                    			    $val=implode(", ", $tabval);
                    			
                			?>
                			<tr class="ligneBody">
                				<td>
                					<?php echo $tabNomprof[$key]; ?>
                				</td>
                				<td>
                					<?php echo $val; ?>
                				</td>
                			</tr>
                			<?php 
                                }
                			?>
                                
                            </tbody>
                    	</table>   
                    </div>    
                    
                    <div align="center" id="zoneclasse" class="">
                    	<div class="mt-5 mb-3 bg-light">
                    		<?php echo $text8; ?>
                    	</div>
                    	
                    	<table width="95%">
                            <thead >
                                <tr class="ligneHead">
                                    <th width="20%"><?php echo $text6; ?></th>
                                    <th width="80%"><?php echo $text7; ?></th>
                                </tr>
                            </thead>
                            
                            <tbody>
                            <?php 
                			     foreach ($tabdonneclasse1 as $key=>$tabval){
                    			    $val=implode(", ", $tabval);
                    			
                			?>
                			<tr class="ligneBody">
                				<td>
                					<?php echo $key; ?>
                				</td>
                				<td>
                					<?php echo $val; ?>
                				</td>
                			</tr>
                			<?php 
                                }
                			?>
                                
                            </tbody>
                    	</table>                           
                    	
                    	<div class="mt-5 mb-3 bg-light" id="page2el">
                    		<?php echo $text9; ?>
                    	</div>
                    	
                    	<table width="95%">
                            <thead >
                                <tr class="ligneHead">
                                    <th width="20%"><?php echo $text6; ?></th>
                                    <th width="80%"><?php echo $text7; ?></th>
                                </tr>
                            </thead>
                            
                            <tbody>
                            <?php 
                                foreach ($tabdonneclasse2 as $key=>$tabval){
                                    $val=implode(", ", $tabval);
                    			
                			?>
                			<tr class="ligneBody">
                				<td>
                					<?php echo $key; ?>
                				</td>
                				<td>
                					<?php echo $val; ?>
                				</td>
                			</tr>
                			<?php 
                                }
                			?>
                                
                            </tbody>
                    	</table>   
                    </div>                                     

                </div>

            </div>
        </div>
    </main>
    <script src="../js/html2pdf.bundle.min.js"></script>  
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="../js/scriptRecapnotes.js"></script>
    <script src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
   </body>
   
 </html>
    		
    		
    		