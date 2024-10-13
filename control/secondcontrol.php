<?php
use model\Evaluation;
use model\Statfait;
use model\StatPrevue;
use model\Classe;
use model\Matiere;
use model\Teacher;

header("Content-Type: text/html");
session_start();
include_once '../model/Teacher.php';
include_once '../model/School.php';
include_once '../model/Sequences.php';
include_once '../model/Evaluation.php';
include_once '../model/Statfait.php';
include_once '../model/StatPrevue.php';

$prof= unserialize($_SESSION["prof"]);
$sequence=unserialize($_SESSION["sequence"]);

if($prof->getLangue()=="F") {
    $text=file_get_contents("../dialog/contenu/prof1_francais.txt");
    $cont=explode("-", "$text");
    $text1=file_get_contents("../dialog/contenu/prof2_francais.txt");
    $cont=explode("-", "$text");
    $cont1=explode("-", "$text1");
}
else {
    $text=file_get_contents("../dialog/contenu/prof1_anglais.txt");
    $cont=explode("-", "$text"); 
    $text1=file_get_contents("../dialog/contenu/prof2_anglais.txt");
    $cont1=explode("-", "$text1"); 
}

$action=$_REQUEST["action"];
switch ($action) {
    case "gestion_notes":
        $affichecomp=$_REQUEST["affichecomp"];
        $classe=$_REQUEST["classe"];
        if (empty($classe)) {
            echo"";
        }
        else {
            if($affichecomp==1) {
                echo "<div class='col-sm-6'>
                        <label for='matiere'>$cont[14]</label>
                      </div>
                      <div class='col-sm-6 d-flex align-items-center'>
                        <select name=\"codematiere\" class='form-select' id=\"matiere\" onchange=\"get_competence(this.value, 'gestion_comp')\" required><option value='' id=''>--Select--</option>";
            }
            elseif ($affichecomp==5) {
                echo "<div class='labinput col-md-6'>
                        <label for='matiere' class='form-label'>$cont[14]</label>
                      </div>
                      <div class='col-md-6'>
    		            <select name=\"codematiere\" class='form-select' id=\"matiere\" onchange=\"afficheTableauStat(this.value, 'statfait')\" required><option value='' id=''>--Select--</option>";
            }
            else {
                echo "<div class='col-sm-6'>
                        <label for='matiere'>$cont[14]</label>
                      </div>
                      <div class='col-sm-6 d-flex align-items-center'>
    		            <select name=\"codematiere\" class='form-select' id=\"matiere\" onchange=\"get_competence(this.value, 'gestion_comp')\" required><option value='' id=''>--Select--</option>";
            }
            
            $tabmatiere=$prof->getMatiereProf($classe, $sequence->getNomannee());
            for ($i = 0; $i < count($tabmatiere); $i++) {
                $codemat=$tabmatiere[$i][0];
                $nommat=$tabmatiere[$i][1];
                echo "<option value='$codemat' id=\"matiere$i\"> $nommat </option>";
            }
            echo "</select></div>";
        }
        break;
        
    case "gestion_comp" :
        $affichecomp=$_REQUEST["comp"];
        $classe=$_REQUEST["classe"];
        $matiere=$_REQUEST["matiere"];
        if (empty($matiere)) {
            echo "::disable";
        }
        else {
            if($prof->getLangue()=="F") {
                $te1="INTITULE DE LA COMPETENCE DU TRIMESTRE";
                $te2="Vous êtes sur le point d'entrer les notes du premier devoir du trimestre";
                $te3="Vous êtes sur le point d'entrer les notes du deuxième devoir du trimestre";
                $te4="Vous êtes sur le point d'entrer les notes du troisième devoir du trimestre";
                $te5="Vous avez déja entré les notes des devoirs prévus pour ce trimestre. vous pouvez uniquement modifier les notes";
                $te6="Vous n'avez pas encore entré de notes de cette matiere dans cette classe";
                $te7="SELECTIONNER LE DEVOIR";
                $te8="Devoir";
                $te9="Vous n'avez pas encore entré les notes du dexième devoir";
                $te10="Vous n'avez pas encore entré les statistiques de cette matières. Entrez d'abors les statistiques avant les notes";
            }
            else {
                $te1="Title of the quarter's skill";
                $te2="You are going to enter the marks of the first evaluation of term";
                $te3="You are going to enter the marks of the second evaluation of term";
                $te4="You are going to enter the marks of the third evaluation of term";
                $te5="You have already entered the homework marks for this quarter. you can only edit the marks";
                $te6="You have not enter the marks of this subject in this class";
                $te7="SELECT EVALUATION";
                $te8="Evaluation";
                $te9="You have not enter the marks of second evaluation";
                $te10="You hve not yet entered statistics of this subject. You have to Enter statistics before mark";
            }
            //compétence et nombre notes
            $eval = new Evaluation();
            $tabcomp = $eval->getDonneeCompetence($matiere, $prof->getCodeTeacher(), $classe, $sequence->getNumtrim(), $sequence->getNomannee(), $prof->getEtab()->getMatriculeetab());
            $nnr=count($tabcomp);
            if($nnr==0)
            {
                $comp="";
                $nbnote=0;
            }
            else
            {
                $comp=utf8_decode($tabcomp[0]);
                $nbnote=$tabcomp[1];
            }
            if($affichecomp==1) {
                //********************************
                //verification des stat after notes
                //*********************************
                
                if($sequence->getStatafternote()=="oui"){
                    //verif si stat déja entré 
                    $stat = new Statfait();
                    if((count($stat->getStatfait($classe, $sequence->getNumtrim(), $matiere, $sequence->getNomannee(), $prof->getEtab()->getMatriculeetab()))==0)AND($nbnote==1)) {
                        echo"<div class='rouge'>$te10</div>::disable"; 
                        exit();
                    }
                }
                
                $nbdevoir = 2;
                $nbcarmax = 135;
                $nbcar=strlen($comp);  
                
                echo "<div class='row'>
                        <div class='col-sm-12'>
                            <label for='competence'>$te1</label>
                        </div>
                      </div>
                      <div class='row mb-3'>
                        <div class='col-sm-12'>
                        <textarea name='competence' class='form-textarea' id='competence' cols='30'
                            rows='3' onkeyup='verif_limite(this.value,$nbcarmax)'>$comp</textarea>
                        <label id='limit'>$nbcar/$nbcarmax</label>
                        </div>
                      </div>";
                if($nbnote<$nbdevoir)
                {
                    switch ($nbnote)
                    {
                        case 0:
                            echo"<center><big>$te2</big></center>";
                            break;
                        case 1:
                            echo"<center><big>$te3</big></center>";
                            break;
                        case 2:
                            echo"<center><big>$te4</big></center>";
                            break;
                        default:
                            echo"<center><big>Vous ne pouvez pas entrer plus de 3 devoirs pour l'instant</big></center>::disable";
                            break;
                    }
                    
                }
                else
                {
                    echo"<div class='rouge'>$te5</div>::disable";
                }
            }
            else {
                if($nbnote==0)
                {
                    echo"<div class='rouge'>$te6</div>::disable";
                }
                else {                  
                    if(!isset($_REQUEST["pasdevoir"])) {
                        echo "<div class='row mt-3'>
                                <div class='col-sm-6'>
                                    <label for='devoir'>$te7</label>
                                </div>";
                        echo "<div class='col-sm-6 d-flex align-items-center'><select name='devoir' class='form-select' aria-label='selectionner le devoir' required><option value=''>Select</option>";
                        for($i=1; $i<=$nbnote; $i++) {
                            echo"<option value='$i'>$te8 $i</option>";
                        }
                        echo"</select></div></div>";
                    }
                    else {
                        if($nbnote<2) {
                            echo"<div class='rouge'>$te9</div>";
                        }
                    }
                } 
            }
        }
        //echo "$classe $matiere $affichecomp";
        
        break;
        
    case "statfait":
        $matiere=$_REQUEST["matiere"];
        $classe=$_REQUEST["classe"];
        $seq=$sequence->getNumtrim();
        if (empty($matiere)) {
            echo"";
        }
        else {
            $statPrevue = new StatPrevue();
            $tabstatprevue = $statPrevue->getStatPrevue($classe, $sequence->getNumtrim(), $matiere, $sequence->getNomannee(), $prof->getEtab()->getMatriculeetab());
            if(empty($tabstatprevue)) {
                $r="disabled"; 
                $t="$cont1[11]";
                $ltp="";
                $lpp="";
                $hp="";
            }
            else {
                $r="";
                $t="";
                $ltp=$tabstatprevue['leconpt'];
                $lpp=$tabstatprevue['leconpp'];
                $hp=$tabstatprevue['heurep'];
            }
            $statfait = new Statfait();
            $tabstatfait = $statfait->getStatfait($classe, $sequence->getNumtrim(), $matiere, $sequence->getNomannee(), $prof->getEtab()->getMatriculeetab());
            if(empty($tabstatfait)) {
                $ltf="";
                $lpf="";
                $hf="";
                $nha="";
            }
            else {
                //print_r($tabstatfait);
                $ltf=$tabstatfait["lecontheof"];
                $lpf=$tabstatfait["leconpraf"];
                $hf=$tabstatfait["heuref"];
                $nha=$tabstatfait["nhad"];
            }
            echo "
             <div class='container donneeprevision text-center text-danger'>
                            <div class='titre text-decoration-underline'>$cont1[12] $seq :</div>
                            <div class='row'>
                                <div class='col-sm-4'>$cont1[13] : $ltp </div>
                                <div class='col-sm-4'>$cont1[14] : $lpp</div>
                                <div class='col-sm-4'>$cont1[15] : $hp</div>
                            </div>
                        </div>
                        <hr />
        	
                <div class='container insertstat mb-4 p-0'>
                            <div class='titre mb-3 bg-light text-center'>
                                $cont1[16]
                            </div>
                            <div class='mt-2 rouge'>$t</div>
                            <div class='row text-center'>
                                <div class='col-lg-6 col-md-6'>
                                    <input type='tel' name='lecontf' id='lecontf' value='$ltf'
                                        class='form-control-sm form-text'
                                        aria-label='$cont1[17]' placeholder='$cont1[17]' maxlength='4'
                                        onkeyup='verifier_nombre(this.value, this.id)' $r required>
                                </div>
                                <div class='col-lg-6 col-md-6'>
                                    <input type='tel' name='leconpf' id='leconpf' value='$lpf'
                                        class='form-control-sm form-text'
                                        aria-label='$cont1[18]' placeholder='$cont1[18]' maxlength='4'
                                        onkeyup='verifier_nombre(this.value, this.id)' $r required>
                                </div>
                                <div class='col-lg-6 col-md-6'>
                                    <input type='tel' name='heuref' id='heuref' value='$hf'
                                        class='form-control-sm form-text'
                                        aria-label='$cont1[19]' placeholder='$cont1[19]' maxlength='4' 
                                        onkeyup='verifier_nombre(this.value, this.id)' $r required>
                                </div>
                                <div class='col-lg-6 col-md-6'>
                                    <input type='tel' name='nhad' id='nhad' value='$nha'
                                        class='form-control-sm form-text' 
                                        aria-label='$cont1[20]' placeholder='$cont1[20]'
                                        maxlength='4' onkeyup='verifier_nombre(this.value, this.id)' $r>
                                </div>
                            </div>
                            <span  id='zoneereur' class='rouge' style='display:none;'>Saisir un nombre / type a number</span><br>
                            <div class='row'>
                            <div class='buttondatelimite col-md-12'>
                                <button type='submit' name='valider_statfait' class='btn btn-success d-block w-50 m-auto'>Ok</button>
                            </div>
                        </div>
                        </div>
	       ";
        }
        
        break;
    case "modifnoteDansInsert":
        $matiere=$_SESSION["codematiere"];
        $codeclasse=$_SESSION["classe"];
        $numerodevoir=$_SESSION['nbnote'];
        $tabEleveAvecNote=$_SESSION["deuxderniereleve"];
        $matricule=$_REQUEST["matri"];
        $note=$_REQUEST["note"];
        $indexe=$_REQUEST["indexe"];
        $classe = new Classe($codeclasse, $sequence->getNomannee(), $prof->getEtab());
        if(($note=="m")||($note=="M")) {
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
        if(Evaluation::updateDonneeEvaluation($note, $appreciation, $sequence->getNomannee(), $matricule, $matiere, $sequence->getNumtrim(), $numerodevoir, $prof->getEtab()->getMatriculeetab())) {
            $tabEleveAvecNote[$indexe][7]=$note;
            $_SESSION["deuxderniereleve"]=$tabEleveAvecNote;
            echo "$note%%$indexe%%$appreciation";
        }
        else {
            echo "Erreur";
        }
        
        break;
    case "langue":
        $lang=$_REQUEST["langue"];
        $prof->setLangue($lang);
        $_SESSION["prof"]=serialize($prof);
        break;
        
    case "suppAdmin":
        $codeprof=$_REQUEST["codeprof"];
        $profad= new Teacher($codeprof, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $prof->getEtab());
        $profad->setSauvegarder_base("non");
        //print_r($profad); exit();
        echo "ok";
        break;
    
    case "userAgent":
        echo $_SERVER ['HTTP_USER_AGENT'];
        break;
        
    case "verifieUserUnique":
        $username=$_REQUEST["user"];
        $matriculeEtab=$_REQUEST["etab"];
        if (Teacher::isNotUniqueUser($username, $matriculeEtab)) {
            echo "oui";
        }
        else {
            echo "non";
        }
        ;
        break;
    
    case "allserie":
        $niveau=$_REQUEST["niveau"];
        if(empty($niveau)){
            echo""; exit();
        }
        $listeSerie=Classe::getAllSerie($prof->getEtab()->getMatriculeetab(), $sequence->getNomannee(), $niveau);
        if (count($listeSerie)!=0) {
            echo "<div class='col-sm-6'>$cont1[27] </div>
            <div class='col-sm-6 d-flex align-items-center'>
            <select name=\"serie\" id=\"serie\" class='form-select'
            aria-label='selectionner la serie' onchange=\"get_matiere_server(this.value, 'matiereDepart')\">
            <option value=''>--$cont1[3]--</option>";
            for ($i=1; $i<=count($listeSerie); $i++)
            {
                $pp=$i-1; 
                echo "<option value=\"$listeSerie[$pp]\" id=\"matiere$i\"> $listeSerie[$pp] </option>";
            }
            echo "<option value='tout'>$cont1[28]</option></select></div>";
        }
        else {
            echo"<input type='hidden' name='serie' id='serie' value=''>";
            $listeMatiere=Matiere::getMatiereDepart($prof->getEtab()->getMatriculeetab(), $prof->getCodeTeacher(), $sequence->getNomannee(), $niveau);
            echo "<div class='col-sm-6'>$cont1[29] </div>
            <div class='col-sm-6 d-flex align-items-center'>
			<select name=\"codematiere\" id=\"matiere\" class='form-select'
            aria-label='selectionner la matiere' onchange=\"get_stat(this.value, 'donneeStatPrevue')\">
			<option value=''>--$cont1[3]--</option>";
            for ($i=0; $i<count($listeMatiere); $i++)
                {
                    $codemat=$listeMatiere[$i][1];
                    $nommat=$listeMatiere[$i][2];
                    echo "<option value=\"$codemat\" id=\"matiere$i\"> $nommat </option>";
                }
            echo "</select></div>";
        }
        break;

    case "matiereDepart":
        $niveau=$_REQUEST["niveau"];
        $serie=$_REQUEST["serie"];
        if (empty($serie)) {
            echo""; exit();
        }
        if($serie=="tout"){
            $listeMatiere=Matiere::getMatiereDepart($prof->getEtab()->getMatriculeetab(), $prof->getCodeTeacher(), $sequence->getNomannee(), $niveau);
        } 
        else {
            $listeMatiere=Matiere::getMatiereDepartSerie($prof->getEtab()->getMatriculeetab(), $prof->getCodeTeacher(), $sequence->getNomannee(), $niveau, $serie);
        }
            echo "<div class='col-sm-6'>$cont1[29] </div>
            <div class='col-sm-6 d-flex align-items-center'>
			<select name=\"codematiere\" id=\"matiere\" class='form-select'
            aria-label='selectionner la matiere' onchange=\"get_stat(this.value, 'donneeStatPrevue')\">
			<option value=''>--$cont1[3]--</option>";
            for ($i=0; $i<count($listeMatiere); $i++)
                {
                    $codemat=$listeMatiere[$i][1];
                    $nommat=$listeMatiere[$i][2];
                    echo "<option value=\"$codemat\" id=\"matiere$i\"> $nommat </option>";
                }
            echo "</select></div>";
        break;

    case "donneeStatPrevue":
        $niveau=$_REQUEST["niveau"];
        $serie=$_REQUEST["serie"];
        $matiere=$_REQUEST["matiere"];
        $donneeStatPrevue = StatPrevue::getStatPrevueannee($niveau, $serie, $matiere, $sequence->getNomannee(), $prof->getEtab()->getMatriculeetab());
        if (count($donneeStatPrevue)==0){
            $donneeStatPrevue=array(array("","",""),array("","",""),array("","",""));
            $nameButton="validerInsertStatPrevue";
        }
        else {
            $nameButton="validerUpdateStatPrevue";
        }
        
        echo "
        <div class='col-12'>
        <div class='bg-light m-2'>$cont1[30]</div>
        <table border='1' bgcolor='lightgreen' class='' align='center'>
        <thead>
            <tr align='center'>
            <td>Trim. </td> <td> $cont1[32]</td> <td> $cont1[33]</td> <td> $cont1[34] </td>
        </tr></thead><tbody>";
        for ($i=1; $i<=3; $i++)
        {
            echo"<tr>
                <td> 
                    $i <input type='hidden' name='seq$i' value='$i'>
                </td>
                <td> 
                    <input type='tel' name='leconpt$i' value='";
                    if (empty($_POST["leconpt$i"])) {echo $donneeStatPrevue[$i-1][0];} else {echo $_POST["leconpt$i"];}
                    echo"' onkeyup='verif_heure_correcte(\"leconpt$i\", this.value, \"zoneereur1$i\", \"$nameButton\")' maxlength='3' class='form-control form-text' required>
                    <div id='zoneereur1$i class='rouge' style='display:none'>Incorrect number </div>
                </td>
                <td> 
                    <input type='tel' name='leconpp$i' value='";
                    if (empty($_POST["leconpp$i"])) {echo $donneeStatPrevue[$i-1][1];} else {echo $_POST["leconpp$i"];}
                    echo"' onkeyup='verif_heure_correcte(\"leconpp$i\", this.value, \"zoneereur2$i\", \"$nameButton\")' maxlength='3' class='form-control form-text' required>
                    <div id='zoneereur2$i class='rouge' style='display:none'>Incorrect number </div>
                </td>
                <td> 
                    <input type='tel' name='heurep$i' value='";
                    if (empty($_POST["heurep$i"])) {echo $donneeStatPrevue[$i-1][2];} else {echo $_POST["heurep$i"];}
                    echo"' onkeyup='verif_heure_correcte(\"heurep$i\", this.value, \"zoneereur3$i\", \"$nameButton\")' maxlength='3' class='form-control form-text' required>
                    <div id='zoneereur3$i class='rouge' style='display:none'>Incorrect number </div>
                </td>
            </tr>";
            
        }
        echo "</tbody></table>
            <div align='center' class='mt-3'>
            <button class='btn btn-success d-block w-100' type='submit' name='$nameButton'> OK </button>
            </div>
            </div>";
        
        
        //print_r($donneeStatPrevue);
        break;
    
    case "":
        ;
        break;    
    default:
        ;
    break;
}



