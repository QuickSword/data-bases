<?php 
echo "<title> Nowe wybory </title>";
$nazwa = $_POST["nazwa"];
$liczba_posad = $_POST["liczba_posad"];
$tz = $_POST["tz"];
$trg = $_POST["trg"];
$tzg = $_POST["tzg"];
$link = pg_connect("host=labdb dbname=mrbd user=jk406704 password=232884");
$id = pg_query($link, "SELECT MAX(id) FROM wybory");
$r = pg_fetch_row($id);
$next = $r[0]+1;
$wynik = pg_query($link, "INSERT INTO wybory VALUES ('" . " $next " . "','" . $nazwa . "','" . $liczba_posad . "','" . $tz . "','" . $trg . "','" . $tzg . "')");

if($wynik) {
    echo "<strong> Zarejestrowano wybory. </strong>";
} else {
    echo "<strong> Błąd lub takie wybory już istnieją. </strong>";
}
pg_close($link);
?>