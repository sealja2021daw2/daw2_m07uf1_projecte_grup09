<?php
	#Treballant amb mètodes màgics.
	# https://www.php.net/manual/es/language.oop5.magic.php
	# https://diego.com.es/metodos-magicos-en-php
	#
	class Command {
        private $datecommand;
        private $iduser;
        private $numbercommand;
        private $nameproduct;
		
        //constructor
        function __construct($iduser,$numbercommand,$nameproduct,$datecommand) {
            $this->datecommand = $datecommand;
            $this->iduser = $iduser;
            $this->numbercommand = $numbercommand;
            $this->nameproduct = $nameproduct;
        }

        //destructor
        public function __destruct(){
              //en un futur aixo anira al fitxer on es guarden les dades, i borrara l'usuari.
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
		public function __set($prop,$valor){
			if(property_exists($this,$prop)){
				$this->$prop=$valor;
			}
        }
        public function toString(){
            return "num.Order: ".$this->numbercommand."\t| Producte: ".$this->nameproduct."\t| data de creacio: ".$this->datecommand;
        }
    }
?>