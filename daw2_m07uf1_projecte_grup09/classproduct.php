<?php
	#Treballant amb mètodes màgics.
	# https://www.php.net/manual/es/language.oop5.magic.php
	# https://diego.com.es/metodos-magicos-en-php
	#
	class Product {
        private $section;
        private $name;
        private $code;
        private $image;
        private $price;
		
        //constructor
        function __construct($code,$name,$section,$price,$image) {
            $this->section = $section;
            $this->name = $name;
            $this->code = $code;
            $this->image = $image;
            $this->price = $price;
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
            return "Codi: ".$this->code."\t| Producte: ".$this->name."\t| Section: ".$this->section."\t| Preu: ".$this->price."€"."\t| Imatge:".'<img class="imatgeX1" src="../IMATGES/'.$this->image.'"/>';
        }
    }
?>
