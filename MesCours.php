<?php
include_once('Fonctions/Fonctions.php');
creer_entete_html('MesCours');
isset($_SESSION['nomUtilisateur'])?entete_page(true):entete_page();

$tableCoursParProgramme = recupererCoursParProgramme();

$codeProgrammeUtilisateur = $_SESSION['codeProgramme'];


$tableCodeCoursNote = recupererCodeCoursNote();

// print_r2($tableCodeCoursNote);
?>

<main>

    <?php returneListeCoursInscrit($tableCoursParProgramme, $tableCodeCoursNote); ?>
</main>
<footer>
</footer>