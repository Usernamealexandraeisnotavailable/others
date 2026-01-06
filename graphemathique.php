<title>Graphémathique</title>
<?php
foreach ($_GET as $i => $v) {
	$_GET[$i] = str_replace(["\"","<",">"],["&quot;","&lt;","&gt;"],$v);
	// petite sécurité lol
}
?>
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
		// "sci", // Écriture scientifique
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
	$multi = 1;
	if (rand(0,1)*rand(0,1)) // proba 1/4
		$multi = 3;
    return $retour_int*$multi;
	// les seuls facteurs premiers sont 2, 3 et 5, et 9 n'en est jamais un facteur
}
function entfrac_alea () {
	$denom = denom_alea();
    return "\\frac{".espacements_en_trois(strval(intval(short_ent_alea())*$denom))."}{".espacements_en_trois(strval($denom))."}";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'entfrac_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		"frac", // Fractions
		// "sci", // Écriture scientifique
		// "pc", // Pourcentage
		// "rel", // Relatifs
		// "nonent", // Non-entières
	]
);
$ecriture['entfrac_alea'] = "frac";
function frac_alea () {
    return "\\frac{".espacements_en_trois(strval(intval(str_replace("\\,","",ent_alea()))))."}{".espacements_en_trois(strval(denom_alea()))."}";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'frac_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		"frac", // Fractions
		// "sci", // Écriture scientifique
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
		// "sci", // Écriture scientifique
		// "pc", // Pourcentage
		// "rel", // Relatifs
		"nonent", // Non-entières
	]
);
$ecriture['dec_alea'] = "dec";

// ÉCRITURE SCIENTIFIQUE
// chiffres significatifs : nombre de chiffres apparents dans une écriture scientifique du nombre

function entsci_alea () {
    return rand(1,9)."\\times10^{".rand(0,9)."}";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'entsci_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		// "frac", // Fractions
		"sci", // Écriture scientifique
		// "pc", // Pourcentage
		// "rel", // Relatifs
		// "nonent", // Non-entières
	]
);
$ecriture['entsci_alea'] = "sci";
function entrelsci_alea () {
    return rel_alea().rand(1,9)."\\times10^{".rel_alea().rand(1,9)."}";
}
$fonctions[count($fonctions)] = array (
	"nom" => 'entrelsci_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		// "frac", // Fractions
		"sci", // Écriture scientifique
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
		"sci", // Écriture scientifique
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
		"sci", // Écriture scientifique
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
		// "sci", // Écriture scientifique
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
		// "sci", // Écriture scientifique
		// "pc", // Pourcentage
		"rel", // Relatifs
		"nonent", // Non-entières
	]
);
$ecriture['decrel_alea'] = "dec";
function relfrac_alea () {
	return rel_alea().frac_alea();
}
$fonctions[count($fonctions)] = array (
	"nom" => 'relfrac_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		"frac", // Fractions
		// "sci", // Écriture scientifique
		// "pc", // Pourcentage
		"rel", // Relatifs
		"nonent", // Non-entières
	]
);
$ecriture['relfrac_alea'] = "frac";
function entrelfrac_alea () {
	return rel_alea().entfrac_alea();
}
$fonctions[count($fonctions)] = array (
	"nom" => 'entrelfrac_alea',
	"prerequis" => [
		// "dec", // Écriture décimale
		"frac", // Fractions
		// "sci", // Écriture scientifique
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
		// "sci", // Écriture scientifique
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
		// "sci", // Écriture scientifique
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
		// "sci", // Écriture scientifique
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
		// "sci", // Écriture scientifique
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
		// "sci", // Écriture scientifique
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
		// "sci", // Écriture scientifique
		// "pc", // Pourcentage
		"rel", // Relatifs
		// "nonent", // Non-entières
		"dfp" // Décomposition en facteurs premiers (addition plus récente)
	]
);
$ecriture['dfprel_alea'] = "dfp";

// MENU

