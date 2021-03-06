﻿
<br><br><br>
<h2>Fiche de frais du <?php echo $numMois."-".$numAnnee?> : 
    </h2>
    <div class="encadre">
    <p>Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> Montant validé : <?php echo $montantValide?></p>
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
        <caption>Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -</caption>
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>  
        </tr>
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
            ?>
            <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
            </tr>
            <?php $i++;
        }
        ?>
    </table>
  </div>
      <div class="piedForm">
        <p>Imprimer le PDF:<a href="index.php?uc=pdf&action=imprimerPDF&mois=<?php echo $numAnnee.$numMois ?>"><img style="float:none;" src="images/iconePDF.png"></a></p>
      </div>
