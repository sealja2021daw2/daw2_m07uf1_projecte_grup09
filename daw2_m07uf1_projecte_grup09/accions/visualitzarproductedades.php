<?php
     ini_set('display_errors', 1);
     session_start();
     if (!isset($_SESSION["clientid"]));
     else{
          include '../classproduct.php';
          include '../classfitxer.php';
          $fitxer1 = new Fitxer("../FITXERS/products.txt");
          $linea=$fitxer1->fitxerlectura();
          $dades="";
          $dades=$fitxer1->visualitzarproductes($linea,$_GET['form_name']); 
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
          else{
               echo "<h1>".$_GET['form_name']."</h1>";
               if($_SESSION['clientname']=="admin") echo $dades.'<br/><a class="a_button" href="../maintenancecatalog.html">tornar</a>';
               else echo "<p>".$dades."</p>".'<a class="a_button" href="../catalog.html">tornar</a>';
          }
     ?>
     </div>
</body>
</html>

