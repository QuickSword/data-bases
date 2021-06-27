<?php
echo "<title> Zgłoś kandydatów </title>";
$id = $_POST["id"];
$link = pg_connect("host=labdb dbname=mrbd user=jk406704 password=232884");

$wynik=pg_query_params($link, "SELECT * FROM wybory WHERE id=$1 AND termin_zgloszen > CURRENT_TIMESTAMP", array($id));
$n=pg_numrows($wynik);
if($n!=0) {
    echo "<strong>Wyborca może kandydować tylko w jednych wyborach i tylko raz można go zgłosić. </strong> <br><br>";
    echo '<form action="zglos1.php" method="post">';
    echo nl2br("<tr>\n" . '<strong> Zgłoś kandydata: </strong> <br><br>' . "</tr>");
    echo "<input type='hidden' name='id' value='$id'><br><br>";
    echo "Imię: <input type='text' name='imie'><br><br>";
    echo "Nazwisko: <input type='text' name='nazwisko'><br><br>";
    echo '</from>';
    echo '<input type="submit" value="Zgłoś">';
}else {
    echo "<strong> Termin zgłoszeń już minął. </strong>";
}
pg_close($link);
?>