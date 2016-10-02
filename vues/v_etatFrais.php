
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
                <th class='statut'>Suprimer</th>
                <th class='statut'>Reporter</th>
             </tr>
             <form action="index.php?uc=etatFrais&action=modifierStatut" method="post">
        <?php      
          foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
		  {
			$date = $unFraisHorsForfait['date'];
			$libelle = $unFraisHorsForfait['libelle'];
			$montant = $unFraisHorsForfait['montant'];                            
		?>
             <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                <td><?php if($_SESSION["visiteur"]==false){
                                echo '<input type="checkbox" name="choix[]">';
                            } ?></td>
                <td><?php if($_SESSION["visiteur"]==false){
                                echo '<input type="text" name="choix2[]" maxlength="10">';
                            } ?></td>
             </tr>
        <?php 
          }
		?>
    </table>
          
  </div>
        <?php if($_SESSION["visiteur"]==false){ ?>
            <div class="piedForm">
            <p>
                <input type="hidden" name="leMois" value="<?php echo($leMois); ?>">
                <input type="hidden" name="leVisiteur" value="<?php echo($leVisiteur); ?>">
                <input type="submit" value="Modifier statut" size="20" name="statut"> <!-- On envoie le mois et l'ID visiteur correspondant a la selection du comptable -->
                </form>
                <form action="index.php?uc=etatFrais&action=validerFrais" method="post">
                <input type="hidden" name="leMois" value="<?php echo($leMois); ?>">
                <input type="hidden" name="leVisiteur" value="<?php echo($leVisiteur); ?>">
                <input type="submit" value="Valider la fiche" size="20" name="valider"> <!-- On envoie le mois et l'ID visiteur correspondant a la selection du comptable -->
                </form>
            </p> 
            </div>  
        <?php }?>
