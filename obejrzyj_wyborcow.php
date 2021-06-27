<?php 
echo "<title> Wyborcy </title>";
$kto = $_POST["kto"];
$link = pg_connect("host=labdb dbname=mrbd user=jk406704 password=232884");
$w = pg_query_params($link, "SELECT *
                          FROM users
                          WHERE log = $1",
                         array($kto));
$ile = pg_numrows($w);
if($ile==0) {
    echo "<strong> Musisz się zalogować. </strong>";
}else {
    $foo = pg_query($link, "SELECT * FROM wyborcy WHERE czy_komisja=false");
    $m = pg_numrows($foo);
    echo "<strong> Wyborcy: </strong> <br><br>";
    for($k=0; $k<$m;$k++) {
        $s = pg_fetch_array($foo, $k);
        $nr = $s["numer_indeksu"];
        $imie = $s["imie"];
        $nazwisko = $s["nazwisko"];
        echo "<strong>Numer indeksu: </strong> $nr  <strong> Imię: </strong> $imie    <strong> Nazwisko:  </strong> $nazwisko <br><br>";
    }

}
pg_close($link);
?>