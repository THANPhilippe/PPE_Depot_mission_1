﻿ <div id="contenu">
    <?php if($_SESSION["visiteur"]==true){ echo '<h2>Mes fiches de frais</h2>'; }else{ echo '<h2>Fiche de frais a valider</h2>';} ?>
      <h3>Mois à sélectionner : </h3>
      <form action=<?php if($_SESSION["visiteur"]==true){
                             echo "'index.php?uc=etatFrais&action=voirEtatFrais'"; 
                             }
                             else
                             { 
                                 echo "'index.php?uc=etatFrais&action=selectionnerMoisFicheComptable'";       
                             }?> method="post">
      <div class="corpsForm">
         
      <p>
	 
        <label for="lstMois" accesskey="n">Mois : </label>
        <select id="lstMois" name="lstMois">
            <?php
            
			foreach ($lesMois as $unMois)
			{
			    $mois = $unMois['mois'];
				$numAnnee =  $unMois['numAnnee'];
				$numMois =  $unMois['numMois'];
				if($mois == $moisASelectionner){
				?>
				<option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
			
			}
           
		   ?>    
            
        </select>
      </p>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
      </p> 
      </div>
        
      </form>
      
      
      <?php if($_SESSION["comptable"]==true && isset($lesVisiteurs)){?>
      <h3>Liste des fiches frais a valider pour les visiteurs du mois : <?php echo (substr( $leMois,4,2));echo ' / '; echo(substr( $leMois,0,4)); ?> </h3>
      <form action="index.php?uc=etatFrais&action=voirEtatFraisComptable" method="post">
      <div class="corpsForm">
         
      <p>
	 
        <label for="lstVisiteur" accesskey="n">Visiteurs : </label>
        <select id="lstVisiteur" name="lstVisiteur">
            <?php
			foreach ($lesVisiteurs as $unVisiteur)
			{
			    $visiteur = $unVisiteur['visiteur'];
				$nom =  $unVisiteur['nom'];
				$prenom =  $unVisiteur['prenom'];
				?>
				<option value="<?php echo $visiteur ?>"><?php echo  $nom."/".$prenom ?> </option>
				<?php 
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