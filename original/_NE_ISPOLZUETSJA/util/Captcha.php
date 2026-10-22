<?php
// On crée la session avant tout
// @session_start();

// On définit la configuration :
$nbr_chiffres = 6; // Nombre de chiffres qui formeront le nombre

// Là, on définit le header de la page pour la transformer en image
// header ("Content-type: image/png");
// Là, on crée notre image
$_img = imagecreatefrompng('fond_verif_img.png');

// On définit maintenant les couleurs
// Couleur de fond :
$arriere_plan = imagecolorallocate($_img, 0, 0, 0); // Au cas où on n'utiliserait pas d'image de fond, on utilise cette couleur-là.
// Autres couleurs :
$avant_plan = imagecolorallocate($_img, 255, 255, 255); // Couleur des chiffres

##### Ici on crée la variable qui contiendra le nombre aléatoire #####
$i = 0;
while($i < $nbr_chiffres) {
        $chiffre = mt_rand(0, 9); // On génère le nombre aléatoire
        $chiffres[$i] = $chiffre;
        $i++;
}
$nombre = null;
// On explore le tableau $chiffres afin d'y afficher toutes les entrées qui s'y trouvent
foreach ($chiffres as $caractere) {
        $nombre .= $caractere;
}
##### On a fini de créer le nombre aléatoire, on le rentre maintenant dans une variable de session #####
$_SESSION['aleat_nbr'] = $nombre;

// On détruit les variables inutiles :
unset($chiffre);
unset($i);
unset($caractere);
unset($chiffres);

imagestring($_img, 5, 18, 8, $nombre, $avant_plan);
$red = imagecolorallocate($_img, 0, 255, 0);
imagesetthickness($_img, 1);
imageline($_img, 0, 10, 100, 20, $red);
// imageline(image, x1, y1, x2, y2, color);

imagepng($_img);