<?php
require_once("../bdd/init.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
if(!internauteEstConnecte()) header("location:connexion.php");
// debug($_SESSION);

$contenu .= '<div class="card" >';
$contenu .= '<div class="card-body" >';
$contenu .= '';
$contenu .= '<div class="d-flex text-black">
<div class="flex-shrink-0">
<img src="../photo/photoprofil.png" alt="G" class="img-fluid" style="width: 80px; border-radius: 10px;">
</div>
<div class="flex-grow-1 ms-3">
<p class="t"> Bonjour <strong>' . $_SESSION['membre']['pseudo'] . '</strong> !!</p>
</div>
</div>';

$contenu .= '<table class="table">
  <tbody>
    <tr>
      <td>E-mail: ' . $_SESSION['membre']['email'] . '</td>
    </tr>
    <tr>
      <td>Adresse : ' . $_SESSION['membre']['adresse'] .'</td>
    </tr>
    <tr>
      <td>Code postal: ' . $_SESSION['membre']['code_postal'] . '</td>
    </tr>
    <tr>
      <td>Ville: ' . $_SESSION['membre']['ville'] . '</td>
    </tr>
  </tbody>
</table>';
$contenu .= '<a class="bprofil">Modifier</a>';
$contenu .= '</div>';
$contenu .= '</div>';



//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("../inc/header.php");
echo $contenu;
require_once("../inc/footer.php");