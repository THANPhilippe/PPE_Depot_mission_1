﻿<?php
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
    case 'demandeConnexion':{
	include("vues/v_connexion.php");
	break;
    }
    case 'valideConnexion':{
	$login = $_REQUEST['login'];
	$mdp = md5($_REQUEST['mdp']);
	$visiteur = $pdo->getInfosVisiteur($login,$mdp);
        $comptable = $pdo->getInfosComptable($login,$mdp);//a optimiser
        if (is_array($visiteur)){
            $_SESSION["visiteur"]=true;
            $_SESSION["comptable"]=false;
            $id = $visiteur['id'];
            $nom =  $visiteur['nom'];
            $prenom = $visiteur['prenom'];
            $type = "VISITEUR";
            connecter($id,$nom,$prenom);
            include("vues/v_sommaire.php");
            include("vues/v_accueilConnexion.php");
	}
        elseif (is_array($comptable)) {
            $_SESSION["visiteur"]=false;
            $_SESSION["comptable"]=true;
            $id = $comptable['id'];
            $nom =  $comptable['nom'];
            $prenom = $comptable['prenom'];
            $type = "COMPTABLE";
            connecter($id,$nom,$prenom);
            include("vues/v_sommaireComptable.php");
            include("vues/v_accueilConnexion.php");
        }
        else{
            ajouterErreur("Login ou mot de passe incorrect");
            include("vues/v_erreurs.php");
            include("vues/v_connexion.php");
	}
        break;
    }
    default :{
	include("vues/v_connexion.php");
	break;
    }
}
?>