<?php
include_once('Fonctions/Fonctions.php');
creer_entete_html('Programmes');
isset($_SESSION['nomUtilisateur'])?entete_page(true):entete_page();


$tableCoursParProgramme = recupererCoursParProgramme();


listeCoursParProgramme($tableCoursParProgramme);


?>