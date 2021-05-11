<?php

//Connexion à MySQL
function ConnectionBD()
{
    //Creation et selection de la connexion
    $bd = mysqli_connect('localhost', 'root');
    $ok = mysqli_select_db($bd, 'moncollege');
    if(! $ok)
    {
        //S'il est impossible de selectionner la base de données
        $ok = mysqli_close($bd);
    }
    else
    {
        //Initialisation du "charset"
        mysqli_set_charset($bd, 'utf8');

        //retour de la chaine de connexion à la fonction appelante
        return $bd;
    }
}

function creer_entete_html($ID)
{
    //On initialize la session
    session_start();

    ?>
    <!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8"/>
            <title> Mon cours en ligne </title>
            <link rel="stylesheet" href="CSS/MesCours.css?v=<?php echo time(); ?>"/>
            <link rel="stylesheet" href="CSS/reset.css"/>
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Antonio:wght@700&display=swap" rel="stylesheet">
        </head>
        <?php
            if($ID != 'Newuser' && $ID != 'Authentification')
            $_SESSION['page'] = $ID;
        ?>

    <!-- On cree le Body du html en utilisant id = $ID -->
    <Body id= <?php echo $ID; ?>>
        
    <?php
}

function entete_page($logged = false)
{

    $prenom = isset($_SESSION['prenom'])?$_SESSION['prenom']:'';
    $nomFamille = isset($_SESSION['nom'])?$_SESSION['nom']:'';

    ?>
    <!-- On cree le header du HTML -->
    <header class="header">

        <div class="entete__boite">
            <img id="logo" src="Images/logo2.png" alt="logo" />
            <div class="background__logo"> </div>
            

            <h1 id="titre">Mes Cours en->ligne </h1>

            <div>
                <!-- Si l'utilisateur n'est pas authentié -->
                <?php if(!$logged) : ?>
                        <form class="login" name = "login" action="Authentication.php" method="post">
                            <p><label for="inputUtilisateur">Nom d'utilisateur: <input class= login__txt type="text" name="txtUtilisateur" id="inputUtilisateur" required> </p>
                            <p class= login__motPasse><label for="inputMotPasse">Mot de passe: </label><input class= login__txt type="password" name="txtMotPasse" id="inputMotPasse" required></p>
                            <p><input class="login__Bouton" type="submit" name="btnSoumettre" value="Soumettre"></p>
                            <p><button class="login__Bouton" type="reset" onclick="document.getElementById('inputUtilisateur').value = ''; document.getElementById('inputMotPasse').value = ''" >Effacer</button></p>
                        </form>

                <?php else: ?>
                    <?php 
                        echo "<div class=\"logged\">";
                        echo("<p>Bienvenu $prenom $nomFamille</p>");
                        echo "<a href=\"logout.php\" >Logout</a>";
                        echo "</div>";
                    ?>
                <?php endif; ?>

                <nav class="navigation">
                    <ul>
                        <li><a href="Programmes.php">Programmes</a></li>
                        <li><a href="Inscription.php">Inscrivez-vous</a></li>
                    </ul>
                </nav>

            </div>
                    
            
        </div>
    </header>

    <?php
}


function creer_pied_html()
{
    ?>
          
    </body>
    </html>
    <?php
}

