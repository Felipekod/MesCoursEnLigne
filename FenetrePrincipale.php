<?php
include_once('Fonctions/Fonctions.php');
creer_entete_html('FenetrePrincipale');
isset($_SESSION['nomUtilisateur'])?entete_page(true):entete_page();

//On recupere la liste d'estudiants par cours
$tableEtudiantsParCours = recupererEtudiantsParCours();
$quantiteLignes = count($tableEtudiantsParCours);

?>

<main>
        <h1 id="tableEtudiants">Table étudiants par cours</h1>
        <table class="table_etudiants">
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
                        echo "<td>" .$tableEtudiantsParCours[$i][0]. "</td>";
                        echo "<td>" .$tableEtudiantsParCours[$i][1]. "</td>";
                        echo "<td>" .$tableEtudiantsParCours[$i][2]. "</td>";
                        echo "<td>" .$tableEtudiantsParCours[$i][3]. "</td>";
                        echo "<td>" .$tableEtudiantsParCours[$i][4]. "</td>";
                        echo "<td>" .$tableEtudiantsParCours[$i][5]. "</td>";
                        echo "<td>" .$tableEtudiantsParCours[$i][6]. "</td>";
                        echo "<td>" .$tableEtudiantsParCours[$i][7]. "</td>";
                        echo "</tr>";
          
                }
            ?>
        </table>
</main>
<footer>
</footer>
