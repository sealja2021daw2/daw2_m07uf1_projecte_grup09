<?php
     date_default_timezone_set('GMT+2');
     $today = date("d-m-Y H:i:s");
     session_start();
     if (!isset($_SESSION["clientid"]));
     else{
          include '../classproduct.php';
          include '../classfitxer.php';
          $fitxer1 = new Fitxer("../FITXERS/products.txt");
          $linea=$fitxer1->fitxerlectura();
          $verifica=null;
          $verifica=$fitxer1->visualitzarproductes($linea,$_POST['form_name']);
          if($verifica ==null);
          else{
               include '../classcommand.php';
               $fitxer1 = new Fitxer("../FITXERS/commands.txt");
               $linea=$fitxer1->fitxerlecturaEscritura();
               $command=null;
               $command=$fitxer1->afegircomanda($linea, $_SESSION["clientid"],$_POST['form_name']);
          }
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
          else if ($verifica==null) echo "<p>Aquet producte no existeix.</p> \n".'Torna a  intentar-lo <a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
          else if($command==null) echo "<p>Ja has demanat al producte anteriorment.</p> \n".'Torna a  intentar-lo <a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
          else echo "AFEGIT".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
     ?>
     </div>
</body>
</html>