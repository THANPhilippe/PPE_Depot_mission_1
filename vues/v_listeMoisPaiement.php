 <div id="contenu">
      <h2> Suivi de paiement </h2>
      <h3> Fiche disponible (VALIDE) pour une mise en paiement : </h3>
      <form action='index.php?uc=suiviPaiement&action=voirEtatFiche' method="post">
      <div class="encadre">
         
      <p>
	 
        <label for="lstFiche" accesskey="n">Fiche : </label>
        <select id="lstFiche" name="lstFiche">
            <?php
			foreach ($lesFiches as $uneFiche)
			{
			    $mois = $uneFiche['mois'];
                            $leVisiteur = $uneFiche['idVisiteur'];
                            $numAnnee =substr( $mois,0,4);
                            $numMois =substr( $mois,4,2);
                            
                            if($mois == $ficheASelectionner){
				?>
				<option selected value="<?php echo $mois; echo $leVisiteur ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
                            }
                            else{ ?>
				<option value="<?php echo $mois; echo $leVisiteur; ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
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
     