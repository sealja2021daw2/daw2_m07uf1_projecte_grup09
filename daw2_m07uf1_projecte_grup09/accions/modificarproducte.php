<?php
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["clientid"])) echo "No hi ha cap sessio";
    else if($_SESSION["clientname"]=="admin"){
        if($_SERVER['REQUEST_METHOD'] === 'PUT'){
            $codeproduct = $_REQUEST["n"];
            $numcolumn = $_REQUEST["p"];
            $datachange = $_REQUEST["d"];
            include '../classfitxer.php';
            $fitxer1 = new Fitxer("../FITXERS/products.txt");
            $linea=$fitxer1->fitxerlecturaEscritura();
            $fitxer1->modificaproducte($linea,$codeproduct,$datachange,$numcolumn);
        }else echo "Metode incorrecte";
    }else echo "No tens permís";  
?>