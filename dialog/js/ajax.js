/*function actualise(y){
	objetXHR=creationXHR();
	objetXHR.open("get","../control/test.php?prof=ALL2%%LSWEBA0001&matriculeEtab=LSWEBA0001",true);
	//Désignation de la fonction de rappel
	objetXHR.onreadystatechange = traitementResultatAccueil;
	objetXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//envoi de la requête avec paramètre
	objetXHR.send(null);
}
function traitementResultatAccueil()
{
	if (objetXHR.readyState==4) 
	{
		if (objetXHR.status==200) 
		{
			var resultat = objetXHR.responseText;
			alert(resultat);
			//Le résultat peut maintenant être inséré dans la page HTML
		}
		else 
		{
			alert("Erreur HTTP N°"+ objetXHR.status);
		}
	}
	else 
	{
		document.getElementById("mesclasses").innerHTML ='<img src="images/charge1.gif" width="10%" height="5%" />';
	}
}*/

function changelangue(lang, y){
	objetXHR=creationXHR();
	objetXHR.open("post","../control/secondcontrol.php",true);
	//Désignation de la fonction de rappel
	objetXHR.onreadystatechange = traitementResultatchangelangue;
	objetXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//envoi de la requête avec paramètre
	param="langue="+lang+"&action="+y;
	//alert("affiche compétence : "+act+" action : "+y);
	objetXHR.send(param);
}
function traitementResultatchangelangue()
{
	if (objetXHR.readyState==4) 
	{
		if (objetXHR.status==200) 
		{
			//var resultat = objetXHR.responseText;
			//Le résultat peut maintenant être inséré dans la page HTML
			location.href="accueil_prof.php";
		}
		else 
		{
			alert("Erreur HTTP N°"+ objetXHR.status);
		}
	}
	else 
	{
		document.getElementById("mesclasses").innerHTML ='<img src="images/charge1.gif" width="10%" height="5%" />';
	}
}

function get_matiere_prof(x, y) //gestion_notes.php   stat_prof.php
{
	document.getElementById("mescomp").innerHTML="";
	aff=document.forms["formulaire"].elements['action'].value;
	objetXHR=creationXHR();
	objetXHR.open("post","../control/secondcontrol.php",true);
	//Désignation de la fonction de rappel
	objetXHR.onreadystatechange = traitementResultat;
	objetXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//envoi de la requête avec paramètre
	param="classe="+x+"&affichecomp="+aff+"&action="+y;
	//alert("affiche compétence : "+act+" action : "+y);
	objetXHR.send(param);
}
//Déclaration de la fonction de rappel
function traitementResultat()
{
	if (objetXHR.readyState==4) 
	{
		if (objetXHR.status==200) 
		{
			var resultat = objetXHR.responseText;
			//Le résultat peut maintenant être inséré dans la page HTML
			document.getElementById("mesclasses").innerHTML=resultat;
			document.forms["formulaire"].elements['valider_gestion_note'].setAttribute("disabled","disabled");
		}
		else 
		{
			alert("Erreur HTTP N°"+ objetXHR.status);
		}
	}
	else 
	{
		document.getElementById("mesclasses").innerHTML ='<img src="images/charge1.gif" width="10%" height="5%" />';
	}
}

function get_competence(x, w) //gestion_notes.php
{
	objetXHR=creationXHR();
	objetXHR.open("post","../control/secondcontrol.php",true);
	//Désignation de la fonction de rappel
	objetXHR.onreadystatechange = traitementResultat1;
	objetXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//envoi de la requête avec paramètre
	aff=document.forms["formulaire"].elements['action'].value;
	y=document.forms["formulaire"].elements['classe'].options[document.forms["formulaire"].elements['classe'].selectedIndex].value;
	param="classe="+y+"&matiere="+x+"&comp="+aff+"&action="+w;
	objetXHR.send(param);
}
//Déclaration de la fonction de rappel
function traitementResultat1()
{
	if (objetXHR.readyState==4) 
	{
		if (objetXHR.status==200) 
		{
			var resultat = objetXHR.responseText;
			//Le résultat peut maintenant être inséré dans la page HTML
			resultat1=resultat.split("::")[0];
			document.getElementById("mescomp").innerHTML=resultat1;
			//désactivation du bouton ok
			if(resultat.split("::")[1]!="disable"){
				document.forms["formulaire"].elements['valider_gestion_note'].removeAttribute("disabled");
			}
			else{
				document.forms["formulaire"].elements['valider_gestion_note'].setAttribute("disabled","disabled");
			}
		}
		else 
		{
			alert("Erreur HTTP N°"+ objetXHR.status);
		}
	}
	else 
	{
		document.getElementById("mescomp").innerHTML ='<img src="images/charge1.gif" width="10%" height="5%" />';
	}
}

