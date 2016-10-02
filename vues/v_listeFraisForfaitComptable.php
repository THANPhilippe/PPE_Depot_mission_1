
<br><br><br>
      <h2>Modification de la liste de frais du <?php echo $numMois."-".$numAnnee ?></h2>
         
      <form method="POST"  action="index.php?uc=etatFrais&action=validerMajFraisForfaitComptable">
      <div class="corpsForm">
          
          <fieldset>
            <legend>Eléments forfaitisés
            </legend>
			<?php
				foreach ($lesFraisForfait as $unFrais)
				{
					$idFrais = $unFrais['idfrais'];
					$libelle = $unFrais['libelle'];
					$quantite = $unFrais['quantite'];
			?>
					<p>
						<label for="idFrais"><?php echo $libelle ?></label>
						<input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantite?>" >
					</p>
			
			<?php
				}
			?>
			
			
			
			
           
          </fieldset>
      </div>
      <div class="piedForm">
      <p>
        <input type="hidden" name="leVisiteur" value="<?php echo($leVisiteur); ?>">
        <input type="hidden" name="leMois" value="<?php echo($leMois); ?>">
        <input id="ok" type="submit" value="Valider la modification" size="20" />
      </p> 
      </div>
        
      </form>
</div>