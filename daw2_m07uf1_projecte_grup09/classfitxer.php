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

        //metodos
        // METODOS PARA ABRIR FICHEROS
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

        //metodos para visualizar comandas
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

        //metodos para visualizar productos
    
    }
?>