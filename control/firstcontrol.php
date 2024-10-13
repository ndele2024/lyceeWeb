<?php
ini_set('max_execution_time',1200);

use model\Teacher;
use model\School;
use model\Sequences;
use model\Evaluation;
use model\Classe;
use model\Statfait;
use model\Absence;
use model\Eleve;
use model\Matiere;
use model\StatPrevue;

session_start();
include_once '../model/Teacher.php';
include_once '../model/School.php';
include_once '../model/Sequences.php';
include_once 'fonction_cypher.php';
include_once '../model/Evaluation.php';
include_once '../model/Statfait.php';
include_once '../model/Absence.php';
include_once '../model/StatPrevue.php';
include_once '../model/Eleve.php';

//redirection vers l'index
if (($_SESSION['access']!="oui")OR(!isset($_SESSION["access"]))) {header("Location:../index_login.php");}

if (isset($_GET["route"])) {
    $route=$_GET["route"];
    switch ($_GET["route"]) {
        case "session_out":
            //suppression des fichiers
            header("location:../dialog/session_out.php");
            break;
        case "forget_password":
            header("location:../dialog/modif_email_prof.php?param=password");
            break;
        case "upload_data":
            $userAgent = $_SERVER ['HTTP_USER_AGENT'];
            if(strstr($userAgent, "SYGBUSS_androidWeb")){
                header("location:../dialog/automate.1lycee.syg");
            }
            else{
                header("location:../dialog/upload_data.php");
            }
            break;
            
        default:
            header("location:../dialog/$route");
        break;
    }
}

if (isset($_POST["validercodeschool"])) {
    $code=$_POST["codeschool"];
    $matriculeet=School::getMatriculeByCode($code);
    if (empty($matriculeet)) {
        header("location:../index_login.php?errus=1");
    }
    else {
        $_SESSION["matetab"]=$matriculeet;
        header("location:../index_log.php");
    }

}

if (isset($_POST["validerindex"])) {
    $username=$_POST["user"];
    $matetab=$_SESSION["matetab"];
    if (empty($username)) {
        header("location:../index_log.php?errus=1");
    }
    else {
        $school=new School($matetab);
        $prof = new Teacher(NULL, NULL, NULL, NULL, $username, NULL, NULL, NULL, NULL, NULL, $school);
        //$listeEtab = $prof->getListeEtabByUsername($username);
        //print_r($listeEtab); exit();
        $_SESSION['access']="oui";
        if($prof->getTeacherByUserOnly($username, $matetab)) {
            //print_r($prof); exit();
            $_SESSION["prof"]=serialize($prof);
            //$school=$prof->getEtab();
            //$_SESSION["nometabfr"]=$school->getNomSchoolFr($school->getMatriculeetab());
            //$sequences = new Sequences($school->getMatriculeetab());
            //$_SESSION["sequence"] = serialize($sequences);
            if(file_exists("../ressources/maintenance.txt")){
                if($username=="ndele"){
                    header("location:../index_pass.php");
                }
                else{
                    header("location:../maintenance.php");
                }
            }
            else {
                header("location:../index_pass.php");
            }
            
            
        }
        elseif ($prof->getTeacherByEmailOnly($username, $matetab)){
            $_SESSION["prof"]=serialize($prof);
            //$school=$prof->getEtab();
            //$sequences = new Sequences($school->getMatriculeetab());
            //$_SESSION["sequence"] = serialize($sequences);
            if(file_exists("../ressources/maintenance.txt")){
                if($username=="ndele"){
                    header("location:../index_pass.php");
                }
                else{
                    header("location:../maintenance.php");
                }
            }
            else {
                header("location:../index_pass.php");
            }
            
        }
        elseif ($prof->getTeacherByContactOnly($username, $matetab)){
            $_SESSION["prof"]=serialize($prof);
            //$school=$prof->getEtab();
            //$sequences = new Sequences($school->getMatriculeetab());
            //$_SESSION["sequence"] = serialize($sequences);
            if(file_exists("../ressources/maintenance.txt")){
                if($username=="ndele"){
                    header("location:../index_pass.php");
                }
                else{
                    header("location:../maintenance.php");
                }
            }
            else {
                header("location:../index_pass.php");
            }
            
        }
        else {
            unset($prof);
            header("location:../index_log.php?errus=2");
        }
    }
        
}

