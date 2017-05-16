<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   
        private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname= ymarivint';   		
      	private static $user='ymarivint' ;    		
      	private static $mdp='Iegie1ae' ;	
	private static $monPdo;
	private static $monPdoGsb=null;
    
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
/**
 * Retourne les informations d'un visiteur
 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
*/
	public function getInfosVisiteur($login, $mdp){
		$req = "select visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom from visiteur 
		where visiteur.login='$login' and visiteur.mdp='$mdp'";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}
/**
 * Retourne les informations nom et prenom d'un visiteur
 
 * @param $idVisiteur
 * @return nom et prenom sous la forme d'un tableau associatif 
*/
        public function getInfosNomPrenom($idVisiteur){
		$req = "SELECT nom as nom,prenom as prenom FROM visiteur WHERE id = '$idVisiteur' ";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}
        
        /**
 * Retourne les informations d'un admin
 
 * @param $logincomptable
 * @param $mdpcomptable
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
*/
	public function getInfosComptable($logincomptable, $mdpcomptable){
		$req = "select comptable.id as id, comptable.nom as nom, comptable.prenom as prenom from comptable  
		where comptable.login='$logincomptable' and comptable.mdp='$mdpcomptable'"; // a optimiser
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}

/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
 * concernées par les deux arguments
 
 * La boucle foreach ne peut être utilisée ici car on procède
 * à une modification de la structure itérée - transformation du champ date-
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
*/
	public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idvisiteur ='$idVisiteur' 
		and lignefraishorsforfait.mois = '$mois' ";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		$nbLignes = count($lesLignes);
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['date'];
			$lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
		}
		return $lesLignes; 
	}
        
/**
 * Retourne le nombre de justificatif d'un visiteur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return le nombre entier de justificatifs 
*/
	public function getNbjustificatifs($idVisiteur, $mois){
		$req = "select fichefrais.nbjustificatifs as nb from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne['nb'];
	}
/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
*/
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, 
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait 
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois' 
		order by lignefraisforfait.idfraisforfait";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
        
        
/**
 * Retourne tous les id de la table FraisForfait
 
 * @return un tableau associatif 
*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
/**
 * Met à jour la table ligneFraisForfait
 
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return un tableau associatif 
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idvisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			PdoGsb::$monPdo->exec($req);
		}
		
	}
        
        	public function majMois($idVisiteur, $mois, $MoisModif){
			$req = "update lignefraisforfait set lignefraisforfait.mois = '$MoisModif'
			where lignefraisforfait.idvisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'";
			PdoGsb::$monPdo->exec($req);
		}
                
/**
 * met à jour le nombre de justificatifs de la table ficheFrais
 * pour le mois et le visiteur concerné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update fichefrais set nbjustificatifs = $nbJustificatifs 
		where fichefrais.idvisiteur = '$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);	
	}
/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux 
*/	
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un visiteur
 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}
	
/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
 
 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
				
		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values('$idVisiteur','$mois',0,0,now(),'CR')";
		PdoGsb::$monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values('$idVisiteur','$mois','$unIdFrais',0)";
			PdoGsb::$monPdo->exec($req);
		 }
	}
/**
 * Crée un nouveau frais hors forfait pour un visiteur un mois donné
 * à partir des informations fournies en paramètre
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
        public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
            $dateFr = dateFrancaisVersAnglais($date);
            $req = "insert into lignefraishorsforfait (idVisiteur,mois,libelle,date,montant)
                values('$idVisiteur','$mois','$libelle','$dateFr','$montant')";
                PdoGsb::$monPdo->exec($req);
        }
        
/**
 * Supprime le frais hors forfait dont l'id est pass� en argument
 
 * @param $idFrais 
*/
	public function reporterFraisHorsForfait($idFrais){
		$req = "select mois from lignefraishorsforfait where lignefraishorsforfait.id =$idFrais ";
		$q = PdoGsb::$monPdo->query($req);
                $mois = $q->fetch()[0];
                $numAnnee =substr($mois,0,4);
                $numMois =substr($mois,4,2);
                $numMoisUnChiffre = substr($mois,5,1);
                $numAnnee = intval($numAnnee);
                $numMois = intval($numMois);
                $numMoisUnChiffre = intval($numMoisUnChiffre);
                $leMois=0;
                if($numMois != 12){
                    if($numMois >= 10){
                        $leMois = $numMois +=1;
                    }else{
                        $leMois = $numMoisUnChiffre += 1;
                    }
                }else{
                    $numAnnee += 1;
                    $leMois = 01;
                }
                echo $req;
                echo "<br>";
                $req = "update lignefraishorsforfait set mois='$numAnnee$leMois' where lignefraishorsforfait.id =$idFrais ";
                echo $req;
                PdoGsb::$monPdo->exec($req);
	}
