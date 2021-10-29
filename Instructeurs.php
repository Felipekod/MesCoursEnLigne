<?php
include_once('Fonctions/Fonctions.php');
include_once('Fonctions/InstructeursFonctions.php');
creer_entete_html('Instructeurs');
isset($_SESSION['nomUtilisateur'])?entete_page(true):entete_page();

//Si l'utilisateur clique sur le bouton enregistrer dans le formulaire modifier
if(isset($_POST['Enregistrer']))
{  
    $codeCours = $_POST['codeCours'];
    $nomCours = $_POST['nomCours'];
    $dureeCours = $_POST['dureeCours'];
    $descriptionCours = $_POST['descriptionCours'];

    updateCours($codeCours, $nomCours, $descriptionCours, $dureeCours);

}
elseif(isset($_POST['Ajouter']))
{

    $codeCours = $_POST['codeCours'];
    $codeProgramme = $_POST['codeProgramme'];
    $nomCours = $_POST['nomCours'];
    $dureeCours = (int)$_POST['dureeCours'];
    $descriptionCours = $_POST['descriptionCours'];

    ajouterCours($codeCours, $nomCours, $descriptionCours, $dureeCours, $codeProgramme);

}

?>
<main id="insctructeurs__main">
    <form class="instructeurs__Select" method="get" action="#">
        <fieldset>
            <legend>Voulez choisir le programme</legend>
            <select dir="rlt" name="programme" required>
                <option disabled selected value>  </option>
                <option value="P1000">PHP</option>
                <option value="J1000">java</option>
                <option value="C1000">CSharp</option>
                <option value="P2000">Phyton</option>
                <option value="U1000">Unity</option>
            </select>
        </fieldset>
        <input type="submit" value="Ok" name="ok" class="envoyer">
        <input type="submit" value="Ajouter" name="ajouter" class="envoyer">
    </form>



<?php

//Si l'utiisateur choisi un valeur dans le fieldset
if(isset($_GET['ok'])){

    $codeProgrammeChoisi = $_GET['programme'];
    $arrayCoursParProgramme = arrayCoursParProgramme($codeProgrammeChoisi);
    creerTableCoursInstructeurs($arrayCoursParProgramme);   
    
}
elseif(isset($_GET['ajouter'])){
    $codeProgrammeChoisi = $_GET['programme'];
    $arrayCoursParProgramme = arrayCoursParProgramme($codeProgrammeChoisi);
    $nvCode = definirNouveauCodeCours($arrayCoursParProgramme);
    $codeProgramme = $arrayCoursParProgramme[0][0];
    $nomProgramme = $arrayCoursParProgramme[0][1];
  //On cree un formulaire pour l'ajout d'un cours
  ?>
  <div class="instructeurs__formulaire">
     <form action="Instructeurs.php?programme=<?= $codeProgramme ?>" method="post" >
        <input type="hidden" value="ok" name="Ajouter" >
        <input type="hidden" value="<?=$nvCode?>" name="codeCours" >
        <p>Programme: <?=$nomProgramme ?><br>Code du cours: <?=$nvCode?></p>
        <input type="text" value="" name="nomCours" placeholder="Voulez saisir le TITRE du cours ici">
        <input type="text" value=""  name="dureeCours" placeholder="Voulez saisir la DURÉE en heures du cours ici">
        <textarea id="instructeurs__textarea" rows="20" cols="100" name="descriptionCours" placeholder="Voulez saisir la DESCRIPTION du cours ici"></textarea>
        <input id="instructeurs__enregistrer" type=submit value="Enregistrer">
        <input type="hidden" value="<?=$codeProgramme?>" name="codeProgramme" >
     </form>
  </div>

<?php
}

//Si l'utilisateur clique sur modifier ou suprimmer un cours
if(isset($_GET['Action'])){

    //on recupere la table de cours
    $tableCoursParProgramme = recupererCoursParProgramme();

    //On recupère le code du cours
    $codeCoursChoisi = $_GET['codeCours'];

    //Si l'utilisateur clique sur modifier un cours, un formulaire pour modifier un cours apparait dans la page.
    if($_GET['Action']=="Modifier"){
        for ($i=0; $i < count($tableCoursParProgramme) ; $i++) { 
            
            if($codeCoursChoisi == $tableCoursParProgramme[$i][2])
            {
                $codeProgramme = $tableCoursParProgramme[$i][0];
                $nomCours = $tableCoursParProgramme[$i][3];
                $description = $tableCoursParProgramme[$i][4];
                $dureeCours = $tableCoursParProgramme[$i][5];

                ?>
                <div class="instructeurs__formulaire">
                    <form action="Instructeurs.php?programme=<?= $codeProgramme ?>" method="post">
                        <input type="hidden" value="ok" name="Enregistrer" >
                        <input type="hidden" value="<?=$codeCoursChoisi?>" name="codeCours" >
                        <p><?=$codeCoursChoisi?></p>
                        <input type="text" value="<?= $nomCours ?>" name="nomCours">
                        <input type="text" value="<?= $dureeCours ?>"  name="dureeCours">
                        <textarea id="instructeurs__textarea" rows="20" cols="100" name="descriptionCours"><?= $description ?></textarea>
                        <input id="instructeurs__enregistrer" type=submit value="Enregistrer">
                    </form>
                </div>
                <?php
            }

        }
                
    }

    //Si l'utilisateur clique en supprimer un cours
    else if($_GET['Action']=="Supprimer"){
            supprimerCours($codeCoursChoisi);
    }

}




?>

</main>
<footer>
</footer>


