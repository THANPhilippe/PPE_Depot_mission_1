 <div id="contenu">
      <h2> Suivi de paiement </h2>
      <h3> Fiche disponible (VALIDE) pour une mise en paiement : </h3>
      <form action='index.php?uc=suiviPaiement&action=voirEtatFiche' method="post">
      <div class="encadre">
         
      <p>
	 <?php             if(!empty($lesFiches)){ ?>
        <label for="lstFiche" accesskey="n">Fiche : </label>
        <select id="lstFiche" name="lstFiche">
            <?php
			foreach ($lesFiches as $uneFiche)
			{
			    $mois = $uneFiche['mois'];
                            $idVisiteur = $uneFiche['idVisiteur'];
                            $nom = $uneFiche['nom'];
                            $prenom = $uneFiche['prenom'];
                            $numAnnee =substr( $mois,0,4);
                            $numMois =substr( $mois,4,2);
                            echo $idVisiteur;
                            
                            if($mois == $ficheASelectionner){
				?>
				<option selected value="<?php echo $mois; echo $idVisiteur ?>"><?php echo ($nom.' '.$prenom.' '.$numMois."/".$numAnnee); ?> </option>
				<?php 
                            }
                            else{ ?>
				<option value="<?php echo $mois; echo $idVisiteur; ?>"><?php echo ($nom.' '.$prenom.' '.$numMois."/".$numAnnee); ?> </option>
				<?php 
                            }
			
			}
		   ?>    
            
        </select>
        <?php             }else{
                echo "INFORMATION : IL N'Y A PAS DE FICHE A METTRE EN PAIEMENT";
            } ?>
      </p>
      </div>
      <?php  if(!empty($lesFiches)){ ?>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
      </p> 
      </div>
       <?php } ?>  
        
      </form>
     