/**
 * Supprime le frais hors forfait dont l'id est pass� en argument
 
 * @param $idFrais 
*/
	public function supprimerFraisHorsForfait($idFrais){
		$req = "select libelle from lignefraishorsforfait where lignefraishorsforfait.id =$idFrais ";
		$q = PdoGsb::$monPdo->query($req);
                $libelle = $q->fetch()[0];
                $req = "update lignefraishorsforfait set libelle= 'REFUSE : $libelle' where lignefraishorsforfait.id =$idFrais ";
                PdoGsb::$monPdo->exec($req);
	}
/**
 * Retourne les mois pour lesquel un visiteur a une fiche de frais
 
 * @param $idVisiteur 
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' 
		order by fichefrais.mois desc ";
		$res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
	}
        
/**
 * Retourne les fiches pour lesquel l'etat est VA
 
 * @return lesFiches
*/
	public function getLesFichesValidePaiement(){
		$req = "select nom,prenom,mois,idVisiteur from fichefrais join visiteur on visiteur.id=fichefrais.idVisiteur where fichefrais.idetat='VA' 
		order by fichefrais.mois desc ";
		$res = PdoGsb::$monPdo->query($req);
		$lesFiches = $res->fetchAll();
		return $lesFiches;
	}
        
        
        
/**
 * Retourne les mois pour lesquel un visiteur a une fiche de frais a VALIDER
 
 * @param aucun param�tre
 * @return un tableau associatif des mois correspondant � la requete
*/
        public function getToutLesMoisDisponiblesComptable(){
		$req = "SELECT fichefrais.mois as mois FROM fichefrais WHERE idEtat = 'CL' order by fichefrais.mois desc ";
		$res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		     "numAnnee"  => "$numAnnee",
                     "numMois"  => "$numMois"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
	}
        
