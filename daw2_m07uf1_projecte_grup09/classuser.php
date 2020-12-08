<?php
	#Treballant amb mètodes màgics.
	# https://www.php.net/manual/es/language.oop5.magic.php
	# https://diego.com.es/metodos-magicos-en-php
	#
	Abstract class User {
		private $id;
        private $user;
        private $password;
        private $allname;
        private $phone;
        private $email;
        private $visa;
        private $postalcode;
		
        //constructor
        function __construct($id,$user,$password,$allname,$phone,$email,$visa,$postalcode) {
            $this->id = $id;
            $this->user = $user;
            $this->password = $password;
            $this->allname = $allname;
            $this->phone = $phone;
            $this->email = $email;
            $this->visa = $visa;
            $this->postalcode = $postalcode;
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
    }

    class Admin extends User{
        private $peticio;
    }

    class Client extends User{
        public function peticioborrausuari(){    

        }
        public function peticiomodificausuari(){
            
        }
        public function toString(){
            return "Nombre Complet: ".$this->allname."\t Telefon: ".$this->phone."\t Email: ".$this->email."\t Visa: ".$this->visa."\t Codi Postal: ".$this->postalcode;
        }
    }
    $admin=new Admin(0,"admin","admin","javier","prova","prova","prova","prova");
?>