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





Modifications à faire:
- CSS centralisé (deja fait le include, maintenant il faut faire le graphique dans chaque page) + changer le css car complètement généré
- PDO centralisé
- SQL centralisé (suçage max)
- Changer ajoutmatch pour qu'il ait une page graphique et un script qui ajoute le match (il faudra mettre les differents fichiers donc les mettre dans core et dans page)
- Créer une page graphique pour ajouter un joueur (en plus il faudra la lier au script php ajoutJoueur et la mettre dans pages)
- Changer [modificationjoueur, modificationmatch, supressionjoueur, suppressionmatch] pour que la page graphique et le script soirt séparé
- Changer modification ya une partie que j'ai générer qui est vraiment pas folle (je l'ai mis en commentaire)

Choses à vérifier: 
- original_num bizarre
- feuille match : NOW requete SQL a changer + fetchAll a expliquer + FETCH_ASSOC
- (int) à expliquer (jsp ce que ça fait j'imagine transtypage)
- variable ?? ''    à expliquer (facile a faire mais j'ai la flemme)
- ajout feuille bizarre : player_$i role_$i <---- c'est trop bizarre

il faut aussi faire une appli differente pour tel

supprimer les boutons inutiles page d'accueil