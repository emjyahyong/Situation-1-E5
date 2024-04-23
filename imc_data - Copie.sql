CREATE TABLE Utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_utilisateur VARCHAR(50) UNIQUE,
    mot_de_passe VARCHAR(255)
);

CREATE TABLE Profils (
    id INT AUTO_INCREMENT,
    utilisateur_id INT,
    nom VARCHAR(50),
    age INT,
    objectif_poids DECIMAL(5,2),
    PRIMARY KEY (id, utilisateur_id),
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);

CREATE TABLE Donnees (
    id INT AUTO_INCREMENT,
    utilisateur_id INT,
    date_enregistrement DATE,
    poids DECIMAL(5,2),
    taille DECIMAL(5,2),
    imc DECIMAL(5,2),
    PRIMARY KEY (id, utilisateur_id),
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);

-- Déclencheur pour supprimer les enregistrements de Profils
DELIMITER //
CREATE TRIGGER delete_profiles_trigger
AFTER DELETE ON Utilisateurs
FOR EACH ROW
BEGIN
    DELETE FROM Profils WHERE utilisateur_id = OLD.id;
END;
//
DELIMITER ;

-- Déclencheur pour supprimer les enregistrements de Donnees
DELIMITER //
CREATE TRIGGER delete_data_trigger
AFTER DELETE ON Utilisateurs
FOR EACH ROW
BEGIN
    DELETE FROM Donnees WHERE utilisateur_id = OLD.id;
END;
//
DELIMITER ;

/
DELIMITER //

CREATE PROCEDURE OR REPLACE SP_InsertUtilisateur (
    IN util_nom VARCHAR(50),
    IN util_mdp VARCHAR(255),
    IN prof_nom VARCHAR(50),
    IN prof_age INT,
    IN donnee_poids DECIMAL(5,2),
    IN donnee_taille DECIMAL(5,2),
    IN donnee_imc DECIMAL(5,2),
    IN prof_obj_poids DECIMAL(5,2)
)
BEGIN
    INSERT INTO Utilisateurs (nom_utilisateur, mot_de_passe) VALUES (util_nom, util_mdp);
    
    INSERT INTO Profils (utilisateur_id, nom, age, objectif_poids)
    VALUES (LAST_INSERT_ID(), prof_nom, prof_age, prof_obj_poids);
    
    INSERT INTO Donnees (utilisateur_id, date_enregistrement, poids, taille, imc)
    VALUES (LAST_INSERT_ID(), DATE(NOW()), donnee_poids, donnee_taille, donnee_imc);
END//

DELIMITER ;

/

Table Utilisateurs {
  id INT [pk, increment]
  nom_utilisateur VARCHAR(50) [unique]
  mot_de_passe VARCHAR(255)
}

Table Profils {
  id INT [pk, increment]
  nom VARCHAR(50)
  age INT
  poids DECIMAL(5,2)
  taille DECIMAL(5,2)
  utilisateur_id INT [unique]
  
}

Table Donnees {
  id INT [pk, increment]
  date_enregistrement DATE
  imc DECIMAL(5,2)
  objectif_poids DECIMAL(5,2)
  utilisateur_id INT
}
Ref: Utilisateurs.id < Profils.utilisateur_id

Ref: Utilisateurs.id < Donnees.utilisateur_id

////////////////////////////////////////
CREATE TABLE Utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_utilisateur VARCHAR(50) UNIQUE,
    mot_de_passe VARCHAR(255)
);

CREATE TABLE Profils (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT UNIQUE, 
    nom VARCHAR(50)
    age INT,
    poids DECIMAL(5,2),
    taille DECIMAL(5,2),
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);

CREATE TABLE Donnees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_enregistrement DATE,
    imc DECIMAL(5,2),
    objectif_poids DECIMAL(5,2)
);

CREATE TABLE Utilisateur_Donnee (
    utilisateur_id INT,
    donnee_id INT,
    PRIMARY KEY (utilisateur_id, donnee_id),
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id),
    FOREIGN KEY (donnee_id) REFERENCES Donnees(id)
);



https://dbdiagram.io/d