function verif_limite(texte, nmax) //gestion_notes.php
{
	//alert(texte);
	nbc=texte.length;
	if(nbc>nmax)
	{
		texte=texte.substr(0,nmax);
		nbc=texte.length;

	}
	document.getElementById("limit").innerHTML=nbc+"/"+nmax;
	document.forms["formulaire"].elements['competence'].value=texte;
}

function donnefocus() //insert_note_prof.php
{
	document.forms["formulaire"].elements['note'].focus();
	/*document.getElementById("note").addEventListener('focus', function () {
		jsuis.getFocus(true);
	})*/
}

function verif_note_correcte(ch, x, y, z) //insert_note_prof.php, modif_note.php
{
	n=x.length;
	codex=x.charCodeAt(n-1);
	if((codex==47)||(codex==77)||(codex==109)||(codex==46)||((codex>=48)&&(codex<=57))) {
		if((x!="m")&&(x!="M")&&(x!="/")) {
			x=parseFloat(x);
			if((x>=0)&&(x<=20)) {
				//correct
				document.forms["formulaire"].elements[z].removeAttribute("disabled");
				document.getElementById(y).style.display="none";
			}
			else {
				//incorect number
				nv=String(x).substr(0, n-1);
				document.forms["formulaire"].elements[ch].value=nv;
				document.getElementById(y).style.display="block";
				document.forms["formulaire"].elements[z].setAttribute("disabled","disabled");
			}
		}
		else {
			//correct
			document.forms["formulaire"].elements[z].removeAttribute("disabled");
			document.getElementById(y).style.display="none";
		}
	}
	else {
		//incorrect number
		nv=x.substr(0, n-1);
		document.forms["formulaire"].elements[ch].value=nv;
		document.getElementById(y).style.display="block";
		document.forms["formulaire"].elements[z].setAttribute("disabled","disabled");
	}
}

function modifNoteDansInsert(x, y) //insert_note_prof.php 
{
	objetXHR=creationXHR();
	objetXHR.open("post","../control/secondcontrol.php",true);
	//Désignation de la fonction de rappel
	objetXHR.onreadystatechange = traitementmodifNoteDansInsert;
	objetXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	elmat="matricule"+x;
	elnote="note"+x;
	matri=document.forms["formulaire"].elements[elmat].value;
	note=document.forms["formulaire"].elements[elnote].value;
	//classe=document.forms["formulaire"].elements['classe'].options[document.forms["formulaire"].elements['classe'].selectedIndex].value;
	//envoi de la requête avec paramètre
	param="matri="+matri+"&indexe="+x+"&note="+note+"&action="+y;
	objetXHR.send(param);
}

function traitementmodifNoteDansInsert()
{
	if (objetXHR.readyState==4) 
	{
		if (objetXHR.status==200) 
		{
			var resultat = objetXHR.responseText;
			//Le résultat peut maintenant être inséré dans la page HTML
			note=resultat.split("%%")[0];
			if(note!="erreur"){
				ind=resultat.split("%%")[1];
				app=resultat.split("%%")[2];
				elnote="note"+ind;
				if(app!="MALADE") {
					document.forms["formulaire"].elements[elnote].value=note;
				}
				else {
					document.forms["formulaire"].elements[elnote].value="m";
				}
				alert("Effectué / Done");
			}
		}
		else 
		{
			alert("Erreur HTTP N°"+ objetXHR.status);
		}
	}
}

function afficheTableauStat(x, y) //stat_prof.php 
{
	objetXHR=creationXHR();
	objetXHR.open("post","../control/secondcontrol.php",true);
	//Désignation de la fonction de rappel
	objetXHR.onreadystatechange = traitementafficheTableauStat;
	objetXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	classe=document.forms["formulaire"].elements['classe'].options[document.forms["formulaire"].elements['classe'].selectedIndex].value;
	//envoi de la requête avec paramètre
	param="matiere="+x+"&classe="+classe+"&action="+y;
	objetXHR.send(param);
}

function traitementafficheTableauStat()
{
	if (objetXHR.readyState==4) 
	{
		if (objetXHR.status==200) 
		{
			var resultat = objetXHR.responseText;
			//Le résultat peut maintenant être inséré dans la page HTML
			document.getElementById("mescomp").innerHTML=resultat;
		}
		else 
		{
			alert("Erreur HTTP N°"+ objetXHR.status);
		}
	}
}

function verifier_nombre(x, y) //statfait.php
{
	n=x.length;
	codex=x.charCodeAt(n-1);
	if((codex>=48)&&(codex<=57)) {
		document.getElementById("zoneereur").style.display="none";
	}
	else {
		if(codex==46) {
			document.getElementById("zoneereur").style.display="none";
		}
		else{
			//incorrect number
		nv=x.substr(0, n-1);
		document.forms["formulaire"].elements[y].value=nv;
		//document.forms["formulaire"].elements['valider_notes'].setAttribute("disabled","disabled");
		document.getElementById("zoneereur").style.display="block";
		}
	}
}

