<?php
require_once("../bdd/init.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- VERIFICATION ADMIN ---//
if(!internauteEstConnecteEtEstAdmin())
{
    header("location:../connexion.php");
    exit();
}
 
//--- SUPPRESSION PRODUIT ---//
if(isset($_GET['action']) && $_GET['action'] == "suppression")
{   // $contenu .= $_GET['id_produit']
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit=$_GET[id_produit]");
    $produit_a_supprimer = $resultat->fetch_assoc();
    $chemin_photo_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . $produit_a_supprimer['photo'];
    if(!empty($produit_a_supprimer['photo']) && file_exists($chemin_photo_a_supprimer)) unlink($chemin_photo_a_supprimer);
    $contenu .= '<div class="alert alert-danger">Le produit n° ' . $_GET['id_produit'] . ' a été supprimé </div>';
    executeRequete("DELETE FROM produit WHERE id_produit=$_GET[id_produit]");
    $_GET['action'] = 'affichage';
}
//--- ENREGISTREMENT PRODUIT ---//
if(!empty($_POST))
{   // debug($_POST);
    $photo_bdd = ""; 
    if(isset($_GET['action']) && $_GET['action'] == 'modification')
    {
        $photo_bdd = $_POST['photo_actuelle'];
    }
    if(!empty($_FILES['photo']['name']))
    {   // debug($_FILES);
        $nom_photo = $_POST['reference'] . '_' .$_FILES['photo']['name'];
        $photo_bdd = RACINE_SITE . "photo/$nom_photo";
        $photo_dossier = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . "/photo/$nom_photo"; 
        copy($_FILES['photo']['tmp_name'],$photo_dossier);
    }
    foreach($_POST as $indice => $valeur)
    {
        $_POST[$indice] = htmlEntities(addSlashes($valeur));
    }
    executeRequete("REPLACE INTO produit (id_produit, reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) values ('$_POST[id_produit]', '$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[public]',  '$photo_bdd',  '$_POST[prix]',  '$_POST[stock]')");
    $contenu .= '<div class="alert alert-success">Le produit a été ajouté</div>';
    $_GET['action'] = 'affichage';
}
//--- LIENS PRODUITS ---//
$contenu .= '<br><br><a class="abutton" href="?action=affichage">Afficher les produits</a>';
$contenu .= '<a  class="abutton" href="?action=ajout">Ajouter un produit</a><br><br><hr><br>';
//--- AFFICHAGE PRODUITS ---//
if(isset($_GET['action']) && $_GET['action'] == "affichage")
{
    $resultat = executeRequete("SELECT * FROM produit");
     

    $contenu .= '<h2 id="tarticle"> Produits dans la boutique : </h2>';
    $contenu .= '<p id="particle" >Nombre d\'éléments dans la boutique : ' . $resultat->num_rows . '</p>';
    $contenu .= '<table border="1" cellpadding="5" class="table table-bordered" id="atable" size="100px"><tr>';
     
    while($colonne = $resultat->fetch_field())
    {    
        $contenu .= '<th>' . $colonne->name . '</th>';
    }
    $contenu .= '<th>Modifier</th>';
    $contenu .= '<th>Supprimer</th>';
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
        $contenu .= '<td><a href="?action=modification&id_produit=' . $ligne['id_produit'] .'"><img src="../photo/editer.png" width="24px"></a></td>';
        $contenu .= '<td><a href="?action=suppression&id_produit=' . $ligne['id_produit'] .'" OnClick="return(confirm(\'Voulez vous vraiment supprimer cette article ?\'));"><img src="../photo/supprimer.png" width="24px"></a></td>';
        $contenu .= '</tr>';
    }
    $contenu .= '</table><br><br>';
}
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
    echo '
    <div class="card" >
  <div class="card-body" >
  
    <h1 id="atitre"> formulaire à remplir !! </h1>
    <form method="post" enctype="multipart/form-data" action="">
     
        <input type="hidden" id="id_produit" name="id_produit" value="'; if(isset($produit_actuel['id_produit'])) echo $produit_actuel['id_produit']; echo '">
        <input type="text" class="farticle" id="reference" name="reference" placeholder="Référence du produit" value="'; if(isset($produit_actuel['reference'])) echo $produit_actuel['reference']; echo '">
        <input type="text" class="farticle" id="categorie" name="categorie" placeholder="Catégorie du produit" value="'; if(isset($produit_actuel['categorie'])) echo $produit_actuel['categorie']; echo '" >
        <input type="text" class="farticle" id="titre" name="titre" placeholder="Titre du produit" value="'; if(isset($produit_actuel['titre'])) echo $produit_actuel['titre']; echo '" >
        <input name="description" class="farticle" id="description" placeholder="déscription du produit"'; if(isset($produit_actuel['description'])) echo $produit_actuel['description']; echo '>
        <input type="text" class="farticle" id="couleur" name="couleur" placeholder="Couleur du produit"  value="'; if(isset($produit_actuel['couleur'])) echo $produit_actuel['couleur']; echo '"> 
        <input type="text" class="farticle" id="prix" name="prix" placeholder="Prix du produit"  value="'; if(isset($produit_actuel['prix'])) echo $produit_actuel['prix']; echo '">
        <input type="text" class="farticle" id="stock" name="stock" placeholder="Stock du produit"  value="'; if(isset($produit_actuel['stock'])) echo $produit_actuel['stock']; echo '">
        <input type="radio" class="fh" name="public" value="m"'; if(isset($produit_actuel) && $produit_actuel['public'] == 'm') echo ' checked '; elseif(!isset($produit_actuel) && !isset($_POST['public'])) echo 'checked'; echo '>Homme
        <input type="radio" class="fh" name="public" value="f"'; if(isset($produit_actuel) && $produit_actuel['public'] == 'f') echo ' checked '; echo '>Femme<br><br>
        
        <input class="form-control" type="file" name="photo" id="formFile">';
        if(isset($produit_actuel))
        {
            // echo '<i>Vous pouvez changer la photo </i><br>';
            // echo '<img src="' . $produit_actuel['photo'] . '"  ="90" height="90"><br>';
            echo '<input type="hidden" name="photo_actuelle" value="' . $produit_actuel['photo'] . '"><br>';
        }
         
        echo '
        
        
        <input id="valider" id="ttaille" type="submit" value="Valider">
    </form>
    </div></div>';
}
require_once("../inc/footer.php"); ?>