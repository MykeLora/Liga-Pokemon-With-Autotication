<?php

// Retorna una URL completa para el sitio
function base_url($path = '') {
    if (!defined('SERVER_URL')) {
        define('SERVER_URL', 'http://localhost:8000'); // Cambia la URL según corresponda
    }
}


function asgInput($label, $id, $valor="", $extra= []){
        
    $type = "text";
    $placeholde = "";

    extract($extra);

    return <<<CODIGO

    <div class="form-group m-3">
        <span class="input-group-text" id="basic-addon1">{$label}<span>
        <input type="{$type}" class="form-control" value="{$valor}" name="{$id}" placeholder="" id="">
    </div>

CODIGO;
}


function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    } else {
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
            
        return $uuid;
    }
}

function irA($url) {
    $url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/' . ltrim($url, '/');
    echo "
        <script>
            console.log('Redirigiendo a: {$url}');
            window.location.href = '{$url}';
        </script>
    ";
    exit();
}



function getMaestroByid($id){
    $id = $_GET['id'];
    $rutaArchivo = 'datos/' . $id . '.dat';

    if(is_file($rutaArchivo)){
        $maestro = unserialize(file_get_contents($rutaArchivo));
        return $maestro;
    }
    return false;
}


//***
//*** Funcion que retorna el usuario actual
//***

function getUser($redirect = true){
    if(isset($_SESSION['PokeUser'])){
        $tmp = $_SESSION['PokeUser'];
        $final = unserialize($tmp);
        return $final;
    }
    if ($redirect){
        irA('login.php');
    }
    return false;
}


/**
 * Guarda el usuario en la sesion
 * @param Usuario $usuario
 */
function setUser($usuario){
    $_SESSION['PokeUser'] = serialize($usuario);
}

class Mensaje {
    public static function mostrarError($mensaje) {
        echo '<div class="alert alert-danger" role="alert">' . $mensaje . '</div>';
    }

    public static function mostrarInfo($mensaje) {
        echo '<div class="alert alert-info" role="alert">' . $mensaje . '</div>';
    }

    public static function mostrarWarning($mensaje) {
        echo '<div class="alert alert-warning" role="alert">' . $mensaje . '</div>';
    }

    public static function mostrarSuccess($mensaje) {
        echo '<div class="alert alert-success" role="alert">' . $mensaje . '</div>';
    }
}
