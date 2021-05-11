<?php
include_once('Fonctions/Fonctions.php');
creer_entete_html('FenetrePrincipale');
isset($_SESSION['nomUtilisateur'])?entete_page(true):entete_page();

//On recupere la liste d'estudiants par cours
$tableEtudiantsParCours = recupererEtudiantsParCours();
$quantiteLignes = count($tableEtudiantsParCours);

?>


<h1>Table étudiants par cours</h1>
<table>
    <tr>
        <th>Id étudiant</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Programme</th>
        <th>Code cours</th>
        <th>Nom cours</th>
        <th>Note</th>
    </tr>
    <?php
        for ($i=0; $i < $quantiteLignes - 1; $i++) { 

           
                echo "<tr>";
                echo "<th>" .$tableEtudiantsParCours[$i][0]. "</th>";
                echo "<th>" .$tableEtudiantsParCours[$i][1]. "</th>";
                echo "<th>" .$tableEtudiantsParCours[$i][2]. "</th>";
                echo "<th>" .$tableEtudiantsParCours[$i][3]. "</th>";
                echo "<th>" .$tableEtudiantsParCours[$i][4]. "</th>";
                echo "<th>" .$tableEtudiantsParCours[$i][5]. "</th>";
                echo "<th>" .$tableEtudiantsParCours[$i][6]. "</th>";
                echo "<th>" .$tableEtudiantsParCours[$i][7]. "</th>";
                echo "</tr>";
                

           
        
        }
    ?>
</table>


<?php

creer_pied_html();

?>