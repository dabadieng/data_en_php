<?php
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8');

//Affiche la liste déroulante des mois
function affiche_SelectMois()
{
	global $liste_mois, $mois;
	?>
	<label for="mois">Mois</label>
	<select id="mois" name="mois">
		<?php
			foreach ($liste_mois as $cle => $valeur) {
				if ($mois == $cle)
					echo "<option selected='selected' value='$cle'>$valeur</option>";
				else
					echo "<option value='$cle'>$valeur</option>";
			}
			?>
	</select>
<?php
}
//initialisation du tableau des mois
$liste_mois = [];
$mois = "";
for ($i = 1; $i <= 12; $i++) {
	$x = mktime(0, 0, 0, $i, 1, 2000);
	$liste_mois[$i] = strftime("%B", $x);
}

//initialisation du tableau des jours de la semaine
$liste_jsem = [];
for ($i = 1; $i <= 7; $i++) {
	$x = mktime(0, 0, 0, 1, $i, 1);
	$liste_jsem[$i] = strftime("%A", $x);
}

//si je reçois les données du formulaire
if (isset($_POST["btSubmit"])) {
	extract($_POST);
} else if (isset($_GET["mois"])) {
	extract($_GET);
	if ($mois == 0) {
		$mois = 12;
		$annee--;
	} else if ($mois == 13) {
		$mois = 1;
		$annee++;
	}
} else {
	$mois = (int) date("m");
	$annee = date("Y");
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8" />
	<title>Agenda</title>
	<link href="style.css" rel="stylesheet">
</head>

<body>
	<form method="post">
		<table>
			<tr>
				<td colspan="3">
					<?php affiche_SelectMois(); ?>
				</td>
				<td colspan="3">
					<label for="annee">Année</label>
					<input type="number" id="annee" name="annee" value="<?= $annee ?>" />
				</td>
				<td><input type="submit" name="btSubmit" value="OK" /></td>
			</tr>
			<tr>
				<td><a href="agenda.php?mois=<?= $mois - 1 ?>&annee=<?= $annee ?>">mois précédent</a></td>
				<td colspan="5"><?= $liste_mois[$mois] . " $annee" ?></td>
				<td><a href="agenda.php?mois=<?= $mois + 1 ?>&annee=<?= $annee ?>">mois suivant</a></td>
			</tr>
		</table>
		<table class="calendrier">
			<colgroup>
				<col span="5">
				<col span="2" class="weekend">
			</colgroup>
			<thead>
				<tr>
					<?php
					foreach ($liste_jsem as $cle => $valeur)
						echo "<th>$valeur</th>";
					?>
				</tr>
			</thead>

			<tbody>
				<?php
				$compteur = 1;
				echo "<tr>";
				$i0 = date("N", mktime(0, 0, 0, $mois, 1, $annee));
				for ($i = 1; $i < $i0; $i++) {
					echo "<td></td>";
				}
				$compteur = $i0;
				for ($i = 1; $i <= date("t", mktime(0, 0, 0, $mois, 1, $annee)); $i++) {			
					$ts=mktime(1, 0, 0, $mois, $i, $annee);
					$tdtext="<a href='rdv.php?ts=$ts'>" . date("d", $ts) . "</a>";
					if (isset($_COOKIE["$ts"])) {
						$tdtext=$tdtext . "<br>" . $_COOKIE["$ts"];
					}
					echo "<td>$tdtext</td>";
					$compteur++;
					if ($compteur > 7) {
						echo "</tr>";
						echo "<tr>";
						$compteur = 1;
					}
				}
				echo "</tr>";
				?>
			</tbody>
			<tfoot>
			</tfoot>			
		</table>
	</form>
	<h1>Liste des rendez-vous</h1>
	<ul>
		<?php
		foreach($_COOKIE as $cle=>$valeur) {
			if (is_int($cle)) {
				echo "<li>" . strftime("%A %d %B %Y",$cle) . " : " . $valeur . "</li>";
			}
		}
		?>
	</ul>
	
</body>

</html>