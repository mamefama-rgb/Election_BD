CREATE FUNCTION ControlerFichierElecteurs(checksum_fichier VARCHAR(64), checksum_saisi VARCHAR(64)) RETURNS BOOLEAN
BEGIN
    IF checksum_fichier = checksum_saisi THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END;