START TRANSACTION;

-- Insert into medecins table
INSERT INTO medecins (prenom, nom, ...) VALUES ('John', 'Doe', ...);

-- Insert into users table
INSERT INTO users (prenom, nom, email, password, role) VALUES ('John', 'Doe', 'john.doe@example.com', SHA2('password', 256), 'medecin');

-- Commit the transaction
COMMIT;
