<?php
require_once("../bdd/init.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- AJOUT PANIER ---//
if(isset($_POST['ajout_panier'])) 
{   // debug($_POST);
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit='$_POST[id_produit]'");
    $produit = $resultat->fetch_assoc();
    ajouterProduitDansPanier($produit['photo'],$_POST['id_produit'],$_POST['quantite'],$produit['prix']);
}
//--- VIDER PANIER ---//
if(isset($_GET['action']) && $_GET['action'] == "vider")
{
    unset($_SESSION['panier']);
}
//--- PAIEMENT ---//
if(isset($_POST['payer']))
{
    for($i=0 ;$i < count($_SESSION['panier']['id_produit']) ; $i++) 
    {
        $resultat = executeRequete("SELECT * FROM produit WHERE id_produit=" . $_SESSION['panier']['id_produit'][$i]);
        $produit = $resultat->fetch_assoc();
        if($produit['stock'] < $_SESSION['panier']['quantite'][$i])
        {
            $contenu .= '<hr><div class="erreur">Stock Restant: ' . $produit['stock'] . '</div>';
            $contenu .= '<div class="erreur">Quantité demandée: ' . $_SESSION['panier']['quantite'][$i] . '</div>';
            if($produit['stock'] > 0)
            {
                $contenu .= '<div class="erreur">la quantité de l\'produit ' . $_SESSION['panier']['id_produit'][$i] . ' à été réduite car notre stock était insuffisant, veuillez vérifier vos achats.</div>';
                $_SESSION['panier']['quantite'][$i] = $produit['stock'];
            }
            else
            {
                $contenu .= '<div class="erreur">l\'produit ' . $_SESSION['panier']['id_produit'][$i] . ' à été retiré de votre panier car nous sommes en rupture de stock, veuillez vérifier vos achats.</div>';
                retirerProduitDuPanier($_SESSION['panier']['id_produit'][$i]);
                $i--;
            }
            $erreur = true;
        }
    }
    if(!isset($erreur))
    {
        executeRequete("INSERT INTO commande (id_membre, montant, date_enregistrement) VALUES (" . $_SESSION['membre']['id_membre'] . "," . montantTotal() . ", NOW())");
        $id_commande = $mysqli->insert_id;
        for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
        {
            executeRequete("INSERT INTO details_commande (id_commande, id_produit, quantite, prix) VALUES ($id_commande, " . $_SESSION['panier']['id_produit'][$i] . "," . $_SESSION['panier']['quantite'][$i] . "," . $_SESSION['panier']['prix'][$i] . ")");
        }
        unset($_SESSION['panier']);
        // mail($_SESSION['membre']['email'], "confirmation de la commande", "Merci votre n° de suivi est le $id_commande", "From:vendeur@dp_site.com");
        $contenu .= "<div class='alert  alert-light' role='alert'>Merci pour votre commande. votre n° de suivi est le $id_commande</div>";
    }
}
 
//--------------------------------- AFFICHAGE HTML ---------------------------------//
include("../inc/header.php");
echo $contenu;

echo " <div class=\"card\" >";
echo " <div class=\"card-body\" >";


echo "<table  border='1' cellpadding='7' class=\"table table-bordered\" id=\"tabl\">";
echo "<tr ><td colspan='5' id='tpanier' >PANIER !! </td></tr>";
echo "<tr><th></th><th>Produit</th><th>Quantité</th><th>Prix Unitaire</th></tr>";
if(empty($_SESSION['panier']['id_produit'])) // panier vide
{
    echo "<tr><td colspan='5'>Votre panier est vide</td></tr>";
}
else
{
    for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) 
    {
        echo "<tr>";
        echo "<td> <img src=". $_SESSION['panier']['photo'][$i] . " ='70' height='70'></td>";
        // echo "<td>" . $_SESSION['panier']['titre'][$i] . "</td>";
        echo "<td>" . $_SESSION['panier']['id_produit'][$i] . "</td>";
        echo "<td>" . $_SESSION['panier']['quantite'][$i] . "</td>";
        echo "<td>" . $_SESSION['panier']['prix'][$i] . "</td>";
        echo "</tr>";
    }
    echo "<tr><th colspan='3'>Total</th><td colspan='2'>" . montantTotal() . " euros</td></tr>";
    if(internauteEstConnecte()) 
    {
        echo '<form method="post" action="">';
        echo '<tr><td colspan="5"><input type="submit" name="payer" class="payer" value="Valider mon Panier">';
        echo "<a class='bpanier' href='?action=vider'>Vider mon panier</a>";
        echo '</td></tr>';   
        echo '</form>';   
    }
    else
    {
        echo '<tr><td colspan="3">Veuillez vous <a class="lien" href="inscription.php">Inscrire</a> ou vous <a class="lien"  href="connexion.php">Connecter</a> afin de pouvoir payer</td></tr>';
        echo "<tr><td colspan='5' style='padding: 15px 0px 15px 0px;'><a class='bpanier' href='?action=vider'>Vider mon panier</a></td></tr>";
    }
    // echo "<tr><td colspan='5'><a class='bpanier' href='?action=vider'>Vider mon panier</a></td></tr>";
}
echo "</table><br>";
echo "</div>";
echo "</div>";
// echo "<i>Réglement par CHÈQUE uniquement à l'adresse suivante : 300 rue de vaugirard 75015 PARIS</i><br>";
// echo "<hr>session panier:<br>"; debug($_SESSION);
include("../inc/footer.php");
?>