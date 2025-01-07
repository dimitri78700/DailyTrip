<?php
/**
 * Classe de gestion de la base de données
 * Pour gérer la connexion et les requêtes
 * à la base de données nous utilisons PDO, 
 * il s'agit d'une classe PHP qui permet de 
 * manipuler des données dans une base de données
 */
class Database {

    private string $host = "localhost:3307";
    private string $dbname = "dailytrip";
    private string $user = "root";
    private string $password = "";
    private PDO $connect;

    // Connexion à la base de données SQLite
    public function __construct() {
        $this->connect = new PDO(
            "mysql:host=" . $this->host . ";dbname=" . $this->dbname,
            $this->user, $this->password
        );
        $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

}