/**
 * Retourne les visiteurs pour lesquel un visiteur a une fiche de frais a VALIDER en fonctione du MOIS selectionn�
 
 * @param leMois
 * @return un tableau associatif des visiteurs correspondant � la requete
*/
        
        public function getToutesLesFichesDisponiblesComptable($leMois){
		$req = "SELECT id as visiteur,nom as nom,prenom as prenom FROM visiteur JOIN fichefrais WHERE id = idVisiteur AND mois='$leMois' and idEtat = 'CL' ";
		$res = PdoGsb::$monPdo->query($req);
		$lesVisiteurs =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
                        $visiteur = $laLigne['visiteur'];
			$nom = $laLigne['nom'];
                        $prenom = $laLigne['prenom'];
			$lesVisiteurs["$visiteur"]=array(
                     "visiteur"=>"$visiteur",
		     "nom"=>"$nom",
                     "prenom"  => "$prenom"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesVisiteurs;
	}
        
        
        
/**
 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs, 
			fichefrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join etat on fichefrais.idEtat = etat.id 
			where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$LaLigne = $res->fetch();
		return $LaLigne;
	}

 /**
 * Modifier le statut d'une fiche de frais en VALIDE
 
 * @param $idVisiteur 
 * @param $numAnnee
 * @param $numMois
*/	
        public function ValiderFiche($idVisiteur, $numAnnee, $numMois){
                $req = "update fichefrais set idEtat = 'VA' where mois=$numAnnee$numMois and idVisiteur='$idVisiteur' ";
		PdoGsb::$monPdo->exec($req);
	}
 /**
 * Modifier le statut d'une fiche de frais en VALIDE
 
 * @param $idVisiteur 
 * @param $numAnnee
 * @param $numMois
*/	
        public function miseEnPaiementFiche($idVisiteur, $numAnnee, $numMois){
                $req = "update fichefrais set idEtat = 'MP' where mois=$numAnnee$numMois and idVisiteur='$idVisiteur' ";
		PdoGsb::$monPdo->exec($req);
	}
        
        
/**
 * Modifie l'état et la date de modification d'une fiche de frais
 
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
 
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = '$etat', dateModif = now() 
		where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);
	}
       
 /**
  * R�cup�re les informations n�cessaire du frais forfait du visiteur pour la cr�ation du PDF
  * @param type $idVisiteur
  * @param type $mois
  * @return type
  */
        
        public function FraisForfaitPDF($idVisiteur, $mois){
                $req = "select distinct fraisforfait.libelle, lignefraisforfait.quantite,fraisforfait.montant from lignefraisforfait join fraisforfait on lignefraisforfait.idFraisForfait=fraisforfait.id where idVisiteur='$idVisiteur' and mois='$mois'";
                $res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
        
 /**
  * R�cup�re les informations n�cessaire du frais hors forfait du visiteur pour la cr�ation du PDF
  * @param type $idVisiteur
  * @param type $mois
  * @return type
  */
        
        public function FraisHorsForfaitPDF($idVisiteur, $mois){
                $req = "select lignefraishorsforfait.date, lignefraishorsforfait.montant,lignefraishorsforfait.libelle from lignefraishorsforfait where idVisiteur='$idVisiteur' and mois='$mois'";
                $res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
        
/**
 * Cr�ation du PDF de la fiche de frais du mois s�lectionn�
 * @param type $lesFraisForfait
 * @param type $lesFraisHorsForfait
 * @param type $mois
 * @param type $nomVisiteur
 */
        public function creerPDF($lesFraisForfait, $lesFraisHorsForfait, $mois, $Visiteur){
                require('fpdf/fpdf.php');
                ob_get_clean();
                $annee=substr($mois, 0,-2);
                $lemois=substr($mois, -2);
                $pdf=new FPDF();
                $ColonneF = array('Frais Forfaitaires','Quantite','Montant unitaire','Total');
                $ColonneHF = array('Date','Libell�','Montant');
                $pdf->AddPage();
                $pdf->SetFont('Times','B',16);
                $pdf->SetTextColor(0,0,0);
                $pageWidth = 200;
                $pageHeight = 286;
                $margin = 10;
                $pdf->Rect(10,50,190,210);
                $pdf->Image("images/logo.jpg", 77, 10, 50, 36);
                $pdf->SetDrawColor(48,69,111);
                $pdf->SetLineWidth(0.2);
                $pdf->Text(65,60,"ETAT DE FRAIS ENGAGES");
                $pdf->SetFont('Times','B',12);
                $pdf->SetTextColor(48,69,111);
                $pdf->Text(18,80,"A retourner accompagn� des justificatifs au plus tard le 10 du mois qui suit lengagement des frais");
                foreach($Visiteur as $leVisiteur){
                    $nom = $leVisiteur['nom'];
                    $prenom = $leVisiteur['prenom'];
                }
                $pdf->SetFont('Times','B',13);
                $pdf->Text(18,90,"Visiteur: ");
                $pdf->SetFont('Times','u',13);
                $pdf->SetTextColor(0,0,0);
                $pdf->Text(40,90,$nom." ".$prenom);
                $pdf->SetFont('Times','B',13);
                $pdf->SetTextColor(48,69,111);
                $pdf->Text(18,100,"Mois: ");
                $pdf->SetFont('Times','u',13);
                $pdf->SetTextColor(0,0,0);
                $pdf->Text(40,100,$lemois."-".$annee);
                $pdf->Ln();
                $pdf->SetFont('Times','BI',13);
                $pdf->SetTextColor(48,69,111);
                $pdf->SetY(120);    // indique la position du curseur en Y
                $pdf->SetX(17);    // indique la position du curseur en X
                $pdf->Cell(50,7,$ColonneF[0],1,0,'C');
                $pdf->Cell(30,7,$ColonneF[1],1,0,'C');
                $pdf->Cell(60,7,$ColonneF[2],1,0,'C');
                $pdf->Cell(30,7,$ColonneF[3],1,0,'C');
                $pdf->Ln();
                $pdf->SetFont('Times','',13);
                $pdf->SetTextColor(0,0,0);
                foreach($lesFraisForfait as $unFrais){
                    $pdf->SetX(17);
                    $libelle = $unFrais['libelle'];
                    $quantite = $unFrais['quantite'];
                    $montant = $unFrais['montant'];
                    $total = $quantite * $montant;
                    $pdf->Cell(50,6,utf8_decode($libelle),1);
                    $pdf->Cell(30,6,utf8_decode($quantite),1);
                    $pdf->Cell(60,6,utf8_decode($montant),1);
                    $pdf->Cell(30,6,utf8_decode($total),1);
                    $pdf->Ln();
                }
                $pdf->Ln();
                $pdf->SetFont('Times','B',13);
                $pdf->SetTextColor(48,69,111);
                $pdf->Text(90,170,"Autres Frais : ");
                $pdf->SetFont('Times','BI',13);
                $pdf->SetTextColor(48,69,111);
                $pdf->SetY(175);   // indique la position du curseur en Y
                $pdf->SetX(17);    // indique la position du curseur en X
                $pdf->Cell(30,7,$ColonneHF[0],1,0,'C');
                $pdf->Cell(110,7,$ColonneHF[1],1,0,'C');
                $pdf->Cell(30,7,$ColonneHF[2],1,0,'C');
                $pdf->Ln();
                $pdf->SetFont('Times','',13);
                $pdf->SetTextColor(0,0,0);
                foreach($lesFraisHorsForfait as $unFraisHF){
                    $pdf->SetX(17);
                    $libelle = $unFraisHF['libelle'];
                    $date = $unFraisHF['date'];
                    $montant = $unFraisHF['montant'];
                    $pdf->Cell(30,6,utf8_decode($date),1);
                    $pdf->Cell(110,6,utf8_decode($libelle),1);
                    $pdf->Cell(30,6,utf8_decode($montant),1);
                    $pdf->Ln();
                    }
                $pdf->Ln();
                $pdf->SetFont('Times','BI',13);
                $pdf->SetTextColor(48,69,111);
                $pdf->Text(160,270,"Signature");
                $pdf->Output();
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
 
/**
 * R�cup�ration du nom+pr�nom du visiteur
 * @param type $idVisiteur
 * @return type
 */

        public function getNomPrenomVisiteur($idVisiteur){
                $req = "select nom, prenom from visiteur where id='$idVisiteur'";
                $res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
}
?>