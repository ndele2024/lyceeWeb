// console.log('appel fonction cherche langue');
    var Userlang={}
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //var langue =xmlhttp.responseText;
             Userlang.langue=xmlhttp.responseText
        }
    };
    xmlhttp.open("post", "../get_langue_javas.php", true);
    xmlhttp.send();


