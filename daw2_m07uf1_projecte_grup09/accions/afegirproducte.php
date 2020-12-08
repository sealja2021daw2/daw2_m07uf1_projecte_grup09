<?php
     ini_set('display_errors', 1);
     session_start();
     if (!isset($_SESSION["clientid"]));
     else if($_SESSION["clientname"]=="admin"){
          include '../classproduct.php';
          $prova=$_POST['form_name'];
          $filename="../FITXERS/products.txt";
          $fitxer=fopen($filename,"r+") or die ("No s'ha pogut obrir el fitxer");
          if ($fitxer) {
               $mida_fitxer=filesize($filename);	
               $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
          }
          $existeix=0;
          foreach ($linia as $cadena) {
               $prop=explode(';',$cadena);
               if($_POST['form_name'] == $prop[1] || $_POST['form_code'] == $prop[0]){
                    $existeix=1;
                    break;
               }
          }
          if($existeix!=1){
               $producte=new Product($_POST['form_code'],$_POST['form_name'],$_POST['form_section'],$_POST['form_price'],$_POST['form_image']);
               $newproducte="\n".$producte->code.";".$producte->name.";".$producte->section.";".$producte->price.";".$producte->image.";";
               file_put_contents($filename, $newproducte, FILE_APPEND | LOCK_EX);
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
          else if($_SESSION["clientname"]!="admin") echo "No tens permís".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/index.html">INICIAR SESSIO</a>';
          else if($existeix==1){
               echo "<p>El nom del producte o el codi ja existeix\n".'Torna a  intentar-lo <a class="a_button" href="../maintenancecatalog.html">tornar</a>';
          }else echo "AFEGIT".'<a class="a_button" href="../maintenancecatalog.html">tornar</a>';
     ?>
     </div>
</body>
</html>