<?php
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8');
extract($_GET);
$text="";
if (isset($_POST["btsubmit"])) {
	extract($_POST);
	setcookie($ts,$rdv,time()+10*365*24*3600);
} else if (isset($_COOKIE["$ts"])) {
	$text=$_COOKIE["$ts"];
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Agerda : Rendez-vous</title>
</head>

<body>
	<h1>Saisie d'un rendez-vous pour le <?=strftime("%A %d %B %Y",$ts)?></h1>
	<?php if (isset($_POST["btsubmit"])) { ?>
		<h3>Votre rendez-vous a bien été pris en compte.</h3>
		<a href="agenda.php?mois=<?=date("n",$ts)?>&annee=<?=date("Y",$ts)?>">Retour à l'agenda</a>
	<?php } else { ?>
	<form method="post">
		<input type="hidden" name="ts" value="<?=$ts?>" >
		<p>
			<label for="rdv">Commentaire</label>
			<textarea id="rdv" name="rdv" cols="80" rows="5"><?=$text?></textarea>
		</p>
		<p>
			<input type="submit" name="btsubmit" value="ok">
		</p>
	</form>
	<?php } ?>
</body>

</html>