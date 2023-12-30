<?php
//EXEMPLE DE FICHIER INDEX.PHP 
// => FRONTCONTROLLER = point d'entrée UNIQUE de notre application !

//IMPORTER LES CONTROLLERS
require __DIR__."/../app/Controllers/MainController.php" ;
require __DIR__."/../app/Controllers/CatalogController.php" ;
require __DIR__."/../app/Controllers/ErrorController.php" ;

//IMPORTER LES CLASSES DES MODELS
require __DIR__."/../app/Models/Model.php" ;

// INCLURE autoload.php => dependances de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Instance de Altorouter
$router = new AltoRouter();

// Definition du SETBASEPATH, dossier du projet
$router->setBasePath($_SERVER['BASE_URI']);

########## TABLEAU DE ROUTES => ROUTER ###################

// exemple ROUTE page d'accueil
$router->map('GET', '/', [
    'controller' => 'MainController',
    'method' => 'home'
], 'main-home');

// exemple ROUTE paramétrique
$router->map('GET', '/recettes/[i:id]', [
    'controller' => 'CatalogController',
    'method' => 'recettes'
], 'catalog-recettes');

#############################################################
// $map() est une méthode d'Altorouter qui accepte 4 arguments
// 1/ méthode HTTP 
// 2/ pattern de match 
// 3/ ce qui sera envoyé à $match['params'], par exp tableau associatif avec controller et method
// 4/ nom de la route ( à réutiliser avec generate() ) sous forme nomDuController-NomDelaMéthode
#############################################################
#############################################################
// $match est un tableau associatif qui a 3 paires clé-valeur
// 1/ ['target'] => contient le tableau asso. avec controller et méthode
// 2/ ['params'] => contient le tableau asso avec l'id ciblé
// 3/ ['name'] => contient le nom de la route
//Exemple de $match :
// array:3 [▼
//   "target" => array:2 [▼
//     "controller" => "CatalogController"
//     "method" => "recettes"
//   ]
//   "params" => array:1 [▼
//     "id" => "1"
//   ]
//   "name" => "catalog-recettes"
// ]
#############################################################
// ALTOROUTER REGARDE SI Y A UN MATCH AVEC LES ROUTES DU TABLEAU DE ROUTES
$match = $router->match();

// S'IL Y A MATCH ENTRE URL ET ROUTE DEFINIE => $match est true
if($match) {
    // on récupère le nom du contrôleur & le nom de la méthode
    $controllerName = $match["target"]["controller"];
    $methodName = $match["target"]["method"];

    // DISPATCHER
    // on instancie "dynamiquement" le bon contrôleur
    $controller = new $controllerName($router);
    // on appelle "dynamiquement" cette méthode
    $controller->$methodName($match["params"]);
} 
// SINON $match est false => pas de route déclarée pour l'URL demandée => 404
else {
    $controller = new ErrorController($router);
    $controller->error404();
}

//On dynamisera les liens de nav avec la méthode generate() d'Altorouter
// Deux args : 1/nom de la route, défini avec map en 4e arg() , 2/ [paramètres éventuels])
// Exp de lien : $router->generate('catalog-recettes', ['id' => $recipe->getID()]) 


