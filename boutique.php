<?php
require_once ("../bdd/init.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- AFFICHAGE DES CATEGORIES ---//
$categories_des_produits = executeRequete("SELECT DISTINCT categorie FROM produit");
$contenu .= ' <div class="boutiqueA"> <div class="boutique-gauche" >';
$contenu .= "<ul>";
while($cat = $categories_des_produits->fetch_assoc())
{
    $contenu .= "<li><a href='?categorie=" . $cat['categorie'] . "'>" . $cat['categorie'] . "</a></li>";
}
$contenu .= "</ul>";
$contenu .= "</div> ";
//--- AFFICHAGE DES PRODUITS ---//
$contenu .= '<div class="boutiqueC" >';
if(isset($_GET['categorie']))
{
    $donnees = executeRequete("select id_produit,reference,titre,photo,prix from produit where categorie='$_GET[categorie]'");  
    while($produit = $donnees->fetch_assoc())
    {
        $contenu .='<div class="boutiquep">';
        $contenu .= '<div class="boutique-produit">';
        $contenu .= "<a href=\"fiche_produit.php?id_produit=$produit[id_produit]\"><img src=\"$produit[photo]\" =\"230\" height=\"200\"></a>";
        $contenu .= "<h2>$produit[titre]</h2>";
        $contenu .= "<p>$produit[prix] €</p>";
        // $contenu .= '<a href="fiche_produit.php?id_produit=' . $produit['id_produit'] . '">Voir la fiche</a>';
        $contenu .= '</div>';
        $contenu .='</div>';
    }
   
}else{
    $contenu .='<div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active" data-bs-interval="10000">
        <img src="../photo/photoc1.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item" data-bs-interval="2000">
        <img src="../photo/photoc3.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="../photo/photoc2.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>';
}
$contenu .= '</div></div>';
//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("../inc/header.php");
echo $contenu;

require_once("../inc/footer.php"); ?>

