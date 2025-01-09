<?php

// Informations de connexion à la base de données
$host = 'localhost:3308';
$user = 'root';
$password = '';
$database = 'dailytrip_0';

try {
    // Connexion au serveur MySQL sans sélectionner de base de données
    $conn = new PDO("mysql:host=$host", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Créer la base de données si elle n'existe pas
    $sql = "CREATE DATABASE IF NOT EXISTS `$database` DEFAULT CHARACTER SET = 'utf8mb4'";
    $conn->exec($sql);
    echo "Base de données '$database' créée avec succès.\n";
    
    // Se connecter à la base de données créée
    $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Définir le moteur InnoDB pour la création des tables
    $engine = 'ENGINE = InnoDB';
    
    // Création des tables
    $tables = [
        // TODO: Ajoutez vos requêtes SQL de création de tables ici

        // Ajout de la table `trips`
         "CREATE TABLE `trips` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(255) NOT NULL,
            `ref` VARCHAR(255) NOT NULL,
            `description` TEXT NOT NULL,
            `cover` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `localisation_id` INT NOT NULL,
            `category_id` INT NOT NULL,
            `status` INT NOT NULL,
            PRIMARY KEY (`id`)
            FOREIGN KEY (`localisation_id`) REFERENCES `localisation`(`id`)
            FOREIGN KEY (`category_id`) REFERENCES `category`(`id`)
        );",

        // Ajout de la table `category` 
        "CREATE TABLE `category` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `image` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`id`)
        );",

        // Ajout de la table `localisation`
        "CREATE TABLE `localisation` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `start` VARCHAR(255) NOT NULL,   
            `finish` VARCHAR(255) NOT NULL,
            `distance` FLOAT NOT NULL,
            `duration` TIME NOT NULL,
            PRIMARY KEY (`id`)
        );",

        // Ajout de la table `poi`
        "CREATE TABLE `poi` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `point` VARCHAR(255) NOT NULL,
            `localisation_id` INT NOT NULL,
            PRIMARY KEY (`id`)
            FOREIGN KEY (`localisation_id`) REFERENCES `localisation`(`id`)
        );",

        // Ajout de la table `review`
        "CREATE TABLE `review` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `fullname` VARCHAR(255) NOT NULL,
            `content` TEXT NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `trip_id` INT NOT NULL,
            PRIMARY KEY (`id`)
            FOREIGN KEY (`trip_id`) REFERENCES `trips`(`id`)
        );",

        // Ajout de la table `rating`
        "CREATE TABLE `rating` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `note` INT NOT NULL,
            `ip_address` VARCHAR(255) NOT NULL,
            `trip_id` INT NOT NULL,
            PRIMARY KEY (`id`)
            FOREIGN KEY (`trip_id`) REFERENCES `trips`(`id`)
        );",
    ];
    
    // Exécution de la création des tables
    foreach ($tables as $tableSql) {
        try {
            $conn->exec($tableSql);
            echo "Table créée avec succès.\n";
        } catch (PDOException $e) {
            echo "Erreur lors de la création de la table : " . $e->getMessage() . "\n";
        }
    }
    
 // Ajout des clés étrangères
 $constraints = [
    
    // contraintes de clé étrangère pour la table `trips`
    "ALTER TABLE `trips` ADD FOREIGN KEY (`localisation_id`) REFERENCES `localisation`(`id`)",
    "ALTER TABLE `trips` ADD FOREIGN KEY (`category_id`) REFERENCES `category`(`id`)",

    // contrainte de clé étrangère pour la table `poi`
    "ALTER TABLE `poi` ADD FOREIGN KEY (`localisation_id`) REFERENCES `localisation`(`id`)",

    // contrainte de clé étrangère pour la table `review`
    "ALTER TABLE `review` ADD FOREIGN KEY (`trip_id`) REFERENCES `trips`(`id`)",

    // contrainte de clé étrangère pour la table `rating`
    "ALTER TABLE `rating` ADD FOREIGN KEY (`trip_id`) REFERENCES `trips`(`id`)",
];
    
    // Exécution des contraintes de clés étrangères
    foreach ($constraints as $constraintSql) {
        try {
            $conn->exec($constraintSql);
            echo "Contrainte de clé étrangère ajoutée avec succès.\n";
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la contrainte : " . $e->getMessage() . "\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
    exit;
} finally {
    // Fermer la connexion
    $conn = null;
}


