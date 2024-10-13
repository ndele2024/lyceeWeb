<!DOCTYPE html>
<html lang="en">

<?php 
$userAgent=$_SERVER ['HTTP_USER_AGENT'];
$_SESSION["useragent"]="oui";
if(stristr($userAgent, "SygbussWebYAKOO")){//Mozilla
    $disButton="";
    $classBut="btn-index";
    $disZone1="zone1";
}
else {
    if (stristr($userAgent, "Windows")) {// linux
        $disZoneW=""; $disZoneA="zone1"; $disZoneL="zone1";
        if ((stristr($userAgent, "Win64"))or(stristr($userAgent, "x64"))or(stristr($userAgent, "x86_64"))) {
            $lien64=""; $lien32="zone1";
        }
        else {
            $lien64="zone1"; $lien32="";
        }
    }
    elseif (stristr($userAgent, "Android")) {
        $disZoneW="zone1"; $disZoneA=""; $disZoneL="zone1";
    }
    else {
        $disZoneW="zone1"; $disZoneA="zone1"; $disZoneL="";
    }
    $disButton="disabled";
    $classBut="btn-index-dis";
    $disZone1="";
}

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="prestation de services informatiques, logiciel de gestion établissements scolaire, installation des caméras, installation des réseaux, ventes du matériel et des logiciel, maintenance"/>
    <meta name="keywords" content="sygbuss, SYGBUSS, YAKOO, Bulletins, etablissement scolaire, installation réseaux informatiques, installaion camera"/>
    <meta name="author" content="YAKOO SYGBUSS" />
    <title>SYGBUSS YAKOO</title>

    <link rel="stylesheet" href="./bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./style/style_index.css">
    <link href="//fonts.googleapis.com/css?family=Playball" rel="stylesheet" type="text/css">
	<link rel="icon" href="dialog/images/favicon.ico" type="image/x-icon"> 
    <script language="javascript" type="text/javascript" src="dialog/js/objetxhr.js"> </script>
	<script language="javascript" type="text/javascript" src="dialog/js/ajax.js"> </script>
</head>

