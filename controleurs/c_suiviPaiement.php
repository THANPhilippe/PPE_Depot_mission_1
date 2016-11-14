<?php
$action = $_REQUEST['action'];
if($action!= 'imprimerPDF'){
if($_SESSION["visiteur"]==true){
     include("vues/v_sommaire.php");
}else{
     include("vues/v_sommaireComptable.php");
}
}
switch($action){
	case 'selectionnerFiche':{
		$lesFiches=$pdo->getLesFichesValidePaiement();
		// Afin de se©lectionner par defaut le dernier mois dans la zone de liste
		// on demande toutes les cles, et on prend la premiere,
		// les mois datant tries decroissants
                if(!empty($lesFiches)){
		$lesCles = array_keys( $lesFiches );
		$ficheASelectionner = $lesCles[0];
                 }
		include("vues/v_listeMoisPaiement.php");
		break;
	}
        	case 'voirEtatFiche':{
		$leMois = substr( $_REQUEST['lstFiche'],0,6);
                $idVisiteur = substr ( $_REQUEST['lstFiche'],6); // lenght omis, le string commençant à partir de start jusqu'à la fin sera retournée.
                $leVisiteur=$idVisiteur;
		$lesFiches=$pdo->getLesFichesValidePaiement();
		$ficheASelectionner = $leMois;
		include("vues/v_listeMoisPaiement.php");
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
		include("vues/v_etatFraisPaiement.php");
                break;
	}
                case 'miseEnPaiementFiche':{
                if(!empty($_POST))
                {
                    $leMois = $_POST['leMois'];
                    $idVisiteur = $_POST['idVisiteur'];
                    $numAnnee =substr( $leMois,0,4);
                    $numMois =substr( $leMois,4,2);
                    $pdo->miseEnPaiementFiche($idVisiteur,$numAnnee,$numMois);
                    $infosVisiteur = $pdo->getInfosNomPrenom($idVisiteur);
                    $nom =  $infosVisiteur['nom']; //On recupère le nom et prenom de la fonction ci-dessus pour un affichage dans la vue
                    $prenom = $infosVisiteur['prenom'];
                }
                include("vues/v_etatFraisPaiementValidation.php");
                break;
        }
}
?>