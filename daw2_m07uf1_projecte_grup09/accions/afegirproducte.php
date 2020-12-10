<?php
     ini_set('display_errors', 1);
     session_start();
     if (!isset($_SESSION["clientid"]));
     else if($_SESSION["clientname"]=="admin"){
     $prova=$_POST['form_name'];
     include '../classproduct.php';
     include '../classfitxer.php';
     $prova=$_POST['form_name'];
     $fitxer1 = new Fitxer("../FITXERS/products.txt");
     $linea=$fitxer1->fitxerlecturaEscritura();
     $product=null;
     $product=$fitxer1->afegirproducte($linea,$_POST['form_code'],$_POST['form_name'],$_POST['form_section'],$_POST['form_price'],$_POST['form_image']);
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
          else if($product==null){
               echo "<p>El nom del producte o el codi ja existeix\n".'Torna a  intentar-lo <a class="a_button" href="../maintenancecatalog.html">tornar</a>';
          }else echo "AFEGIT".'<a class="a_button" href="../maintenancecatalog.html">tornar</a>';
     ?>
     </div>
</body>
</html>