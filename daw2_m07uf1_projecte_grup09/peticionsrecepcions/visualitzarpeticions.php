<?php
     $filename="../FITXERS/peticions.txt";
     $fitxer=fopen($filename,"r") or die ("No s'ha pogut obrir el fitxer");
     if ($fitxer) {
          $mida_fitxer=filesize($filename);	
          $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
     }
     $visupeticio="";
     foreach ($linia as $cadena) {
          $prop=explode(';',$cadena);
          if("Modifiedcommand"== $prop[0] || "Deletecommand"== $prop[0] || "Deleteuser"== $prop[0] || "Modifieduser"== $prop[0]){
            $visupeticio.="".$prop[0]."|\t".$prop[1]."|\t".$prop[2]."|\t".$prop[3]."|\t".$prop[4]."<br/>";
          }
     }
     fclose($fitxer);
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
          echo "<h1>VIEW LIST REQUESTS</h1>";
          echo "<p>".$visupeticio."</p>".'<a class="a_button" href="../adminprincipal.html">tornar</a>';
     ?>
     </div>
</body>
</html>