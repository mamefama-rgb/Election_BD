CREATE PROCEDURE ValiderImportation()
BEGIN
    -- Transférer les données de la table temporaire à la table persistante
    INSERT INTO electeurs (numero_electeur, nom, prenom, date_naissance, lieu_naissance, sexe , carte_identite , upload_time)
    SELECT id , numero_electeur, nom, prenom, date_naissance,  sexe , carte_identite , upload_time
    FROM temp_electeurs;

    -- Supprimer les données de la table temporaire
    DELETE FROM temp_electeurs;

    -- Désactiver l'upload
    UPDATE etat_upload SET etat = FALSE;
END;
id	numero_electeur	nom	prenom	date_naissance	sexe	carte_identite	adresse_ip	upload_time