function verifEmail(x, y, z) {
	 var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
     if(re.test(x)) {
		//adresse valide
		document.forms["formulaire"].elements[y].removeAttribute("disabled");
		document.getElementById(z).style.display="none";
	}
	else{
		document.forms["formulaire"].elements[y].setAttribute("disabled","disabled");
		document.getElementById(z).style.display="block";
	}
}

function pasemailprof(x, y) {
	cse=document.forms["formulaire"].elements[x];
	param=document.forms["formulaire"].elements["param"].value;
	if(cse.checked) {
		if(param==""){
			document.forms["formulaire"].elements[y].removeAttribute("disabled");
		}
		else {
			document.getElementById("zoneretour").style.display="block";
		}
		
	}
	else {
		if(param=="") {
			document.forms["formulaire"].elements[y].setAttribute("disabled","disabled");
		}
		else {
			document.getElementById("zoneretour").style.display="none";
		}
		
	}
}

function modifie_zone() //modif_user  modif_password
{
	c=document.forms["formulaire"].elements["setpass"];
	if (c.checked)
	{
		var zone1 = document.getElementById("zone1");
		var zone2 = document.getElementById("zone2");
		var zone3 = document.getElementById("zone3");
		zone1.setAttribute("type", "text");
		zone2.setAttribute("type", "text");
		zone3.setAttribute("type", "text");
	}
	else
	{
		var zone1 = document.getElementById("zone1");
		var zone2 = document.getElementById("zone2");
		var zone3 = document.getElementById("zone3");
		zone1.setAttribute("type", "password");
		zone2.setAttribute("type", "password");
		zone3.setAttribute("type", "password");
	}
}

function verifier_userpass(x, y, z, w, tt) { //modif_user  modif_password
	ini=document.forms["formulaire"].elements[y].value;
	if(x!=ini) {
		document.getElementById(w).style.display="block";
		document.forms["formulaire"].elements[z].setAttribute("disabled","disabled");
	}
	else {
		document.getElementById(w).style.display="none";
		if(tt=="oui") {
			document.forms["formulaire"].elements[z].removeAttribute("disabled");
		}
	}
}

function verifie_user(x,y,z) { //modif_user  modif_password
	alert(y);
	objetXHR=creationXHR();
	objetXHR.open("post","../control/secondcontrol.php",true);
	//Désignation de la fonction de rappel
	objetXHR.onreadystatechange = traitementverifie_user;
	objetXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//envoi de la requête avec paramètre
	param="user="+x+"&etab="+y+"&action="+z;
	objetXHR.send(param);
}
function traitementverifie_user()
{
	if (objetXHR.readyState==4) 
	{
		if (objetXHR.status==200) 
		{
			var resultat = objetXHR.responseText;
			//Le résultat peut maintenant être inséré dans la page HTML
			if(resultat=="oui") {
				elmt=document.getElementById("zoneresult");
				elmt.classList.remove("cache");
			}
			else {
				elmt=document.getElementById("zoneresult");
				elmt.classList.add("cache");
			}
			//document.getElementById("mescomp").innerHTML=resultat;
		}
		else 
		{
			alert("Erreur HTTP N°"+ objetXHR.status);
		}
	}
}

function supprimeAdmin(x,y) { //Ajouter_admin
	codeprof=document.forms["formulaire"].elements[x].value;
	//alert(codeprof);
	objetXHR=creationXHR();
	objetXHR.open("post","../control/secondcontrol.php",true);
	//Désignation de la fonction de rappel
	objetXHR.onreadystatechange = traitementafficheSuprimeadmin;
	objetXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//envoi de la requête avec paramètre
	param="codeprof="+codeprof+"&action="+y;
	objetXHR.send(param);
}
function traitementafficheSuprimeadmin()
{
	if (objetXHR.readyState==4) 
	{
		if (objetXHR.status==200) 
		{
			var resultat = objetXHR.responseText;
			//Le résultat peut maintenant être inséré dans la page HTML
			//document.getElementById("mescomp").innerHTML=resultat;
			location.href="ajouter_admin.php";
		}
		else 
		{
			alert("Erreur HTTP N°"+ objetXHR.status);
		}
	}
}

function afichezonerecap(x, y, act, inact){
	document.getElementById(x).style.display="block";
	document.getElementById(y).style.display="none";
	document.getElementById(act).classList.remove("inactive");
	document.getElementById(inact).classList.add("inactive");
	document.getElementById("idZonePdf").innerText=x;
}

function gestionValidationAbsence(x, y){
	if(x==""){
		document.getElementById(y).setAttribute("disabled", "disabled");
	}
	else{
		document.getElementById(y).removeAttribute("disabled");
	}
}

