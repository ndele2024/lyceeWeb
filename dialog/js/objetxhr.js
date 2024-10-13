function creationXHR() 
{
var result=null;
try {//test pour les navigateurs : Mozilla, Opera...
result= new XMLHttpRequest();
}
catch (Error) {
try {//test pour les navigateurs Internet Explorer > 5.0
result= new ActiveXObject("Msxml2.XMLHTTP");
}
catch (Error) {
try {//test pour le navigateur Internet Explorer 5.0
result= new ActiveXObject("Microsoft.XMLHTTP");
}
catch (Error) {
result= null;
}
}
}
return result;
}