if(isset($_POST["validerpass"])) {
    $pass=$_POST["password"];
    $etablissement=$_POST["etablissement"];
    $school = new School($etablissement);
    if ((empty($pass))OR(empty($etablissement))) {
        header("location:../index_pass.php?errpass=1");
    }
    else {
        $prof = unserialize($_SESSION["prof"]);
        if($prof->getTeacherByUser($prof->getUsername(), $school)) {
            //print_r($prof); exit();
            ;
        }
        elseif ($prof->getTeacherByEmail($prof->getEmail(), $school)){
            ;
        }
        else {
            $prof->getTeacherByContact($prof->getContact(), $school);
        }
        //$_SESSION['access']="oui";
        if($pass==$prof->getPassword()) {
            //$school= new School($etablissement);
            $_SESSION["nometabfr"]=$school->getNomSchoolFr($school->getMatriculeetab());
            $sequences = new Sequences($school->getMatriculeetab());
            $prof->setEtab($school);
            
            //$_SESSION['access']="oui";
            $_SESSION["sequence"] = serialize($sequences);
            $_SESSION["prof"]=serialize($prof);
            //print_r($prof);
            $suiteUrl=$school->crypteUrl($prof->getSauvegarder_base());
            //print_r($school->decrypteUrl($suiteUrl)); exit();
            header("location:../dialog/accueil_prof.php?$suiteUrl");
        }
        else {
            header("location:../index_pass.php?errpass=2");
        }
    }
}

if(isset($_POST["valider_upload_data"])) {
    if (empty($_FILES["datafile"]["tmp_name"])) {
        header("location:../dialog/upload_data.php?err=1");
    }
    else {
        $prof = unserialize($_SESSION["prof"]);
        $matriculeEtabActuel=$prof->getEtab()->getMatriculeetab();

        $nomsortie=$_FILES["datafile"]["name"];
        if(file_exists("../data/$nomsortie")) {
            unlink("../data/$nomsortie");
        }
        if ($_FILES["datafile"]['type'] != "application/octet-stream") {
            header("location:../dialog/upload_data.php?err=2");
        }
        // Placement du fichier à l’emplacement désiré
        $dossier = "../data/datatoload$matriculeEtabActuel.ry";
        $bon=move_uploaded_file($_FILES["datafile"]["tmp_name"], $dossier);

        //transfert FTP
        /*$ftp_hostname = '65.108.123.218';
        $ftp_username = 'sygbusslocal@sygbuss.cm';
        $ftp_password = 'wcpBKLQypIoH';
        $dest_file = "public_html/data/datatoload$matriculeEtabActuel.ry";
        //$src_file = $_FILES['srcfile']['name'];
        $ftpcon = ftp_connect($ftp_hostname); //or die('Error connecting to server...');
        if (@ftp_login($ftpcon, $ftp_username, $ftp_password)){
            // successfully connected
            $bon=ftp_put($ftpcon, $dest_file, $nomsortie, FTP_ASCII);
        }else{
            ftp_close($ftpcon);
            header("location:../dialog/upload_data.php?err=3");
        }
        ftp_close($ftpcon);*/

        if (!$bon) {
            header("location:../dialog/upload_data.php?err=3");
        }
        else {
            //$prof = unserialize($_SESSION["prof"]);
            //$matriculeEtabActuel=$prof->getEtab()->getMatriculeetab();
            $input="../data/datatoload$matriculeEtabActuel.ry";
            $output="../data/datatoload$matriculeEtabActuel.xml";
            decrypte($input, $output);
            $cs = simplexml_load_file("../data/datatoload$matriculeEtabActuel.xml");
            foreach ($cs->etablissement as $etab) {
                $matriculeetab=$etab->matriculeetab;
            }
            
            if(($matriculeEtabActuel==$matriculeetab)OR($prof->getFonction()=="RIEN")) {
                if(!isset($_POST["datelimite"])) {
                    $_SESSION["datelimite"] = "";
                }
                else {
                    $_SESSION["datelimite"] = $_POST["datelimite"];
                }
                
                header("location:../dialog/recap_uplaod.php");
            }
            else {
                header("location:../dialog/upload_data.php?err=4");
            }
            /*$school=$prof->getEtab();
            $sequences = new Sequences($school->getMatriculeetab());
            //vérification si déja données
            $input="../data/datatoload.ry";
            $output="../data/datatoload.xml";
            decrypte($input, $output);
            $cs = simplexml_load_file('../data/datatoload.xml');
            foreach ($cs->etablissement as $etab) {
                $matriculeetab=$etab->matriculeetab;
            }
            
            foreach ($cs->sequences as $seq) {
                $numtrim=$seq->numtrim;
                $annee=$seq->nomannee;
            }
            //si on est dans la meme sequence 
            if($sequences->getNumtrim()==$numtrim) {
                //vérification si déja entré les notes
                if (Evaluation::verifNoteExist($numtrim, $annee, $matriculeetab)) {
                    //affichage du message por confirmer le chargement des données malgré l'existance des notes
                }
            }*/
 
        } 
    }
}

