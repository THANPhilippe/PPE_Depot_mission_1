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
                break;
	}
        
        case 'selectionnerMoisComptable':{
		$lesMois=$pdo->getToutLesMoisDisponiblesComptable();
		$lesCles = array_keys( $lesMois ); //
		$moisASelectionner = $lesCles[0]; //Pour metre le premier en selection de base
		include("vues/v_listeMois.php");
		break;
	}
        case 'selectionnerMoisFicheComptable':{
            //Premi�re liste d�roulante
            	$lesMois=$pdo->getToutLesMoisDisponiblesComptable();
                $leMois = $_REQUEST['lstMois']; //On recup�re la valeur du pr�c�dent formulaire
		$moisASelectionner = $leMois ; //Pour metre le mois selectionn� en selection de base
                include("vues/v_listeMois.php");
            //Deuxieme liste deroulante
		$lesVisiteurs=$pdo->getToutesLesFichesDisponiblesComptable($leMois); 
		include("vues/v_listeVisiteur.php");
            }
		break;
        case 'voirEtatFraisComptable':{
            //Premi�re liste d�roulante
            	$lesMois=$pdo->getToutLesMoisDisponiblesComptable();
                $leMois = $_POST['leMois'];//On recup�re la valeur du pr�c�dent formulaire
		$moisASelectionner = $leMois; //Pour metre le mois selectionn� en selection de base
                include("vues/v_listeMois.php");
            //Deuxieme liste deroulante
		$lesVisiteurs=$pdo->getToutesLesFichesDisponiblesComptable($leMois);
                $leVisiteur = $_REQUEST['lstVisiteur'];
                $visiteurASelectionner = $leVisiteur; //Pour metre le visiteur selectionn� en selection de base
		include("vues/v_listeVisiteur.php");
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
            //Affichage de la modification possible d'un frais forfait
                include("vues/v_listeFraisForfaitComptable.php");
                break;
	}
      
        case 'validerFrais':{
            if(!empty($_POST))
            {
                $leMois = $_POST['leMois'];
                $idVisiteur = $_POST['leVisiteur'];
                $numAnnee =substr( $leMois,0,4);
                $numMois =substr( $leMois,4,2);
                $pdo->Valider($idVisiteur,$numAnnee,$numMois);
                $infosVisiteur = $pdo->getInfosNomPrenom($idVisiteur);
                $nom =  $infosVisiteur['nom'];
                $prenom = $infosVisiteur['prenom'];
            }
            include("vues/v_etatFraisValidation.php");
            break;
        }
        
           
        
        case 'validerMajFraisForfaitComptable':{ 
            if(isset($_POST['$leMois'])&&isset($_POST['$leVisiteur'])){
            // On affiche la meme selection qu'auparavant, avec les donn�es modifi�es
            //Premi�re liste d�roulante
            	$lesMois=$pdo->getToutLesMoisDisponiblesComptable();
                $leMois = $_POST['leMois'];//On recup�re la valeur du pr�c�dent formulaire
		$moisASelectionner = $leMois; //Pour metre le mois selectionn� en selection de base
                include("vues/v_listeMois.php");
            //Deuxieme liste deroulante
		$lesVisiteurs=$pdo->getToutesLesFichesDisponiblesComptable($leMois);
                $leVisiteur = $_POST['leVisiteur'];
                $visiteurASelectionner = $leVisiteur; //Pour metre le visiteur selectionn� en selection de base
		include("vues/v_listeVisiteur.php");
            //Affichage de la fiche visiteur pour le mois
                $lesFrais = $_POST['lesFrais'];
                if(lesQteFraisValides($lesFrais)){
	  	 	$pdo->majFraisForfait($leVisiteur,$leMois,$lesFrais);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include("vues/v_erreurs.php");
		}
                
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
            //Affichage de la modification d'un frais forfait
                include("vues/v_listeFraisForfaitComptable.php");
            }
	  break;
	}
}
?>