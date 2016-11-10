<?php
$action = $_REQUEST['action'];
if($action!= 'imprimerPDF'){
if($_SESSION["visiteur"]==true){
     include("vues/v_sommaire.php");
}else{
     include("vues/v_comptable.php");
}
}
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){
    	case 'imprimerPDF':{
                $mois=$_REQUEST['mois'];
                $lesFraisHorsForfait = $pdo->FraisHorsForfaitPDF($idVisiteur,$mois);
                $lesFraisForfait = $pdo->FraisForfaitPDF($idVisiteur,$mois);
                $nomVisiteur = $pdo->getNomPrenomVisiteur($idVisiteur);
                include("vues/v_pdf.php");
		break;
	}
	case 'selectionnerMois':{
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		// Afin de se©lectionner par defaut le dernier mois dans la zone de liste
		// on demande toutes les cles, et on prend la premiere,
		// les mois datant tries decroissants
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
		$lesMois=$pdo->getToutLesMoisDisponiblesComptable();//Tous les mois a valider
		$lesCles = array_keys( $lesMois ); 
		$moisASelectionner = $lesCles[0]; //Pour mettre le premier mois en selection de base
		include("vues/v_listeMois.php");
		break;
	}
        case 'selectionnerMoisFicheComptable':{
            //Première liste déroulante
            	$lesMois=$pdo->getToutLesMoisDisponiblesComptable();
                $leMois = $_REQUEST['lstMois']; //On recupère la valeur du précédent formulaire
		$moisASelectionner = $leMois ; //Pour metre le mois selectionné en selection de base
                include("vues/v_listeMois.php");
            //Deuxieme liste deroulante
		$lesVisiteurs=$pdo->getToutesLesFichesDisponiblesComptable($leMois);//Les visiteurs du mois avec une fiche a valider
		include("vues/v_listeVisiteur.php");
            }
		break;
        case 'voirEtatFraisComptable':{
            //Première liste déroulante
            	$lesMois=$pdo->getToutLesMoisDisponiblesComptable();
                $leMois = $_POST['leMois'];//On recupère la valeur du précédent formulaire
		$moisASelectionner = $leMois; //Pour metre le mois selectionné en selection de base
                include("vues/v_listeMois.php");
            //Deuxieme liste deroulante
		$lesVisiteurs=$pdo->getToutesLesFichesDisponiblesComptable($leMois);
                $leVisiteur = $_REQUEST['lstVisiteur'];
                $visiteurASelectionner = $leVisiteur; //Pour metre le visiteur selectionné en selection de base
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
		include("vues/v_etatFraisComptable.php");
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
                $nom =  $infosVisiteur['nom']; //On recupère le nom et prenom de la fonction ci-dessus pour un affichage dans la vue
                $prenom = $infosVisiteur['prenom'];
            }
            include("vues/v_etatFraisValidation.php");
            break;
        }
        
           
        
        case 'validerMajFraisForfaitComptable':{ 
            // On affiche la meme selection qu'auparavant, avec les données modifiées
            //Première liste déroulante
            	$lesMois=$pdo->getToutLesMoisDisponiblesComptable();
                $leMois = $_POST['leMois'];//On recupère la valeur du précédent formulaire
		$moisASelectionner = $leMois; //Pour metre le mois selectionné en selection de base
                include("vues/v_listeMois.php");
            //Deuxieme liste deroulante
		$lesVisiteurs=$pdo->getToutesLesFichesDisponiblesComptable($leMois);
                $leVisiteur = $_POST['leVisiteur'];
                $visiteurASelectionner = $leVisiteur; //Pour metre le visiteur selectionné en selection de base
		include("vues/v_listeVisiteur.php");
            //Affichage de la fiche visiteur pour le mois
                $lesFrais = $_POST['lesFrais'];
                if(lesQteFraisValides($lesFrais)){ // Pour vérifier si les valeurs du tableau sont des entiers
	  	 	$pdo->majFraisForfait($leVisiteur,$leMois,$lesFrais);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent etre numeriques");
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
		include("vues/v_etatFraisComptable.php");
            //Affichage de la modification d'un frais forfait
                include("vues/v_listeFraisForfaitComptable.php");
	  break; 
	}
}
?>