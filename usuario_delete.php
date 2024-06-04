<?php


require('library/main.php');

$usuario = getUser();

$id = $_GET['id'];

    $rutaArchivo = 'usuarios/' . $id . '.dat';

    if(is_file($rutaArchivo)){
        unlink($rutaArchivo);
    }
    irA('list_usuario.php');