if(isset($_POST["valider_data_upload"])) {
    include_once 'lireXML.php';
    //eregistrement dans un fichier pour affichage en cas de coupure
    
    header("location:../dialog/recap_after_upload.php");
}

if (isset($_POST['valider_gestion_note'])) {
    $classep=$_POST['classe'];
    $seq=$_POST['seq'];
    $action=$_POST['action'];
    $codematiere=$_POST["codematiere"];
    $prof = unserialize($_SESSION["prof"]);
    $sequence=unserialize($_SESSION["sequence"]);
    
    if ((empty($classep))||(empty($codematiere))) {
        header("location:../dialog/gestion_notes.php?err=1");
        exit();
    }
    
    switch ($action) {
        case 1:
            if(isset($_SESSION["jourRestatnt"])) {
                header("location:../dialog/gestion_notes.php?err=5");
                exit();
            }
            
            $competence=utf8_encode(addslashes($_POST['competence']));
            $eval = new Evaluation();
            //verif si ma copétence est deja inserer sinon insert si oui update
            $tabcomp = $eval->getDonneeCompetence($codematiere, $prof->getCodeTeacher(), $classep, $seq, $sequence->getNomannee(), $prof->getEtab()->getMatriculeetab());
            $nnr=count($tabcomp);
            if($nnr==0) {
                $nbnote=0;
                $execute = $eval->insertCompetence($prof->getCodeTeacher(), $classep, $codematiere, $competence, $seq, $nbnote, $sequence->getNomannee(), $prof->getEtab()->getMatriculeetab());
            }
            else {
                $nbnote=$tabcomp[1];
                $excute = $eval->setDonneeCompetence($competence, $nbnote, $codematiere, $prof->getCodeTeacher(), $classep, $seq, $sequence->getNomannee(), $prof->getEtab()->getMatriculeetab());
            }
            
            if($nbnote>=2)
            {
                header("location:../dialog/gestion_notes.php?err=2");
                exit();
            }
            $numerodevoir=$nbnote+1;
            
            $_SESSION['classe']=$classep;
            $_SESSION['seq']=$seq;
            $_SESSION['codematiere']=$codematiere;
            $_SESSION['verif']=1;
            $_SESSION['nbnote']=$numerodevoir;
            $classe = new Classe($classep, $sequence->getNomannee(), $prof->getEtab());
            $tabeleve = $classe->eleveSuivant($codematiere, $classep, $sequence->getNumtrim(), $numerodevoir, $sequence->getNomannee(), $sequence->getMatriculeetab());
            $tabEleveAvecNote=$classe->getAllEleveClasseAvecNote($classep, $codematiere, $seq, $numerodevoir, $sequence->getNomannee(), $sequence->getMatriculeetab());
            $nbEAN=count($tabEleveAvecNote);
            if($nbEAN==0) {
                $_SESSION["deuxderniereleve"]=array();
            }
            elseif ($nbEAN<2) {
                $_SESSION["deuxderniereleve"]=array($tabEleveAvecNote[$nbEAN-1]);
            }
            else {
                $_SESSION["deuxderniereleve"]=array($tabEleveAvecNote[$nbEAN-2], $tabEleveAvecNote[$nbEAN-1]);
            }
            $_SESSION["eleve"]=$tabeleve;
            header("location:../dialog/insertion_note_prof.php");
            break;
        
        case 2:
            $numdevoir=$_POST['devoir'];
            if(empty($numdevoir)){
                header("location:../dialog/gestion_notes.php?err=3");
                exit();
            }
            //si plus de jour restant
            if(isset($_SESSION["jourRestatnt"])) {
                header("location:../dialog/gestion_notes.php?err=5");
                exit();
            }
            
            $_SESSION['classe']=$classep;
            $_SESSION['seq']=$seq;
            $_SESSION['codematiere']=$codematiere;
            $_SESSION['numdevoir']=$numdevoir;
            $classe = new Classe($classep, $sequence->getNomannee(), $prof->getEtab());
            $tabEleveNote=$classe->getAllEleveClasseAvecNote($classep, $codematiere, $seq, $numdevoir, $sequence->getNomannee(), $sequence->getMatriculeetab());
            $tabEleveClasse=$classe->getAllEleveClasse($classep, $sequence->getNomannee(), $sequence->getMatriculeetab());
            if(count($tabEleveNote)<count($tabEleveClasse)) {
                header("location:../dialog/gestion_notes.php?err=4");
                exit();
            }
            $_SESSION["eleve"] = $tabEleveNote;
            //print_r($_SESSION["eleve"]); exit();
            header("location:../dialog/modif_note_prof.php");
            break;
        
        case 3:
            $numdevoir=$_POST['devoir'];
            if(empty($numdevoir)){
                header("location:../dialog/gestion_notes.php?err=3");
                exit();
            }
            $_SESSION['classe']=$classep;
            $_SESSION['seq']=$seq;
            $_SESSION['codematiere']=$codematiere;
            $_SESSION['numdevoir']=$numdevoir;
            //info sur les élèves à afficher
            $classe = new Classe($classep, $sequence->getNomannee(), $prof->getEtab());
            $tabEleveNote=$classe->getAllEleveClasseAvecNote($classep, $codematiere, $seq, $numdevoir, $sequence->getNomannee(), $sequence->getMatriculeetab());
            $tabEleveClasse=$classe->getAllEleveClasse($classep, $sequence->getNomannee(), $sequence->getMatriculeetab());
            if(count($tabEleveNote)<count($tabEleveClasse)) {
                header("location:../dialog/gestion_notes.php?err=4");
                exit();
            }
            $_SESSION["eleve"] = $tabEleveNote;
            //print_r($_SESSION["eleve"]); exit();
            header("location:../dialog/affiche_note_prof.php");
            break;
            
        default:
            ;
            break;
    }
    
}

