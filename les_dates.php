<?php
//régle la date sur le fuseau horaire de la France
date_default_timezone_set('Europe/Paris');
//Timestamp : nombre de secondes écoulées depuis le 01/01/1970
echo time();
echo "<hr>";
//Formatage d'un timestamp pour etre lisible
echo date("Y-m-d H:i:s",time());
echo "<hr>";
//fabrication d'un timestamp avec mktime(Heure, Minute, Seconde, Mois, Jour, Année)
$x=mktime(15,20,32,8,23,1978);
echo $x;
echo "<hr>";
//affichage du jour de la semaine et du mois (en Anglais) correspondant à un timestamp
echo date("l d F Y à H:i",$x);
echo "<hr>";
//affichage en Français
setlocale(LC_TIME, 'fr_FR.utf8');
echo strftime("%A %d %B %Y à %H:%M",$x);
echo "<hr>";

for($i=1;$i<100;$i++) {
    $x=mktime(15,20,32,8,$i,1978);
    echo strftime("%A %d %B %Y à %H:%M",$x);
    echo "<hr>";
}
?>
