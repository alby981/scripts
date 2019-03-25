<?php
$file = file("keywords.csv");
$n = $z = 0;
$chars = array("\r\n", '\\n', '\\r', "\n", "\r", "\t", "\0", "\x0B");
foreach ($file as $row) {
    $n++;
    if ($n < 4) {
        continue;
    }
    $exp = explode(",",$row);
    $firstColumn = str_replace($chars,"",trim($exp[0]));
    $totale = str_replace($chars,"",trim($exp[2]));
    $punteggiatura = [".",",",";"];
    $vocali = ["a","e","o","i"];

    if (stripos($firstColumn, "premium") !== false) {
	if($totale > 1500) {
	    echo $firstColumn . " | ";
	}
    }
}
