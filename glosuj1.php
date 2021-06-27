<?php 
echo "<title> Głosowanie </title>";
$id = $_POST["kandydat"];
$i = $_POST["id"];
$kto = $_POST["kto"];
$link = pg_connect("host=labdb dbname=mrbd user=jk406704 password=232884");
$indeks = pg_query_params($link, "SELECT nr_indeksu_wyborcy FROM glosy WHERE id_wyborow=$1 AND nr_indeksu_wyborcy=$2", array($i, $kto));
$n = pg_numrows($indeks);
if($n==0) {
    $wynik = pg_query($link, "INSERT INTO glosy VALUES ('" . $i . "','" . $kto . "','" . $id . "')");
    if($wynik) {
        echo "<strong>Pomyślnie zagłosowano na $id w wyborach $i </strong>";
    }else {
        echo "<strong>Coś poszło nie tak. </strong>";
    }
} else {
    echo "<strong>Nie można zagłosować drugi raz w tych samych wyborach.</strong>";
}
pg_close($link)

?>