//  *******************************
//  ensemble des évènements
//  *******************************

//index_pass.php


//accueil_prof.php
const bout1 = document.querySelector('#affichetout1');
const bout2 = document.querySelector('#affichetout2');
bout1.addEventListener('click', function () {
    affichetout("#rapnote", "rapport-note", "#affichetout1");
});
bout2.addEventListener('click', function () {
    affichetout("#rapstat", "rapport-stat", "#affichetout2");
});




//  *******************************
//  fonction des évènements
//  *******************************

//accueil_prof.php
function affichetout(x, y, z) {
    const elmt = document.querySelector(x);
    elmt.classList.toggle(y);
    if (elmt.classList.contains(y)) {
        document.querySelector(z).innerHTML = "Voir plus...";
    }
    else {
        document.querySelector(z).innerHTML = "Réduire";
    }

}