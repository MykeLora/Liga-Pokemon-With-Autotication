<?php
require('library/main.php');


if($_POST){

    // Inicializar la variable $usuario
    $usuario = new Usuario();
    $id = $_POST['id'];

    // Obtener el usuario por ID si está disponible
    if(isset($id)){
        $usuario_existente = getUsuarioById($id);
        if($usuario_existente){
            $usuario = $usuario_existente;
        }
    }
    
    // Asignar los valores de POST al usuario
    $usuario->usuario = $_POST['usuario'];
    $usuario->nombre = $_POST['nombre'];
    $usuario->clave = md5($_POST['clave'] . PWD_SALT); // Nota: esto no es seguro, se recomienda usar password_hash()

    // Guardar el usuario en un archivo
    if(!is_dir('usuarios')){
        mkdir('usuarios');
    }

    // Ruta completa al archivo dentro de la carpeta "datos"
    $rutaArchivo = 'usuarios/' . $usuario->usuario . '.dat';

    // Serializar el objeto y guardar los datos en el archivo
    $data = serialize($usuario);
    file_put_contents($rutaArchivo, $data);

    // Redireccionar a 'datos.php'
    irA('list_usuario.php');

} elseif(isset($_GET['id'])){
    $id = $_GET['id'];
    $rutaArchivo = 'usuarios/' . $id . '.dat';

    if(is_file($rutaArchivo)){
        // Deserializar el objeto desde el archivo
        $usuario = unserialize(file_get_contents($rutaArchivo));
    }
}
else{
    $usuario = new Usuario();
}

template::aplicar('Inicio');
?>

<h3>Registro de Usuario</h3>

<form method="post" action="" class="mt-4">
    <?php
    echo asgInput('Usuario', 'usuario', $usuario->usuario);
    echo asgInput('Nombre', 'nombre', $usuario->nombre);
    echo asgInput('Clave', 'clave', $usuario->clave); // Asegúrate de que estás manejando la seguridad de la contraseña correctamente
    ?>
    <div class="">
        <button class="btn btn-primary mt-3">Guardar</button>
    </div>
</form>
