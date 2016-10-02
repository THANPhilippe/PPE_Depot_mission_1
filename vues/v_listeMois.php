 <div id="contenu">
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
      