if (isset($_POST['valider_notes'])) {
    $matricule=$_POST["matricule"];
    $numseq=$_POST["seq"];
    $note=$_POST["note"];
    $matiere=$_SESSION["codematiere"];
    $numerodevoir=$_SESSION['nbnote'];
    $codeclasse=$_SESSION["classe"];
    $prof = unserialize($_SESSION["prof"]);
    $sequence=unserialize($_SESSION["sequence"]);
    if ($note==""){
        $classe = new Classe($codeclasse, $sequence->getNomannee(), $prof->getEtab());
        $tabeleve = $classe->eleveSuivant($matiere, $codeclasse, $sequence->getNumtrim(), $numerodevoir, $sequence->getNomannee(), $sequence->getMatriculeetab());
        header("location:../dialog/insertion_note_prof.php?er=1");
    }
    else {
        $classe = new Classe($codeclasse, $sequence->getNomannee(), $prof->getEtab());
        $sectionClasse=$classe->getSectionc();
        
        if (($note=="m")||($note=="M")||($note=="/")){
            $note=0; 
            $appreciation="MALADE";
        }
        else {
            if($sectionClasse=='A') {
                $appreciation = Evaluation::appreciation1($note);
            }
            else {
                $appreciation = Evaluation::appreciation($note);
            }
        }
        
        if(Evaluation::insertDonneeEvaluation($sequence->getNomannee(), $matricule, $matiere, $numseq, $note, $appreciation, $numerodevoir, $sequence->getMatriculeetab())){
            $nombreEleveTotal=count($classe->getAllEleveClasse($codeclasse, $sequence->getNomannee(), $sequence->getMatriculeetab()));
            $nombreEleveNote= Evaluation::nombreNoteClasse($codeclasse, $numseq, $numerodevoir, $matiere, $sequence->getNomannee(), $sequence->getMatriculeetab());
            //print_r($nombreEleveNote);exit();
            if($nombreEleveNote==$nombreEleveTotal) {
                $eval = new Evaluation();
                $tabcomp = $eval->getDonneeCompetence($matiere, $prof->getCodeTeacher(), $codeclasse, $numseq, $sequence->getNomannee(), $prof->getEtab()->getMatriculeetab());
                $excute = $eval->setDonneeCompetence($tabcomp[0], $numerodevoir, $matiere, $prof->getCodeTeacher(), $codeclasse, $numseq, $sequence->getNomannee(), $prof->getEtab()->getMatriculeetab());
                header("location:../dialog/insertion_note_prof.php?er=3");
            }
            else {
                $tabeleve = $classe->eleveSuivant($matiere, $codeclasse, $sequence->getNumtrim(), $numerodevoir, $sequence->getNomannee(), $sequence->getMatriculeetab());
                $tabEleveAvecNote=$classe->getAllEleveClasseAvecNote($codeclasse, $matiere, $numseq, $numerodevoir, $sequence->getNomannee(), $sequence->getMatriculeetab());
                //print_r($tabEleveAvecNote); exit();
                $nbEAN=count($tabEleveAvecNote);
                if($nbEAN==0) {
                    $_SESSION["deuxderniereleve"]=array();
                }
                elseif ($nbEAN<2) {
                    $_SESSION["deuxderniereleve"]=array($tabEleveAvecNote[$nbEAN-1]);
                }
                else {
                    $_SESSION["deuxderniereleve"]=array($tabEleveAvecNote[$nbEAN-2], $tabEleveAvecNote[$nbEAN-1]);
                }
                $_SESSION["eleve"]=$tabeleve;
                header("location:../dialog/insertion_note_prof.php");
            }
        }
        else {
            header("location:../dialog/insertion_note_prof.php?er=2");
        }
    }
}

