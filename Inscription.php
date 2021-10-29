<?php
include_once('Fonctions/Fonctions.php');
include_once('Fonctions/InscriptionFonctions.php');

isset($_POST['txNvNomUtilisateur'])?$nomUtilisateur = trim($_POST['txNvNomUtilisateur']): $nomUtilisateur = '' ;
isset($_POST['txNvMotPasse'])?$motPasse = $_POST['txNvMotPasse']: $motPasse = '' ;
isset($_POST['txNvMotPasseCheck'])? $motPasseCheck = $_POST['txNvMotPasseCheck']: $motPasseCheck = '' ;
isset($_POST['txNvPrenom'])?$prenom = $_POST['txNvPrenom']: $prenom = '';
isset($_POST['txNvNom'])?$nom = $_POST['txNvNom']: $nom = '' ;
isset($_POST['txNvEmail'])?$email = $_POST['txNvEmail']: $email = '';
isset($_POST['programme'])?$programme = $_POST['programme']: $programme = '';


if(empty($nomUtilisateur) || empty($motPasse) || empty($motPasseCheck) || empty($prenom) || empty($nom) || empty($email) || empty($programme))
{
 
}
else{
    if($motPasse!=$motPasseCheck)
    {
        echo("<p class=\"erreur__inscription\">Le mot de passe n'a pas été confirmé</p>");
    }
    else{
        if(validerNom($prenom) && validerNom($nom) && validerMotPasse($motPasse, $motPasseCheck) && validerNomUtilisateur($nomUtilisateur) && validerEmail($email) )
        {
            if(enregistrerUtilisateur($nomUtilisateur, $motPasse, $prenom, $nom, $email, $programme))
            {
                header("location: ValidationInscription.php");
            }
        }
    }
}


creer_entete_html('Inscription');
isset($_SESSION['nomUtilisateur'])?entete_page(true):entete_page();



?>

<main>
    <div>
        <form class="inscription" method="post" action="#">
            <label for="nvNomUtilisateur">Nom d'utilisateur:<input type="text" id="nvNomUtilisateur" 
            name="txNvNomUtilisateur" class="input" required placeholder="Voulez saisir votre nom d'utilisateur"></label>

            <label for="nvMotPasse">Mot de passe:<input type="password" id="nvMotPasse" 
            name="txNvMotPasse" class="input" required placeholder="Voulez saisir votre mot de passe"></label>
            
            <label for="nvMotPasseCheck">Confirmer mot de passe:<input type="password" id="nvMotPasseCheck" 
            name="txNvMotPasseCheck" class="input" required placeholder="Voulez confirmer votre mot de passe"></label>
            
            <label for="nvPrenom">Prenom:<input type="text" id="nvPrenom" 
            name="txNvPrenom" class="input" required placeholder="Voulez saisir votre prenom"></label>
            
            <label for="nvNom">Nom de famille:<input type="text" id="nvNom" 
            name="txNvNom" class="input" required placeholder="Voulez saisir votre nom de famille"></label>
            
            <label for="nvEmail">E-mail:<input type="text" id="nvEmail" 
            name="txNvEmail" class="input" required placeholder="Voulez saisir votre courriel eletronique"></label>
            
            <fieldset>
                <legend>Voulez choisir le programme</legend>
                <select name="programme" required>
                    <option value="P1000">PHP</option>
                    <option value="J1000">java</option>
                    <option value="C1000">CSharp</option>
                    <option value="P2000">Phypon</option>
                    <option value="U1000">Unity</option>
                </select>
            </fieldset>

            <label class="frais">Une frais d'inscripton de $100 est exigé </label>
            <label for="nomCarteCredit">Nom inscrit sur la carte de crédit:<input type="text" id="nomCarteCredit" 
            name="txNomCarteCredit" class="input" required placeholder="Voulez saisir le nom inscrit sur la carte"></label>

            <label for="numeroCarteCredit">Numero de la carte de crédit:<input type="text" id="numeroCarteCredit" 
            name="txNumeroCarteCredit" class="input" required placeholder="Voulez saisir le numero de la carte"></label>

            <input type="submit" value="Envoyer formulaire" class="envoyer">

        </form>
    </div>
</main>
<footer>
</footer>

<?php





?>