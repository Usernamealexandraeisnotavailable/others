<title>Graphémathique</title>
<?php
foreach ($_GET as $i => $v) {
	$_GET[$i] = str_replace(['"',"'",'<','>'],['&quot;','’','&lt;','&gt;'],$v);
	// petite sécurité !
}
if (isset($_GET["seuil_max"]))
	$seuil_max = max(1,min(5,intval($_GET["seuil_max"])));
if (isset($_GET["graine"])) {
	if (intval($_GET["graine"]) == 0)
		$graine = rand(1,1000000);
	else $graine = max(1,min(1000000,intval($_GET["graine"])));
} else $graine = rand(1,1000000);
srand($graine);
?>
<meta name="description" content="Un casse-tête qui mêle maths et écriture&nbsp;!">
<!-- Le jeu utilise la génération procédurale : Chaque "partie" est générée aléatoirement, il n'y a pas de banque d'exercices prédéfinie. -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Andika:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<script id='MathJax-script' async src='https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js'></script>
<style>
td, input, span {
	font-family: Andika
}
td {
    font-size : 100pt
}
input[type="checkbox"] {
	width: 30px;
	height: 30px
}
form {
	margin : 0pt;
	padding : 0pt
}
a {
	color: rgb(50,100,255);
	text-decoration: none
}
a:hover {
	border: rgb(50,100,255)
}
</style>
<table width="100%" height="100%">
<tr width="100%" height="100%">
<td width="100%" height="100%" valign="center">
<center>
<?php

$fonctions = [];
$ecriture = [];

function espacements_en_trois ($str) {
	$retour = "";
	$j = 0;
	for ($i = strlen($str)-1; $i >= 0; $i--) {
		$retour .= $str[$i];
		$j++;
		if ($j % 3 == 0 and $i != 0)
			$retour .= ",\\";
	}
	return strrev($retour);
}

// SIGNE / NOMBRES RELATIFS

function rel_alea () {
    if (rand(0,1))
        return "-";
    return "";
}

// ENTIERS

function ent_alea () {
    $fini = false;
    $retour = strval(rand(1,9));
    while (!$fini) {
        $retour .= strval(rand(0,9));
        $fini = rand(0,1); // proba 1/2
    }
	// loi géométrique de paramètre 1/2 sur la longueur de l'entier généré
    return espacements_en_trois($retour);
}
$fonctions[count($fonctions)] = array (
	"nom" => 'ent_alea',
	"prerequis" => [
		"dec", // Écriture décimale
		// "frac", // Fractions
		// "sci", // Notation scientifique
		// "pc", // Pourcentage
		// "rel", // Relatifs
		// "nonent", // Non-entières
	]
);
$ecriture['ent_alea'] = "dec";
function short_ent_alea () {
    $fini = false;
    $retour = strval(rand(1,9));
    while (!$fini) {
        $retour .= strval(rand(0,9));
        $fini = 1 - rand(0,1)*rand(0,1); // proba 3/4
    }
	// loi géométrique de paramètre 1/4 sur la longueur de l'entier généré
    return $retour;
	// à noter qu'il n'y a pas d'espacements en trois dans cette fonction-ci
}

// FRACTIONS

