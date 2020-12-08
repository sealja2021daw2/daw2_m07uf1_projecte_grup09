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
          $productes="";
          foreach ($linia as $cadena) {
               $prop=explode(';',$cadena);
               if($_GET['form_section']== $prop[2]){
               $producte=new Product($prop[0],$prop[1],$prop[2],$prop[3],$prop[4]);
               $productes.="code ".$producte->code."|\t".$producte->name."\t".$producte->price."€<br/>";
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
     <?php
          if (!isset($_SESSION["clientid"])) echo "NO HI HA CAP SESSIO CREADA".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/index.html">INICIAR SESSIO</a>';
          else if($_SESSION['clientname']=="admin"){
               echo "<h1>PRODUCTS for ".$_GET['form_section']."</h1>";
               echo "<p>".$productes."</p>".' <a class="a_button" href="../maintenancecatalog.html">tornar</a>';
          }
          else{ 
               echo "<h1>PRODUCTS for ".$_GET['form_section']."</h1>";
               echo "<p>".$productes."</p>".'<a class="a_button" href="../catalog.html">tornar</a>';
          }
     ?>
     </div>
</body>
</html>