if (isset($_POST["valider_statfait"])) {
    $codeclasse=$_POST["classe"];
    $codematiere=$_POST["codematiere"];
    $lecontf=$_POST["lecontf"];
    $leconpf=$_POST["leconpf"];
    $heuref=$_POST["heuref"];
    $nhad=$_POST["nhad"];
    
    if(empty($nhad)) {
        $nhad=0;
    }
    
    $prof = unserialize($_SESSION["prof"]);
    $sequence=unserialize($_SESSION["sequence"]);
    
    if (($lecontf=="")||($leconpf=="")||($heuref=="")) {
        header("location:../dialog/stat_prof.php?er=1");
        exit;
    }
    $statfait = new Statfait();
    if(count($statfait->getStatfait($codeclasse, $sequence->getNumtrim(), $codematiere, $sequence->getNomannee(), $sequence->getMatriculeetab()))==0) {
        if($statfait->insererDonneeStatfait($sequence->getNomannee(), $codeclasse, $codematiere, $sequence->getNumtrim(), $prof->getCodeTeacher(), $lecontf, $leconpf, $heuref, $nhad, $sequence->getMatriculeetab())) {
            header("location:../dialog/stat_prof.php?er=2");
        }
        else {
            header("location:../dialog/stat_prof.php?er=3");
        }
    }
    else {
        if($statfait->updateStatfait($codeclasse, $codematiere, $sequence->getNumtrim(), $sequence->getNomannee(), $sequence->getMatriculeetab(), $lecontf, $leconpf, $heuref, $nhad)) {
            header("location:../dialog/stat_prof.php?er=2");
        }
        else {
            header("location:../dialog/stat_prof.php?er=3");
        }
    }
}

if(isset($_POST["valider_modif_note"])) {
    $prof = unserialize($_SESSION["prof"]);
    $sequence=unserialize($_SESSION["sequence"]);
    $classep= $_SESSION['classe'];
    $seq=$_SESSION['seq'];
    $codematiere=$_SESSION['codematiere'];
    $numdevoir=$_SESSION['numdevoir'];
    $tabeleve=$_SESSION["eleve"];
    $classe = new Classe($classep, $sequence->getNomannee(), $prof->getEtab());
    for ($i = 0; $i < count($tabeleve); $i++) {
        $matricule=$_POST["matricule$i"];
        $note=$_POST["note$i"];
        if($note==$tabeleve[$i][7]) {
            continue;
        }
        
        if(($note=="m")||($note=="M")||($note=="/")) {
            $note=0;
            $appreciation="MALADE";
        }
        else {
            $sectionClasse=$classe->getSectionc();
            if($sectionClasse=='A') {
                $appreciation = Evaluation::appreciation1($note);
            }
            else {
                $appreciation = Evaluation::appreciation($note);
            }
        }
        
        if(Evaluation::updateDonneeEvaluation($note, $appreciation, $sequence->getNomannee(), $matricule, $codematiere, $seq, $numdevoir, $prof->getEtab()->getMatriculeetab())) {
            $tabEleveNote=$classe->getAllEleveClasseAvecNote($classep, $codematiere, $seq, $numdevoir, $sequence->getNomannee(), $sequence->getMatriculeetab());
            $_SESSION["eleve"]=$tabEleveNote;
            header("location:../dialog/modif_note_prof.php?er=1");
        }
        else {
            header("location:../dialog/modif_note_prof.php?er=2");
        }
    }
}