function verif_heure_correcte(ch, x, y, z) //insert_note_prof.php, modif_note.php
{
	n=x.length;
	codex=x.charCodeAt(n-1);
	if((codex>=48)&&(codex<=57)) {
		//correct
		document.forms["formulaire"].elements[z].removeAttribute("disabled");
		document.getElementById(y).style.display="none";
	}
	else {
		//incorrect number
		nv=x.substr(0, n-1);
		document.forms["formulaire"].elements[ch].value=nv;
		document.getElementById(y).style.display="block";
		document.forms["formulaire"].elements[z].setAttribute("disabled","disabled");
	}
}

function get_info_user(x) { //user agent
	objetXHR=creationXHR();
	objetXHR.open("post","control/user_agent.php",true);
	//Désignation de la fonction de rappel
	objetXHR.onreadystatechange = traitementResultatinfouser;
	objetXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//envoi de la requête avec paramètre
	param="action="+x;
	objetXHR.send(param);
}
function traitementResultatinfouser()
{
	if (objetXHR.readyState==4) 
	{
		if (objetXHR.status==200) 
		{
			var resultat = objetXHR.responseText;
			//Le résultat peut maintenant être inséré dans la page HTML
			console.log(resultat);
		}
		else 
		{
			alert("Erreur HTTP N°"+ objetXHR.status);
		}
	}
	else 
	{
		;
	}
}

function get_serie_server(x, z) //stap_ap.php
{
	objetXHR=creationXHR();
	objetXHR.open("post","../control/secondcontrol.php",true);
	//Désignation de la fonction de rappel
	objetXHR.onreadystatechange = traitementResultatallserie;
	objetXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//envoi de la requête avec paramètre
	param="niveau="+x+"&action="+z;
	objetXHR.send(param);
}
//Déclaration de la fonction de rappel
function traitementResultatallserie()
{
	if (objetXHR.readyState==4) 
	{
		if (objetXHR.status==200) 
		{
			var resultat = objetXHR.responseText;
			//Le résultat peut maintenant être inséré dans la page HTML
			document.getElementById("mesclasses").innerHTML=resultat;
			document.getElementById("zonemat").innerHTML='&nbsp;';
			document.getElementById("zonestat").innerHTML='&nbsp;';
		}
		else 
		{
			alert("Erreur HTTP N°"+ objetXHR.status);
		}
	}
	else 
	{
		document.getElementById("mesclasses").innerHTML ='<img src="images/charge1.gif" width="10%" height="5%" />';
	}
}

function get_matiere_server(x, z)
{
	objetXHR=creationXHR();
	objetXHR.open("post","../control/secondcontrol.php",true);
	//Désignation de la fonction de rappel
	objetXHR.onreadystatechange = traitementResultatmatieredepart;
	objetXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//envoi de la requête avec paramètre
	y=document.getElementById("niveau").value;
	param="niveau="+y+"&serie="+x+"&action="+z;
	objetXHR.send(param);
}
//Déclaration de la fonction de rappel
function traitementResultatmatieredepart()
{
	if (objetXHR.readyState==4) 
	{
		if (objetXHR.status==200) 
		{
			var resultat = objetXHR.responseText;
			//Le résultat peut maintenant être inséré dans la page HTML
			document.getElementById("zonemat").innerHTML=resultat;
			document.getElementById("zonestat").innerHTML='&nbsp;';
		}
		else 
		{
			alert("Erreur HTTP N°"+ objetXHR.status);
		}
	}
	else 
	{
		document.getElementById("zonemat").innerHTML ='<img src="images/charge1.gif" width="10%" height="5%" />';
	}
}

function get_stat(x, z)
{
	objetXHR=creationXHR();
	objetXHR.open("post","../control/secondcontrol.php",true);
	//Désignation de la fonction de rappel
	objetXHR.onreadystatechange = traitementResultatdonneestat;
	objetXHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//envoi de la requête avec paramètre
	w=document.getElementById("niveau").value;
	y=document.getElementById("serie").value;
	param="niveau="+w+"&serie="+y+"&matiere="+x+"&action="+z;
	objetXHR.send(param);
}
//Déclaration de la fonction de rappel
function traitementResultatdonneestat()
{
	if (objetXHR.readyState==4) 
	{
		if (objetXHR.status==200) 
		{
			var resultat = objetXHR.responseText;
			//Le résultat peut maintenant être inséré dans la page HTML
			document.getElementById("zonestat").innerHTML=resultat;
		}
		else 
		{
			alert("Erreur HTTP N°"+ objetXHR.status);
		}
	}
	else 
	{
		document.getElementById("zonestat").innerHTML ='<img src="images/charge1.gif" width="10%" height="5%" />';
	}
}

