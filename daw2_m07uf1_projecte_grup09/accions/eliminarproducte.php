<?php
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["clientid"])) echo "No hi ha cap sessio";
    else if($_SESSION["clientname"]=="admin"){
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $codeproduct = $_REQUEST["n"];
            $filename="../FITXERS/products.txt";
            $fitxer=fopen($filename,"r+") or die ("No s'ha pogut obrir el fitxer");
            if ($fitxer) {
                $mida_fitxer=filesize($filename);	
                $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
            }
            $numLinea=0;
            $existeix=0;
            foreach ($linia as $cadena){
                $prop=explode(';',$cadena);
                if($codeproduct==$prop[0]){
                    $existeix=1;
                    $encontrado=0;
                    array_splice($linia, $numLinea, 1);
                    echo "ELIMINACIO AMB EXIT!!! :)";
                 }
                    $numLinea++;
                } 
                fclose($fitxer);
                if($existeix==1){
                    $fitxer = fopen($filename,'w');
                    $contenido = implode(PHP_EOL,$linia);  
                    fwrite($fitxer,$contenido);
                    fclose($fitxer);
                }else echo "No existeix el producte";  
        }else echo "Metode incorrecte";
    }else echo "No tens permís";  
?>