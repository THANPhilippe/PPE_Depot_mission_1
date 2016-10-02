
    <?php if (isset($nom)&&isset($prenom)&&isset($numMois)&&isset($numAnnee)){ ?>
        <div id="contenu">
        <h2>VALIDATION</h2>
        <h3> Rapport : SUCCESS <?php echo "$nom $prenom $numMois/$numAnnee";?> </h3>
        <?php
        echo "La fiche du visiteur $nom $prenom pour le mois et annee $numMois/$numAnnee a ete VALIDE";
    }else{?>
        <div class="erreur">
        <h2>VALIDATION</h2>
        <h3> Rapport : ECHEC </h3>
        <?php
        echo "La fiche du visiteur selectionne n'a pas ete VALIDE";
    }
    ?>
</div>