if(isset($_POST["validerEmail"])) {
    $param=$_POST["param"];
    $prof = unserialize($_SESSION["prof"]);
    if (empty($param)) {
        $email=$_POST["email"];
        if (empty($email)) {
            $email="yakoo2022@sygbuss.cm";
            //$email=$prof->getEmailAdmin();
        }
        $prof->setEmail($email, $prof->getEtab()->getMatriculeetab());
        $_SESSION["prof"]=serialize($prof);
        header("location:../dialog/modif_email_prof.php?er=1");
    }
    else {
        $email=$_POST["email"];
        if($prof->getEmail()!=$email) {
            header("location:../dialog/modif_email_prof.php?er=2&param=password");
        }
        else {
             //envoie du mail 
            $lienModifPass="http://127.0.0.1/sygbussconnectweb.net/dialog/modif_password_prof.php";
             $message="SYGBUSS WEB \n Cliquer sur le lien ci-dessous pour la modification de votre mot de passe\n 
            <a href='$lienModifPass'>Modification du mot de passe du compte Sygbuss web</a>";
             if(mail($email, "Modification du mot de passe SYGBUSS WEB", $message)) {
                 header("location:../dialog/modif_email_prof.php?er=3&param=password");
             }
             else {
                 header("location:../dialog/modif_email_prof.php?er=4&param=password");
             }
        }
    }
    
}

if (isset($_POST["valider_reinitialise"])) {
    $codeTeacher=$_POST["teacher"];
    $prof = unserialize($_SESSION["prof"]);
    $teacher = new Teacher($codeTeacher, null, null, null, null, null, null, null, null, null, $prof->getEtab());
    $teacher->getTeacherByCode($codeTeacher, $prof->getEtab());
    $newUsername=strtoupper(explode("%%", $teacher->getCodeTeacher())[0]).explode("LSWEBA", $prof->getEtab()->getMatriculeetab())[1];
    //verification de l'unicité
    $test=Teacher::isNotUniqueUser($newUsername, $prof->getEtab()->getMatriculeetab());
    while($test) {
        $newUsername=$newUsername.$prof->getEtab()->getMatriculeetab();
        $test=Teacher::isNotUniqueUser($newUsername, $prof->getEtab()->getMatriculeetab());
    }
    $teacher->setUsername($newUsername, $teacher->getEtab()->getMatriculeetab());
    $teacher->setPassword($newUsername, $teacher->getEtab()->getMatriculeetab());
    $nom=$teacher->getNomTeacher(); 
    $username=$teacher->getUsername();
    $passw=$teacher->getPassword();
    header("location:../dialog/reinitialiser_compte.php?nomT=$nom&userT=$username&passT=$passw");
}

if (isset($_POST["valider_modif_user"])) {
    $prof = unserialize($_SESSION["prof"]);
    $oldUser=$_POST["user1"];
    $newUser=$_POST["user2"];
    if ($prof->getUsername()!=$oldUser) {
        header("location:../dialog/modif_user.php?er=1");
        exit();
    }
    
    $prof->setUsername($newUser, $prof->getEtab()->getMatriculeetab());
    $_SESSION["prof"]=serialize($prof);
    header("location:../dialog/modif_user.php?er=3");
}

if (isset($_POST["valider_modif_pass"])) {
    $prof = unserialize($_SESSION["prof"]);
    $oldPass=$_POST["password1"];
    $newPass=$_POST["password2"];
    if ($prof->getPassword()!=$oldPass) {
        header("location:../dialog/modif_user.php?er=2");
        exit();
    }
    
    $prof->setPassword($newPass, $prof->getEtab()->getMatriculeetab());
    $_SESSION["prof"]=serialize($prof);
    header("location:../dialog/modif_user.php?er=3");
}

if (isset($_POST["validerAdmin"])) {
    $prof = unserialize($_SESSION["prof"]);
    $profadmin=$_POST["enseignant"];
    if (empty($profadmin)) {
        header("location:../dialog/ajouter_admin.php?er=1");
        exit();
    }
    $profad= new Teacher($profadmin, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $prof->getEtab());
    $profad->setSauvegarder_base("oui");
    //print_r($profad);
    header("location:../dialog/ajouter_admin.php?er=2");

}

