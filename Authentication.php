<?php
require('Fonctions/Fonctions.php');
creer_entete_html('Authentification');
entete_page();

$nomUtilisateur = trim($_POST['txtUtilisateur']);
$motPasse = trim($_POST['txtMotPasse']);
$page_precedente = $_SESSION['page'];

$message = authentification($nomUtilisateur, $motPasse);
if($message == "Reussi")
{
    echo("teste");
    echo("$nomUtilisateur");
   echo("$page_precedente");
   header("location: $page_precedente.php");
}
else if($message == "professeur")
{
    //Si le maitre est auhtentifié on associe les valeurs de session vide et le redirige vers la fenetre principale
    
    $_SESSION['nomUtilisateur'] = "Maitre";
    $_SESSION['nom'] = "x";
    $_SESSION['prenom'] = "Professor";
    $_SESSION['adresseCourriel'] = "";
    $_SESSION['codeProgramme'] = "";

   header("location: FenetrePrincipale.php");
}
else
{
    echo("<p>Un problème est survenu lors de votre tentative d'authentification sur notre site.</p>");
    echo("<p>$message</p>");
    echo("<p>Réessayez plus tard.</p>");
    echo("<p>Cliquez <a href=\"$page_precedente.php\">ici</a> pour continuer votre visite sur notre site.</p>");
}


creer_pied_html();

?>