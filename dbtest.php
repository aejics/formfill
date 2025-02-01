<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once(__DIR__ . "/vendor/autoload.php");
    $giae = new \juoum\GiaeConnect\GiaeConnect("giae.aejics.org");
    $giae->session=$_COOKIE["session"];
    $config = json_decode($giae->getConfInfo(), true);
    $perfil = json_decode($giae->getPerfil(), true);
    // var_dump($config);
    // print $perfil['perfil']['nome'];
    // print $perfil['perfil']['email'];
    // print $config['fotoutente'];
    print $config['nomeutilizador'];
?>