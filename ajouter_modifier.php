<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Stagiaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php

    require "stagiaire.class.php";

    // Fonction qui supprime les espaces en début et fin de chaîne, supprime les antislashes, convertit les
    // caractères spéciaux en entités HTML 
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Si nous sommes dans le cas d'une modification des données ou d'une simple insertion
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $paramUrl = "?id=" . $id . "&modif=true";
    } else {
        $paramUrl = "";
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
        }
    }

    // Création de l'objet $stagiaire pour accéder aux méthodes utilitaires de la classe Stagiaire
    $stagiaire = new Stagiaire();
    if (isset($id)) {
        $donnees = $stagiaire->get_stagiaire_by_id($id);
    }

    // Si le Bouton de soumission "Envoyer" du formulaire a été activé on traite les données du formulaire et 
    // s'il y a des erreurs on les collecte dans un tableau associatif.
    // S'il n'y a pas d'erreur on gère l'insertion et/ou la modification en Bdd
    if (isset($_POST["submit"])) {
        
        if(isset($_POST["nom"])&&isset($_POST["prenom"])){

            $nom = test_input(strtoupper($_POST["nom"]));
            $prenom = test_input(ucfirst($_POST["prenom"]));
        }
        
        $erreurs = $stagiaire->control_form_fields($prenom, $nom);

        if (empty($erreurs)) {

            if (isset($_GET["modif"])) {

                $id = $_GET["id"];

                if (isset($id)) {

                    $stagiaire->modifier_stagiaire($nom, $prenom, $id);
                }
            } else {

                $stagiaire->ajouter_stagiaire($nom, $prenom);
            }

            header('Location: index.php');
        }
    }
    ?>
    <h1><?php if (isset($_GET["modif"])) {
            echo $titre = "Modification d'un Stagiaire";
        } else {
            echo $titre = "Ajouter un Stagiaire";
        } ?></h1>
    <form class="container" action="<?= $_SERVER['SCRIPT_NAME'] . $paramUrl; ?>" method="POST" id="monform">
        <table class="table table-dark table-striped">
            <tr>
                <td><label for="prenom">Prénom</label></td>
                <td><input type="text" name="prenom" id="prenom" value="<?php
                                                                        if (!empty($_POST["prenom"])) {
                                                                            echo $_POST["prenom"];
                                                                        } else {

                                                                            if (isset($_GET["modif"])) {

                                                                                echo $donnees["login_membre"];
                                                                            }
                                                                        }
                                                                        ?>" autocomplete="off"></td>
                <td class="tderreur">
                    <div class="erreur"><?php if (!empty($erreurs["prenom"])) {
                                            echo $erreurs["prenom"];
                                        } ?></div>
                </td>
            </tr>
            <tr>
                <td><label for="nom">Nom</label></td>
                <td><input type="text" name="nom" id="nom" value="<?php
                                                                    if (!empty($_POST["nom"])) {
                                                                        echo $_POST["nom"];
                                                                    } else {

                                                                        if (isset($_GET["modif"])) {

                                                                            echo $donnees["nom_membre"];
                                                                        }
                                                                    }
                                                                    ?>" autocomplete="off"></td>
                <td class="tderreur">
                    <div class="erreur"><?php if (!empty($erreurs["nom"])) {
                                            echo $erreurs["nom"];
                                        } ?></div>
                </td>
            </tr>
            <tr>
                <td><input type="submit" id="submit" name="submit" value="Envoyer"></td>
                <td><input type="reset" id="reset" value="Annuler"></td>
                <td class="tderreur">
                </td>
            </tr>
        </table>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/script.js"></script>
</body>

</html>