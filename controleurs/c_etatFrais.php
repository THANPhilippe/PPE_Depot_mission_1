﻿<?php
if($_SESSION["visiteur"]==true){
     include("vues/v_sommaire.php");
}else{
     include("vues/v_comptable.php");
}
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){
	case 'selectionnerMois':{
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
		include("vues/v_listeMois.php");
		break;
	}
        	case 'voirEtatFrais':{
		$leMois = $_REQUEST['lstMois']; 
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $leMois;
		include("vues/v_listeMois.php");
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_etatFrais.php");
	}
        
        case 'selectionnerMoisComptable':{
		$lesMois=$pdo->getToutLesMoisDisponibles();
		$lesCles = array_keys( $lesMois ); //
		$moisASelectionner = $lesCles[0]; //Pour metre le premier en selection de base
		include("vues/v_listeMois.php");
		break;
	}
        case 'selectionnerMoisFicheComptable':{
            //Premi�re liste d�roulante
            	$lesMois=$pdo->getToutLesMoisDisponibles();
		$lesCles = array_keys( $lesMois ); //
		$moisASelectionner = $lesCles[0]; //Pour la premi�re valeur de la liste
            //Deuxieme liste deroulante
                $leMois = $_REQUEST['lstMois'];
		$lesVisiteurs=$pdo->getToutLesFichesDisponiblesComptable($leMois);
		include("vues/v_listeMois.php");
		break;
	}
        case 'voirEtatFraisComptable':{
            //Premi�re liste d�roulante
            	$lesMois=$pdo->getToutLesMoisDisponibles();
		$lesCles = array_keys( $lesMois ); //
		$moisASelectionner = $lesCles[0]; //Pour la premi�re valeur de la liste
            //Deuxieme liste deroulante
                $leMois = $_GET['leMois'];//On recup�re la valeur du pr�c�dent formulaire
		$lesVisiteurs=$pdo->getToutLesFichesDisponiblesComptable($leMois);
		include("vues/v_listeMois.php");
            //Affichage de la fiche visiteur pour le mois
                $leVisiteur = $_REQUEST['lstVisiteur']; 
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($leVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_etatFrais.php");
	}

        
        
        
      
}
?>