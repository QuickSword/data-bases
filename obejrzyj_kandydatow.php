<?php 
echo "<title> Kandydaci </title>";
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
    $foo = pg_query($link, "SELECT * FROM kandydaci");
    $m = pg_numrows($foo);
    echo "<strong> Kandydaci: </strong> <br><br>";
    for($k=0; $k<$m;$k++) {
        $s = pg_fetch_array($foo, $k);
        $id = $s["id_wyborow"];
        $nr = $s["kandydat"];
        $foo2 = pg_query_params($link, "SELECT imie, nazwisko FROM wyborcy WHERE numer_indeksu=$1", array($nr));
        $pa = pg_fetch_array($foo2);
        $imie=$pa["imie"];
        $nazwisko=$pa["nazwisko"];
        echo "<strong> Numer indeksu: </strong> $nr  <strong> ID wyborów:  </strong> $id  <strong> Nazwisko: </strong> $nazwisko <strong> Imię: </strong> $imie <br><br>";
    }

}
pg_close($link);
?>