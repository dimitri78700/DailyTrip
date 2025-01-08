<?php

/**
 * Classe de gestion du routage des pages
 */

class Router
{
    // Propriétés (Attributs, vairiables de l'objet)
    private string $url;
    private string $path;

    /**
     * Un constructeur permet d'instancier un objet issue d'une classe
     * en lui attribuant des valeurs et caractéristiques par défaut.
     */
    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI']; // URL de la requête
        $this->path = parse_url($this->url, PHP_URL_PATH); // Chemin de la requête
        $this->path = rtrim($this->path, '/'); // Supprimer le slash de la fin
    }


    // METHODES (FONCTIONS)
    /**
     * Méthode (fonction) pour démarrer le routage
     * Permet de lancer l'écoute des requêtes et
     * d'y répondre en fonction de l'URL demandée
     * @return void
     */
    public function start()
    {
        $this->goTo();
    }

    /**
     * Méthode (fonction)  permettant de vérifier si l'URL demandée
     * existe puis de rendre la page correspondante à la demande
     * @return void
     */
    public function goTo(): void
    {
        try {
            require_once './src/views' . $this->path . '.html.php';
        } catch (\Exception $e) {
            require_once './src/views/404.html.php';
        }
    }
}


// // Si le chemin est vide, rediriger vers l'index
// if ($path === '') {
//     $path = '/home';
// }