function authentification($nomUtilisateur, $motPasse)
{
    if($nomUtilisateur == "maitre" && $motPasse == "acceder"){
        $message = "professeur";
    }
    else{

        $connection = ConnectionBD();
        if(! $connection)
        {
            //Creation d'un message qui averti l'utilisateur de l'erreur
            $message = "Il est actuellement impossible de se connecter à la base de données";
        }
        else{
            //Creation de la requete selection
            $requete = mysqli_query($connection, "SELECT * FROM tbl_utilisateurs WHERE Nom_Utilisateur = '$nomUtilisateur'
            AND Mot_Passe = '$motPasse' ");
            if(mysqli_num_rows($requete) != 0)
            {
                 $utilisateur = mysqli_fetch_assoc($requete);
                 enregistrementSession($utilisateur);
                 $message = "Reussi";
            }
            else
            {
                //Creation d'un message qui averti l'utilisateur
            $message = "Il est impossible de vous authentifier.
            Soit vous n'êtes pas inscrit dans notre base de données, soit vous
            avez mal saisi vos informations d'authentification. Dans ce dernier
            cas, vérifiez votre nom d'utilisateur et votre mot de passe.";

            }
            $ok = mysqli_close($connection);
        }

    }
    return $message;

}

function enregistrementSession($utilisateur)
{

     //inserction de données dans des variables de session.  


     //TO DO
     $_SESSION['nomUtilisateur'] = $information['NomUtilisateur'];
     $_SESSION['motPasse'] = $information['MotPasse'];
     $_SESSION['prenom'] = $information['Prenom'];
     $_SESSION['nomFamille'] = $information['Nom'];
     $_SESSION['adresse'] = $information['Adresse'];
     $_SESSION['ville'] = $information['Ville'];
     $_SESSION['province'] = $information['Province'];
     $_SESSION['codePostal'] = $information['CodePostal'];
     $_SESSION['telephone'] = $information['Telephone'];
     $_SESSION['cellulaire'] = $information['Cellulaire'];
     $_SESSION['courriel'] = $information['Courriel'];
     $_SESSION['typeAnimal'] = $information['TypeAnimal'];
     $_SESSION['nomAnimal'] = $information['NomAnimal'];
     $_SESSION['raceAnimal'] = $information['RaceAnimal'];
     $_SESSION['ageAnimal'] = $information['AgeAnimal'];
     $_SESSION['commentaires'] = $information['Commentaires'];
     $_SESSION['enregistre'] = 'true';

     $prenom = isset($_SESSION['prenom'])?$_SESSION['prenom']:'';
     $nomFamille = isset($_SESSION['nomFamille'])?$_SESSION['nomFamille']:'';

}

//Recuperer étudiants par cours

function recupererEtudiantsParCours()
{
    $connection = ConnectionBD();
    if(! $connection)
    {
        $message ="Impossible de se connecter à la base de donnée.";
        return $message;
    }
    else 
    {
        //Creation de la requete select
        $requete = "select A.Id_Utilisateur, A.Nom, A.Prenom, A.Adresse_Courriel,D.Titre_Programme, B.Code_Cours,C.Titre_Cours, B.Note from tbl_utilisateurs as A
        INNER JOIN tbl_utilisateurs_cours as B 
        ON a.Id_Utilisateur = B.Id_Etudiant
        INNER JOIN tblcours as C
        On B.Code_Cours = C.Code_Cours
        INNER JOIN tblprogrammes as D 
        ON A.Code_Programme = D.Code_Programme";

        $query = mysqli_query($connection, $requete);
        if(mysqli_num_rows($query) != 0)
        {
            $etudiantsParCours = mysqli_fetch_all($query);
            return $etudiantsParCours;
        }
        else {
           $message = "Impossible de trouver des étudiants dans la base de donées.";
           return $message;
        }

        $ok = mysqli_close($connection);
    }
}

//recuperer la liste de programmes
function recupererCoursParProgramme()
{
    $connection = ConnectionBD();
    if(! $connection)
    {
        $message = "Impossible de se connecter à la base de donnée.";
    }
    else 
    {
        //creation de la requete select
        $requete = "SELECT A.Code_Programme, A.Titre_Programme, C.Code_Cours,C.Titre_Cours, C.Description_Cours
        FROM tblprogrammes AS A
        INNER JOIN tblcours_programme AS B
        ON A.Code_Programme = B.Code_Programme
        INNER JOIN tblcours AS C
        ON C.Code_Cours = B.Code_Cours";

        $query = mysqli_query($connection, $requete);
        if(mysqli_num_rows($query) != 0)
        {
            $listeCoursParProgramme = mysqli_fetch_all($query);
            return $listeCoursParProgramme;
        }
        else
        {
           $message = "Impossible de trouver des programmes dans la base de données.";
           return $message;
        }

        $ok = mysqli_close($connection);
    }
}

//On enregistre le resultat de la table dans une variable array
function listeCoursParProgramme($tableCoursParProgramme)
{
    $titreProgramme;
    $codeProgramme;
    $titreCours;
    $codeCours;
    $description;

    //$arrayCoursParProgramme = array();
    

        $quantiteLignes = count($tableCoursParProgramme);
        for ($i=0; $i < $quantiteLignes - 1 ; $i++) { 

            $codeProgramme = $tableCoursParProgramme[$i][0];
            $titreProgramme = $tableCoursParProgramme[$i][1];
            $codeCours = $tableCoursParProgramme[$i][2];
            $titreCours = $tableCoursParProgramme[$i][3];
            $description = $tableCoursParProgramme[$i][4];

            //si le programme est le premier de la liste
            if($i == 0)
            {
                ?> <ul>
                    <li><h2 id="<?php echo($codeProgramme) ?>"> <?php echo($titreProgramme) ?></h2>  </li>
                    <li> <?php echo($codeProgramme) ?>  </li>
                    <ul> 
                        <li>
                            <h2> <?php echo($titreCours) ?>  </h2>
                            <h3> <?php echo($codeCours) ?>  </h2>
                            <p> <?php echo($description) ?>  </p>
                        </li> 
                    
                    <?php //Si le cours ne fait pas part du prochain programme on ferme la liste
                    if($codeProgramme != $tableCoursParProgramme[$i +1][0])
                    {
                        ?> </ul>
                        </ul><?php
                    }
            }
            else 
            {
                //Si le cours ne fait pas part du programme antecedent on crie une liste pour le nouveau programme
                if($codeProgramme != $tableCoursParProgramme[$i -1][0])
                {
                    ?> <ul>
                        <li><h2 id="<?php echo($codeProgramme) ?>"><?php echo($titreProgramme) ?></h2></li><?php
                    ?>  <li> <?php echo($codeProgramme) ?>  </li>
                        <ul> <?php
                }
                        ?><li> 
                            <h2> <?php echo($titreCours) ?>  </h2>
                            <h3> <?php echo($codeCours) ?>  </h2>
                            <p> <?php echo($description) ?>  </p>
                        </li><?php

                //Si le cours ne fait pas part du prochain programme on ferme la liste
                if($codeProgramme != $tableCoursParProgramme[$i +1][0])
                {
                    ?> </ul>
                    </ul><?php
                }
            }
        
        }

}




?>