function denom_alea () {
    $retour_int = 1;
    $fini = false; 
    while (!$fini) {
        $retour_int *= 2;
        $fini = rand(0,1); // proba 1/2
    }
    $fini = false; 
    while (!$fini) {
        $retour_int *= 5;
        $fini = 1-rand(0,1)*rand(0,1); // proba 3/4
    }
    return $retour_int;
	// les seuls facteurs premiers sont 2 et 5, pour s'assurer d'avoir des nombres décimaux
}
function entfrac_alea () {
	$multi = 1;
	if (rand(0,1)*rand(0,1)) // proba 1/4
		$multi = 3;
	elseif (rand(0,1)*rand(0,1)) // proba 1/4
		$multi = 7;
	$denom = denom_alea()*$multi;
    return "\\frac{".espacements_en_trois(strval(intval(short_ent_alea())*$denom*$multi))."}{".espacements_en_trois(strval($denom*$multi))."}";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'entfrac_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		"frac", // Fractions
		// "sci", // Notation scientifique
		// "pc", // Pourcentage
		// "rel", // Relatifs
		// "nonent", // Non-entières
	]
);
$ecriture['entfrac_alea'] = "frac";
function frac_alea () {
	$multi = 1;
	if (rand(0,1)*rand(0,1)) // proba 1/4
		$multi = 3;
	elseif (rand(0,1)*rand(0,1)) // proba 1/4
		$multi = 7;
    return "\\frac{".espacements_en_trois(strval(intval(str_replace("\\,","",ent_alea()))*$multi))."}{".espacements_en_trois(strval(denom_alea()*$multi))."}";
	// ça permet d'avoir des fois des dénominateurs multiples de 3 xor de 7, tout en gardant un développement décimal fini
}
$fonctions[count($fonctions)] = array (
	"nom" => 'frac_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		"frac", // Fractions
		// "sci", // Notation scientifique
		// "pc", // Pourcentage
		// "rel", // Relatifs
		"nonent", // Non-entières
	]
);
$ecriture['frac_alea'] = "frac";

// ÉCRITURES DÉCIMALES

function dec_alea () {
	$fini = rand(0,1);
	$zeros = "";
	while (!$fini) {
		$zeros .= "0";
		$fini = rand(0,1);
	}
	if (rand(0,1))
		return ent_alea()."{,}".$zeros.short_ent_alea();
	return "0{,}".$zeros.short_ent_alea();
}
$fonctions[count($fonctions)] = array (
	"nom" => 'dec_alea',
	"prerequis" => [
		"dec", // Écriture décimale
		// "frac", // Fractions
		// "sci", // Notation scientifique
		// "pc", // Pourcentage
		// "rel", // Relatifs
		"nonent", // Non-entières
	]
);
$ecriture['dec_alea'] = "dec";

// ÉCRITURE SCIENTIFIQUE
// chiffres significatifs : nombre de chiffres apparents dans une notation scientifique du nombre

function entsci_alea () {
    return rand(1,9)."\\times10^{".rand(0,9)."}";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'entsci_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		// "frac", // Fractions
		"sci", // Notation scientifique
		// "pc", // Pourcentage
		// "rel", // Relatifs
		// "nonent", // Non-entières
	]
);
$ecriture['entsci_alea'] = "sci";
function entrelsci_alea () {
    return rel_alea().rand(1,9)."\\times10^{".rand(1,9)."}";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'entrelsci_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		// "frac", // Fractions
		"sci", // Notation scientifique
		// "pc", // Pourcentage
		"rel", // Relatifs
		// "nonent", // Non-entières
	]
);
$ecriture['entrelsci_alea'] = "sci";
function decsci_alea () {
    return rand(1,9)."{,}".short_ent_alea()."\\times10^{".rand(0,9)."}";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'decsci_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		// "frac", // Fractions
		"sci", // Notation scientifique
		// "pc", // Pourcentage
		// "rel", // Relatifs
		"nonent", // Non-entières
	]
);
$ecriture['decsci_alea'] = "sci";
function decrelsci_alea () {
    return rel_alea().rand(1,9)."{,}".short_ent_alea()."\\times10^{".rel_alea().rand(1,9)."}";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'decrelsci_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		// "frac", // Fractions
		"sci", // Notation scientifique
		// "pc", // Pourcentage
		"rel", // Relatifs
		"nonent", // Non-entières
	]
);
$ecriture['decrelsci_alea'] = "sci";

// FONCTIONS COMBINÉES

