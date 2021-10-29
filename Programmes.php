<?php
include_once('Fonctions/Fonctions.php');
creer_entete_html('Programmes');
isset($_SESSION['nomUtilisateur'])?entete_page(true):entete_page();
?>
<main>
    <ul class="programmes__liste">
        <li>
            <a  href="Cours.php#P1000"> <h2>PHP</h2>
            <h3></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget diam in lectus ultricies interdum sagittis ut erat.
             Maecenas gravida leo sed arcu varius, eu varius elit porta. Sed luctus imperdiet nibh eget tempor. Morbi vitae luctus nibh.
             Maecenas egestas vestibulum ante, sit amet auctor leo semper id. Donec vestibulum metus viverra, blandit nisl in, porta mauris.
             Etiam gravida ex ut diam ornare viverra. Cras gravida suscipit lacus, at fringilla quam commodo eget. </p>
            </a>
        </li>
        <li>
            <a href="Cours.php#J1000">
            <h2>Java</h2>
            <h3></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget diam in lectus ultricies interdum sagittis ut erat.
             Maecenas gravida leo sed arcu varius, eu varius elit porta. Sed luctus imperdiet nibh eget tempor. Morbi vitae luctus nibh.
             Maecenas egestas vestibulum ante, sit amet auctor leo semper id. Donec vestibulum metus viverra, blandit nisl in, porta mauris.
             Etiam gravida ex ut diam ornare viverra. Cras gravida suscipit lacus, at fringilla quam commodo eget. </p>
             </a>
        </li>
        <li>
            <a href="Cours.php#C1000">
            <h2>CSharp</h2>
            <h3></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget diam in lectus ultricies interdum sagittis ut erat.
             Maecenas gravida leo sed arcu varius, eu varius elit porta. Sed luctus imperdiet nibh eget tempor. Morbi vitae luctus nibh.
             Maecenas egestas vestibulum ante, sit amet auctor leo semper id. Donec vestibulum metus viverra, blandit nisl in, porta mauris.
             Etiam gravida ex ut diam ornare viverra. Cras gravida suscipit lacus, at fringilla quam commodo eget. </p>
             </a>
        </li>
        <li>
            <a href="Cours.php#P2000">
            <h2>Phyton</h2>
            <h3></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget diam in lectus ultricies interdum sagittis ut erat.
             Maecenas gravida leo sed arcu varius, eu varius elit porta. Sed luctus imperdiet nibh eget tempor. Morbi vitae luctus nibh.
             Maecenas egestas vestibulum ante, sit amet auctor leo semper id. Donec vestibulum metus viverra, blandit nisl in, porta mauris.
             Etiam gravida ex ut diam ornare viverra. Cras gravida suscipit lacus, at fringilla quam commodo eget. </p>
             </a>
        </li>
        <li>
            <a href="Cours.php#U1000">
            <h2>Unity</h2>
            <h3></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget diam in lectus ultricies interdum sagittis ut erat.
             Maecenas gravida leo sed arcu varius, eu varius elit porta. Sed luctus imperdiet nibh eget tempor. Morbi vitae luctus nibh.
             Maecenas egestas vestibulum ante, sit amet auctor leo semper id. Donec vestibulum metus viverra, blandit nisl in, porta mauris.
             Etiam gravida ex ut diam ornare viverra. Cras gravida suscipit lacus, at fringilla quam commodo eget. </p>
            </a>
        </li>
    </ul>
</main>
<footer>
</footer>