if (isset($_POST["validerModifDatelimite"])) {
    $datelimit=$_POST["datelimite"];
    $tabdate=explode("-", $datelimit);
    if((empty($datelimit))OR($datelimit=="jj-mm-aaaa")) {
        header("location:../dialog/modif_datelimite.php?er=1");
    }
    elseif (count($tabdate)!=3){
        header("location:../dialog/modif_datelimite.php?er=2");
    }
    else {
        $datelimite=implode("-", array_reverse(explode("/", $datelimit)));
        //print_r($datelimite); exit();
        $sequence=unserialize($_SESSION["sequence"]);
        $sequence->setDatelimite($datelimite);
        $_SESSION["sequence"] = serialize($sequence);
        header("location:../dialog/modif_datelimite.php?er=3");
    }
}

if(isset($_POST["valider_gestion_absence"])) {
    $prof = unserialize($_SESSION["prof"]);
    $sequence = unserialize($_SESSION["sequence"]);
    $codeclasse = $_POST["classe"];
    $classe = new Classe($codeclasse, $sequence->getNomannee(), $prof->getEtab());
    $_SESSION["listeEleveAbsence"] = $classe->getAllEleveClasseAvecAbsence($codeclasse, $sequence->getNumtrim(), $sequence->getNomannee(), $sequence->getMatriculeetab());
    $_SESSION["classe"] = $codeclasse;
    header("location:../dialog/insert_heure_absence.php");
}

if(isset($_POST["valider_insert_heure"])) {
    $tabEleveAbsence = $_SESSION["listeEleveAbsence"];
    $prof = unserialize($_SESSION["prof"]);
    $sequence=unserialize($_SESSION["sequence"]);
    $codeclasse = $_SESSION["classe"];
    $absence = new Absence();
    for ($i = 0; $i < count($tabEleveAbsence); $i++) {
        $matricule=$_POST["matricule$i"];
        $heure=$_POST["note$i"];
        $jour=0;
        $tabdonneeAbsence = $absence->getDonneeAbsenceEleve($sequence->getNomannee(), $matricule, $sequence->getNumtrim(), $sequence->getMatriculeetab());
        if (count($tabdonneeAbsence)==0) {
            $res = Absence::insertDonneeAbsence($sequence->getNomannee(), $matricule, $sequence->getNumtrim(), $heure, $jour, $sequence->getMatriculeetab());
        }
        else {
            $res = Absence::updateHeureAbsence($sequence->getNomannee(), $matricule, $sequence->getNumtrim(), $sequence->getMatriculeetab(), $heure, $jour);
        }
    }
    $classe = new Classe($codeclasse, $sequence->getNomannee(), $prof->getEtab());
    $_SESSION["listeEleveAbsence"] = $classe->getAllEleveClasseAvecAbsence($codeclasse, $sequence->getNumtrim(), $sequence->getNomannee(), $sequence->getMatriculeetab());
    header("location:../dialog/insert_heure_absence.php?er=1");
}

if(isset($_POST["validerInsertStatPrevue"])){
    $prof = unserialize($_SESSION["prof"]);
    $sequence=unserialize($_SESSION["sequence"]);
    $niveau=$_POST["niveau"];
	$serie=$_POST["serie"];
	$codematiere=$_POST["codematiere"];
    for ($i=1; $i<=3; $i++)
	{
		$leconpt=$_POST["leconpt$i"];
		$leconpp=$_POST["leconpp$i"];
		$heurep=$_POST["heurep$i"];
        $listeClasseNiveau=Classe::getAllClasseNiveau($sequence->getMatriculeetab(), $sequence->getNomannee(), $niveau, $serie);
		for ($k=0; $k<count($listeClasseNiveau); $k++)
		{
			$codeclasse=$listeClasseNiveau[$k];
			$res=StatPrevue::insererDonneeStatPrevue($sequence->getNomannee(),$codeclasse,$codematiere,$i,$leconpt,$leconpp,$heurep,$sequence->getMatriculeetab());
		}
	}
    header("location:../dialog/stat_ap.php?er=1");
}

if(isset($_POST["validerUpdateStatPrevue"])){
    $prof = unserialize($_SESSION["prof"]);
    $sequence=unserialize($_SESSION["sequence"]);
    $niveau=$_POST["niveau"];
	$serie=$_POST["serie"];
	$codematiere=$_POST["codematiere"];
    for ($i=1; $i<=3; $i++)
	{
		$leconpt=$_POST["leconpt$i"];
		$leconpp=$_POST["leconpp$i"];
		$heurep=$_POST["heurep$i"];
        $listeClasseNiveau=Classe::getAllClasseNiveau($sequence->getMatriculeetab(), $sequence->getNomannee(), $niveau, $serie);
        $tabdonnee=array($leconpt, $leconpp, $heurep);
        //print_r($listeClasseNiveau); exit();
		for ($k=0; $k<count($listeClasseNiveau); $k++)
		{
			$codeclasse=$listeClasseNiveau[$k];
			$res=StatPrevue::updateStatprevue($sequence->getNomannee(),$sequence->getMatriculeetab(),$codeclasse,$codematiere,$i,$tabdonnee);
		}
	}
    header("location:../dialog/stat_ap.php?er=1");
}