function entrel_alea () {
	return rel_alea().ent_alea();
}
$fonctions[count($fonctions)] = array (
	"nom" => 'entrel_alea',
	"prerequis" => [
		"dec", // Écriture décimale
		// "frac", // Fractions
		// "sci", // Notation scientifique
		// "pc", // Pourcentage
		"rel", // Relatifs
		// "nonent", // Non-entières
	]
);
$ecriture['entrel_alea'] = "dec";
function decrel_alea () {
	return rel_alea().dec_alea();
}
$fonctions[count($fonctions)] = array (
	"nom" => 'decrel_alea',
	"prerequis" => [
		"dec", // Écriture décimale
		// "frac", // Fractions
		// "sci", // Notation scientifique
		// "pc", // Pourcentage
		"rel", // Relatifs
		"nonent", // Non-entières
	]
);
$ecriture['decrel_alea'] = "dec";
function relfrac_alea () {
	$multi = 1;
	if (rand(0,1)*rand(0,1)) // proba 1/4
		$multi = 3;
	elseif (rand(0,1)*rand(0,1)) // proba 1/4
		$multi = 7;
    return rel_alea()."\\frac{".rel_alea().espacements_en_trois(strval(intval(str_replace("\\,","",ent_alea()))*$multi))."}{".rel_alea().espacements_en_trois(strval(denom_alea()*$multi))."}";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'relfrac_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		"frac", // Fractions
		// "sci", // Notation scientifique
		// "pc", // Pourcentage
		"rel", // Relatifs
		"nonent", // Non-entières
	]
);
$ecriture['relfrac_alea'] = "frac";
function entrelfrac_alea () {
	$multi = 1;
	if (rand(0,1)*rand(0,1)) // proba 1/4
		$multi = 3;
	elseif (rand(0,1)*rand(0,1)) // proba 1/4
		$multi = 7;
	$denom = denom_alea()*$multi;
    return rel_alea()."\\frac{".rel_alea().espacements_en_trois(strval(intval(short_ent_alea())*$denom*$multi))."}{".rel_alea().espacements_en_trois(strval($denom*$multi))."}";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'entrelfrac_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		"frac", // Fractions
		// "sci", // Notation scientifique
		// "pc", // Pourcentage
		"rel", // Relatifs
		// "nonent", // Non-entières
	]
);
$ecriture['entrelfrac_alea'] = "frac";
function entpc_alea () {
	return espacements_en_trois(strval(intval(short_ent_alea())*100))."\\,\\%";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'entpc_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		// "frac", // Fractions
		// "sci", // Notation scientifique
		"pc", // Pourcentage
		// "rel", // Relatifs
		// "nonent", // Non-entières
	]
);
$ecriture['entpc_alea'] = "pc";
function entrelpc_alea () {
	return rel_alea().espacements_en_trois(strval(intval(short_ent_alea())*100))."\\,\\%";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'entrelpc_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		// "frac", // Fractions
		// "sci", // Notation scientifique
		"pc", // Pourcentage
		"rel", // Relatifs
		// "nonent", // Non-entières
	]
);
$ecriture['entrelpc_alea'] = "pc";
function decpc_alea () {
	return dec_alea()."\\,\\%";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'decpc_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		// "frac", // Fractions
		// "sci", // Notation scientifique
		"pc", // Pourcentage
		// "rel", // Relatifs
		"nonent", // Non-entières
	]
);
$ecriture['decpc_alea'] = "pc";
function decrelpc_alea () {
	return rel_alea().dec_alea()."\\,\\%";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'decrelpc_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		// "frac", // Fractions
		// "sci", // Notation scientifique
		"pc", // Pourcentage
		"rel", // Relatifs
		"nonent", // Non-entières
	]
);
$ecriture['decrelpc_alea'] = "pc";

// DÉCOMPOSITION EN FACTEURS PREMIERS

