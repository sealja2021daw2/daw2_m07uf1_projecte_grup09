<?php
     ini_set('display_errors', 1);
     $error=0;
     if(strlen($_POST['form_passwordr'])<8) $error=1;
     else if(strlen($_POST['form_userr'])<4) $error=2;
     else{
          include 'classuser.php';
          include 'classfitxer.php';
          $prova=$_POST['form_userr'];
          $fitxer1 = new Fitxer("FITXERS/users.txt");
          $linea=$fitxer1->fitxerlecturaEscritura();
          $user=null;
          $user=$fitxer1->afegirusuari($linea,$_POST['form_userr'],$_POST['form_passwordr'],$_POST['form_allnamer'],$_POST['form_phoner'],$_POST['form_emailr'],$_POST['form_visar'],$_POST['form_postalr']);
     }
     ?>
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
          if($error==1) echo "La contrasenya te que tindre minim 8 caracters\n".'Torna a  intentar-lo <a class="a_button" href="registre.html">REGISTER</a>';
          else if($error==2) echo "El nom del usuari te que tindre minim 4 caracters\n".'Torna a  intentar-lo <a class="a_button" href="registre.html">REGISTER</a>';
          else if($user!=null){
               echo "<h1>Benvingut ".$user->user."</h1>\n".'<a class="a_button" href="index.html">LOGIN</a>';
               echo "Ets al usuari:".$user->id;
          }else echo "Aquet Usuari ja existeix\n".'Torna a  intentar-lo <a class="a_button" href="registre.html">REGISTER</a>';
     ?>
</div>
</body>
</html>
