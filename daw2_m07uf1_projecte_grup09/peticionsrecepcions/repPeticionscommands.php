<?php
    session_start();
    if (!isset($_SESSION["clientid"])) echo "No hi ha cap sessio";
    else if($_SESSION["clientname"]=="admin"){
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $tipoPeticio = $_REQUEST["n"];
            $iduser = $_REQUEST["p"];
            $numCommand = $_REQUEST["d"];
            if($tipoPeticio=="Deletecommand"){
                include '../classfitxer.php';
                $fitxer1 = new Fitxer("../FITXERS/peticions.txt");
                $linea=$fitxer1->fitxerlecturaEscritura();
                $existeix=$fitxer1->verificapeticioeliminacomanda($linea,$iduser,$tipoPeticio,$numCommand);
                if ($existeix==1){
                    $fitxer1 = new Fitxer("../FITXERS/commands.txt");
                    $linea=$fitxer1->fitxerlecturaEscritura();
                    $existeix=$fitxer1->eliminacomanda($linea,$iduser,$numCommand);
                }else echo "La peticio no existeix o es incorrecte";
            }else echo "Tipus de Peticio incorrecte";
        }
        else if($_SERVER['REQUEST_METHOD'] === 'PUT'){
            $tipoPeticio = $_REQUEST["n"];
            $iduser = $_REQUEST["p"];
            $numCommand = $_REQUEST["d"];
            $numColumn=2;
            if($tipoPeticio=="Modifiedcommand"){
                include '../classfitxer.php';
                $fitxer1 = new Fitxer("../FITXERS/peticions.txt");
                $linea=$fitxer1->fitxerlecturaEscritura();
                $product=$fitxer1->verificapeticiomodificacomanda($linea,$iduser,$tipoPeticio,$numCommand,$numColumn);
                if ($product!=null){
                    $fitxer1 = new Fitxer("../FITXERS/commands.txt");
                    $linea=$fitxer1->fitxerlecturaEscritura();
                    $existeix=$fitxer1->modificacomanda($linea,$iduser,$numCommand,$product);
                }else echo "La peticio no existeix o es incorrecte";
            }else echo "Tipus de Peticio incorrecte";
        }else echo "Metode incorrecte";
    }else echo "No tens permís";  
?>
