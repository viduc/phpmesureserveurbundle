# phpmesure-bundle

Bundle symfony pour intégrer le serveur phpmesure dans un projet symfony

## Pour démarrer



### Prérequis

Pour fonctionner ce bundle a besoin de ces prérequis:

```
"php": ">=5.5.9",
"symfony/framework-bundle": "~2.7|~3.0|~4.0"
```

### Installation

Pour installer ce bundle, éditer le fichier composer.json de votre application et ajouter ces deux lignes:

```
"require": {
    ...
    "viduc/phpmesureserveur-bundle": "dev-master"
}
```

Puis faire une mise à jour de composer

```
composer update
```

Activer ensuite le bundle dans le fichier AppKernel

```
$bundles = [
    ...
    new viduc\phpmesureserveurBundle\viducphpmesureserveurBundle(),
    ];
```
### Configuration



## Exécuter les tests

Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```

## Built With

* [Symfony](https://symfony.com/) - Le framework utilisé

## Autheurs

* **Tristan Fleury** - *Créateur* - [Viduc](https://github.com/Viduc)

## License

Ce projet est sous licence GPL 3.0. Le fichier de license se trouve à la racine du projet
