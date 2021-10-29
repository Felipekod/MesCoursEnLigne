<?php
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/OAuth.php';
require 'vendor/phpmailer/phpmailer/src/POP3.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

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
            

            <a href="Index.php" id="titre"><h1>Mes Cours en->ligne </h1></a>

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
                        <?php if(!$logged): ?>
                            <li><a href="Programmes.php">Programmes</a></li>
                            <li><a href="Inscription.php">Inscrivez-vous</a></li>
                        <?php elseif($_SESSION['nomUtilisateur']=='Maitre'): ?>
                            <li><a href="FenetrePrincipale.php">Accueil</a></li>
                            <li><a href="Instructeurs.php">Instructeurs</a></li>
                        <?php else: ?>
                            <li><a href="Programmes.php">Programmes</a></li>
                            <li><a href="MesCours.php">Mes Cours</a></li>
                        <?php endif; ?>
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

function enregistrementSession($information)
{

     //inserction de données dans des variables de session.  

     $_SESSION['idUtilisateur'] = $information['Id_Utilisateur'];
     $_SESSION['nomUtilisateur'] = $information['Nom_Utilisateur'];
     $_SESSION['motPasse'] = $information['Mot_Passe'];
     $_SESSION['prenom'] = $information['Prenom'];
     $_SESSION['nom'] = $information['Nom'];
     $_SESSION['adresseCourriel'] = $information['Adresse_Courriel'];
     $_SESSION['codeProgramme'] = $information['Code_Programme'];
     $_SESSION['enregistre'] = 'true';

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

//recuperer la table de la liste de programmes
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
        $requete = "SELECT A.Code_Programme, A.Titre_Programme, C.Code_Cours,C.Titre_Cours, C.Description_Cours, C.Duree_Cours
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


//Function pour recuperer le cours disponible par programme
function listeCoursDisponibleParProgramme($tableCoursParProgramme, $codeProgrammeUtilisateur)
{
    $titreProgramme;
    $codeProgramme;
    $titreCours;
    $codeCours;
    $description;

    //$arrayCoursParProgramme = array();
    

        $quantiteCours = count($tableCoursParProgramme);
        for ($i=0; $i < $quantiteCours - 1 ; $i++) { 

            $codeProgramme = $tableCoursParProgramme[$i][0];
            $titreProgramme = $tableCoursParProgramme[$i][1];
            $codeCours = $tableCoursParProgramme[$i][2];
            $titreCours = $tableCoursParProgramme[$i][3];
            $description = $tableCoursParProgramme[$i][4];

            ?><ul><?php

            //si le programme est le premier de la liste
            if($codeProgramme == $codeProgrammeUtilisateur)
            {
                ?> 
                    
                        <li>
                            <h2> <?php echo($titreCours) ?>  </h2>
                            <h3> <?php echo($codeCours) ?>  </h2>
                            <p> <?php echo($description) ?>  </p>
                        </li> 

            <?php   
            } ?>

            </ul> <?php
        
        }

}

// Recuperer une table qui contient la liste de code du cours qui l'utilisateur est inscrit. Recupere ainsi la note si le cours a été completé.
function recupererCodeCoursNote()
{
    $connection = ConnectionBD();
    $idEtudiant = $_SESSION["idUtilisateur"];

    $requete = "SELECT A.Code_Cours, A.Note FROM tbl_utilisateurs_cours as A
    INNER JOIN tbl_utilisateurs AS B
    ON A.Id_Etudiant = B.Id_Utilisateur
    WHERE B.Id_Utilisateur = '$idEtudiant'";

    $resultat = mysqli_query($connection, $requete );

    if(mysqli_num_rows($resultat) != 0)
    {
        $tableCodeCoursNote = mysqli_fetch_all($resultat);
        return $tableCodeCoursNote;
    }
    else {
        return false;

    }

    
}

function returneListeCoursInscrit($tableCoursParProgramme, $tableCodeCoursNote)
{
    $quantiteCours = count($tableCoursParProgramme);
    $quantiteCoursInscrits = count($tableCodeCoursNote);
    $listeCoursInscrit = array();

    if($tableCodeCoursNote === false)
    {
        ?> 
        <div>
            <h2>Voulez-vous inscrire dans un cours associé à votre programme</h2>
        </div>
         <?php

    }
    else {
        ?> 
        <div>
            <h2 id="mesCours">Mes cours</h2>
            <ul class="mesCours__liste">
         <?php

            //On fait parcourir la table de cours par programme
        for ($i=0; $i < $quantiteCours - 1 ; $i++) { 

            $codeProgramme = $tableCoursParProgramme[$i][0];
            $titreProgramme = $tableCoursParProgramme[$i][1];
            $codeCours = $tableCoursParProgramme[$i][2];
            $titreCours = $tableCoursParProgramme[$i][3];
            $description = $tableCoursParProgramme[$i][4];

            //On identifie les cours inscrits par l'etudiant
            for ($j=0; $j <= $quantiteCoursInscrits - 1 ; $j++) { 

                //Si le code du cours de la première table existe dans la deuxième table
                if($codeCours == $tableCodeCoursNote[$j][0]){
                    //si il n'y a pas de note enregistré on insère la valeur 'N/A'
                    $note;
                    isset($tableCodeCoursNote[$j][1])?$note = $tableCodeCoursNote[$j][1]: $note = 'N/A';

                    ?> <li>
                            <h2><?php echo($titreCours); ?></h2>
                            <h3><?php echo($codeCours); ?></h3>
                            <p>Note: <?php echo($note); ?></p>
                       </li> <?php

                }

            }
            
        }
        ?>
             </ul>
        </div>
        <?php
        
        
    }

    

}
//------------ Enregistrement Cours
function verifierCoursChoisi($idEtudiant, $codeCours){
    $connection = ConnectionBD();
    if(! $connection)
    {
        $message = "Impossible de se connecter à la base de donnée.";
    }
    else 
    {
        //creation de la requete select
        $requete = "SELECT *
        FROM tbl_utilisateurs_cours
        WHERE Id_Etudiant = $idEtudiant AND Code_Cours = '$codeCours'";

        $query = mysqli_query($connection, $requete);
        if(mysqli_num_rows($query) != 0)
        {
            return false;
        }
        else
        {
           return true;
        }
    }

}

function inscriptionCours($idEtudiant, $codeCours){

    $connection = ConnectionBD();
    if(! $connection)
    {
        $message = "Impossible de se connecter à la base de donnée.";
    }
    else 
    {
        //creation de la requete select
        $requete = "INSERT INTO  tbl_utilisateurs_cours
                    (Id_Etudiant, Code_Cours) 
                    VALUES ($idEtudiant, '$codeCours')";

        if(mysqli_query($connection, $requete))
        {
            return true;
        }
        else {
            
            return false;
        }
    }
}
//------------------- mail ------------------------

function confirmationEmail($nomEtudiant, $mail, $codeCours){
    try{
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail -> Host = "smtp.gmail.com"; 
        $mail -> Port = 587;
        $mail -> SMTPAuth = true;
        $mail -> SMTPSecure = 'tls';
        $mail->CharSet="UTF-8";
        $mail -> Username = 'votregmail@gmail.com';
        $mail -> Password = 'votreMotPasse';
        $mail -> setFrom('felipe.kodorna@gmail.com', 'Test');
        $mail->addAddress($mail, $nom);
        $mail -> IsSMTP(true);
        $mail->isHTML(true);
        $mail->AllowEmpty = true;
        $mail -> SMTPDebug = 3;
        $mail -> Subject = "Confirmation inscription.";
        $mail -> Body = 'Bonjour' . $nom . '<br> Vous avez inscrit dans le cours: ' . $codeCours;
    
    }
    catch (phpmailerException $e) 
    {
        echo $e->errorMessage(); //Error messages from PHPMailer
    } 
    
    
    
    if (!$mail -> send())
    {
    
        echo "Error -- Message not send!";
        
    }
   
}
//------------------- Test function ------------------------
function print_r2($val){
    echo '<pre>';
    print_r($val);
    echo  '</pre>';
}


?>