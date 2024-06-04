<?php
require('library/main.php');

// Inicializar la variable $maestro
$maestro = new Maestro();

if($_POST){
    $id = $_POST['id'];

    // Obtener el maestro por ID si está disponible
    if(isset($id)){
        $maestro_existente = getMaestroByid($id);
        if($maestro_existente){
            $maestro = $maestro_existente;
        }
    }
    
    // Asignar los valores de POST al maestro
    $maestro->cedula = $_POST['cedula'];
    $maestro->nombre = $_POST['nombre'];
    $maestro->apellido = $_POST['apellido'];
    $maestro->fnacimiento = $_POST['fnacimiento'];

    // Guardar el maestro en un archivo
    if(!is_dir('datos')){
        mkdir('datos');
    }

    // Ruta completa al archivo dentro de la carpeta "datos"
    $rutaArchivo = 'datos/' . $maestro->id . '.dat';

    // Serializar el objeto y guardar los datos en el archivo
    $data = serialize($maestro);
    file_put_contents($rutaArchivo, $data);

    // Redireccionar a 'datos.php'
    irA('datos.php');

} elseif(isset($_GET['id'])){
    $id = $_GET['id'];
    $rutaArchivo = 'datos/' . $id . '.dat';

    if(is_file($rutaArchivo)){
        // Deserializar el objeto desde el archivo
        $maestro = unserialize(file_get_contents($rutaArchivo));
    }
}

template::aplicar('Inicio');
?>

<h3>Listado del Maestr@</h3>

<form method="post" action="" class="mt-4">
    <!-- Corregir para mostrar el ID -->
    <input type="hidden" name="id" value="<?= $maestro->id; ?>">
    <?php
    echo asgInput('Cedula', 'cedula', $maestro->cedula);
    echo asgInput('Nombre', 'nombre', $maestro->nombre);
    echo asgInput('Apellido', 'apellido', $maestro->apellido);
    echo asgInput('Fecha de Nacimiento', 'fnacimiento', $maestro->fnacimiento, ['type'=>'date']);
    ?>
    <div class="">
        <button class="btn btn-primary">Guardar</button>
    </div>
</form>
