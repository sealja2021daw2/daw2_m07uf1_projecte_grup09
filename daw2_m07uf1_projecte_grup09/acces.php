<?php
    ini_set('display_errors', 1);
    session_start();
    if (isset($_SESSION['clientid'])){
        $where=0;
        if($_SESSION['clientname']=="admin") $where=1;    
    }else{
        include 'classuser.php';
        $estat=0;
        if($_POST['form_useri']==$admin->user && $_POST['form_passwordi']==$admin->password){
            $_SESSION['clientname'] = $admin->user;
            $_SESSION['clientid'] = $admin->id;
            $estat=1;
        }else{
            include 'classfitxer.php';
            $fitxer1 = new Fitxer("FITXERS/users.txt");
            $linea=$fitxer1->fitxerlectura();
            $usuariacces=$fitxer1->accedir($linea,$_POST['form_useri'],$_POST['form_passwordi']); 
        }
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
        if (isset($where)){ 
            if($where==1) echo "<h1>No habias tancat la sessio amb l'usuari ". $_SESSION['clientname']."</h1>\n".' <a class="a_button" href="adminprincipal.html">ACCEDEIX</a>';
            else echo "<h1>No habias tancat la sessio amb l'usuari ".$_SESSION['clientname']."</h1>\n".' <a class="a_button" href="clientprincipal.html">ACCEDEIX</a>';
        }else if(!isset($_SESSION['clientname'])) echo "Usuari o contrasenya incorrecta\n".'<a class="a_button" href="index.html">LOGIN</a>';
        else if($_SESSION['clientname']=="admin") echo "<h1>Hola de nou ".$admin->user."</h1>\n".' <a class="a_button" href="adminprincipal.html">ACCEDEIX</a>';
        else echo "<h1>Hola de nou ".$usuariacces->user."</h1>\n".' <a class="a_button" href="clientprincipal.html">ACCEDEIX</a>';
        exit(0);
     ?>
</div>
</body>
</html>