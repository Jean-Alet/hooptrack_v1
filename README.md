Explication des fonctions et outils un peu compliqués que l'on a utilisé :

- === correspond à une vérification stricte (c'est pour comparer à la fois le type et la valeur)
- fetchColumn() correspond à une alternative de fetch qui permet dans notre cas de récuperer directement la valeur de hash
- step correspond à un objet graphique qui nous permet de définir incrément pour un champ (step de à 0.1 ne permettra pas d'accepter une valeur comme 0.55)
- htmlspecialchars correspond à protéger l’affichage de chaînes dans du HTML
- echo on en met beaucoup notamment pour les tableaux pour pouvoir utiliser une boucle en php afin que chaque case de tableaux ait la bonne valeur
- urlencode

- setAttribute()  
  Méthode PDO pour définir le comportement d'erreur. On l'appelle sur l'objet PDO 
- ATTR_ERRMODE indique comment PDO doit gérer les erreurs
- ERRMODE_EXCEPTION permet de pouvoir lancer des exception
quand il y a erreur sql.





Modifications a faire:


- CSS centralisé (deja fait le include, maintenant il faut faire le graphique dans chaque page) + changer le css car complètement généré
- PDO centralisé
- SQL centralisé (suçage max)
- Changer [modificationjoueur, modificationmatch, supressionjoueur, suppressionmatch] pour que la page graphique et le script soirt séparé
- Changer modification ya une partie que j'ai générer qui est vraiment pas folle (je l'ai mis en commentaire)
- changer les noms pour rendre plus explicite
- equipe.php, authentification.php séparer le php 
- quand on met un joueur dans une feuille de match et qu'on l'enregistre, la feuille de match que l'on vient de modifier est vide en affichage alors que dans la base non
- feuille de match pas mal de choses à faire
- include linkpdo sur toutes les pages

Choses à vérifier: 
- original_num bizarre
- feuille match : NOW requete SQL a changer + fetchAll a expliquer + FETCH_ASSOC
- (int) à expliquer (jsp ce que ça fait j'imagine transtypage)
- variable ?? ''    à expliquer (facile a faire mais j'ai la flemme)
- ajout feuille bizarre : player_$i role_$i <---- c'est trop bizarre

il faut aussi faire une appli differente pour tel 