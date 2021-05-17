<?php
include_once('Fonctions/Fonctions.php');


function validerNom($nom)
{
 if(preg_match('/^\w{2,50}$/', $nom))
 {
    return true;
 }
 else {
    echo("<p class=\"erreur__inscription\">Le Nom et Prenom doivent avoir entre 2 et 50 caractères. </p>");
    return false;
 }

}

function validerMotPasse($motPasse, $motPasseConfirme){

    if($motPasse == $motPasseConfirme)
    {
        return true;
    }
    else {
        echo("<p class=\"erreur__inscription\">Le mot de passe ne se confirme pas.. </p>");
        return false;
    }

}

function validerNomUtilisateur($nomUtilisateur)
{

    $connection = ConnectionBD();
    if($nomUtilisateur == "maitre")
    {
        echo("<p class=\"erreur__inscription\">Le Nom d'utilisateur ".$nomUtilisateur ." ne peut pas être utilisé.</p>");
    }
    else {
        //Creation de la requete SELECT
        $requete = mysqli_query($connection, "SELECT * FROM tbl_utilisateurs WHERE Nom_Utilisateur = '$nomUtilisateur' ");
        if(mysqli_num_rows($requete) == 0)
        {
            return true;
        }
        else {
            echo("<p class=\"erreur__inscription\">Le Nom d'utilisateur ".$nomUtilisateur ." a déjà été choisi.</p>");
            return false;
        }
    }
}

function validerEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
      } else {
        echo("<p class=\"erreur__inscription\">Le email ".$email ." n\'est pas valide.</p>");
        return false;
      }

}

function enregistrerUtilisateur($nomUtilisateur, $motPasse, $prenom, $nom, $email, $codeProgramme){

    $connection = ConnectionBD();

    $requete = "INSERT INTO tbl_utilisateurs(Nom_Utilisateur, Mot_Passe, Nom, Prenom, Adresse_Courriel, Code_Programme) 
    VALUES ('{$nomUtilisateur}', '{$motPasse}', '{$nom}', '{$prenom}', '{$email}', '{$codeProgramme}' )";

    if(mysqli_query($connection, $requete))
    {
        return true;
    }
    else {
        echo("<p class=\"erreur__inscription\">Erreur dans l'inserction dans la base de donée.</p>");
        return false;
    }
}

?>