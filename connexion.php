<?php require_once("../bdd/init.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}

function generateCSRFToken(): string {
    $session_token_label = 'CSRF_TOKEN_SESS_IDX';
    $hashAlgo = 'sha3-512';
    $hmac_data = 'nL9BmHh3wg1aVgojcbJlWEyIKC00LvkJ';
   
    if (empty($_SESSION[$session_token_label])) {
        $_SESSION[$session_token_label] = bin2hex(openssl_random_pseudo_bytes(256));
    }
    return hash_hmac($hashAlgo, $hmac_data, $_SESSION[$session_token_label]);
}
// --------------------------------
if(isset($_GET['action']) && $_GET['action'] == "deconnexion")
{
    session_destroy();
}
if(internauteEstConnecte())
{
    header("location:profil.php");
}
if($_POST)
{
    // $contenu .=  "pseudo : " . $_POST['pseudo'] . "<br>mdp : " .  $_POST['mdp'] . "";
    $resultat = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");
    if($resultat->num_rows != 0)
    {
        // $contenu .=  '<div style="background:green">pseudo connu!</div>';
        $membre = $resultat->fetch_assoc();
        if($membre['mdp'] == $_POST['mdp'])
        {
            //$contenu .= '<div class="validation">mdp connu!</div>';
            foreach($membre as $indice => $element)
            {
                if($indice != 'mdp')
                {
                    $_SESSION['membre'][$indice] = $element;
                }
            }
            header("location:profil.php");
        }
        else
        {
            $contenu .= '<div class="alert alert-danger" role="alert">Il y a une erreur dans votre MDP</div>';
        }       
    }
    else
    {
        $contenu .= '<div  class="alert alert-danger" role="alert">il y a une erreur dans votre Pseudo</div>';
    }
}
//--------------------------------- AFFICHAGE HTML ---------------------------------//
?>
<?php require_once("../inc/header.php"); ?>
<?php echo $contenu; ?>
  
<div class="card" >
  <div class="card-body" >
    <form method="post" action="">
        <label for="text" > <h2 class="titre">Connectez-vous !!</h2> </label><br>
            
          
    <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo"><br><br>

    <label>
    <input type="password" name="mdp" placeholder="Mot de passe">
    <div class="password-icon"><i data-feather="eye"></i><i data-feather="eye-off"></i></div>
    </label><br><br>

    <input name="token" value="<?php echo generateCSRFToken(); ?>" type="hidden" ></input>   
     
    <input type="submit" value="Se connecter" class="btn" id="button" >
</form>
  </div>
</div>

<script src="https://unpkg.com/feather-icons"></script>
<script>
  feather.replace();
const eye = document.querySelector(".feather-eye");
const eyeoff = document.querySelector(".feather-eye-off");
const passwordField = document.querySelector("input[type=password]");
eye.addEventListener("click", () => {
eye.style.display = "none";
eyeoff.style.display = "block";
  passwordField.type = "text";
});

eyeoff.addEventListener("click", () => {
  eyeoff.style.display = "none";
  eye.style.display = "block";
  passwordField.type = "password";
});
</script>

<?php require_once("../inc/footer.php"); ?>