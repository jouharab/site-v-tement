<!-- <?php
require_once("../bdd/init.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- VERIFICATION ADMIN ---//
if(!internauteEstConnecteEtEstAdmin())
{
    header("location:../connexion.php");
    exit();
}
 
//--- SUPPRESSION membre ---//
if(isset($_GET['action']) && $_GET['action'] == "suppression")
{   // $contenu .= $_GET['id_produit']
    $resultat = executeRequete("SELECT * FROM membre WHERE id_membre=$_GET[id_membre]");
    $membre_a_supprimer = $resultat->fetch_assoc();
    // $contenu .= '<div class="validation">Supprimer un membre : ' . $_GET['id_membre'] . '</div>';
    executeRequete("DELETE FROM membre WHERE id_membre=$_GET[id_membre]");
    $_GET['action'] = 'affichage';
}
//--- ENREGISTREMENT membre ---//
if(!empty($_POST))
{   // debug($_POST);
    // foreach($_POST as $indice => $valeur)
    // {
    //     $_POST[$indice] = htmlEntities(addSlashes($valeur));
    // }
    executeRequete("REPLACE INTO membre (id_membre, pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse) values ('$_POST[id_membre]', '$_POST[pseudo]', '$_POST[mdp]', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]' ,  '$_POST[code_postal]',  '$_POST[adresse]')");
    // $contenu .= '<div class="validation">Le produit a été ajouté</div>';
    $_GET['action'] = 'affichage';
}


//--- AFFICHAGE membre ---//

    $resultat = executeRequete("SELECT * FROM membre");
     
    $contenu .= '<h2 id="tmembre"> Membres du site : </h2>';
    $contenu .= '<p id="pmembre"> Nombre d\'abonné : ' . $resultat->num_rows . '</p>' ;
    $contenu .= '<table border="1" cellpadding="5" id="mtable" class="table table-bordered"><tr>';
     
    while($colonne = $resultat->fetch_field())
    {    
        $contenu .= '<th>' . $colonne->name . '</th>';
    }
    
    $contenu .= '<th>Supression</th>';
    $contenu .= '</tr>';
 
    while ($ligne = $resultat->fetch_assoc())
    {
        $contenu .= '<tr>';
        foreach ($ligne as $indice => $information)
        {
            if($indice == "photo")
            {
                $contenu .= '<td><img src="' . $information . '" ="70" height="70"></td>';
            }
            else
            {
                $contenu .= '<td>' . $information . '</td>';
            }
        }
        $contenu .= '<td><a href="?action=suppression&id_membre=' . $ligne['id_membre'] .'" OnClick="return(confirm(\'En êtes vous certain ?\'));"><img src="../photo/supprimerprofil.png" width="24px"></a></td>';
        $contenu .= '</tr>';
    }
    $contenu .= '</table><br><br>';

//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("../inc/header.php");
echo $contenu;
if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification'))
{
    if(isset($_GET['id_produit']))
    {
        $resultat = executeRequete("SELECT * FROM produit WHERE id_produit=$_GET[id_produit]");
        $produit_actuel = $resultat->fetch_assoc();
    }
    
}
require_once("../inc/footer.php"); ?> -->