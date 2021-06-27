<?php 
echo "<title> Wyniki wyborów </title>";
$id_wyborow = $_POST["id"];

$link = pg_connect("host=labdb dbname=mrbd user=jk406704 password=232884");
$check = pg_query_params($link, "SELECT * FROM wybory WHERE id=$1 AND termin_zakonczenia < CURRENT_TIMESTAMP", array($id_wyborow));
if(pg_numrows($check)==0) {
    echo "<strong> Nie można opublikować wyników dopóki trwa głosowanie. </strong>";
}else {
    $t = pg_query($link, "CREATE TABLE wyniki ( id SERIAL REFERENCES wybory(id), kandydat VARCHAR(5) REFERENCES kandydaci(kandydat), liczba_glosow NUMERIC(9), PRIMARY KEY(id, kandydat))");
    $wyniki = pg_query_params($link, "INSERT INTO wyniki SELECT id_wyborow, kandydat, COALESCE(COUNT(kandydat), 0) AS liczba_glosow FROM glosy WHERE id_wyborow=$1 GROUP BY kandydat, id_wyborow ORDER BY liczba_glosow DESC", array($id_wyborow));
    $foo = pg_query_params($link, "SELECT nazwa, liczba_posad FROM wybory WHERE id=$1", array($id_wyborow));
    $nazwa = pg_fetch_array($foo);
    $n = $nazwa["nazwa"];
    $l = (int)$nazwa["liczba_posad"];
    echo "<center><strong> Wyniki wyborów: $n, gdzie liczba posad: $l </strong></center>";
    $w = pg_query_params($link, "SELECT kandydaci.kandydat, COALESCE(w.liczba_glosow, 0) AS liczba_glosow FROM kandydaci LEFT JOIN wyniki w ON w.kandydat=kandydaci.kandydat WHERE kandydaci.id_wyborow=$1", array($id_wyborow));
    $m = pg_numrows($w);
    for($k=0; $k<$m;$k++) {
        $s = pg_fetch_array($w, $k);
        $kandydat = $s["kandydat"];
        $liczba_glosow = $s["liczba_glosow"];
        $c=$k+1;
        if($c<=$l) {
            echo "$c. <p style='color:green'> Kandydat $kandydat zdobył $liczba_glosow głosów. </p> <br><br>";
        }else {
            echo "$c. <p style='color:red'> Kandydat $kandydat zdobył $liczba_glosow głosów. </p> <br><br>";
        }  
    }
    if($w) {
        echo "<strong> Opublikowano wyniki. </strong><br><br>";
        $frek1 = pg_query_params($link, "SELECT COUNT(DISTINCT nr_indeksu_wyborcy) FROM glosy WHERE id_wyborow=$1", array($id_wyborow));
        $frek2 = pg_query($link, "SELECT COUNT(DISTINCT numer_indeksu) FROM wyborcy WHERE czy_komisja=false");
        $f = pg_fetch_array($frek1);
        $g = pg_fetch_array($frek2);
        $frekwencja = intval($f[0])/intval($g[0])*100;
        $sss = pg_query_params($link, "SELECT kandydat FROM kandydaci WHERE id_wyborow=$1", array($id_wyborow));
        $all = (int)pg_numrows($sss);
        $dif = $all - $l;
        // $x = pg_query_params($link, "CREATE TABLE porazka AS (SELECT kandydaci.id_wyborow, kandydaci.kandydat, coalesce(g.liczba_glosow, 0) FROM kandydaci LEFT JOIN wyniki g ON g.kandydat = kandydaci.kandydat WHERE kandydaci.id_wyborow=$1 ORDER BY g.liczba_glosow DESC LIMIT $2);", array($id_wyborow, $dif));
        // $y = pg_query($link, "DELETE FROM wyniki WHERE kandydat IN (SELECT kandydat FROM porazka)");
        // $z = pg_query($link, "DELETE FROM glosy WHERE kandydat IN (SELECT kandydat FROM porazka)");
        // $k = pg_query($link, "DELETE FROM kandydaci WHERE kandydat IN (SELECT kandydat FROM porazka)");
        // if($x && $y && $z && $k) {
        //     echo "Wygrani (zieloni) zostają w bazie, przegrani (czerwoni, razem z tymi którzy nie zdobyli żadnych głosów w tych wyborach) są usuwani z tabeli kandydatów, głosów i wyników, aby mogli wziąć udział w kolejnych wyborach w przyszłości. <br><br>";
        // }
        echo "<strong> Frekwencja: </strong> $frekwencja % <br><br>";
    } else {
        echo "<strong> Coś poszło nie tak. </strong>";
    }
}
pg_close($link);
?>