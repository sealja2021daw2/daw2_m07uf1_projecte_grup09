<?php
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["clientid"])) echo "No hi ha cap sessio";
    else if($_SESSION["clientname"]=="admin"){
        if($_SERVER['REQUEST_METHOD'] === 'PUT'){
            $codeproduct = $_REQUEST["n"];
            $numcolumn = $_REQUEST["p"];
            $datachange = $_REQUEST["d"];
            $numLinea=0;
            $existeix=0;
            $filename="../FITXERS/products.txt";
            $fitxer=fopen($filename,"r+") or die ("No s'ha pogut obrir el fitxer");
            if ($fitxer) {
                $mida_fitxer=filesize($filename);	
                $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
            }
            foreach ($linia as $cadena){
                $prop=explode(';',$cadena); 
                if($codeproduct==$prop[0]){
                    $existeix=1;
                    $changeproduct="";
                    for($i=0; $i<4; $i++){
                        if($i!=$numcolumn) $changeproduct.="".$prop[$i].";";
                        else $changeproduct.="".$datachange.";";
                    }
                    $cadena=$changeproduct;
                    $linia[$numLinea] = $cadena;
                    echo "MODIFICACIO AMB EXIT!!! :)";
                    break;
                 }
                $numLinea++;
            } 
            fclose($fitxer);
            if($existeix==1){
                $fitxer = fopen($filename,'w');
                $contenido = implode(PHP_EOL,$linia);  
                fwrite($fitxer,$contenido);
                fclose($fitxer);
            }else echo "No existeix el usuari";      
        }else echo "Metode incorrecte";
    }else echo "No tens permís";  
?>