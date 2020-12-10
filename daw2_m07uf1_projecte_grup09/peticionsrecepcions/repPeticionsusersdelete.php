<?php
    session_start();
    if (!isset($_SESSION["clientid"])) echo "No hi ha cap sessio";
    else if($_SESSION["clientname"]=="admin"){
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $tipoPeticio = "Deleteuser";
            $iduser = $_REQUEST["n"];
            if($tipoPeticio=="Deleteuser"){
                include '../classfitxer.php';
                $fitxer1 = new Fitxer("../FITXERS/peticions.txt");
                $linea=$fitxer1->fitxerlecturaEscritura();
                $existeix=$fitxer1->verificapeticioeliminausuari($linea,$iduser,$tipoPeticio);
                if ($existeix==1){
                    $fitxer1 = new Fitxer("../FITXERS/users.txt");
                    $linea=$fitxer1->fitxerlecturaEscritura();
                    $existeix=$fitxer1->eliminausuari($linea,$iduser);
                    if($existeix==1){
                        $fitxer1 = new Fitxer("../FITXERS/commands.txt");
                        $linea=$fitxer1->fitxerlecturaEscritura();
                        $existeix=$fitxer1->eliminacomandapereliminaciousuari($linea,$iduser);
                    }else echo "No existeix el usuari";
                }else echo "La peticio no existeix o es incorrecte";
            }else echo "Tipus de Peticio incorrecte";
        }else echo "Metode incorrecte";
    }else echo "No tens permís";  
?>