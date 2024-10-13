<?php
	//use model\Sequences;
	include_once '../model/Sequences.php';
	session_start();
	//$langue=$_SESSION["langue"];
	$sequences=unserialize($_SESSION["sequence"]);
	$matriculeEtab=$sequences->getMatriculeetab();
	//print_r($sequences); exit();
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
<?php 
	   require_once 'boutonretour.php';
    	$cs = simplexml_load_file("../data/datatoload$matriculeEtab.xml");
    	foreach ($cs->etablissement as $etab) {
    	    $matriculeetab=$etab->matriculeetab;
    	    $nometabFR=$etab->nometabfr;
    	    $nometabAN=$etab->nometabang;
    	}
    	
    	foreach ($cs->sequences as $seq) {
    	    $numtrim=$seq->numtrim;
    	    $annee=$seq->nomannee;
    	}
    	$nbprof=0;
    	$nbeleve=0;
    	$nbclasse=0;
    	foreach ($cs->listepersonnel as $listepersonnel) {
    	    foreach ($listepersonnel->personnel as $personnel) {
    	       $nbprof++;   
    	    }
    	}
    	
    	foreach ($cs->listeeleve as $listeeleve) {
    	    foreach ($listeeleve->eleve as $eleve) {
    	       $nbeleve++;    
    	    }
    	}
    	foreach ($cs->listeclasse as $listeclasse) {
    	    foreach ($listeclasse->classe as $classe) {
    	        $nbclasse++;
    	    }
    	}

	?>

	<main>
        <div class="container mainpart">
            <div class="row">
                <div class="col-md-5 leftpart">

                </div>

                <div class="col-md-7 rightpart">
                    <div class="mb-2">
                        <?php echo boutonretour("accueil_prof.php", $langue); ?>
                    </div>
                    <hr />

                    <form name="formulaire" method="post" action="../control/firstcontrol.php" id="formu">
						<div class="mb-3 bg-light text-center">RECAPITULATIF DES DONNÉES À CHARGER</div>
						
						<div class="mb-2">
							<table width="100%" align="center" class="">
								<tr id="tabrecapupload">
									<td>
										Nom de l'établissement
									</td>
									<td align="center">
										<?php echo "$nometabFR / $nometabAN"; ?>
									</td>
								</tr>
								
								<tr id="tabrecapupload">
									<td>
										Trimestre 
									</td>
									<td align="center">
										<?php echo "$numtrim"; ?>
									</td>
								</tr>
								
								<tr id="tabrecapupload">
									<td>
										Année scolaire 
									</td>
									<td align="center">
										<?php echo "$annee"; ?>
									</td>
								</tr>
								
								<tr id="tabrecapupload">
									<td>
										Date limite entrée des notes 
									</td>
									<td align="center">
										<?php echo $_SESSION["datelimite"]; ?>
									</td>
								</tr>
								
								<tr id="tabrecapupload">
									<td>
										nombre de classes
									</td>
									<td align="center">
										<?php echo "$nbclasse"; ?>
									</td>
								</tr>
								
								<tr id="tabrecapupload">
									<td>
										Nombre d'élèves
									</td>
									<td align="center">
										<?php echo "$nbeleve"; ?>
									</td>
								</tr>
								
								<tr id="tabrecapupload">
									<td>
										Nombre d'enseignants
									</td>
									<td align="center">
										<?php echo "$nbprof"; ?>
									</td>
								</tr>
							</table>
						</div>
						<div class="rouge" align="center">
							Le chargement du fichier entrainera la suppression de toutes les données précédentes concernant le <?php echo $nometabFR." / ".$nometabAN; ?> !
							<br /> cLIQUER SUR LE BOUTON POUR CONTINUER
							<br />
							<input type="submit" name="valider_data_upload" value="  Continuer  " />
						</div>
						<br />
					</form>
                </div>

            </div>
        </div>
    </main>
    
    <script src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
	
</body>
</html>	
	
	
	
	
	