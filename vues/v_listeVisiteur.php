   <?php if($_SESSION["comptable"]==true && isset($lesVisiteurs)){?>
      <h3>Liste des fiches frais a valider pour les visiteurs du mois : <?php echo (substr( $leMois,4,2));echo ' / '; echo(substr( $leMois,0,4)); ?> </h3>
      <form action="index.php?uc=etatFrais&action=voirEtatFraisComptable" method="post">
      <div class="encadre">
         
      <p>
	 
        <label for="lstVisiteur" accesskey="n">Visiteurs : </label>
        <select id="lstVisiteur" name="lstVisiteur">
            <?php
			foreach ($lesVisiteurs as $unVisiteur)
			{
			    $visiteur = $unVisiteur['visiteur'];
				$nom =  $unVisiteur['nom'];
				$prenom =  $unVisiteur['prenom'];
				if($visiteur == $visiteurASelectionner){
				?>
				<option selected value="<?php echo $visiteur ?>"><?php echo  $nom."/".$prenom ?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $visiteur ?>"><?php echo  $nom."/".$prenom ?> </option>
				<?php 
				}
			}
		   ?>    
            
        </select>
      </p>
      </div>
      <div class="piedForm">
      <p>
        <input type="hidden" name="leMois" value="<?php echo($leMois); ?>">
        <input id="ok" type="submit" value="Valider" size="20" />
      </p> 
      </div>
        
      </form>
      <?php } ?>