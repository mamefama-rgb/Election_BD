CREATE FUNCTION ControlerElecteurs() RETURNS BOOLEAN
BEGIN
    DECLARE ligne_probleme BOOLEAN DEFAULT FALSE;

    -- Vérifier chaque ligne de la table temporaire
    FOR ligne IN (SELECT * FROM tempelecteurs) DO
        -- Vérifier le format de la CIN et du numéro d'électeur
        IF LENGTH(ligne.id) != 10 OR LENGTH(ligne.numero_electeur) != 10 THEN
            INSERT INTO tempproblemeelecteurs (id, numero_electeur, error_message , upload_time, carte_identite)
            VALUES (ligne.id, ligne.numero_electeur, 'Format de CIN ou numéro d\'électeur incorrect', ligne.upload_time, ligne.carte_identite);
            SET ligne_probleme = TRUE;
          
        END IF;

        -- Vérifier la complétude des données
        IF ligne.nom IS NULL OR ligne.prenom IS NULL OR ligne.date_naissance IS NULL OR ligne.lieu_naissance IS NULL OR ligne.sexe IS NULL THEN
            INSERT INTO tempproblemeelecteurs (carte_identite , upload_time, id, numero_electeur, error_message)
            VALUES (ligne.carte_identite, ligne.upload_time, ligne.id, ligne.numero_electeur, 'Données incomplètes');
            SET ligne_probleme = TRUE;
        END IF;
    END FOR;

    IF ligne_probleme THEN
        RETURN FALSE;
    ELSE
        RETURN TRUE;
    END IF;
END;
	id	numero_electeur	carte_identite	error_message	upload_time