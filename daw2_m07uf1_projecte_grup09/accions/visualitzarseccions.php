<?php
     ini_set('display_errors', 1);
     session_start();
     if (!isset($_SESSION["clientid"]));
     else{
          include '../classproduct.php';
          $filename="../FITXERS/products.txt";
          $fitxer=fopen($filename,"r") or die ("No s'ha pogut obrir el fitxer");
          if ($fitxer) {
               $mida_fitxer=filesize($filename);	
               $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
          }
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
          fclose($fitxer);
     }
?>
<html>
<head>
     <meta content="text/html" charset="UTF-8" http-equiv="content-type"/>
     <link href="../CSS/projecte.css" rel="stylesheet" type="text/css"/>
	<title>projecte</title>
</head>
<body>
     <div class="contingut_centrat">
         <h1>SECTIONS</h1>
     <?php
          if (!isset($_SESSION["clientid"])) echo "NO HI HA CAP SESSIO CREADA".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/index.html">INICIAR SESSIO</a>';
          else if( $_SESSION['clientname']=="admin") echo "<p>".$seccions."</p>".' <a class="a_button" href="../maintenancecatalog.html">ACCEDEIX</a>';
          else echo "<p>".$seccions."</p>".'<a class="a_button" href="../catalog.html">tornar</a>';
     ?>
     </div>
</body>
</html>