<?php
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["clientid"])) echo "No hi ha cap sessio";
    else if($_SESSION["clientname"]=="admin"){
        if($_SERVER['REQUEST_METHOD'] === 'PUT'){
            $tipoPeticio = "Modifieduser";
            $iduser = $_REQUEST["n"];
            $numcolumn = $_REQUEST["p"];
            if($tipoPeticio=="Modifieduser"){
                include '../classfitxer.php';
                $fitxer1 = new Fitxer("../FITXERS/peticions.txt");
                $linea=$fitxer1->fitxerlecturaEscritura();
                $changedata=$fitxer1->verificapeticiomodificausuari($linea,$iduser,$tipoPeticio,$numcolumn);
                if ($changedata!=null){
                    $fitxer1 = new Fitxer("../FITXERS/users.txt");
                    $linea=$fitxer1->fitxerlecturaEscritura();
                    $existeix=$fitxer1->modificausuari($linea,$iduser,$numcolumn,$changedata);
                }else echo "La peticio no existeix o es incorrecte";
            }else echo "Tipus de Peticio incorrecte";
        }else echo "Metode incorrecte";
    }else echo "No tens permís";  
?>