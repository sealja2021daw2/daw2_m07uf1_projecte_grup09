<?php
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["clientid"])) echo "No hi ha cap sessio";
    else if($_SESSION["clientname"]=="admin"){
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            include '../classfitxer.php';
            $codeproduct = $_REQUEST["n"];
            $fitxer1 = new Fitxer("../FITXERS/products.txt");
            $linea=$fitxer1->fitxerlecturaEscritura();
            $fitxer1->eliminaproducte($linea,$codeproduct);
        }else echo "Metode incorrecte";
    }else echo "No tens permís";  
?>