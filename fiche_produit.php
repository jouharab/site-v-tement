<?php
require_once("../bdd/init.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
if(isset($_GET['id_produit']))  { $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = '$_GET[id_produit]'"); }
if($resultat->num_rows <= 0) { header("location:boutique.php"); exit(); }
 
$produit = $resultat->fetch_assoc();
$contenu .= "<img id=\"iproduit\" src='$produit[photo]' ='150' height='150'>";
$contenu .= "<div id='dproduit'>";
$contenu .= "<h2 id=\"hproduit\" >$produit[titre]</h2><hr id=\"hr\">";
$contenu .= "<h5 id='fcouleur' >$produit[categorie] $produit[couleur]</h5>";
$contenu .= '<label id="ftaille"for="taille">Taille :</label>';
$contenu .= '<select id="ataille" name="taille">';
// if(isset($produit) && $produit['taille'] == 'S'){
    $contenu .= '<option value="S">S</option>';
// }
// if(isset($produit) && $produit['taille'] == 'M'){
    $contenu .= '<option value="M">M</option>';
// }
// if(isset($produit) && $produit['taille'] == 'L'){
    $contenu .= '<option value="L">L</option>';
// }
// if(isset($produit) && $produit['taille'] == 'XL'){
    $contenu .= '<option value="XL">XL</option>';
// }

$contenu .= '</select>';
// $contenu .= "<p  id='ftaille'>Taille : $produit[taille]</p>";
$contenu .= "<h1 id='fprix' >$produit[prix] €</h1>";
$contenu .= "<p id='fdescription'><i> $produit[description]</i></p><br>";

 
if($produit['stock'] > 0)
{
    $contenu .= "<i id=\"nproduit\">Plus que $produit[stock] produits disponible </i><br><br>";
    $contenu .= '<form method="post" action="panier.php">';
        $contenu .= "<input type='hidden' name='id_produit' value='$produit[id_produit]'>";
        $contenu .= '<label  id="qproduit" for="quantite">Quantité : </label>';
        $contenu .= '<select id="quantite" name="quantite">';
            for($i = 1; $i <= $produit['stock'] && $i <= 9; $i++)
            {
                $contenu .= "<option>$i</option>";
            }
        $contenu .= '</select>';
        $contenu .= '<input type="submit" id="aproduit"name="ajout_panier" value="Ajouter au panier" >';
    $contenu .= '</form>';
}
else
{
    $contenu .= 'Rupture de stock !';
}
$contenu .= "<br><a id=\"bproduit\" href='boutique.php?categorie=" . $produit['categorie'] . "'>Retour vers la séléction de " . $produit['categorie'] . "</a>";

$contenu .= "</div>";

//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("../inc/header.php");
echo $contenu;
require_once("../inc/footer.php"); ?> 