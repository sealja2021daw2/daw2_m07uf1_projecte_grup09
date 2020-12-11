<?php
	#Treballant amb mètodes màgics.
	# https://www.php.net/manual/es/language.oop5.magic.php
	# https://diego.com.es/metodos-magicos-en-php
	#
	class Fitxer {
        private $filename;
        private $fitxer;
		
        //constructor
        function __construct($filename) {
            $this->filename = $filename;
        }

        //destructor
        public function __destruct(){
             fclose($this->fitxer);
         }
        
        //getter and setter
		public function __get($prop){
			if(property_exists($this,$prop)){
				return $this->$prop;
			}
			else{
				return -1;
			}		
		}

        //metodes
        // METODES PER OBRIR FITXERS
        public function fitxerlectura(){
            $fitxer=fopen($this->filename,"r") or die ("No s'ha pogut obrir el fitxer");
            if ($fitxer) {
                $mida_fitxer=filesize($this->filename);	
                $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
            }
            $this->fitxer=$fitxer;
            return $linia;
        }
        public function fitxerEscritura(){
            $fitxer=fopen($this->filename,"w") or die ("No s'ha pogut obrir el fitxer");
            if ($fitxer) {
                $mida_fitxer=filesize($this->filename);	
                $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
            }
            $this->fitxer=$fitxer;
            return $linia;
        }
        public function fitxerlecturaEscritura(){
            $fitxer=fopen($this->filename,"r+") or die ("No s'ha pogut obrir el fitxer");
            if ($fitxer) {
                $mida_fitxer=filesize($this->filename);	
                $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
            }
            $this->fitxer=$fitxer;
            return $linia;
        }

        //metode per el login o accedir a la interficie
        public function accedir($linia,$form_useri,$form_passwordi){
            $usuariacces=null;
            foreach ($linia as $cadena) {
                $prop=explode(';',$cadena);
                if($form_useri == $prop[1] && $form_passwordi==$prop[2]){
                    $estat=1;
                    $usuariacces=new Client($prop[0],$prop[1],$prop[2],$prop[3],$prop[4],$prop[5],$prop[6],$prop[7]);
                    $_SESSION['clientname'] = $usuariacces->user;
                    $_SESSION['clientid'] = $usuariacces->id;
                    break;
                }
            }
            return $usuariacces; 
        }


        //metodes per visualizar comandes
        public function visualitzarcomanda($linia,$clienteid,$numcomanda){
            $comandes="";
            foreach ($linia as $cadena) {
                $prop=explode(';',$cadena); 
                if($clienteid==$prop[0] && $numcomanda==$prop[1]){
                    $comanda=new Command($prop[0],$prop[1],$prop[2],$prop[3],$prop[4]);
                    $comandes.="".$comanda->toString()."<br/>";
                    break;
                }
            }
            return $comandes;
        }

        public function visualitzarllistacomandes($linia,$clienteid){
            $comandes="";
            
            foreach ($linia as $cadena) {
            $prop=explode(';',$cadena); 
            if($clienteid==$prop[0]){
                $comanda=new Command($prop[0],$prop[1],$prop[2],$prop[3],$prop[4]);
                $comandes.="".$comanda->toString()."<br/>";
            }
        }
            return $comandes;
        }

        //metodes per visualitzar seccions de productes
		public function visualitzarseccio($linia,$producte){
            $cambia="h";
            $seccions="";
            foreach ($linia as $cadena) {
                 $prop=explode(';',$cadena);
                 if( $cambia != $prop[2]){
                    $cambia=$prop[2];
                    $producte=new Product($prop[0],$prop[1],$prop[2],$prop[3],$prop[4]);
                    $seccions.="".$producte->section."<br/>";
                 }
            }
           return $seccions;
          }

        //metode per visualitzar productes per seccio
        public function visualitzarproductesseccio($linia,$producte){
            $productes="";
            foreach ($linia as $cadena) {
                 $prop=explode(';',$cadena);
                 if($producte== $prop[2]){
                    $producteobj=new Product($prop[0],$prop[1],$prop[2],$prop[3],$prop[4]);
                    $productes.="code ".$producteobj->code."|\t".$producteobj->name."\t PREU: ".$producteobj->price."€<br/>".'<img class="imatgeX1" src="../IMATGES/'.$producteobj->image.'"/>'."<br/>";
                 }
            }
            return $productes;
        }

        //metode per visualitzar productes
        public function visualitzarproductes($linia,$producte){
            $dades=null;
            foreach ($linia as $cadena) {
                 $prop=explode(';',$cadena);
                 if($producte== $prop[1]){
                    $producte=new Product($prop[0],$prop[1],$prop[2],$prop[3],$prop[4]);
                    $dades=$producte->toString()."<br/>";
                    break;
                 }
             }
            return $dades;
        }

        //metode per visualitzar dades usuari
        public function visualitzardadespersonals($linia,$clientname){
            $user="";
            foreach ($linia as $cadena) {
                $prop=explode(';',$cadena);
                if($clientname==$prop[1]){
                    $user=new Client($prop[0],$prop[1],$prop[2],$prop[3],$prop[4],$prop[5],$prop[6],$prop[7]);
                    break;
                }
            }
            return $user;
        }

        //metode per visualitzar peticions
        public function visualitzarpeticions($linia){
            $visupeticio="";
            foreach ($linia as $cadena) {
                $prop=explode(';',$cadena);
                if("Modifiedcommand"== $prop[0] || "Deletecommand"== $prop[0] || "Deleteuser"== $prop[0] || "Modifieduser"== $prop[0]){
                    $visupeticio.="".$prop[0]."|\t".$prop[1]."|\t".$prop[2]."|\t".$prop[3]."|\t".$prop[4]."<br/>";
                }
            }
            return $visupeticio;
        }



        //metode per afegir usuari
        public function afegirusuari($linia,$form_userr,$form_passwordr,$form_allnamer,$form_phoner,$form_emailr,$form_visar,$form_postalr){
            $existeix=0;
            $numusers=1;
            $seguentID=0;
            foreach ($linia as $cadena) {
                $numusers++;
                $prop=explode(';',$cadena);
                if($seguentID<$prop[0])$seguentID=$prop[0];
                if($form_userr == $prop[1]){
                     $existeix=1;
                     break;
                }
           }
           $usuariregistre=null;
           if($existeix!=1){
                $usuariregistre=new Client($seguentID+1,$form_userr,$form_passwordr,$form_allnamer,$form_phoner,$form_emailr,$form_visar,$form_postalr);
                $usuari="\n".$usuariregistre->id.";".$usuariregistre->user.";".$usuariregistre->password.";".$usuariregistre->allname.";".$usuariregistre->phone.";".$usuariregistre->email.";".$usuariregistre->visa.";".$usuariregistre->postalcode.";";
                file_put_contents($this->filename, $usuari, FILE_APPEND | LOCK_EX);
           }
           return $usuariregistre;
        }

        //metode per afegir producte
        public function afegirproducte($linia,$form_code,$form_name,$form_section,$form_price,$form_image){
            $existeix=0;
            foreach ($linia as $cadena) {
                $prop=explode(';',$cadena);
                if($form_name == $prop[1] || $form_code == $prop[0]){
                    $existeix=1;
                    break;
               }
            }
            if($existeix!=1){
                $producte=new Product($form_code,$form_name,$form_section,$form_price,$form_image);
                $newproducte="\n".$producte->code.";".$producte->name.";".$producte->section.";".$producte->price.";".$producte->image.";";
                file_put_contents($this->filename, $newproducte, FILE_APPEND | LOCK_EX);
            }
            return $newproducte;
        }

        //metode per afegir comanda
        public function afegircomanda($linia,$clientid,$form_name,$today){
            $existeix=0;
            $numcomanda=1;
            foreach ($linia as $cadena) {
                 $prop='';
                 $prop=explode(';',$cadena);
                 if($_SESSION["clientid"] == $prop[0]){
                      $numcomanda++;
                 }
                 if($form_name == $prop[2] && $clientid == $prop[0]){
                      $existeix=1;
                      break;
                 }
            }
            $newcomanda="";
            if($existeix!=1){
                 $comanda=new Command($clientid,$numcomanda,$form_name,$today);
                 $newcomanda.="\n".$comanda->iduser.";".$comanda->numbercommand.";".$comanda->nameproduct.";".$comanda->datecommand.";";
                 file_put_contents($this->filename, $newcomanda, FILE_APPEND | LOCK_EX);
            }
            return $newcomanda;
        }

        //metode afegir peticio elimina comanda
        public function afegirpeticioeliminacomanda($linia,$clientid,$form_numcommand){
                $newpeticio="\nDeletecommand;".$clientid.";".$form_numcommand.";";
                file_put_contents($this->filename, $newpeticio, FILE_APPEND | LOCK_EX);
                return $newpeticio;
        }

        //metode afegir peticio elimina user
        public function afegirpeticioeliminauser($linia,$clientid){
            $newpeticio="\nDeleteuser;".$_SESSION["clientid"].";";
            file_put_contents($this->filename, $newpeticio, FILE_APPEND | LOCK_EX);
            return $newpeticio;
        }   

        //metodes per afegir peticio modifica comanda
        public function verificambicomanda($linia,$clientid,$form_changeproduct,$form_numcommand){
            $existeix=0;
            $existeixp=0;
            foreach ($linia as $cadena){
                $prop=explode(';',$cadena); 
                if($clientid==$prop[0] && $form_changeproduct==$prop[2]){
                    $existeixp=1;
                    $existeix=0;
                    break;
                }
                if( $clientid==$prop[0] && $form_numcommand==$prop[1] && $form_changeproduct!=$prop[2]){
                    $existeix=1;  
                }
            }
            return $existeix;
        }  

        public function afegirpeticiomodificacomanda($linia,$clientid,$form_changeproduct,$form_numcommand){
            $newpeticio="\nModifiedcommand;".$_SESSION["clientid"].";".$_POST['form_numcommand'].";2;".$_POST['form_changeproduct'].";";
            file_put_contents($this->filename, $newpeticio, FILE_APPEND | LOCK_EX);
            return $newpeticio;
        }  

        //metodes per afegir peticio modifica usuari
        public function verificacambiusuari($linia,$clientid,$form_dataoption,$form_changedata){
            $existeix=0;
            $existeixp=0;
            foreach ($linia as $cadena){
                $prop=explode(';',$cadena); 
                if($clientid==$prop[0] && $form_changedata==$prop[$form_dataoption]){
                    $existeixp=1;
                    $existeix=0;
                    break;
                }
                if($clientid==$prop[0]){
                    $existeix=1;
                    break;
                }
            }
            return $existeix;
        }    
        
        public function afegirpeticiomodificauser($linia,$clientid,$form_dataoption,$form_changedata){
            $newpeticio="\nModifieduser;".$clientid.";".$form_dataoption.";".$form_changedata.";";
            file_put_contents($this->filename, $newpeticio, FILE_APPEND | LOCK_EX);
            return $newpeticio;
        }  

        //metode elimina producte
        public function eliminaproducte($linia,$codeproduct){
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
                if($existeix==1){
                    $this->fitxer = fopen($this->filename,'w');
                    $contenido = implode(PHP_EOL,$linia);  
                    fwrite($this->fitxer,$contenido);
                }else echo "No existeix el producte"; 
        } 

        //metode modifica producte
        public function modificaproducte($linia,$codeproduct,$datachange,$numcolumn){
            $numLinea=0;
            $existeix=0;
            foreach ($linia as $cadena){
                $prop=explode(';',$cadena); 
                if($codeproduct==$prop[0]){
                    $existeix=1;
                    $changeproduct="";
                    for($i=0; $i<=4; $i++){
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
            if($existeix==1){
                $this->fitxer = fopen($this->filename,'w');
                $contenido = implode(PHP_EOL,$linia);  
                fwrite($this->fitxer,$contenido);
            }else echo "No existeix el producte";
        } 
        
        //metodes per eliminar comanda
        public function verificapeticioeliminacomanda($linia,$iduser,$tipoPeticio,$numCommand){
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
            if($existeix==1){
                for($i=0; $i<=sizeof($linia); $i++){
                    $prop=explode(';',$linia[$i]); 
                    if( $iduser==$prop[1] && $numCommand==$prop[2]){
                        array_splice($linia, $i, 1);
                        $i=$i-1;
                    }
                } 
                $this->fitxer = fopen($this->filename,'w');
                $contenido = implode(PHP_EOL,$linia);  
                fwrite($this->fitxer,$contenido);
            }
            return $existeix;
        }

        public function eliminacomanda($linia,$iduser,$numCommand){
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
                if($existeix==1){
                    $this->fitxer = fopen($this->filename,'w');
                    $contenido = implode(PHP_EOL,$linia);  
                    fwrite($this->fitxer,$contenido);
                }else echo "No existeix la comanda";   
            return $existeix;
        }

        //metodes per modificar comanda
        public function verificapeticiomodificacomanda($linia,$iduser,$tipoPeticio,$numCommand,$numcolumn){
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
                if($product!=null){
                    $this->fitxer = fopen($this->filename,'w');
                    $contenido = implode(PHP_EOL,$linia);  
                    fwrite($this->fitxer,$contenido);
                }        
            return $product;
        }

        public function modificacomanda($linia,$iduser,$numCommand,$product){
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
            if($existeix==1){
                $this->fitxer = fopen($this->filename,'w');
                $contenido = implode(PHP_EOL,$linia);  
                fwrite($this->fitxer,$contenido);
            }else echo "No existeix la comanda";  
            return $existeix;
        }

        //metodes per eliminar usuari
        public function verificapeticioeliminausuari($linia,$iduser,$tipoPeticio){
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
            $numLinea=0;
            if($existeix==1){
                for($i=0; $i<=sizeof($linia); $i++){
                    $prop=explode(';',$linia[$i]); 
                    if($iduser==$prop[1]){
                        array_splice($linia, $i, 1);
                        $i=$i-1;
                    }
                } 
                $this->fitxer = fopen($this->filename,'w');
                $contenido = implode(PHP_EOL,$linia);  
                fwrite($this->fitxer,$contenido);
            }           
            return $existeix;
        }

        public function eliminausuari($linia,$iduser){
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
                if($existeix==1){
                    $this->fitxer = fopen($this->filename,'w');
                    $contenido = implode(PHP_EOL,$linia);  
                    fwrite($this->fitxer,$contenido);
                }      
                return $existeix;
        }

        public function eliminacomandapereliminaciousuari($linia,$iduser){
            $existeix=0;
            for($i=0; $i<=sizeof($linia); $i++){
                $prop=explode(';',$linia[$i]);
                if($iduser==$prop[0]){
                    $existeix=1;
                    array_splice($linia, $i, 1);
                    $i=$i-1;
                }
            } 
            if($existeix==1){
                $this->fitxer = fopen($this->filename,'w');
                $contenido = implode(PHP_EOL,$linia);  
                fwrite($this->fitxer,$contenido);
            }else echo "No existeix la comanda";    
            return $existeix;
        }

        //metodes per modificar dades usuari
        public function verificapeticiomodificausuari($linia,$iduser,$tipoPeticio,$numcolumn){
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
            if($existeix==1){
                $this->fitxer = fopen($this->filename,'w');
                $contenido = implode(PHP_EOL,$linia);  
                fwrite($this->fitxer,$contenido);
            } 
            return $changedata;
        }

        public function modificausuari($linia,$iduser,$numcolumn,$changedata){
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
            if($existeix==1){
                $this->fitxer = fopen($this->filename,'w');
                $contenido = implode(PHP_EOL,$linia);  
                fwrite($this->fitxer,$contenido);
            }else echo "No existeix el usuari";
            return $existeix;
        }
    }
?>