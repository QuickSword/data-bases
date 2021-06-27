<?php 
echo "<title> Rejestracja nowych wyborców </title>";
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

if ($ile != 0) {
    echo "Zgodnie z założeniem członek komisji nie jest wyborcą (ani kandydatem), ale można zarejestrować kolejnego członka komisji. <br><br>";
    echo '<form action="rejestruj.php" method="post">';
            echo nl2br("<tr>\n" . '<strong> Zarejestruj wyborcę: </strong> <br><br>' . "</tr>");
            echo "Login: <input type=text name='login' value='$login'><br><br>";
            echo "Hasło: <input type='password' name='pass' value='$pass'><br><br>";
            echo "Imię: <input type=text name='imie' value='$imie'><br><br>";
            echo "Nazwisko: <input type=text name='nazwisko' value='$nazwisko'><br><br>";
            echo "Czy komisja: <select name='i'>"; 
            echo "<option value='false'> nie </option>";
            echo "<option value='true'> tak </option>";
            echo "</select>";
            echo "<br><br>";
        echo '<input type="submit" value="Zarejestruj wyborcę">';
} else {
    echo "<strong>Błąd</strong>";
}
?>