<?php 
    use model\Classe;
    use model\Matiere;
    use model\Teacher;
    use model\Eleve;
    use model\StatPrevue;
    
    include_once '../model/Teacher.php';
    include_once '../model/Eleve.php';
    include_once '../model/Classe.php';
    include_once '../model/Matiere.php';
    include_once '../model/StatPrevue.php';
    //include_once '../model/Sequences.php';

	session_start();
    require_once 'boutonretour.php';
	//print_r($_SESSION); exit();

    $tabdonneXML=$_SESSION["donneexml"];
    $tabuserModif=$_SESSION["usermodif"];
    //print_r($tabdonneXML); exit();
    //$sequence=unserialize($_SESSION["sequence"]);
    $tabdonnebase=array(Classe::getNombreclasse($tabdonneXML[9], $tabdonneXML[10]),
        Matiere::getNombreMatiere($tabdonneXML[9]),
        Matiere::getNobreSerie($tabdonneXML[9]),
        Matiere::getNombreDepart($tabdonneXML[9]),
        Teacher::getNombreProf($tabdonneXML[9]),
        Eleve::getNombreEleve($tabdonneXML[10], $tabdonneXML[9]),
        Classe::getNombreCour($tabdonneXML[9], $tabdonneXML[10]),
        Teacher::getNombreCour($tabdonneXML[10], $tabdonneXML[9]),
        StatPrevue::getnobreStat($tabdonneXML[10], $tabdonneXML[9])
     );
    $tabtablebase=array("classe", "matière", "série", "département", "enseignant", "élève", "Cours classe", "Cours Enseignant", "Prévision statistique");
    //echo Matiere::getNombreMatiere($tabdonneXML[6]); exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SYGBUSS YAKOO</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" /> 
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="../bootstrap-5.1.3-dist/css/bootstrap.css" />
    <link rel="stylesheet" href="../style/styleshare.css" />
    <link rel="stylesheet" href="../style/styleGestionNotes.css" />
	<script language="javascript" type="text/javascript" src="js/objetxhr.js"> </script>
	<script language="javascript" type="text/javascript" src="js/ajax.js"> 
	
	</script>

</head>
<body>

	<main>
        <div class="container mainpart">
            <div class="row">
                <div class="rightpart">
                    <div class="mb-2">
                        <?php echo boutonretour("../control/firstcontrol.php?route=session_out", "F"); ?>
                    </div>
                    <hr />
					
					<form name="formulaire" method="post" action="../control/firstcontrol.php" id="formu">
			
						<div class="text-center bg-light mb-3">
							RECAPITULATIF DES DONNÉES QUE VOUS AVEZ CHARGEES
						</div>
						<div class="mb-4">
							<table width="100%" align="center">
								<thead>
									<tr class="text-center bg-success entete">
										<td>QUANTITE DE DONNEES</td>
										<td>DANS LE FICHIER</td>
										<td>DANS LA BASE DE DONNÉES</td>
										<td>OBSERVATIONS</td>
									</tr>
								</thead>
								<tbody>
									<?php 
									for ($i = 0; $i < count($tabtablebase); $i++) {
									?>
									<tr id="tabrecapupload">
										<td>
											<?php echo $tabtablebase[$i]; ?>
										</td>
										<td align="center">
											<?php echo $tabdonneXML[$i]; ?>
										</td>
										<td align="center">
											<?php echo $tabdonnebase[$i]; ?>
										</td>
										<td>
											<?php 
											if($tabdonneXML[$i]==$tabdonnebase[$i]){
													echo "RAS";
												}
												else {
													$x=$tabdonneXML[$i]-$tabdonnebase[$i];
													echo "<span>$x ".$tabtablebase[$i]."(s) pas enregistrée(s)</span>";
												}
											?>
										</td>
									</tr>
									<?php 
									}
									?>
								</tbody>
							</table>
						</div>
						
							<?php 
								if(count($tabuserModif)>0) {
							?>
								<div class="text-center bg-light mb-2"> 
									LES NOMS D'UTILISATEUR DES ENSEIGNANTS SUIVANTS ONT ETE MODIFIES
								</div>
								<table align='center'>
									<tr>
										<th>Nom de l'enseignant</th>
										<th>Nouveau nom utilisateur</th>
									</tr>
									<?php 
									for ($i = 0; $i < count($tabuserModif); $i++) {
									?>
									<tr>
										<td>
											<?php echo $tabuserModif[$i][0]; ?>
										</td>
										<td>
											<?php echo $tabuserModif[$i][1]; ?>
										</td>
									</tr>
									<?php 
									}
									?>
								
								</table>
								<br /><br />
							<?php 
							}
							?>	
					</form>
                </div>

            </div>
        </div>
    </main>
    
    <script src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>

</body>
</html>

