<?php
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["clientid"])) echo "No hi ha cap sessio";
    else if($_SESSION["clientname"]=="admin"){
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $tipoPeticio = "Deleteuser";
            $iduser = $_REQUEST["n"];
            if($tipoPeticio=="Deleteuser"){
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
                    if($tipoPeticio==$prop[0] && $iduser==$prop[1]){
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
                        if( $iduser==$prop[1]){
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
                    $filename="../FITXERS/users.txt";
                    $fitxer=fopen($filename,"r+") or die ("No s'ha pogut obrir el fitxer");
                    if ($fitxer) {
                        $mida_fitxer=filesize($filename);	
                        $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
                    }
                    $numLinea=0;
                    $existeix=0;
                    foreach ($linia as $cadena){
                        $prop=explode(';',$cadena);
                        if($iduser==$prop[0]){
                            $existeix=1;
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
                            if($iduser==$prop[0]){
                                $existeix=1;
                                $encontrado=0;
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
                        }else echo "No existeix la comanda"; 
                    }else echo "No existeix el usuari";      
                }else echo "La peticio no existeix o es incorrecte";
            }else echo "Tipus de Peticio incorrecte";
        }else echo "Metode incorrecte";
    }else echo "No tens permís";  
?>