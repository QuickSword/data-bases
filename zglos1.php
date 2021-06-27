<?php 
echo "<title> Zgłoś kandydatów </title>";
$id = $_POST["id"];
$imie = $_POST["imie"];
$nazwisko = $_POST["nazwisko"];

$link = pg_connect("host=labdb dbname=mrbd user=jk406704 password=232884");
$indeks = pg_query_params($link, "SELECT * FROM wyborcy WHERE imie=$1 AND nazwisko=$2", array($imie,$nazwisko));
$ile = pg_numrows($indeks);
$result = pg_query_params($link, "SELECT * FROM wyborcy WHERE imie=$1 AND nazwisko=$2", array($imie,$nazwisko));
$idks = pg_fetch_row($result);
$numrows = pg_numrows($result);
$a = $idks[0];
if($ile==0) {
    echo "<strong> Nie ma takiego wyborcy. </strong>";
}else {
    $czy_komisja = pg_query_params($link, "SELECT czy_komisja FROM wyborcy WHERE numer_indeksu=$1", array($a));
    $f = pg_fetch_array($czy_komisja);
    if(!$f[0]) {
        echo "<strong>Nie można zgłosić komisji.</strong>";
    }else {
        $link = pg_connect("host=labdb dbname=mrbd user=jk406704 password=232884");
        $wynik = pg_query($link, "INSERT INTO kandydaci VALUES ('" . $id . "','" . $a . "')");
        
        if($wynik) {
            echo "<strong>Zgłoszono kandydata: $imie, $nazwisko. ID stanowiska: $id. </strong>";
        } else {
            echo "<strong> Już zgłoszono tego kandydata. </strong>";

        }
    }
}
pg_close($link);
?>