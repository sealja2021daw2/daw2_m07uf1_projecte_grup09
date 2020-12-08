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
                $filename="../FITXERS/peticions.txt";
                $fitxer=fopen($filename,"r") or die ("No s'ha pogut obrir el fitxer");
                if ($fitxer) {
                    $mida_fitxer=filesize($filename);	
                    $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
                }
                $existeix=0;
                $changedata="";
                $numLinea=0;
                foreach ($linia as $cadena){
                    $prop=explode(';',$cadena); 
                    if($tipoPeticio==$prop[0] && $iduser==$prop[1] && $numcolumn==$prop[2]){
                        $existeix=1;
                        $changedata=$prop[3];
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
                            $changeuser="";
                            for($i=0; $i<7; $i++){
                                if($i!=$numcolumn) $changeuser.="".$prop[$i].";";
                                else $changeuser.="".$changedata.";";
                            }
                            $cadena=$changeuser;
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
                }else echo "La peticio no existeix o es incorrecte";
            }else echo "Tipus de Peticio incorrecte";
        }else echo "Metode incorrecte";
    }else echo "No tens permís";  
?>