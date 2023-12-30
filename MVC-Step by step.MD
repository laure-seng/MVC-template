# MVC FROM SCRATCH 

1. Créer l'arborescence : 

<dossier_projet_MVC>
  |- .gitignore
  |- app/
  |  |- Controllers/
  |  |- Models/
  |  |- Utils/
  |  |  |- Database.php
  |  |- Views/
  |  |- config.ini
  |  |- config.ini.example
  |  |- .htaccess    -> permet de bloquer l'accès au dossier app/
  |- public/
     |- index.php
     |- .htaccess    -> permet la réécriture d'URL 
     \- assets/
        |- css/
        |- img/
        \- js/

2. On remplit le fichier **config.ini.example** et le fichier **config.ini**,
Et le fichier **Database.php** (pdo) qui est exécuté avec les données de config.ini
3. On remplit le **.htaccess du dossier public pour y donner l'accés et celui du dossier app** ( pour en bloquer l'accès avec Deny From All )
Attention: il faut le **module Mod_Rewrite** soit activé
Sinon l'installer avec : `sudo a2enmod rewrite`
Aller dans etc/apache/apache.conf et changer `AllowOverRide "None"` par `"All"` sur le dossier /var/www/html
Redémarrer : `sudo systemctl restart apache2`
4. **Composer** : verifier qu'il est installé
**installer les dépendances** :  `composer require altorouter/altorouter`  et composer `require symfony/var-dumper`
verifier qu'on ne commit pas vendor en modifiant le .gitignore (et vérifier que le fichier app/config.ini y est aussi :) )'
5. **Tableau de routes** => ROUTER et **DISPATCHER**=>correspondance route/ctroller et méthode dans index.php (FRONTCONTROLLER)
Créer la variable $BASE_URL qui contiendra le **setBasePath** d'altorouter et servira aussi comme référence pour les url des assets notamment.
Exemple de routes :
* Exemple route page d'accueil
`$router->map('GET', '/', [
    'controller' => 'MainController',
    'method' => 'home'
], 'home');`
* Exemple de route paramétrique
`$router->map('GET', '/catalogue/categorie/[i:id]', [
    'controller' => 'CatalogController',
    'method' => 'category'
], 'category');`
6. **Controller main à modifier**
7. **Views à créer**
8. **Inclure tous les controllers** dans index.php (il faudra aussi inclure les Models une fois créés)
9. On met les données qu'on veut afficher sous forme de tableau associatif qu'on utilisera en argument des methodes découlant de show().
10. Récupération des données avec le pattern **Active Record** : 
une table => une classe  , 
une colonne=>une propriété de la classe,
méthodes findAll() et find() pour tous les modèles \+ méthodes correspondant au CRUD 
11. **Même processus avec les routes paramètriques et le catalogController**
12. **Dynamisation en utilisant $viewData ds les template** pour remplacer ce qui est codé en dur
13. **Dynamiser les liens** de nav avec generate(1/nom de la route, défini avec map en 4e arg() , [paramètres éventuels])
Exp : `<?= $router->generate('product', ['id' => $product->getId()]) ?>`
14. **Clé étrangére** : dans le controller, ds la méthode du produit, utiliser les méthodes des Models des marque et categorie pour récuperer avec findById 
ds une variable qu'on va intégrer ds le viewData ss forme de tableau associatif `['produit'=>$product,'category'=>$category etc ]`
15. **Réparer les assets** avec $_SERVER

