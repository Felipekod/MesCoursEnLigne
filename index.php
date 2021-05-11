<?php
include_once('Fonctions/Fonctions.php');
creer_entete_html('index');

isset($_SESSION['nomUtilisateur'])?entete_page(true):entete_page();


?>
<main>
    <section>
        <div class="bienvenue">
            <div class="bienvenue__texte">
                <h1>Étudiez l'informatique et la technologie de l'information!</h1>
                <p>Vous allez étudier et pratiquer dans une plataforme que respire de la technologie.</p>
            </div>
            <img src="Images/logo2.png" alt="logo">
        </div>
        <div class="programmes">
            <ul class="programmes__unite">
                <li>
                    <img class="programmes__images" src="Images/php01.png" alt="logo PHP">
                    <p>Programme</p>
                    <h3>PHP</h3>
                    <ul>
                        <a></a>
                        <a></a>
                        <a></a>
                    </ul>
                </li>
            </ul>
            <ul class="programmes__unite">
                <li>
                    <img class="programmes__images" id="logo__java" src="Images/java01.png" alt="logo Java">
                    <p>Programme</p>
                    <h3>Java</h3>
                    <ul>
                        <a></a>
                        <a></a>
                        <a></a>
                    </ul>
                </li>
            </ul>
            <ul class="programmes__unite">
                <li>
                    <img class="programmes__images" src="Images/csharp01.png" alt="logo Csharp">
                    <p>Programme</p>
                    <h3>C#</h3>
                    <ul>
                        <a></a>
                        <a></a>
                        <a></a>
                    </ul>
                </li>
            </ul>
            <ul class="programmes__unite">
                <li>
                    <img  class="programmes__images" src="Images/python01.png" alt="logo Python">
                    <p>Programme</p>
                    <h3>Python</h3>
                    <ul>
                        <a></a>
                        <a></a>
                        <a></a>
                    </ul>
                </li>
            </ul>
            <ul class="programmes__unite">
                <li>
                    <img class="programmes__images" src="Images/unity02.png" alt="logo Unity">
                    <p>Programme</p>
                    <h3>Unity</h3>
                    <ul>
                        <a></a>
                        <a></a>
                        <a></a>
                    </ul>
                </li>
            </ul>
        </div>
    </section>
</main>


<?php



creer_pied_html();


?>