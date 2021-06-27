<?php
echo "<title> Start </title>";
$kto = $_POST["kto"];
$klucz = $_POST["klucz"];
$link = pg_connect("host=labdb dbname=mrbd user=jk406704 password=232884");
$wynik = pg_query_params($link, "SELECT *
                          FROM users
                          WHERE log = $1 AND pass = $2",
                         array($kto,$klucz));
$ile = pg_numrows($wynik);
$result = pg_query($link, "select * from wybory");
$numrows = pg_numrows($result);
$current = date("Y-m-d H:i:s");
?>

<?php
if ($ile == 0) {
  echo "<center><strong>Nie ma takiego użytkownika</strong></center>";
}
else {
  $czy_komisja = pg_query_params($link, "select * from wyborcy where numer_indeksu=$1 and czy_komisja='t'", array($kto));
  $i = pg_numrows($czy_komisja);
  if($i==0){
    echo "<strong><center> Strona dla wyborców. </center></strong>";
    $link = pg_connect("host=labdb dbname=mrbd user=jk406704 password=232884");
    for ($ri = 0; $ri < $numrows; $ri++) {
      $row = pg_fetch_array($result, $ri);
      $termin_zgloszen = $row["termin_zgloszen"];
      $termin_rozpoczecia = $row["termin_rozpoczecia"];
      $termin_zakonczenia = $row["termin_zakonczenia"];
      $i = $row["id"];
      echo nl2br( "<br><br> <strong>Stanowisko: </strong>" . $row["nazwa"] . "</tr>" .
      "<tr>\n" ."ID: " . $row["id"] . "</tr>" . 
      "<tr>\n" ."Liczba posad: " . $row["liczba_posad"] . "</tr>" . 
      "<tr>\n" . "Current timestamp: " . $current . "</tr>" .
      "<tr>\n" . "Termin zgłaszania kandydatów: " . $termin_zgloszen . "</tr>" . 
      "<tr>\n" . "Termin rozpoczęcia wyborów: " . $termin_rozpoczecia . "</tr>" . 
      "<tr>\n" . "Termin zakończenia głosowania: " . $termin_zakonczenia . "</tr>" . "<tr>\n</tr>");
    }
    echo nl2br("<tr>\n</tr>" . "<tr>\n</tr>");
    echo "<br><br>";
    
    echo '<form action="zglos.php" method="post">';
    echo "Id wyborów: <select name='id'>";
    $rlt = pg_query($link, "select * from wybory");
    $p = pg_numrows($rlt);
    for ($ri = 0; $ri < $p; $ri++) {
      $ss = pg_fetch_array($rlt, $ri);
      echo "<option value='". $ss['id'] . "'>'" . $ss['id'] . "'</option>";
    }
    echo "</select>";
    echo "<input type='hidden' name='kto' value='$kto'>";
    echo '<input type="submit" value="Zgłoś kandydata">';
    echo '</form>';

    echo "<br><br>";

    echo '<form action="glosuj.php" method="post">';
    echo "Id wyborów: <select name='id'>";
    $rlt = pg_query($link, "select * from wybory");
    $p = pg_numrows($rlt);
    for ($ri = 0; $ri < $p; $ri++) {
      $ss = pg_fetch_array($rlt, $ri);
      echo "<option value='". $ss['id'] . "'>'" . $ss['id'] . "'</option>";
    }
    echo "</select>";
    echo "<input type='hidden' name='kto' value='$kto'>";
    echo '<input type="submit" value="Zobacz kandydatów">';
    echo '</form>';
    
    echo "<br><br>";
    echo '<form action="wyniki.php" method="post">';
    echo "Id wyborów: <select name='id'>";
    $rlt = pg_query($link, "select * from wybory");
    $p = pg_numrows($rlt);
    for ($ri = 0; $ri < $p; $ri++) {
      $ss = pg_fetch_array($rlt, $ri);
      echo "<option value='". $ss['id'] . "'>'" . $ss['id'] . "'</option>";
    }
    echo "</select>";
    echo '<input type="submit" value="Zobacz wyniki">';
    echo '</form>';

    echo "<br><br>";
    
  } else {?>
  <?php 
    echo "<strong><center> Strona dla komisji. </center></strong>";
    echo '<form action="zarejestruj.php" method="post">';
    echo "<input type='hidden' name='klucz' value='$klucz'> ";
    echo "<input type='hidden' name='kto' value='$kto'>";
    echo '<input type="submit" value="Zarejestruj wyborcę.">';
    echo "</form>";
    echo "<br><br>";
    echo '<form action="nowe_wybory.php" method="post">';
        echo nl2br("<tr>\n" . '<strong> Zarejestruj nowe wybory: </strong> <br><br>' . "</tr>");
        echo "Nazwa: <input type=text name='nazwa' value='$nazwa'><br><br>";
        echo "Liczba posad: <input type='text' name='liczba_posad' value='$liczba_posad'><br><br>";
        echo "Format: YYY-MM-DD HH:MM:SS np. 2021-06-24 09:00:00<br><br>";
        echo "Termin zgłoszeń: <input type='text' name='tz' value = $tz> <br><br>";
        echo "Termin rozpoczęcia głosowania: <input type='text' name='trg' value =$trg> <br><br>";
        echo "Termin zakończenia głosowania: <input type='text' name='tzg' value =$tzg> <br><br>";    
    echo '<input type="submit" value="Zarejestruj wybory">';
    echo "</form>";
    echo "<br><br>";
    ?>
    <?php
    echo "Kiedy minie czas głosowania na kandydatów pojawi się tu opcja publikacji wyników. <br><br>";
    $ids = pg_query($link, "SELECT id FROM wybory WHERE termin_zakonczenia < CURRENT_TIMESTAMP");
    $n = pg_numrows($ids);
    if($n!=0) {
      echo '<form action="publikuj_wyniki.php" method="post">';
          echo nl2br("<tr>\n" . '<strong> Opublikuj wyniki: </strong> <br><br>' . "</tr>");
          echo "Id wyborów: <select name='id'>";
          $rlt = pg_query($link, "SELECT id FROM wybory");
          $p = pg_numrows($rlt);
          for ($ri = 0; $ri < $p; $ri++) {
            $ss = pg_fetch_array($rlt, $ri);
            echo "<option value='". $ss['id'] . "'>'" . $ss['id'] . "'</option>";
          }
          echo "</select>";
      echo '<input type="submit" value="Publikuj">';
      echo '</form>';
    }
    echo "<br><br>";
    echo '<form action="obejrzyj_wyborcow.php" method="post">';
    echo "<input type='hidden' name='kto' value='$kto'>";
    echo '<input type="submit" value="Wyborcy">';
    echo '</form>';

    echo '<form action="obejrzyj_wybory.php" method="post">';
    echo "<input type='hidden' name='kto' value='$kto'>";
    echo '<input type="submit" value="Wybory">';
    echo '</form>';

    echo '<form action="obejrzyj_kandydatow.php" method="post">';
    echo "<input type='hidden' name='kto' value='$kto'>";
    echo '<input type="submit" value="Kandydaci">';
    echo '</form>';
  }
  pg_close($link);
}
?>
