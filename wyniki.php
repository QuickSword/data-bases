<?php 
echo "<title> Wyniki wyborów </title>";
$link = pg_connect("host=labdb dbname=mrbd user=jk406704 password=232884");
$id_wyborow = $_POST["id"];
$current = date("Y-m-d H:i:s");
$foo = pg_query_params($link, "SELECT nazwa, liczba_posad, termin_zakonczenia FROM wybory WHERE id=$1", array($id_wyborow));
$nazwa = pg_fetch_array($foo);
$n = $nazwa["nazwa"];
$l = $nazwa["liczba_posad"];
$tz = $nazwa["termin_zakonczenia"];
$w = pg_query_params($link, "SELECT kandydaci.kandydat, COALESCE(w.liczba_glosow, 0) AS liczba_glosow FROM kandydaci LEFT JOIN wyniki w ON w.kandydat=kandydaci.kandydat WHERE kandydaci.id_wyborow=$1", array($id_wyborow));
$m = pg_numrows($w);
if($tz > $current || $m==0) {
    echo "<strong> Nie opublikowano jeszcze wyborów. </strong>";
}else {
    echo "<center><strong> Wyniki wyborów: $n, gdzie liczba posad: $l </strong></center>";
    for($k=0; $k<$m;$k++) {
        $s = pg_fetch_array($w, $k);
        $kandydat = $s["kandydat"];
        $liczba_glosow = $s["liczba_glosow"];
        $c=$k+1;
        if($c<=$l) {
            echo "$c. <p style='color:green'> Kandydat $kandydat zdobył $liczba_glosow głosów. </p> <br><br>";
        }else {
            echo "$c. <p style='color:red'>Kandydat $kandydat zdobył $liczba_glosow głosów. </p> <br><br>";
        }
    }
    $frek1 = pg_query_params($link, "SELECT COUNT(DISTINCT nr_indeksu_wyborcy) FROM glosy WHERE id_wyborow=$1", array($id_wyborow));
    $frek2 = pg_query($link, "SELECT COUNT(DISTINCT numer_indeksu) FROM wyborcy WHERE czy_komisja=false");
    $f = pg_fetch_array($frek1);
    $g = pg_fetch_array($frek2);
    $frekwencja = intval($f[0])/intval($g[0])*100;
    
    
    echo "<strong> Frekwencja: </strong> $frekwencja % <br><br>";
}

pg_close($link);
?>