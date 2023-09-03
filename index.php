<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des Stagiaires</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php

    require "stagiaire.class.php";

    $stagiaire = new Stagiaire();
    $stagiaires = $stagiaire->get_all_stagiaires();

    ?>
    <h1>Liste des Membres</h1>
    <table class="montableau">
        <tr>
            <th> ID Membre </th>
            <th> Prénom Membre </th>
            <th> Nom Membre </th>
            <th> Suppression </th>
        </tr>
        <?php
            foreach ($stagiaires as $item) {
                echo "<tr>";
                echo "<td class='colid'> $item[id_membre] </td>";
                echo "<td><a href=ajouter_modifier.php?id=$item[id_membre]&modif=true> $item[login_membre] </a></td>";
                echo "<td> $item[nom_membre] </td>";
                echo "<td class='colsuppr'><a href=supprimer.php?id=$item[id_membre]>Supprimer</a></td>";
                echo "</tr>";
            }
        ?>
        <tr><td id= "montdajout" colspan=4><a href="ajouter_modifier.php">Ajouter un Stagiaire</a></td></tr>
    </table>
</body>
</html>