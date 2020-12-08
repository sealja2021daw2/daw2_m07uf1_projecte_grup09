<html>
<head>
     <meta content="text/html" charset="UTF-8" http-equiv="content-type"/>
	<link href="CSS/projecte.css" rel="stylesheet" type="text/css"/>
	<title>projecte</title>
</head>
<body>
<div class="contingut_centrat">
     <?php
          ini_set('display_errors', 1);
          include 'classuser.php';
          $prova=$_POST['form_userr'];
          $filename="FITXERS/users.txt";
          $fitxer=fopen($filename,"r+") or die ("No s'ha pogut obrir el fitxer");
          if ($fitxer) {
               $mida_fitxer=filesize($filename);	
               $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
          }
          $existeix=0;
          $numusers=1;
          $seguentID=0;
          foreach ($linia as $cadena) {
               $numusers++;
               $prop=explode(';',$cadena);
               if($seguentID<$prop[0])$seguentID=$prop[0];
               if($_POST['form_userr'] == $prop[1]){
                    $existeix=1;
                    echo "Aquet Usuari ja existeix\n".'Torna a  intentar-lo <a class="a_button" href="registre.html">REGISTER</a>';
                    break;
               }
          }
          $usuariregistre=new Client($seguentID+1,$_POST['form_userr'],$_POST['form_passwordr'],$_POST['form_allnamer'],$_POST['form_phoner'],$_POST['form_emailr'],$_POST['form_visar'],$_POST['form_postalr']);
          $usuari="\n".$usuariregistre->id.";".$usuariregistre->user.";".$usuariregistre->password.";".$usuariregistre->allname.";".$usuariregistre->phone.";".$usuariregistre->email.";".$usuariregistre->visa.";".$usuariregistre->postalcode.";";
          if($existeix!=1){
               file_put_contents($filename, $usuari, FILE_APPEND | LOCK_EX);
               echo "<h1>Benvingut ".$usuariregistre->user."</h1>\n".'<a class="a_button" href="index.html">LOGIN</a>';
               echo "Ets al usuari:".$usuariregistre->id;
          }
	     fclose($fitxer);
          exit(0);
     ?>
</div>
</body>
</html>
