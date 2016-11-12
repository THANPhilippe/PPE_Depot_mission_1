
    <?php if (isset($nom)&&isset($prenom)&&isset($numMois)&&isset($numAnnee)){ ?>
        <div id="contenu">
        <h2>MISE EN PAIEMENT</h2>
        <h3> Rapport : SUCCESS <?php echo "$nom $prenom $numMois/$numAnnee";?> </h3>
        <?php
        echo "La fiche du visiteur $nom $prenom pour la date du $numMois/$numAnnee est MISE EN PAIEMENT";
    }else{?>
        <div class="erreur">
        <h2>MIS EN PAIEMENT</h2>
        <h3> Rapport : ECHEC </h3>
        <?php
        echo "La fiche du visiteur selectionne n'a pas ete MISE EN PAIEMENT";
    }
    ?>
</div>