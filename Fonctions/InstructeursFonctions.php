<?php
include_once('Fonctions/Fonctions.php');

function arrayCoursParProgramme($codeProgramme){
    $connection = ConnectionBD();
    if(! $connection)
    {
        $message = "Impossible de se connecter à la base de donnée.";
    }
    else 
    {
        //creation de la requete select
        $requete = "SELECT A.Code_Programme, A.Titre_Programme, C.Code_Cours,C.Titre_Cours, C.Description_Cours, C.Duree_Cours
        FROM tblprogrammes AS A
        INNER JOIN tblcours_programme AS B
        ON A.Code_Programme = B.Code_Programme
        INNER JOIN tblcours AS C
        ON C.Code_Cours = B.Code_Cours
        WHERE A.Code_Programme = '$codeProgramme '";

        $query = mysqli_query($connection, $requete);
        if(mysqli_num_rows($query) != 0)
        {
            $arrayCoursParProgramme = mysqli_fetch_all($query);
            return $arrayCoursParProgramme;
        }
        else
        {
           $message = "Impossible de trouver des programmes dans la base de données.";
           return $message;
        }

        $ok = mysqli_close($connection);
    }
}

function creerTableCoursInstructeurs($arrayCoursParProgramme){


    $totalCours = count($arrayCoursParProgramme);

    ?> <table class="instructeurs__table"> 
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Durée</th>
                <th>Description</th>
                <th>   </th>
                <th>  </th>
            </tr>  <?php

    for ($i=0; $i < $totalCours ; $i++) { 

            $codeCours = $arrayCoursParProgramme[$i][2];
            $nomCours = $arrayCoursParProgramme[$i][3];
            $description = $arrayCoursParProgramme[$i][4];
            $dureeCours = $arrayCoursParProgramme[$i][5];

        ?> 
            <tr>
                <td><?=$codeCours ?></td>
                <td><?=$nomCours ?></td>
                <td><?=$dureeCours ?></td>
                <td><?=nl2br($description)?></td>
                <td><a href="Instructeurs.php?codeCours=<?=$codeCours?>&Action=Modifier">Modifier</a></td>
                <td><a href="Instructeurs.php?codeCours=<?=$codeCours?>&Action=Supprimer">Supprimer</a></td>
            </tr>
            <?php
    }

    ?> </table> <?php
    
}

function updateCours($codeCours, $nomCours, $descriptionCours, $dureeCours)
{
    $connection = ConnectionBD();
    if(!$connection)
    {
        $message = "Impossible de se connecter à la base de donnée.";
    }
    else{
        
        $requette = "UPDATE tblcours
                    SET Titre_Cours = '$nomCours', Duree_Cours = $dureeCours, Description_Cours = '$descriptionCours'
                    WHERE Code_Cours = '$codeCours' ";

        mysqli_query($connection, $requette);

    }

}

function definirNouveauCodeCours($arrayCoursParProgramme){

    $totalRows = count($arrayCoursParProgramme) ;
    
    //On choisi le chifre le plus grand et on ajoute 1
    for ($i=0; $i < $totalRows; $i++) { 
        $premierNumero = intval(substr($arrayCoursParProgramme[$i][2], -3, 3));
        $prochainNumero = isset($arrayCoursParProgramme[$i + 1][2])? intval(substr($arrayCoursParProgramme[$i + 1][2], -3, 3)) : false;

        if($prochainNumero != false)
        {
            if($premierNumero < $prochainNumero)
            {
                $premierNumero = $prochainNumero;
            }
        }
        else {
            $premierNumero += 1;

            //On defini le code du cours à ajouter
            $nvNumero = str_pad((string)$premierNumero, 3, "0", STR_PAD_LEFT);
            $codeNouveauCours = substr($arrayCoursParProgramme[0][2], -5, 2) . $nvNumero;

            return $codeNouveauCours;
        }
    }
    
}

function ajouterCours($codeCours, $nomCours, $descriptionCours, $dureeCours, $codeProgramme)
{
    $connection = ConnectionBD();
    if(!$connection)
    {
        $message = "Impossible de se connecter à la base de donnée.";
    }
    else{
        
        $requette = "INSERT INTO tblcours(Code_Cours, Titre_Cours, Duree_Cours, Description_Cours)
                     VALUES('$codeCours', '$nomCours', $dureeCours, '$descriptionCours') ";
        //On enregistre dans la table tblcours
        if(mysqli_query($connection, $requette)){

            $requette = "INSERT INTO tblcours_programme(Code_Cours, Code_Programme)
                         VALUES('$codeCours','$codeProgramme')";

            //On enregistre dans la table tblcours_programmes
            if(!mysqli_query($connection, $requette))
            {
                ?><p>Erreur: <?=mysqli_error($connection);?></P><?php 
            return false;

            }
        
        }
        else{
            ?><p>Erreur: <?=mysqli_error($connection);?></P><?php 
            return false;
        }

    }

}

function supprimerCours($codeCours)
{
    $connection = ConnectionBD();
    if(!$connection)
    {
        $message = "Impossible de se connecter à la base de donnée.";
    }
    else{
        
        $requette = "SELECT * FROM tbl_utilisateurs_cours WHERE Code_Cours = '$codeCours'";
        $result = mysqli_query($connection, $requette);
        if(mysqli_num_rows($result) == 0){
            //On suprimme de la table tblcours_programme
            $requette = "DELETE FROM tblcours_programme WHERE Code_Cours = '$codeCours'";
            mysqli_query($connection, $requette);

            //On suprimme de la table tblprogrammes
            $requette = "DELETE FROM tblcours WHERE Code_Cours = '$codeCours'";
            mysqli_query($connection, $requette);
        }
        else{
            echo '<p class="instructeurs__erreur">Il est impossible de suprimmer un cours quand il y a au moins UN étudiant inscrit.</p>';
        }
        
    }

}






?>