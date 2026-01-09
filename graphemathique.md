# Graphémathique : Questions posables, éléments de vérification et de résolution.

## son numérateur !

**Spécifique** aux fractions.

**Vérification :** Le nombre donné est égal au numérateur de la fraction, indiqué dans sa graphie par le nombre en haut de la barre de fraction.

***Point de vigilance :*** *Si la fraction est préfixée d'un signe négatif, on ne prend en compte que la fraction-même. De la sorte, De la sorte, -(-37)/56 admet pour dénominateur -37.*

**Méthode de résolution (exemple) :** Repérer la fraction, le nombre qui se trouve en haut de sa barre de fraction, et l'extraire comme réponse.

## son dénominateur !

**Spécifique** aux fractions.

**Vérification :** Le nombre donné est égal au dénominateur de la fraction, indiqué dans sa graphie par le nombre en bas de la barre de fraction.

***Point de vigilance :*** *Si la fraction est préfixée d'un signe négatif, on ne prend en compte que la fraction-même. De la sorte, -(-37)/56 admet pour numérateur 56.*

**Méthode de résolution (exemple) :** Repérer la fraction, le nombre qui se trouve en bas de sa barre de fraction, et l'extraire comme réponse.

## une écriture sous forme de fraction irréductible !

**Spécifique** aux fractions.

**Vérification :** La fraction est bien égale au nombre de départ, le numérateur et le dénominateur sont des entiers premiers entre eux (aucun facteur premier commun).

**Méthode de résolution (exemple) :** On commence avec une fraction A/B, pour A entier relatif et B entier relatif non-nul. On prend le plus petit facteur premier P commun entre A et B, et on applique l'identité A/B = (A/P)/(B/P), qui permet d'obtenir une fraction égale à l'initiale, mais A/P et B/P ont strictement moins de facteurs communs entre eux que A et B entre eux. Ainsi, en continuant l'algorithme en réassignant A ← A/P et B ← B/P, cet algorithme s'arrête forcément sur une fraction irréductible.

## son ordre de grandeur !

**Spécifique** à la notation scientifique. 

**Vérification :**
- Si la mantisse est strictement inférieure à 5, remplacer cette mantisse par 1 donne un nombre égal au nombre donné. *(Exemple : 3,5×10², la mantisse 3,5 est strictement inférieure à 5, donc toute réponse correcte est égale à 1×10².)*
- Si la mantisse est supérieure ou égale à 5, remplacer cette mantisse par 10 donne un nombre égal au nombre donné. *(Exemple : 8,3×10², la mantisse 8,3 est supérieure ou égale à 5, donc toute réponse correcte est égale à 10×10².)*

**Méthode de résolution (exemple) :**
- Si la mantisse est strictement inférieure à 5, on n'a qu'à extraire la puissance de dix indiquée. *(Exemple : 3,5×10⁻², la mantisse 3,5 est strictement inférieure à 5, donc on peut extraire sa puissance de dix, à savoir 10⁻².)*
- Si la mantisse est supérieure ou égale à 5, on peut remplacer la mantisse par 10, puis on peut éventuellement l'identité 10×10ⁿ = 10ⁿ⁺¹ pour donner une réponse comme puissance de dix. *(Exemple : -8,3×10², la mantisse 8,3 est supérieure ou égale à 5, donc la réponse est 10×10², qu'on peut aussi noter 10³.)*

## son exposant !

**Spécifique** à la notation scientifique.

**Vérification :** La réponse donnée est égale au nombre en exposant de 10 dans la graphie donnée.

**Méthode de résolution (exemple) :** On donne directement le nombre en exposant de 10 dans la graphie donnée.

## son nombre de chiffres significatifs !

**Spécifique** à la notation scientifique.

**Vérification :** La réponse donnée est égale au nombre de chiffres affichée dans la graphie de la mantisse. *(Exemple : La mantisse -4,7600×10⁻² est 4,7600 dont la graphie contient 5 chiffres, donc toute réponse correcte est égale à 5.)*

**Méthode de résolution (exemple) :** On donne directement le nombre de chiffres affichée dans la graphie de la mantisse.

## son chiffre des unités !

**Méthode de résolution (exemple) :** On convertit le nombre en écriture décimale, et on extrait le premier chiffre placé le plus à droite avant le séparateur décimal.

**Erreurs/ambiguïtés envisagées :**

- En notation scientifique, le chiffre des unités de la mantisse, quand l'exposant est non-nul, n'est pas le chiffre des unités du nombre.
- En pourcentage, il ne s'agit pas du chiffre des unités du nombre en pourcentage, car le pourcentage revient à diviser par cent — Cela vous donnera, en réalité, son chiffre des centièmes.
- Dans une fraction, il ne s'agit ni du chiffre des unités du numérateur, ni du dénominateur, sauf coïncidence.
- En binaire, il peut s'agir aussi du chiffre des unités de l'écriture binaire (0 ou 1) ou du chiffre des unités decimal, qui lui nécessite bien de convertir en decimal dans la plupart des cas.