function dfp_alea () {
	$retour = "";
	$aumoinsun = false;
	foreach ([2,3,5,7] as $p) {
		if (rand(0,1)) {
			$retour .= "$p^{".rand(1,max(2,6-$p))."}\\times";
			$aumoinsun = true;
		}
		if (!$aumoinsun) {
			return dfp_alea();
		}
	}
	$retour .= "/";
	$retour = str_replace("\\times/","",$retour);
	return $retour;
}
$fonctions[count($fonctions)] = array (
	"nom" => 'dfp_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		// "frac", // Fractions
		// "sci", // Notation scientifique
		// "pc", // Pourcentage
		// "rel", // Relatifs
		// "nonent", // Non-entières
		"dfp" // Décomposition en facteurs premiers (addition plus récente)
	]
);
$ecriture['dfp_alea'] = "dfp";
function dfprel_alea () {
	return rel_alea().dfp_alea();
}
$fonctions[count($fonctions)] = array (
	"nom" => 'dfprel_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		// "frac", // Fractions
		// "sci", // Notation scientifique
		// "pc", // Pourcentage
		"rel", // Relatifs
		// "nonent", // Non-entières
		"dfp" // Décomposition en facteurs premiers (addition plus récente)
	]
);
$ecriture['dfprel_alea'] = "dfp";

// binaire

function bin_alea () {
    $fini = false;
    $retour = '1';
    while (!$fini) {
        $retour .= strval(rand(0,1));
        $fini = rand(0,1)*rand(0,1); // proba 1/4
    }
	// loi géométrique de paramètre 1/4 sur la longueur de l'entier généré
    return "\\tt b\\,".espacements_en_trois($retour)."";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'bin_alea',
	"prerequis" => [
		"dec", // Écriture décimale
		// "frac", // Fractions
		// "sci", // Notation scientifique
		// "pc", // Pourcentage
		// "rel", // Relatifs
		// "nonent", // Non-entières
		"bin" // Binaire
	]
);
$ecriture['bin_alea'] = "bin";

function binrel_alea () {
    $fini = false;
    $retour = '1';
    while (!$fini) {
        $retour .= strval(rand(0,1));
        $fini = rand(0,1)*rand(0,1); // proba 1/4
    }
	// loi géométrique de paramètre 1/4 sur la longueur de l'entier généré
    return "\\tt ".rel_alea()."b\\,".espacements_en_trois($retour)."";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'binrel_alea',
	"prerequis" => [
		"dec", // Écriture décimale
		// "frac", // Fractions
		// "sci", // Notation scientifique
		// "pc", // Pourcentage
		"rel", // Relatifs
		// "nonent", // Non-entières
		"bin" // Binaire
	]
);
$ecriture['binrel_alea'] = "bin";

// MENU