<body onload="get_info_user('userAgent')">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-success navsygbuss">
            <div class="container-fluid">
                <img src="./ressources/logo1.png" alt="logo sygbuss" class="image_logo">
                <a class="navbar-brand text-nav css-3d-text" href="#">YAKOO Sygbuss</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <div class="text-logo css-3d-text">
            YAKOO SYGBUSS
        </div>
        <div class="bouton-connect">
            <!-- <a href="index_login.php"> -->
            <button class="<?php echo $classBut; ?>" id="bouton-index" <?php echo $disButton; ?> >SE CONNECTER</button>
            <!-- </a> -->
        </div>
        <div class="text-head" id="<?php echo $disZone1; ?>">
        	<div id="<?php echo $disZoneW; ?>">
        		Veuillez Télécharger et installer l'application 
            	<div id="<?php echo $lien64; ?>"><a href="update/SYGBUSS_clien.exe">SYGBUSS-Client Windows 64 bits</a></div>
            	<div id="<?php echo $lien32; ?>"><a href="update/SYGBUSS_clien.exe">SYGBUSS-Client Windows 32 bits</a></div> 
            	pour utiliser votre service de façon optimale !<br />
            	Merci de faire confiance à YAKOO SYGBUSS.
        	</div>
        	<div id="<?php echo $disZoneA; ?>">
        		Veuillez Télécharger et installer l'application 
            	<div id="lien64"><a href="https://play.google.com/store/apps/details?id=com.yakoo.sygbuss&hl=fr">SYGBUSS android</a></div>
            	pour utiliser votre service de façon optimale !<br />
            	Merci de faire confiance à YAKOO SYGBUSS.
        	</div>
        	<div id="<?php echo $disZoneL; ?>">
        		Vous ne pouvez pas utiliser l'application avec ce système d'exploitation.
        		<br /> Veuillez utiliser un ordinateur sous Windows ou votre smart-phone
        	</div>
            	
         </div>
        
     </header>

    <main>
        <!-- grille publicitaire -->
        <div class="container">
            <div class="texte-service">NOS SERVICES</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3" id="card-index">
                        <img src="./ressources/logobmp.bmp" class="card-img-top img-card" alt="logo sygbuss">
                        <div class="card-body">
                            <h5 class="card-title">SYGBUSS Votre application de gestion d'établissement scolaire</h5>
                            <p class="card-text">Editez vos bulletins et statistiques en toutes sérénité. Générez vos
                                emplois de temps, cartes d'identité informatisées et communiquez avec les parents
                                d'élèves</p>
                            <a href="#text-contacter" class="card-button">Nous contacter ...</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3" id="card-index">
                        <img src="./ressources/vente-materiel.jpg" class="card-img-top img-card" alt="matériels informatiques">
                        <div class="card-body">
                            <h5 class="card-title">Vente du matériel informatique</h5>
                            <p class="card-text">Offrez vous du matériel informatique de qualité : ordinateur,
                                imprimante, vidéo-projecteur, photocopieuse, accessoires informatiques divers,
                                équipements réseaux...
                                A des prix défiants toutes concurences. </p>
                            <a href="#text-contacter" class="card-button">Nous contacter ...</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3" id="card-index">
                        <img src="./ressources/maintenance.png" class="card-img-top img-card" alt="image maintenance">
                        <div class="card-body">
                            <h5 class="card-title">Maintenance des ordinateurs et copieur</h5>
                            <p class="card-text">Problème avec vos équipements informatiques : ordinateurs, imprimantes,
                                photocipieuses ... Nous sommes à votre service</p>
                            <a href="#text-contacter" class="card-button">Nous contacter ...</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3" id="card-index">
                        <img src="./ressources/install-camera.jpg" class="card-img-top img-card" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Installation des caméras de surveillance</h5>
                            <p class="card-text">Nous installons les caméras de surveillance dans vos locaux avec accès
                                à distance via vos appareils mobiles</p>
                            <a href="#text-contacter" class="card-button">Nous contacter ...</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3" id="card-index">
                        <img src="./ressources/install-reseau.png" class="card-img-top img-card" alt="image maintenance">
                        <div class="card-body">
                            <h5 class="card-title">Installation des réseaux informatiques</h5>
                            <p class="card-text">Problème avec vos équipements informatiques : ordinateurs, imprimantes,
                                photocipieuses ... Nous sommes à votre service</p>
                            <a href="#text-contacter" class="card-button">Nous contacter ...</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div>
        </div>
        <hr />
        <!-- carroussel d'image -->
        <p class="titre-caroussel">Quelques exemples de documents de l'application SYGBUSS</p>

        <div id="carouselExampleDark" class="carousel carousel-dark slide bloc-carroussel" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3" aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="4" aria-label="Slide 5"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="5" aria-label="Slide 6"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="./ressources/doc-sygbuss/bulletin1.jpg" class="d-block w-100" alt="Bulletin de note modèle 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Bulletin SYGBUSS</h5>
                        <p>Premier modèle de bulletin</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="./ressources/doc-sygbuss/bulletin2.jpg" class="d-block w-100" alt="Bulletin de note modèle 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Bulletin SYGBUSS</h5>
                        <p>Deuxième modèle de bulletin</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./ressources/doc-sygbuss/bulletin3.jpg" class="d-block w-100" alt="Bulletin de note modèle 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Bulletin SYGBUSS</h5>
                        <p>Troisième modèle de bulletin</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./ressources/doc-sygbuss/fiche-stat_010.jpg" class="d-block w-100" alt="Fiche statistique">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Fiche statistique</h5>
                        <p>Recap des taux de couvertrure des programmes et heures</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./ressources/doc-sygbuss/fiche-stat_022.jpg" class="d-block w-100" alt="Fiche statistique">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Fiche statistique</h5>
                        <p>Recap des taux de couvertrure des programmes et heures</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./ressources/doc-sygbuss/fiche-stat_022.jpg" class="d-block w-100" alt="Fiche statistique">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Livret scolaire</h5>
                        <p>Recapitulatif des notes pour livret scolaire</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </main>

    <footer>

        <div id="text-contacter">
            <p>Nous contacter</p>

            <p class="contacts">
                <img src="./ressources/phone-solid.svg" alt="whatsapp icone" class="img-contact"> 695 30 88 69 <br />
                <img src="./ressources/whatsapp-brands.svg" alt="phone icone" class="img-contact"> 676 74 09 94 <br />
                <img src="./ressources/envelope-solid.svg" alt="mail icone" class="img-contact"> sygbussyakoo@gmail.com
                <br />
            </p>
        </div>

    </footer>

    <script src="./bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
	<script language="javascript" type="text/javascript"> 
		document.querySelector(".btn-index").addEventListener("click", function () {
				location.href="index_login.php";
			});
			
		/*userAgent = navigator.userAgent;
		
		if((userAgent.indexOf("QtWebEngine")==-1)||(userAgent.indexOf("Android")!=-1)) {
			document.getElementById("zone1").style.display="none";
			document.querySelector(".btn-index").addEventListener("click", function () {
				location.href="index_login.php";
			});
		}
		else if(userAgent.indexOf("Windows")!=-1){
					document.querySelector("#lien32").style.setProperty("visibility", "hidden");
		if((userAgent.indexOf("Win64")!=-1)||(userAgent.indexOf("x64")!=-1)||(userAgent.indexOf("x86_64")!=-1)) {
				document.querySelector("#lien64").style.setProperty("visibility", "visible");
			}
			else {
				document.querySelector("#lien32").style.setProperty("visibility", "visible");
				document.querySelector("#lien64").style.setProperty("visibility", "hidden");
			}
			document.getElementById("zone1").style.display="block";
			document.querySelector(".btn-index").style.setProperty("display", "none");
		}
		else{
			console.log(userAgent);
			document.getElementById("zone1").innerHTML="Vous ne pouvez pas vous connecter avec ce système veuillez utiliser Windows ou Android";
			document.querySelector(".btn-index").style.setProperty("display", "none");
		}
		*/
</script>
</body>

</html>