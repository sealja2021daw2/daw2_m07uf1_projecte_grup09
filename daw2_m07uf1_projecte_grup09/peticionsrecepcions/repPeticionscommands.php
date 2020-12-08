<?php
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["clientid"])) echo "No hi ha cap sessio";
    else if($_SESSION["clientname"]=="admin"){
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $tipoPeticio = $_REQUEST["n"];
            $iduser = $_REQUEST["p"];
            $numCommand = $_REQUEST["d"];
            if($tipoPeticio=="Deletecommand"){
                $filename="../FITXERS/peticions.txt";
                $fitxer=fopen($filename,"r") or die ("No s'ha pogut obrir el fitxer");
                if ($fitxer) {
                    $mida_fitxer=filesize($filename);	
                    $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
                }
                $existeix=0;
                $numLinea=0;
                foreach ($linia as $cadena){
                    $prop=explode(';',$cadena); 
                    if($tipoPeticio==$prop[0] && $iduser==$prop[1] && $numCommand==$prop[2]){
                        $existeix=1;
                        array_splice($linia, $numLinea, 1);
                    }
                    $numLinea++;
                }             
                fclose($fitxer);
                $numLinea=0;
                if($existeix==1){
                    foreach ($linia as $cadena){
                        $prop=explode(';',$cadena); 
                        if( $iduser==$prop[1] && $numCommand==$prop[2]){
                            array_splice($linia, $numLinea, 1);
                        }
                        $numLinea++;
                    } 
                    $fitxer = fopen($filename,'w');
                    $contenido = implode(PHP_EOL,$linia);  
                    fwrite($fitxer,$contenido);
                    fclose($fitxer);
                }
                if ($existeix==1){
                    $filename="../FITXERS/commands.txt";
                    $fitxer=fopen($filename,"r+") or die ("No s'ha pogut obrir el fitxer");
                    if ($fitxer) {
                        $mida_fitxer=filesize($filename);	
                        $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
                    }
                    $numLinea=0;
                    $existeix=0;
                    foreach ($linia as $cadena){
                        $prop=explode(';',$cadena);
                        if($existeix==1 && $iduser==$prop[0]){
                            $tmp=(int)$prop[1]-1;
                            $changecommand="".$prop[0].";".$tmp.";".$prop[2].";".$prop[3].";";
                            $cadena=$changecommand;
                            $linia[$numLinea]=$cadena;
                        }
                        if($iduser==$prop[0] && $numCommand==$prop[1]){
                            $numCommand=null;
                            $existeix=1;
                            $encontrado=0;
                            array_splice($linia, $numLinea, 1);
                            echo "ELIMINACIO AMB EXIT!!! :)";
                            $numLinea--;
                        }
                        $numLinea++;
                    } 
                    fclose($fitxer);
                    if($existeix==1){
                        $fitxer = fopen($filename,'w');
                        $contenido = implode(PHP_EOL,$linia);  
                        fwrite($fitxer,$contenido);
                        fclose($fitxer);
                    }else echo "No existeix la comanda";      
                }else echo "La peticio no existeix o es incorrecte";
            }else echo "Tipus de Peticio incorrecte";
        }
        else if($_SERVER['REQUEST_METHOD'] === 'PUT'){
            $tipoPeticio = $_REQUEST["n"];
            $iduser = $_REQUEST["p"];
            $numCommand = $_REQUEST["d"];
            $numcolumn = 2;
            if($tipoPeticio=="Modifiedcommand"){
                $filename="../FITXERS/peticions.txt";
                $fitxer=fopen($filename,"r") or die ("No s'ha pogut obrir el fitxer");
                if ($fitxer) {
                    $mida_fitxer=filesize($filename);	
                    $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
                }
                $existeix=0;
                $product="";
                $numLinea=0;
                foreach ($linia as $cadena){
                    $prop=explode(';',$cadena); 
                    if($tipoPeticio==$prop[0] && $iduser==$prop[1] && $numCommand==$prop[2] && $numcolumn==$prop[3]){
                        $existeix=1;
                        $product=$prop[4];
                        array_splice($linia, $numLinea, 1);
                    } 
                    $numLinea++;
                }  
                fclose($fitxer);
                if($existeix==1){
                    $fitxer = fopen($filename,'w');
                    $contenido = implode(PHP_EOL,$linia);  
                    fwrite($fitxer,$contenido);
                    fclose($fitxer);
                }        
                if ($existeix==1){
                    $filename="../FITXERS/commands.txt";
                    $fitxer=fopen($filename,"r+") or die ("No s'ha pogut obrir el fitxer");
                    if ($fitxer) {
                        $mida_fitxer=filesize($filename);	
                        $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
                    }
                    $numLinea=0;
                    $existeix=0;
                    foreach ($linia as $cadena){
                        $prop=explode(';',$cadena); 
                        if($iduser==$prop[0] && $numCommand==$prop[1] ){
                            $existeix=1;
                            $changecommand="".$prop[0].";".$prop[1].";".$product.";".$prop[3].";";
                            $cadena=$changecommand;
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
                    }else echo "No existeix la comanda";      
                }else echo "La peticio no existeix o es incorrecte";
            }else echo "Tipus de Peticio incorrecte";
        }else echo "Metode incorrecte";
    }else echo "No tens permís";  
?>
