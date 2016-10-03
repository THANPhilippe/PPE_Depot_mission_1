<?php
if($_SESSION["visiteur"]==true){
     include("vues/v_sommaire.php");
}else{
     include("vues/v_comptable.php");
}
$idVisiteur = $_SESSION['idVisiteur'];
$mois = getMois(date("d/m/Y"));
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = $_REQUEST['action'];
switch($action){
	case 'saisirFrais':{
		if($pdo->estPremierFraisMois($idVisiteur,$mois)){
			$pdo->creeNouvellesLignesFrais($idVisiteur,$mois);
		}
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
            $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
            include("vues/v_listeFraisForfait.php");
            include("vues/v_listeFraisHorsForfait.php");
		break;
	}
	case 'validerMajFraisForfait':{
		$lesFrais = $_REQUEST['lesFrais'];
		if(lesQteFraisValides($lesFrais)){
	  	 	$pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent Ãªtre numÃ©riques");
			include("vues/v_erreurs.php");
		}
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
            $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
            include("vues/v_listeFraisForfait.php");
            include("vues/v_listeFraisHorsForfait.php");
	  break;
	}
	case 'validerCreationFrais':{
		$dateFrais = $_REQUEST['dateFrais'];
		$libelle = $_REQUEST['libelle'];
		$montant = $_REQUEST['montant'];
		valideInfosFrais($dateFrais,$libelle,$montant);
		if (nbErreurs() != 0 ){
			include("vues/v_erreurs.php");
		}
		else{
			$pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$dateFrais,$montant);
		}
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
            $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
            include("vues/v_listeFraisForfait.php");
            include("vues/v_listeFraisHorsForfait.php");
		break;
	}
	case 'supprimerFrais':{
            $idFrais = $_REQUEST['idFrais'];
	    $pdo->supprimerFraisHorsForfait($idFrais);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
            $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
            include("vues/v_listeFraisForfait.php");
            include("vues/v_listeFraisHorsForfait.php");
		break;
	}
        
        case 'supprimerFraisComptable':{
            $idFrais = $_REQUEST['idFrais'];
	    $pdo->supprimerFraisHorsForfait($idFrais); //On refuse le frais selectionné
            //Première liste déroulante
            	$lesMois=$pdo->getToutLesMoisDisponiblesComptable();
                $leMois = $_GET['leMois'];//On recupère la valeur du précédent formulaire
		$moisASelectionner = $leMois; //Pour metre le mois selectionné en selection de base
                include("vues/v_listeMois.php");
            //Deuxieme liste deroulante
		$lesVisiteurs=$pdo->getToutesLesFichesDisponiblesComptable($leMois);
                $leVisiteur=$_GET['leVisiteur'];
                $visiteurASelectionner = $leVisiteur; //Pour metre le visiteur selectionné en selection de base
		include("vues/v_listeVisiteur.php");
            //Affichage de la fiche visiteur pour le mois
                $leVisiteur = $_GET['leVisiteur'];
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
		include("vues/v_etatFraisComptable.php");
            //Affichage de la modification possible d'un frais forfait
                include("vues/v_listeFraisForfaitComptable.php");
            break;
	}
       
}

?>