if (!isset($_GET["ok"])) {
?>

<form method="get">
<table><tr>
<td style="font-size: 30pt"><span style="font-size: 5pt"><br></span>
<big><b>Graphémat<i>h</i>ique</b></big><br><small><small>Un casse-têtes qui mêle maths et écriture&nbsp;!
<center style="background-color: grey; color: white">
<small style="font-family: Times New Roman"><br><b>Graphématique.</b> <i>n.f.</i> Étude linguistique des<br>systèmes d'écriture et de leurs composantes<br>de base, i.e. les graphèmes.<br><br></small></small></small>
</center>
<small><small><a href="https://github.com/Usernamealexandraeisnotavailable/others/blob/main/graphemathique.php" target="_blank">code source</a></small></small><br>
Nombre de questions (max.)&nbsp;: <input type="number" name="seuil_max" min="1" max="10" value="5" style="font-size: 30pt; text-align: center"><br>
<label><input type="checkbox" name="dec"<?php if (rand(0,1)) { ?> checked <?php } ?>> Écriture décimale</label><br>
<label><input type="checkbox" name="frac"<?php if (rand(0,1)) { ?> checked <?php } ?>> Fractions</label><br>
<label><input type="checkbox" name="sci"<?php if (rand(0,1)) { ?> checked <?php } ?>> Écriture scientifique</label><br>
<label><input type="checkbox" name="pc"<?php if (rand(0,1)) { ?> checked <?php } ?>> Pourcentage</label><br>
<label><input type="checkbox" name="dfp"<?php if (rand(0,1)) { ?> checked <?php } ?>> Décomposition en facteurs premiers</label><br>
<small><small>
<label><input type="checkbox" name="rel"<?php if (rand(0,1)) { ?> checked <?php } ?> style="width: 18pt; height: 18pt"> <i>Relatifs</i></label><br>
<label><input type="checkbox" name="nonent"<?php if (rand(0,1)) { ?> checked <?php } ?> style="width: 18pt; height: 18pt"> <i>Valeurs non-entières</i></label><br>
<input type="submit" name="ok" value="OK" style="font-size: 30pt; width: 100%">
</table>
</form>

<?php
} else {
	
	// QUESTIONS
	
	if (isset($_GET["nonent"]))
	$specifiques = array (
		"dec" => [
			"<li>sa partie entière&nbsp;!",
			"<li>sa partie décimale&nbsp;!",
			"<li>un arrondi à l'unité près&nbsp;!"
		],
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
		"dfp" => []
	);
	else
	$specifiques = array (
		"dec" => [
			"<li>sa partie entière&nbsp;!",
			"<li>sa partie décimale&nbsp;!"
		],
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
		"dfp" => []
	);
	
	$conversions = array (
		array (
			"schema" => "<li>son chiffre des unités&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Écriture scientifique
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
				// "sci", // Écriture scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				// "nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>une écriture décimale&nbsp;!\n",
			"prerequis" => [
				"dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Écriture scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				// "nonent", // Non-entières
			],
			"redondance" => "dec"
		),
		array (
			"schema" => "<li>une écriture décimale, avec au moins ".rand(2,5)." chiffres après la virgule&nbsp;!\n",
			"prerequis" => [
				"dec", // Écriture décimale
				// "frac", // Fractions
				// "sci", // Écriture scientifique
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
				// "sci", // Écriture scientifique
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
				// "sci", // Écriture scientifique
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
				// "sci", // Écriture scientifique
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
				// "sci", // Écriture scientifique
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
				// "sci", // Écriture scientifique
				// "pc", // Pourcentage
				// "rel", // Relatifs
				// "nonent", // Non-entières
			]
		),
		array (
			"schema" => "<li>une écriture scientifique&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				"sci", // Écriture scientifique
				// "pc", // Pourcentage
				"rel", // Relatifs /* ça risque de demander des magnitudes négatives */
				"nonent", // Non-entières /* en général ça risque de demander des nombres non-entiers */
			],
			"redondance" => "sci"
		),
		array (
			"schema" => "<li>une écriture scientifique, avec au moins ".rand(2,5)." chiffres significatifs&nbsp;!\n",
			"prerequis" => [
				// "dec", // Écriture décimale
				// "frac", // Fractions
				"sci", // Écriture scientifique
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
				// "sci", // Écriture scientifique
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
				// "sci", // Écriture scientifique
				// "pc", // Pourcentage
				"rel", // Relatifs
				// "nonent", // Non-entières
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
		print "<i style='font-size: 30pt'>hein&nbsp;?</i>";
		print "<meta http-equiv='refresh' content='1; ?'>";
	} else {
		$fun = $utilisables[rand(0,count($utilisables)-1)];
		print "<br>\n<span style='color: white'>";
		print "\\(\\color{black}\\sf".$fun()."\\)";
		print "</span><table><tr><td><ul style='font-size: 20pt'><br><br>Trouvez-lui...<br>";
		$questions = [];
		foreach ($specifiques[$ecriture[$fun]] as $specifique)
			$questions[count($questions)] = $specifique."\n";
		foreach (conversions_utilisables($ecriture[$fun]) as $conversion)
			$questions[count($questions)] = $conversion."\n";
		if (isset($_GET["dfp"]) and in_array($fun, ['ent_alea','entfrac_alea','entpc_alea','entsci_alea','entrel_alea','entrelfrac_alea','entrelpc_alea','entrelsci_alea'])) {
			$questions[count($questions)] = "<li>ses facteurs premiers entre 2 inclu et 5 inclu&nbsp;!";
		}
		shuffle ($questions);
		$nombre_restants = intval($_GET["seuil_max"]);
		foreach ($questions as $question) {
			print $question;
			$nombre_restants--;
			if ($nombre_restants == 0)
				break;
		}
		print "<center><a href='' style='font-size: 50pt'>⟳</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='?' style='font-size: 50pt'>⌫</a></table>";
	}
	
}
?>
