<?php
function recherche($x, $p)
{
  $co=file_get_contents("/var/www/lycee/privilege/$x");
  $ok=strstr($co, $p);
  return $ok;
}
//$langue=$prof->getLangue();
//$fonction=$prof->getFonction();
$langue=$prof->getLangue();
if($langue=="F")
{
  $text11="Gestion des notes/absences";
  $text12="Langue";
  $text13="Francais";
  $text14="Anglais";
  $text15="Imprimer la fiche statistique";

  $text1="Gestion des notes";
  $text2="Insérer des notes";
  $text3="Modifier une note";
  $text4="Afficher des notes";
  $text5="Récapitulatif de l'entrée des notes";
  $text6="Modifier la date limite d'entrée des notes";
  $text7="Ajouter/modifier un administrateur";
  $text8="Impression de l\'emplois de temps";
  $text9="Insérer/Modifier les heures d'absence";
  $text10="Modifier les heures d'absence";
  $t1=array("Statistiques", "Statistiques professeur", "Prévisions statistiques AP", "Commenter la fiche statistique", "Imprimer la fiche statistique", "Modifier les statistiques des enseignants");
  $t2=array("Professeur principal", "Imprimer les bulletins", "Commenter la fiche stat du conseil de classe", "Imprimer la fiche stat du conseil de classe", "Imprimer la liste des tableaux d\'honneur", "Insérer les numéros de téléphone", "Modifier un élève", "Charger/Modifier les photos", "Vérifier les photos des élèves", "Permuter les photos des élèves", "Choisir les matières optionnelles des élèves");
  $t3=array("Paramètre compte", "Deconnexion", "Modifier le nom d'utilisateur", "Modifier le mot de passe", "Insérer la signature", "Envoyer des sms", "Statut envoie des sms", "Sauvegarder la base de données", "Réinitialiser un compte", "Arrêter SYGBUSS", "Déconnecter un utilisateur", "Envoyer des sms", "Inserer licence", "Supprimer des notes", "Charger les photos des élèves", "Vérifier les photos des élèves", "Supprimer les photos des élèves", "Permuter les photos des élèves", "Update SYGBUSS", "Télécharger le fichier pour envoie des sms");
  $t4=array("Impression des documents", "Impression des Bulletins", "Impression des listes des élèves", " Statistiques du conseil de classe", "Fiches statistiques", "Récapitulatifs des résultats", "Listes statistiques personnalisées par classe", "Impression du recapitulatif des heures");
  $t5=array("Gestion des notes à la maison", "Télécharger les données pour tranfert à l'établissement", "charger les données de bases");
}
else
{
    $text11="Marks/absences managment";
    $text12="Language";
    $text13="French";
    $text14="English";
    $text15="Printing statistics";

  $text1="Marks managment";
  $text2="Insert the marks";
  $text3="Modify a mark";
  $text4="Display marks";
  $text5="Insertion marks report";
  $text6="Modify the limit date of marks insertion";
  $text7="Add/Modify an administrator";
  $text8="print time table";
  $text9="Insert / Modify student absence time";
  $text10="Modify student absence time";
  $t1=array("Statistics", "Teacher's statistics", "H.O.Ds provisional statistics", "Comment the statistics form", "Print the statistics form", "Update statistics of teatchers");
  $t2=array("Class master", "Print report cards", "Comment the class council\'s statistics form", "Print the class council\'s statistics form", "Print the list of honour roll", "enter phone number", "Modify a student", "Load/Update pictures", "Verify student\'s pictures", "Permute student\'s pictures", "Choose the student\'s optionnels subjects");
  $t3=array("Account tools", "Log off", "Modify the username", "Modify the password", "Insert the signature", "Send the messages", "Sending sms Status", "Save the database", "Reinitialize an account", "stop sygbuss server", "Log off an user", "Send messages", "Insert licence", "Delete marks", "Load student's pictures", "Verify student\'s pictures", "Delete student's pictures", "Permute student\'s pictures", "Update SYGBUSS", "Download the file for sending sms");
  $t4=array("Printing documents", "print report cards", "print student's list", " Statistiques du conseil de classe", "Fiches statistiques", "Récapitulatifs des résultats", "Listes statistiques personnalisées par classe", "Impression du recapitulatif des heures");
  $t5=array("Marks managment for home", "Download datas for tranfer to school", "upload basis data");
}

//info telephone
//$infotel="azerty_bon";//$_GET["infotel"];

if($prof->getFonction()=="SURVEILLANT GENERAL"){
    $textNote="$text11";
}
else {
    $textNote="$text1";
}

?>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark navsygbuss">
        <div class="container-fluid">
            <img src="../ressources/logo1.png" alt="logo sygbuss" class="image_logo">
            <a class="navbar-brand" href="#">Sygbuss</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="accueil_prof.php">Accueil</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink1" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php 
                                echo $textNote;
                            ?>
                        </a>
                        
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
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
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo"$t1[0]"; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
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
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink3" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo"$t3[0]"; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
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
                    </li>
                    <li class="nav-item dropdown decalage-nom">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink3" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $text12 ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a onclick="changelangue('F', 'langue')" class="dropdown-item" href="#"><?php echo $text13 ?></a></li>
                            <li><a onclick="changelangue('A', 'langue')" class="dropdown-item" href="#"><?php echo $text14 ?></a></li>
                        </ul>
                    </li>
                    <li class="nav-item-end">
                        <span class="" id="forme-nom" aria-current="page">
                        <?php 
                            echo $prof->getNomTeacher();
                        ?>
                        </span>
                        <a href="session_out.php" class="">
                            <img src="../ressources/deconnexion.png" alt="deconnexion" class="image_deconnexion" />
                        </a>
                    </li>
                </ul>
                
            </div>
        </div>
    </nav>

    <?php include 'message_bienv.php';?>
    
</header>