if(isset($_POST["valider_print_stat"])){
    //pour l'instant
    //header("location:../dialog/imprimer_fiche_stat.php?err=3");
    //a revoir
    $prof = unserialize($_SESSION["prof"]);
    $sequence=unserialize($_SESSION["sequence"]);
    $departement=$_POST["departement"];
    $persoDepartement=Matiere::getProfDepartement($sequence->getMatriculeetab(), $departement);
    $tabniveau=Classe::getAllNiveau($sequence->getMatriculeetab(), $sequence->getNomannee());
    for($i=0; $i<count($tabniveau); $i++){
        $niveau=$tabniveau[$i];
        $tabMatiereNibeau=Matiere::getMatiereDepart($sequence->getMatriculeetab(),$persoDepartement[0], $sequence->getNomannee(), $niveau);
        //print_r($tabMatiereNibeau); exit();
        for ($j=0; $j < count($tabMatiereNibeau); $j++) { 
            $codematiere=$tabMatiereNibeau[$j][1];
            $tabstatprevue=StatPrevue::getStatPrevueNiveau($niveau, $sequence->getNumtrim(),$codematiere, $sequence->getNomannee(), $sequence->getMatriculeetab());
            if(count($tabstatprevue)==0) {
                $tabstatprevue[0]=array($niveau, 0, 0, 0);
            }
            //print_r($tabstatprevue); exit();
            $tabstatfait=Statfait::getStatFaitNiveau($niveau, $sequence->getNumtrim(),$codematiere, $sequence->getNomannee(), $sequence->getMatriculeetab());
            if(count($tabstatfait)==0) {
                $tabstatfait[0]=array($niveau, 0, 0, 0);
            }
            //print_r($tabstatfait); exit();
            //numerodevoir evaluation ?
            $tabnote1=Evaluation::noteNiveau($niveau, $sequence->getNumtrim(), 1, $codematiere, $sequence->getNomannee(), $sequence->getMatriculeetab());
            $tabnote2=Evaluation::noteNiveau($niveau, $sequence->getNumtrim(), 2, $codematiere, $sequence->getNomannee(), $sequence->getMatriculeetab());
            //echo count($tabnote1)."<br>";
            //print_r($tabnote1); exit();
            $tabeleve=Eleve::getEleveNiveau($sequence->getNomannee(), $sequence->getMatriculeetab(), $niveau);
            //print_r($tabeleve); exit();
            $tabmoyenne=array();
            for ($k=0; $k < count($tabeleve); $k++) { 
                $matricule=$tabeleve[$k][0];
                if(isset($tabnote1[$matricule])) {
                    if(isset($tabnote2[$matricule])) {
                        $tabmoyenne[$matricule]=($tabnote1[$matricule]+$tabnote2[$matricule])/2;
                    }
                    else {
                        $tabmoyenne[$matricule]=$tabnote1[$matricule];
                    }
                }
                else {
                    if(isset($tabnote2[$matricule])) {
                        $tabmoyenne[$matricule]=$tabnote2[$matricule];
                    }
                }
            }
            //echo count($tabmoyenne)."<br>";
            //print_r($tabmoyenne); exit();
            //nombre d'élève évalua
            $nbEleveEvalue=count($tabmoyenne);
            //nombre eleve moyenne
            $nbEleveMoyenne=0;
            foreach ($tabmoyenne as $value) {
                if($value>=10) {
                    $nbEleveMoyenne++;
                }
            }

            $donneeStat[$niveau][$codematiere]=array(
                "heure"=>array($tabstatprevue[0][3], $tabstatfait[0][3]),
                "presenciel"=>array($tabstatprevue[0][1], $tabstatfait[0][1]),
                "distanciel"=>array(0, 0),
                "TP"=>array($tabstatprevue[0][2], $tabstatfait[0][2]),
                "eleveR"=>array($nbEleveEvalue, $nbEleveMoyenne)
            );
        }
    }
    //print_r($donneeStat); exit();
    $_SESSION["donneestat"]=$donneeStat;
    $_SESSION["departement"]=$departement;
    header("location:../excel/fiche_statistique.php");
}



