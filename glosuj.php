<?php
echo "<title> Głosowanie </title>";
$link = pg_connect("host=labdb dbname=mrbd user=jk406704 password=232884");

$id = $_POST["id"];
$kto = $_POST["kto"];

$wynik = pg_query_params($link, "SELECT * FROM wybory WHERE id=$1 AND termin_rozpoczecia < CURRENT_TIMESTAMP AND  termin_zakonczenia > CURRENT_TIMESTAMP", array($id));
$n = pg_numrows($wynik);

if($n!=0) {
    echo '<form action="glosuj1.php" method="post">';
    echo nl2br("<tr>\n" . '<strong> Zgłoś kandydata: </strong> <br><br>' . "</tr>");
    echo "<input type='hidden' name='id' value='$id'><br><br>";
    echo "<input type='hidden' name='kto' value='$kto'><br><br>";
    $kand = pg_query_params($link, "SELECT * FROM kandydaci WHERE id_wyborow=$1", array($id));
    $p = pg_numrows($kand);
    echo "Wybierz kandydata: <select name='kandydat'>";
    for ($ri = 0; $ri < $p; $ri++) {
      $ss = pg_fetch_array($kand, $ri);
      $indeks = $ss['kandydat'];
      $res = pg_query_params($link, "SELECT imie, nazwisko FROM wyborcy WHERE numer_indeksu=$1", array($indeks));
      $u = pg_fetch_array($res);
      echo "<option value='". $indeks . "'>'" . $u["imie"] . " " .$u["nazwisko"] . "'</option>";
    }
    echo "</select>";
    echo '</from>';
    echo '<input type="submit" value="Zagłosuj">';
}else {
    echo "<strong>Termin głosowania już minął lub dopiero się odbędzie. </strong>";
}
pg_close($link);
?>