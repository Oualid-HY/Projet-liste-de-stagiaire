<?php
require "stagiaire.class.php";

if(isset($_GET["id"])){
    $id =  $_GET["id"];
    $stagiaire = new Stagiaire();
    $stagiaire->delete_stagiaire_by_id($id);
}

header("Location:index.php");
?>