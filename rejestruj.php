<?php 
echo "<title> Zarejestruj nowych użytkowników </title>";
$log = $_POST["login"];
$pass = $_POST["pass"];
$imie = $_POST["imie"];
$nazwisko = $_POST["nazwisko"];
$tn = $_POST["i"];
$link = pg_connect("host=labdb dbname=mrbd user=jk406704 password=232884");
$wynik = pg_query($link, "INSERT INTO users VALUES ('" . $log . "','" . $pass . "')");
$u = pg_query($link, "INSERT INTO wyborcy VALUES ('" . $log . "','" . $imie . "','" . $nazwisko . "','" . $tn . "')");
    
if($wynik) {
    echo "<strong> Zarejestrowano wyborcę. </strong>";
} else {
    echo "<strong> Błąd lub taki użytkownik już istnieje. </strong>";
}
?>