    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2>
    
</h2>
    
      </div>  
        <ul id="menuList">
            <li >
            Comptable :<br>
            <?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?>
            </li>
           <li class="smenu">
              <a href="index.php?uc=etatFrais&action=selectionnerMoisComptable" title="Valide fiche de frais">Valide fiche frais</a>
           </li>
           <li class="smenu">
              <a href="index.php?uc=suiviPaiement&action=selectionnerFiche" title="Consultation du paiement des fiches">Suivi de paiement</a>
           </li>
 	   <li class="smenu">
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Deconnexion</a>
           </li>
         </ul>
     
    </div>