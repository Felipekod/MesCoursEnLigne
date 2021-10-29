<?php
include_once('Fonctions/Fonctions.php');
creer_entete_html('EnregistrementCours');
isset($_SESSION['nomUtilisateur'])?entete_page(true):entete_page();

$mailEtudiant = $_SESSION['adresseCourriel'];
$nomEtudiant = $_SESSION['prenom'];
$idEtudiant = $_SESSION['idUtilisateur'];
$coursChoisi = $_GET['coursChoisi'];
$titreCours = $_GET['titreCours'];

$confirmation = false;

$formEnvoye;

//On verifie si l'etudiant est deja inscrit
$peutSInscrire = verifierCoursChoisi($idEtudiant, $coursChoisi);

//Si le formilaire a ete evoyé
isset($_POST['id'])?$formEnvoye = true:$formEnvoye = false;

if($formEnvoye)
{
    if(inscriptionCours($idEtudiant, $coursChoisi))
    {
        $confirmation = true;
        confirmationEmail($nomEtudiant, $mailEtudiant, $titreCours );
    }
    else {
        echo("<p class=\"erreur__inscription\">Erreur dans l'inserction dans la base de donée.</p>");
    }
}
?>
<main>

<?php if(!$peutSInscrire) : ?>
    <h2>Vous etes deja inscrit dans ce cours</h2>
    <?php elseif($confirmation) : ?>
    <h2>Inscription faite</h2>
    <?php else: ?>
        <form class="inscription" method="post" action="#">
            <input type="hidden" value="<?=$idEtudiant?>" name="id" >
            <input type="hidden" value="<?=$coursChoisi?>" name="coursChoisi" >
            <h1 class="cours__choisi">Cours choisi: <?=$titreCours?></h1>
            <h2 class="cours__choisi"><?=$coursChoisi?></h2>
            <label class="frais">Une frais d'inscripton de $100 est exigé </label>
            <label for="nomCarteCredit">Nom inscrit sur la carte de crédit:<input type="text" id="nomCarteCredit" 
            name="txNomCarteCredit" class="input" required placeholder="Voulez saisir le nom inscrit sur la carte"></label>

            <label for="numeroCarteCredit">Numero de la carte de crédit:<input type="text" id="numeroCarteCredit" 
            name="txNumeroCarteCredit" class="input" required placeholder="Voulez saisir le numero de la carte"></label>
            <input type="submit" value="Envoyer formulaire" class="envoyer">
        </form>
    <?php endif; ?>

</main>
