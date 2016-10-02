﻿
<br><br><br>
<h2>Fiche de frais du <?php echo $numMois."-".$numAnnee?> : 
    </h2>
    <div class="encadre">
    <p>
        Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> Montant validé : <?php echo $montantValide?>
              
                     
    </p>
  	<table class="listeLegere">
  	   <caption>Eléments forfaitisés </caption>
        <tr>
         <?php
         foreach ( $lesFraisForfait as $unFraisForfait ) 
		 {
			$libelle = $unFraisForfait['libelle'];
		?>	
			<th> <?php echo $libelle?></th>
		 <?php
        }
		?>
		</tr>
        <tr>
        <?php
          foreach (  $lesFraisForfait as $unFraisForfait  ) 
		  {
				$quantite = $unFraisForfait['quantite'];
		?>
                <td class="qteForfait"><?php echo $quantite?> </td>
		 <?php
          }
		?>
		</tr>
    </table>
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class='montant'>Montant</th>  
                <th class='statut'>Supprimer</th>
                <th class='statut'>Reporter</th>
             </tr>
             <form action="index.php?uc=etatFrais&action=modifierStatut" method="post">
        <?php
           $i = 0;
          foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
		  {
                        $idFrais = $unFraisHorsForfait['id'];
			$date = $unFraisHorsForfait['date'];
			$libelle = $unFraisHorsForfait['libelle'];
			$montant = $unFraisHorsForfait['montant'];    
                        $numAnnee =substr( $date,6,4);
                        $numMois =substr( $date,3,2);  
                        $numDay =substr( $date,0,2);
                        $choixReport[$i][0]=$idFrais;
		?>
             <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                <td><?php if($_SESSION["visiteur"]==false){
                                echo '<input type="checkbox" name="choix[]">';
                            } ?></td>
                <td><?php if($_SESSION["visiteur"]==false){?>
                                <input type='date' name='choixReport[<?php echo $i; ?>][1]' maxlength='10' value='<?php echo $numAnnee; ?>-<?php echo $numMois; ?>-<?php echo $numDay; ?>' >
                            <?php } ?></td>
             </tr>
        <?php $i++;
          }
		?>
             <tr><td></td><td></td><td></td>
                <td>            
                <form action="" method="post">
                <input type="hidden" name="leMois" value="<?php echo($leMois); ?>">
                <input type="hidden" name="leVisiteur" value="<?php echo($leVisiteur); ?>">
                <input type="submit" value="Supprimer" size="4" name="statut"> <!-- On envoie le mois et l'ID visiteur correspondant a la selection du comptable -->
                </form>
                 </td>
                <td>            
                <form action="index.php?uc=etatFrais&action=reporterMajFraisHorsForfaitComptable" method="post">
                <input type="hidden" name="leMois" value="<?php echo($leMois); ?>">
                <input type="hidden" name="leVisiteur" value="<?php echo($leVisiteur); ?>">
                <input type="submit" value="Modifier" size="4" name="statut"> <!-- On envoie le mois et l'ID visiteur correspondant a la selection du comptable -->
                </form>
                 </td>
             </tr>
    </table>
          
  </div>
        <?php if($_SESSION["visiteur"]==false){ ?>
            <div class="piedForm">
            <p>
                <form action="index.php?uc=etatFrais&action=validerFrais" method="post">
                <input type="hidden" name="leMois" value="<?php echo($leMois); ?>">
                <input type="hidden" name="leVisiteur" value="<?php echo($leVisiteur); ?>">
                <input type="submit" value="Valider la fiche" size="20" name="valider"> <!-- On envoie le mois et l'ID visiteur correspondant a la selection du comptable -->
                </form>
            </p> 
            </div>  
        <?php }?>
