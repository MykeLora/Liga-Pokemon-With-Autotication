<?php
require('library/main.php');

// Definir usuario y contraseña por defecto
define('DEFAULT_USER', 'admin');
define('DEFAULT_PASSWORD', 'puntosregalados');

// Obtener la ruta a la carpeta de usuarios
$rutaUsuarios = 'usuarios';

// Verificar si se han realizado intentos de inicio de sesión
if (!isset($_SESSION['pokeIntentos'])) {
    $_SESSION['pokeIntentos'] = 0;
}

$mensaje = ''; // Mensaje para mostrar errores

// Obtener la lista de archivos de usuarios
$archivos = scandir($rutaUsuarios);

// Verificar si hay usuarios registrados
$hayUsuarios = count($archivos) > 2; // scandir() devuelve '.' y '..' además de los archivos

if ($_POST) {
    // Obtener los datos de usuario y contraseña del formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Verificar si el usuario y la contraseña coinciden con el usuario por defecto
    if ($usuario == DEFAULT_USER && $password == DEFAULT_PASSWORD && !$hayUsuarios) {
        // Establecer el usuario autenticado como el usuario por defecto
        $usuario_autenticado = new Usuario();
        $usuario_autenticado->usuario = DEFAULT_USER;
        $usuario_autenticado->nombre = "Defaul User";
        setUser($usuario_autenticado);
        // Redireccionar a la página principal
        irA('');
    } else {
        // Si hay usuarios registrados o si el usuario no es el por defecto, realizar la autenticación normal
        foreach ($archivos as $archivo) {
            if ($archivo != '.' && $archivo != '..') {
                // Construir la ruta al archivo de usuario
                $rutaArchivo = $rutaUsuarios . '/' . $archivo;
                // Deserializar el contenido del archivo para obtener el usuario
                $usuarioGuardado = unserialize(file_get_contents($rutaArchivo));
                // Verificar si el usuario y la contraseña coinciden
                if ($usuarioGuardado->usuario == $usuario && md5($password . PWD_SALT) == $usuarioGuardado->clave) {
                    // Establecer el usuario autenticado
                    setUser($usuarioGuardado);
                    // Redireccionar a la página principal
                    irA('');
                }
            }
        }

        // Incrementar el contador de intentos de inicio de sesión
        $_SESSION['pokeIntentos']++;
        // Establecer el mensaje de error
        $mensaje = "Usuario o contraseña incorrectos ($_SESSION[pokeIntentos])";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/Main.css">
    <title></title>
</head>
<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="text-center">
                            <h3 class="mt-2">Inicio de Sesion</h3>
                            <hr>
                            <img src="img/pokebola.png" alt="poke" style="width: 100px; border-radius: 50%;" class="m-2">
                        </div>

                        <div class="card-body ">
                            <form action="" method="post">
                                <div class="form-outline form-white mb-4">
                                    <label class="form-label" for="usuario">Usuario</label>
                                    <input type="text" name="usuario" id="usuario" class="form-control form-control-lg" required autofocus />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <label class="form-label" for="password">Contraseña</label>
                                    <input  type="password" name="password" id="password" class="form-control form-control-lg" required />
                                </div>

                                <div>
                                    <?php if ($hayUsuarios && isset($_POST['usuario']) && $_POST['usuario'] == DEFAULT_USER): ?>
                                    <div style="color: red;">Usuario por defecto deshabilitado.</div>
                                    <?php endif; ?>

                                </div><br>

                                <div class="text-center">
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Iniciar Sesion</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
