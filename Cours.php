<?php
include_once('Fonctions/Fonctions.php');
creer_entete_html('Programmes');
isset($_SESSION['nomUtilisateur'])?entete_page(true):entete_page();


$tableCoursParProgramme = recupererCoursParProgramme();

$etudiantInscrit;
isset($_SESSION['codeProgramme'])?$etudiantInscrit= true :$etudiantInscrit = false ;

//on declare les variables temporaires
$titreProgramme;
$codeProgramme;
$titreCours;
$codeCours;
$description;

?><main> <?php

//On cree la liste de cours
    $quantiteCours = count($tableCoursParProgramme);
    for ($i=0; $i < $quantiteCours - 1 ; $i++) { 

        $codeProgramme = $tableCoursParProgramme[$i][0];
        $titreProgramme = $tableCoursParProgramme[$i][1];
        $codeCours = $tableCoursParProgramme[$i][2];
        $titreCours = $tableCoursParProgramme[$i][3];
        $description = $tableCoursParProgramme[$i][4];

        //si le programme est le premier de la liste
        if($i == 0)
        {
            ?> <ul class="cours__liste">
                <li>
                <h1 id="<?php echo($codeProgramme) ?>"> <?php echo($titreProgramme) ?></h1>  
                <h3> <?php echo($codeProgramme) ?>  </h3>
                <h2> <?php echo($titreCours) ?>  </h2>
                <h4> <?php echo($codeCours) ?>  </h4>
                <p> <?php echo($description) ?>  </p>
                <?php // Si l'etudiant est deja inscrit
                if($etudiantInscrit)
                {
                  ?> <a href="EnregistrementCours.php?coursChoisi=<?=$codeCours?>"> Inscrivez-vous à ce cours </a> <?php  
                }
                else {
                    ?> <a href="Inscription.php"> Inscrivez-vous à ce cours en devenant étudiant avec nous </a> <?php  
                }  //Si le cours ne fait pas part du prochain programme on ferme la liste
                if($codeProgramme != $tableCoursParProgramme[$i +1][0])
                {
                    ?> </li>
                    <?php
                }
        }
        else 
        {
            //Si le cours ne fait pas part du programme antecedent on crie une liste pour le nouveau programme
            if($codeProgramme != $tableCoursParProgramme[$i -1][0])
            {
                ?>  <li>
                    <h1 id="<?php echo($codeProgramme) ?>"><?php echo($titreProgramme) ?></h1><?php
                ?>  <h3> <?php echo($codeProgramme) ?> </h3>
                      <?php
            }
                    ?>
                        <h2> <?php echo($titreCours) ?>  </h2>
                        <h4> <?php echo($codeCours) ?>  </h4>
                        <p> <?php echo($description) ?>  </p>
                    <?php
                    // Si l'etudiant est deja inscrit
                    if($etudiantInscrit)
                    {
                    ?> <a href="EnregistrementCours.php?coursChoisi=<?=$codeCours?>&titreCours=<?=$titreCours?>"> Inscrivez-vous à ce cours </a> <?php  
                    }
                    else {
                        ?> <a href="Inscription.php"> Inscrivez-vous à ce cours en devenant étudiant avec nous </a> <?php  
                    }
            //Si le cours ne fait pas part du prochain programme on ferme la liste
            if($codeProgramme != $tableCoursParProgramme[$i +1][0])
            {
                ?> </li>
                <?php
            }
        }
    
    }
    ?> </ul>

</main>
<footer>
</footer>
    <?php

?>