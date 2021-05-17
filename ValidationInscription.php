<?php
include_once('Fonctions/Fonctions.php');
include_once('Fonctions/InscriptionFonctions.php');
creer_entete_html('Inscription');
isset($_SESSION['nomUtilisateur'])?entete_page(true):entete_page();
?>

<main>
    <div class="inscription__succes">
        <p>La compte a été crée avec succès</p>
        <p><a href="Index.php">Cliquez  ici</a> pour retourner à la page d'acceuil.</p>
    </div>
</main>

<?php session_destroy(); ?>