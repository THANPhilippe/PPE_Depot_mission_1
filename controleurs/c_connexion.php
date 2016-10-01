<?php
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
			connecter($id,$nom,$prenom);
			include("vues/v_sommaire.php");
		}
                elseif (is_array($comptable)) {
                        $_SESSION["comptable"]=true;
                        $_SESSION["visiteur"]=false;
                        $idcomptable = $comptable['id'];
			$nomcomptable =  $comptable['nom'];
			$prenomcomptable = $comptable['prenom'];
			connecter($idcomptable,$nomcomptable,$prenomcomptable);
			include("vues/v_comptable.php");     
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