if (!isset($_GET["seuil_max"])) {

?>

<form method="get">
<table><tr>
<td style="font-size: 25pt">
<big><b><a href="?">Graphémat<i>h</i>ique</a></b></big><br><small><small>Un casse-tête qui mêle maths et écriture&nbsp;!
<center style="background-color: grey; color: white">
<small style="font-family: Times New Roman"><br><b>Graphématique.</b> <i>n.f.</i> Étude linguistique des<br>systèmes d'écriture et de leurs composantes<br>de base, i.e. les graphèmes.<br><br></small></small></small>
</center>
<small><small><a href="https://github.com/Usernamealexandraeisnotavailable/others/blob/main/graphemathique.php" target="_blank">code source</a> &bullet; <a href="https://github.com/Usernamealexandraeisnotavailable/others/blob/main/graphemathique.md" target="_blank">méthodes de résolution et de vérification</a></small></small><br>
<b style="color: rgb(255, 0, 127)">Nombre de questions (max.)&nbsp;:</b> <input type="number" name="seuil_max" min="1" max="5" required style="font-size: 25pt; text-align: center" value=""><br>
<!-- L'attribut required permet de faire en sorte que l'utilisateur doive lui-même saisir le nombre de questions à générer. (Maximum 5 pour éviter d'en avoir trop à chaque partie.) -->
<label><input type="checkbox" name="rel"<?php if (rand(0,10) != 0) { ?> checked <?php } ?>> <i style="color: rgb(255,127,127)">Relatifs</i></label><br>
<label><input type="checkbox" name="nonent"<?php if (rand(0,10) != 0) { ?> checked <?php } ?>> <i style="color: rgb(255,127,127)">Valeurs non-entières</i></label><br>
<!-- Ces options-ci ne permettent pas de générer des questions à elles seules, donc le fait qu'elles soient cochées automatiquement la plupart du temps (aléatoirement) permet de montrer qu'il s'agit de cases à cocher. -->
<label><input type="checkbox" name="dec"> Écriture décimale</label><br>
<label><input type="checkbox" name="frac"> Fractions</label><br>
<label><input type="checkbox" name="sci"> Notation scientifique</label><br>
<label><input type="checkbox" name="pc"> Pourcentage</label><br>
<label><input type="checkbox" name="dfp"> Décomposition en facteurs premiers</label><br>
<label><input type="checkbox" name="bin"> Binaire</label><br>
<!-- Ces options ne sont pas cochées, pour faire en sorte qu'il y ait plus de chance qu'aucune des options ci-dessus ne soient cochées, résultant en un "Options incomplètes, veuillez cocher d'autres options&nbsp;!" -->
Graine&nbsp;: <input type="number" name="graine" min="1" max="1000000" style="font-size: 25pt; text-align: center; font-family: Courier" placeholder="<?=$graine;?>"><br>
<!-- Permet de mettre une graine -->
<input type="submit" name="ok" value="OK" style="font-size: 30pt; width: 100%">
</table>
</form>
<!-- Globalement, ce formulaire est fait pour pousser l'utilisateur à choisir les options qu'il veut, et le nombre de questions à générer. -->

<?php
} else {
	
	// QUESTIONS
	
	$specifiques = array (
		"dec" => [],
		"frac" => [
			"<li>son numérateur&nbsp;!",
			"<li>son dénominateur&nbsp;!",
			"<li>une écriture sous forme de fraction irréductible&nbsp;!"
		],
		"sci" => [
			"<li>son ordre de grandeur&nbsp;!",
			"<li>son exposant&nbsp;!",
			"<li>son nombre de chiffres significatifs&nbsp;!"
		],
		"pc" => [],
		"dfp" => [],
		"bin" => []
	);
	
	$conversions = array (
		array (
			"schema" => "<li>son chiffre des unités&nbsp;!\n", // <-- ça, c'est pour la partie "graphème"
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				// "nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>son chiffre des dizaines&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				// "nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>son chiffre des centaines&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				// "nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>son chiffre des dixièmes&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				"nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>son chiffre des centièmes&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				"nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>une écriture décimale&nbsp;!\n", // <-- et à partir de là, c'est surtout la partie "système d'écriture"
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				// "nonent", // Non-entières
			],
			"redondance" => "dec"
		),
		array (
			"schema" => "<li>une écriture décimale, avec au moins ".rand(2,5)." chiffres après le séparateur décimal&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				"nonent", // Non-entières /* techniquement ça resterait des entiers, mais les virgules ne sont pas vus avant */
			]
		),
		array (
			"schema" => "<li>une écriture comme fraction qui n'est pas une fraction décimale&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				"frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				// "nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>une écriture comme fraction décimale&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				"frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				// "nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>une écriture comme fraction avec un numérateur négatif&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				"frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				"rel", // Relatifs
				// "nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>une écriture comme fraction avec un dénominateur négatif&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				"frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				"rel", // Relatifs
				// "nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>une écriture comme fraction réductible&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				"frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				// "nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>une notation scientifique&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				"sci", // Notation scientifique
				// "pc", // Pourcentage
				"rel", // Relatifs /* ça risque de demander des magnitudes négatives */
				"nonent", // Non-entières /* en général ça risque de demander des nombres non-entiers */
			],
			"redondance" => "sci"
		),
		array (
			"schema" => "<li>une notation scientifique, avec au moins ".rand(2,5)." chiffres significatifs&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				"sci", // Notation scientifique
				// "pc", // Pourcentage
				"rel", // Relatifs /* ça risque de demander des magnitudes négatives */
				"nonent", // Non-entières /* en général ça risque de demander des nombres non-entiers, ou avec virgule explicite */
			]
		),
		array (
			"schema" => "<li>une écriture en tant que pourcentage&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Notation scientifique
				"pc", // Pourcentage
				// "rel", // Relatifs
				// "nonent", // Non-entières
			],
			"redondance" => "pc"
		),
		array (
			"schema" => "<li>une écriture qui commence par un signe moins&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				"rel", // Relatifs
				// "nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>une écriture avec aussi peu de symboles que possible&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Notation scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				// "nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>une écriture avec une fraction de nombres binaires&nbsp;!",
			"prerequis" => [
				"frac",
				"bin"
			]
		)
	);
	
	// JEU
	
	function fonctions_utilisables () {
		global $fonctions;
		$retour = [];
		foreach ($fonctions as $fonction) {
			$bool = true;
			foreach ($fonction["prerequis"] as $pre) {
				if (!isset($_GET[$pre])) {
					$bool = false;
				}
			}
			if ($bool)
				$retour[count($retour)] = $fonction["nom"];
		}
		return $retour;
	}
	
	function conversions_utilisables ($ecriture) {
		global $conversions;
		$retour = [];
		foreach ($conversions as $conversion) {
			$bool = true;
			if (isset($conversion["redondance"]))
				if ($conversion["redondance"] == $ecriture)
					$bool = false;
			foreach ($conversion["prerequis"] as $pre) {
				if (!isset($_GET[$pre])) {
					$bool = false;
				}
			}
			if ($bool)
				$retour[count($retour)] = $conversion["schema"];
		}
		return $retour;
	}
	
	$utilisables = fonctions_utilisables();
	
	if (count($utilisables) == 0) {
		print "<i style='font-size: 30pt'>Options incomplètes, veuillez cocher d'autres options&nbsp;!</i><br><i style='font-size: 15pt'>Veuillez patienter 5 secondes, on vous redirige sur le menu...</i>";
		print "<meta http-equiv='refresh' content='5; ?'>";
	} else {
		$fun = $utilisables[rand(0,count($utilisables)-1)];
		print "<span style='font-size: 50pt'><br></span>\n<span style='color: white'>";
		print "\\(\\color{black}\\sf".$fun()."\\)";
		print "</span><table><tr><td><ul style='font-size: 20pt'><br><br>Trouvez-lui...<br>";
		$questions = [];
		foreach ($specifiques[$ecriture[$fun]] as $specifique)
			$questions[count($questions)] = $specifique."\n";
		foreach (conversions_utilisables($ecriture[$fun]) as $conversion)
			$questions[count($questions)] = $conversion."\n";
		if (isset($_GET["dfp"]) and in_array($fun, ['ent_alea','entfrac_alea','entpc_alea','entsci_alea','entrel_alea','entrelfrac_alea','entrelpc_alea','entrelsci_alea','bin_alea','binrel_alea'])) {
			$questions[count($questions)] = "<li>ses facteurs premiers entre 2 inclu et 5 inclu&nbsp;!";
		}
		if (isset($_GET["bin"]) and in_array($fun, ['ent_alea','entfrac_alea','entpc_alea','entsci_alea','entrel_alea','entrelfrac_alea','entrelpc_alea','entrelsci_alea','bin_alea','binrel_alea'])) { // un nombre décimal ne peut pas toujours être écrit comme une fraction dyadique
			$questions[count($questions)] = "<li>son écriture en binaire&nbsp;!";
		}
		shuffle ($questions);
		$nombre_restants = $seuil_max;
		foreach ($questions as $question) {
			print $question;
			$nombre_restants--;
			if ($nombre_restants == 0)
				break;
		}
		if (substr_count($_SERVER['REQUEST_URI'], "graine") > 0) {
			$uri = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "&graine="));
		} else {
			$uri = $_SERVER['REQUEST_URI'];
		}
		print "<center><span style='font-size: 30pt'>Graine&nbsp;: <a href='$uri&graine=$graine' style='font-family: courier; font-size: 30pt'>$graine</span></span><br><a href='$uri' style='font-size: 50pt'>⟳</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='?' style='font-size: 50pt'>⌫</a></table>";
	}
	
}
?>
