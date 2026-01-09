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


Choses à vérifier: 
- original_num bizarre
- feuille match : NOW requete SQL a changer + fetchAll a expliquer + FETCH_ASSOC
- (int) à expliquer (jsp ce que ça fait j'imagine transtypage)
- variable ?? ''    à expliquer (facile a faire mais j'ai la flemme)
- ajout feuille bizarre : player_$i role_$i <---- c'est trop bizarre
- STAT

STatistique;


------------------------------------------------------------------------------------------------------------------------------------------------------
IMPORTANT A VERIFIER
modifier_joueur
supprimer_joueur_disp
supprimer_match_disp
supprimer_joueur
modifier_match
modifier_disp
ajoutfeuille (les erreurs notamment)
ajouterJoueur (sinj ????)

container div <--- pas fou


||||||||||||||||||||||||||||||||||||||||||||||||   QUERIES ATTENTION FULL GENERER    |||||||||||||||||||||||||||||||||||||||||||||||||||

Des fonctions qui ne sont pas folle folle (sinj notamment, après yen a des hyper spécifique)

Style a changer je retrouve du css dans le html attention
dans les modifier => on delete puis on insert (pk on update pas plutot ?)


Rajouter option nul pour les matchs
Dans stat le statut s'affiche pas quand le joueur est suspendu/inactif
Evaluation de l'entraineur 
Selection consécutive dans stat 

AUTRE
il faut aussi faire une appli differente pour tel 
On ne peut pas voir les feuilles de matchs on peut juste les creer (en plus on pourrait générer un pdf avec les noms des gens licences etc...)

------------------------------------------------------------------------------------------------------------------------------------------------------

feuille de match quand on modif faire contrainte 5 joueurs min