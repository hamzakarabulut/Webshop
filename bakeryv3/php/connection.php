<?php

$fpconnection = mysqli_connect("127.0.0.1","root","","bakery");

    if(!$fpconnection){
    echo "Fehler: konnte nicht mit DB verbinden." . PHP_EOL;
    echo "Debug-Fehlernummer: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debug-Fehlermeldung: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    $fpconnection->set_charset( 'utf8' ); 
}

?>

