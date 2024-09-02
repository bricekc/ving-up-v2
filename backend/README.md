# Projet Vign'UP

## Description

Le projet Vign'UP vise à aider les acteurs du vignoble à mieux comprendre les vignes semi-larges. Pour cela, le projet se compose d'une API développée avec API Platform et d'une application frontend développée avec React.

## Instructions de développement

- Pour cloner le projet : `git clone https://url_du_projet.git`
- Toujours travailler avec une version à jour de Composer : `composer self-update`
- Installer les dépendances : `composer install`
- Les push vers la branche `main` sont interdits, il faut travailler avec des branches portant le nom des fonctionnalités qu'elles implémentent en effectuant des merges requests sur la branche `main`.
- Créer une branche : `git branch NomDeMaBranch`
- Voir les branches courantes : `git branch` ATTENTION : la branche précédée de * est la branche courante.
- Voir les branches qui ont déjà été fusionnées avec la branche courante : `git branch --merged`
- Voir les branches qui n'ont pas encore été fusionnées avec la branche courante : `git branch --no-merged`
- Supprimer une branche : `git branch -d NomDeMaBranch`
- Changer le nom d'une branche : `git branch --move mauvais-nom-de-branche nom-de-branche-corrigé` PUIS faire : `git push origin --delete mauvais-nom-de-branche`.

## Tests et scripts utiles

- Script pour lancer le serveur : `composer start`
- Script pour lancer les tests : `composer test:codeception`
- Script pour créer la base de données : `composer db`

## Identifiants de connexion

Pour se connecter en tant qu'admin :
- Identifiant : `dio@example.com`
- Mot de passe : `adminfloppa01`

Pour se connecter en tant que viticulteur :
- Identifiant : `shaka@example.com`
- Mot de passe : `test01`

Pour se connecter en tant que fournisseur :
- Identifiant : `brick@example.com`
- Mot de passe : `test02`

## Présentation des différentes pages du projet

Les pages de l'application frontend développée avec React sont accessibles via des routes. Seules deux routes sont disponibles dans l'API développée avec API Platform :

- `/admin` : cette route permet d'accéder à l'interface d'administration générée par EasyAdminBundle.
- `/api` : cette route permet d'accéder aux différentes ressources de l'API.
- `/login` : cette route permet d'accéder au formulaire de connexion.
