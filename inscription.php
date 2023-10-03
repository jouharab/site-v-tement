<?php require_once("../bdd/init.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
if($_POST)
{
    // debug($_POST);
    $verif_caractere = preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo']); 
    if(!$verif_caractere && (strlen($_POST['pseudo']) < 1 || strlen($_POST['pseudo']) > 20) ) // 
    {
        $contenu .= "<div class='erreur'>Le pseudo doit contenir entre 1 et 20 caractères. <br> Caractère accepté : Lettre de A à Z et chiffre de 0 à 9</div>";
    }
    else
    {
        $membre = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");
        if($membre->num_rows > 0)
        {
            $contenu .= "<div class='erreur'>Pseudo indisponible. Veuillez en choisir un autre svp.</div>";
        }
        else
        {
            // $_POST['mdp'] = md5($_POST['mdp']);
            foreach($_POST as $indice => $valeur)
            {
                $_POST[$indice] = htmlEntities(addSlashes($valeur));
            }
            executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse) VALUES ('$_POST[pseudo]', '$_POST[mdp]', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]', '$_POST[code_postal]', '$_POST[adresse]')");
            $contenu .= "<div class='alert alert-success'>Vous êtes inscrit à notre site web. <a class='valide' href=\"connexion.php\"><u>Cliquez ici pour vous Connecter</u></a></div>";
        }
    }
}
//--------------------------------- AFFICHAGE HTML ---------------------------------//
?>
<?php require_once("../inc/header.php"); ?>
<?php echo $contenu; ?>
 
<div class="card" >
  <div class="card-body" >
    <form method="post" action="">
    <label for="text" > <h2 class="titre">Inscrivez-vous !!</h2> </label><br>
            
    <input type="text" id="pse" name="pseudo" maxlength="20" placeholder="Votre pseudo" pattern="[a-zA-Z0-9-_.]{1,20}" title="caractères acceptés : a-zA-Z0-9-_." required="required">
          
    
    <input type="text" id="motdp" name="mdp" required="required" placeholder="Mot de passe"><br><br>
   
  
    <input type="text" id="nom" name="nom" placeholder="Votre nom">
          
   
    <input type="text" id="prenom" name="prenom" placeholder="Votre prénom"><br><br>
  
    
    <input type="text" id="ville" name="ville" placeholder="Votre ville" pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés : a-zA-Z0-9-_.">
          
    
    <input type="text" id="code_postal" name="code_postal" placeholder="Code postal" pattern="[0-9]{5}" title="5 chiffres requis : 0-9"><br><br>
    
    <input id="adresse" name="adresse" placeholder="Votre adresse" pattern="[a-zA-Z0-9-_. ]{5,15}" title="caractères acceptés :  a-zA-Z0-9-_.">  
   
    <input type="email" id="email" name="email" placeholder="Exemple@gmail.com"><br><br>
    
    <input name="civilite" value="m" checked="" type="radio">Homme
    <input name="civilite" value="f" type="radio">Femme<br>
                  
    
   
   
 
    <input type="submit" name="inscription" value="S'inscrire" class="btn" id="butn" >
</form>
 
  </div>
</div>


<?php require_once("../inc/footer.php"); ?>