## son chiffre des dizaines !

**Méthode de résolution (exemple) :** On convertit le nombre en écriture décimale, et on extrait le deuxième chiffre placé le plus à droite avant le séparateur décimal.

## son chiffre des centaines !

**Méthode de résolution (exemple) :**  On convertit le nombre en écriture décimale, et on extrait le troisième chiffre placé le plus à droite avant le séparateur décimal.

## son chiffre des dixièmes !

**Pré-requis :** Valeurs non-entières.

**Méthode de résolution (exemple) :**  On convertit le nombre en écriture décimale, et on extrait le premier chiffre placé le plus à gauche après le séparateur décimal.

## son chiffre des centièmes !

**Pré-requis :** Valeurs non-entières.

**Méthode de résolution (exemple) :**  On convertit le nombre en écriture décimale, et on extrait le deuxième chiffre placé le plus à gauche après le séparateur décimal.

## son écriture décimale !

**Redondance :** Écriture décimale.

**Vérification :** On peut écrire le nombre donné sur la calculatrice, et vérifier que le nombre est bien la réponse donnée, avec éventuellement quelques zéros en plus après (le dernier chiffre non-nul après le séparateur décimal) ; On n'est jamais à l'abri de chiffres en plus, en moins, ou altérés par rapport à la solution réelle. Pour le cas du binaire, on peut utiliser Python pour trouver son écriture décimale : On préfixe un nombre binaire positif par 0b, et un nombre binaire négatif par -0b, et on le print en l'état. *(Exemple : le nombre binaire -b1101 se trouve en exécutant la ligne print(-0b1101) sur Python, ce qui renvoie bien 13.)*

## une écriture décimale, avec au moins [entre 2 inclu et 5 inclu] chiffres après le séparateur décimal !

**Pré-requis :** Valeurs non-entières.

## une écriture comme fraction qui n'est pas une fraction décimale !

**Pré-requis :** Fractions.

## une écriture comme fraction décimale !

**Pré-requis :** Fractions.

## une écriture comme fraction avec un numérateur négatif !

**Pré-requis :** Fractions ; Relatifs.

**Méthode de résolution (exemple) :** On convertit d'abord le nombre en fraction. Ensuite, on peut exploiter les identités A/B = -((-A)/B), ou -(A/B) = ((-A)/B), ou A/(-B) = (-A)/B.

## une écriture comme fraction avec un dénominateur négatif !

**Pré-requis :** Fractions ; Relatifs.

**Méthode de résolution (exemple) :** On convertit d'abord le nombre en fraction. Ensuite, on peut exploiter les identités A/B = -(A/(-B)), ou -(A/B) = (A/(-B)), ou (-A)/B = A/(-B).

## une écriture comme fraction réductible !

**Pré-requis :** Fractions.

**Méthode de résolution (exemple) :** On convertit d'abord le nombre en fraction. Ensuite, si la fraction obtenue est irréductible, on peut exploiter l'identité A/B = (2A)/(2B), ou A/B = (3A)/(3B), ou A/B = (4A)/(4B), etc.

## une notation scientifique !

**Pré-requis :** Notation scientifique ; Relatifs ; Valeurs non-entières.

**Redondance :** Notation scientifique.

## une notation scientifiques, avec au moins [entre 2 inclu et 5 inclu] chiffres significatifs !

**Pré-requis :** Notation scientifique ; Relatifs ; Valeurs non-entières.

## une écriture en tant que pourcentage !

**Pré-requis :** Pourcentage.

**Redondance :** Pourcentage.

## une écriture qui commence par un signe moins !

**Pré-requis :** Relatifs.

**Méthode de résolution (exemple) :** On peut utiliser l'involution de l'opposée, qui est l'identité A = -(-A).

## une écriture avec aussi peu de symboles que possible !

**Notes :** N'attendez pas forcément qu'une bonne réponse sorte parmi celles qui ont effectivement le moins de symboles possibles, le but est plutôt d'engager les élèves à qui trouvera l'écriture la plus concise.

## une écriture avec une fraction de nombres binaires ! 

**Pré-requis :** Fraction ; Binaire.

**Notes :** Il y a plusieurs façons de l'écrire. Par exemple, on peut utiliser sans préfixe ou suffixe (101 110), avec un préfixe (b 101 110 ici, ou 0b101110 comme en Python), avec un indice 2 en suffixe (101 110₂), etc.

## ses facteurs premiers entre 2 inclu et 5 inclu !

**Pré-requis :** Décomposition en facteurs premiers.

**Ne s'affiche que pour des nombres entiers.**

## son écriture en binaire !

**Pré-requis :** Binaire.

**Ne s'affiche que pour des nombres entiers.**
