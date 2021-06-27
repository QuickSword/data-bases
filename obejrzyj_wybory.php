<?php 
echo "<title> Wybory </title>";
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
    $foo = pg_query($link, "SELECT * FROM wybory");
    $m = pg_numrows($foo);
    echo "<strong> Wybory: </strong> <br><br>";
    for($k=0; $k<$m;$k++) {
        $s = pg_fetch_array($foo, $k);
        $id = $s["id"];
        $nazwa = $s["nazwa"];
        $l = $s["liczba_posad"];
        $tz = $s["termin_zgloszen"];
        $trg = $s["termin_rozpoczecia"];
        $tzg = $s["termin_zakonczenia"];
        echo "<strong> ID:  </strong> $id <strong> Nazwa: </strong> $nazwa <strong> Liczba posad: </strong> $l <strong> Termin zgłoszeń kandydatów: </strong> $tz <strong> Termin rozpoczęcia wyborów: </strong> $trg <strong> Termin zakończenia wyborów: </strong> $tzg  <br><br>";
    }

}
pg_close($link);
?>