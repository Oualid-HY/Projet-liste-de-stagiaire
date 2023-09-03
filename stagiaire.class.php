<?php
include_once "database.class.php";

class Stagiaire {

    private $id;
    private $nom;
    private $prenom;
    
    // Création de la liste des Stagiaires
    public function get_all_stagiaires(){
        
        $pdo = Database::connect();
        $stagiaires = array();
        $sql = "SELECT * from membres";

        foreach ($pdo->query($sql) as $row) {
            $stagiaires[] = $row;
        }
        return $stagiaires;
        Database::disconnect();
    }

    // Suppression d'un Stagiaire par id
    public function delete_stagiaire_by_id($id){
        
        $this->id = $id;
        
        $pdo = Database::connect();
        $sql = "DELETE FROM membres WHERE id_membre = :id";
        $reponse = $pdo->prepare($sql);
        $reponse->bindValue(":id", intval($this->id), PDO::PARAM_INT);
        $reponse->execute();
        Database::disconnect();

    }

    public function ajouter_stagiaire($nom, $prenom){
        
        $this->nom = $nom;
        $this->prenom = $prenom;
        
        $pdo = Database::connect();
        $sql = "INSERT INTO membres(nom_membre, login_membre) VALUES (:nom, :prenom)";
        $reponse = $pdo->prepare($sql);
        $reponse->bindParam(':nom',  $this->nom);
        $reponse->bindParam(':prenom', $this->prenom);
        $reponse->execute();
        Database::disconnect();

    }

    public function modifier_stagiaire($nom, $prenom, $id){

        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        
        $pdo = Database::connect();
        $sql = "UPDATE membres SET nom_membre = :nom , login_membre = :prenom WHERE id_membre = :id";
        $reponse = $pdo->prepare($sql);
        $reponse->bindParam(':nom', $this->nom);
        $reponse->bindParam(':prenom', $this->prenom);
        $reponse->bindParam(':id', $this->id, PDO::PARAM_INT);
        $reponse->execute();
        Database::disconnect();

    }

    public function get_stagiaire_by_id($id){
        
        $this->id = $id;

        $pdo = Database::connect();
        $sql = "SELECT * from membres WHERE id_membre = :id";
        $reponse = $pdo->prepare($sql);
        $reponse->bindParam(':id',  $this->id, PDO::PARAM_INT);
        $reponse->execute();
        return $reponse->fetch();
        Database::disconnect();
    }


    // Méthode de contrôle des champs de saisie des champs des formulaires
    // d'Insertion et de Modification
    function control_form_fields($prenom, $nom)
    {
        
        $this->nom = $nom;
        $this->prenom = $prenom;

        $erreurs = array();

        if ((!empty($this->nom)) && (!empty($this->prenom))) {

            if (!preg_match("#^[A-Za-z-']{2,}$#", $this->nom)) {

                $erreurs["nom"] = "Veuillez saisir un nom valide !<br>";
            }

            if (!preg_match("#^[A-Za-z-']{2,}$#", $this->prenom)) {

                $erreurs["prenom"] = "Veuillez saisir un prénom valide !<br>";
            }
        } else {

            if (empty($this->nom)) {

                $erreurs["nom"] = "Veuillez saisir un nom pour le stagiaire !";
            } else {

                if (!preg_match("#^[A-Za-z-']{2,}$#", $this->nom)) {

                    $erreurs["nom"] = "Veuillez saisir un nom valide !<br>";
                }
            }

            if (empty($this->prenom)) {

                $erreurs["prenom"] = "Veuillez saisir un prénom pour le stagiaire !";
            } else {

                if (!preg_match("#^[A-Za-z-']{2,}$#", $this->prenom)) {

                    $erreurs["prenom"] = "Veuillez saisir un prénom valide !<br>";
                }
            }
        }

        return $erreurs;
    }

}