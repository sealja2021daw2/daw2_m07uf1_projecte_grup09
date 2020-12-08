<?php
     date_default_timezone_set('GMT+2');
     $today = date("d-m-Y H:i:s");
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
            $verifica=0;
            foreach ($linia as $cadena) {
                $prop=explode(';',$cadena);
                if($_POST['form_name']==$prop[1]){
                    $verifica=1;
                    break;
                }
            }
            fclose($fitxer);
          if($verifica !=1) echo "No existeix aquet producte";
          else{
               include '../classcommand.php';
               $prova=$_POST['form_name'];
               $filename="../FITXERS/commands.txt";
               $fitxer=fopen($filename,"r+") or die ("No s'ha pogut obrir el fitxer");
               if ($fitxer) {
                    $mida_fitxer=filesize($filename);	
                    $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
               }
               $existeix=0;
               $numcomanda=1;
               foreach ($linia as $cadena) {
                    $prop='';
                    $prop=explode(';',$cadena);
                    if($_SESSION["clientid"] == $prop[0]){
                         $numcomanda++;
                    }
                    if($_POST['form_name'] == $prop[2] && $_SESSION["clientid"] == $prop[0]){
                         $existeix=1;
                         break;
                    }
               }
               if($existeix!=1){
                    $comanda=new Command($_SESSION["clientid"],$numcomanda,$_POST['form_name'],$today);
                    $newcomanda="\n".$comanda->iduser.";".$comanda->numbercommand.";".$comanda->nameproduct.";".$comanda->datecommand.";";
                    file_put_contents($filename, $newcomanda, FILE_APPEND | LOCK_EX);
               }
               fclose($fitxer);
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
          else if ($verifica!=1) echo "<p>Aquet producte no existeix.</p> \n".'Torna a  intentar-lo <a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
          else if($existeix==1) echo "<p>Ja has demanat al producte anteriorment.</p> \n".'Torna a  intentar-lo <a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
          else echo "AFEGIT".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
     ?>
     </div>
</body>
</html>