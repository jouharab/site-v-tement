           <!DOCTYPE html>
  <html lang="en">
    <head>
        <!-- <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <link rel="stylesheet" href="<?php echo RACINE_SITE; ?>inc/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
        <title>Bboutique</title>
        <link rel="icon" type="image/ico" href="../photo/LOGO 1.ico" />
    </head>
    <body >
       <!-- <nav class="navbar navbar-expand-lg bg-body-tertiary" -->
      <nav class="navbar navbar-expand-lg " >
        <div class="container-fluid" style="margin-left: 50px ; margin-right: 50px ;" >
         
          
          <?php
                    if(internauteEstConnecteEtEstAdmin())
                    {
                        echo '<a href="' . RACINE_SITE . 'admin/membre.php" class="texte">Gérer les membres</a>';
                        // echo '<a href="' . RACINE_SITE . 'admin/commande.php" class="texte">Gestion des commandes</a>';
                        echo '<a href="' . RACINE_SITE . 'admin/article.php" class="texte">Gérer les articles</a>';
                    }
                    if(internauteEstConnecte())
                    {
                        echo '<img src="../photo/logo1.png" alt=".." style=" width:90px; height: 70px;">';
                        echo '<a href="' . RACINE_SITE . 'pages/boutique.php" class="texte">Acceuil</a>';
                        echo '<a href="' . RACINE_SITE . 'pages/profil.php" class="texte"><img src="../photo/profil.png" alt=".." style=" width:20px; height: 20px;"></a>';
                        echo '<a href="' . RACINE_SITE . 'pages/panier.php" class="texte"><img src="../photo/panier.png" alt=".." style=" width:20px; height: 20px;"></a>';
                        echo '<a href="' . RACINE_SITE . 'pages/connexion.php?action=deconnexion" class="texte">Se déconnecter</a>';
                    }
                    else
                    {
                      echo '<img src="../photo/logo1.png" alt=".." style=" width:90px; height: 70px;">';
                        echo '<a href="' . RACINE_SITE . 'pages/inscription.php" class="texte">Inscription</a>';
                        echo '<a href="' . RACINE_SITE . 'pages/connexion.php" class="texte">Connexion</a>';
                        echo '<a href="' . RACINE_SITE . 'pages/boutique.php" class="texte">Acceuil</a>';
                        echo '<a href="' . RACINE_SITE . 'pages/panier.php" class="texte"><img src="../photo/panier.png" alt=".." style=" width:20px; height: 20px;"></a>';
                    }
                    ?>
          
         
      </div>
      </nav>
    
 

    <!-- </body>
  </html> -->
