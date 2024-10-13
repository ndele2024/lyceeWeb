<?php 
use model\Teacher;
use model\School;

header("Content-Type: text/plain");
header('Access-Control-Allow-Origin: http://localhost:3000');

include_once '../model/Teacher.php';
include_once '../model/School.php';

$codeperso=$_GET["prof"];
$matriculeEtab = $_GET["matriculeEtab"];
$etab = new School($matriculeEtab);

$tabDoneeProf = Teacher::getTeacherByCode1($codeperso, $etab);
echo json_encode($tabDoneeProf);
