<?php
require('library/main.php');
template::aplicar('Datos de los Entrenadores');
?>

<style>
    /* Estilos personalizados para la tabla */
    .table-custom {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
        color: #333;
        background-color: #f8f9fa;
    }

    .table-custom th,
    .table-custom td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table-custom th {
        background-color: green;
        color: #fff;
    }

    .table-custom .pokemones-cell {
        background-color: ##f8f9fa; /* Cambia el color de fondo a transparente */
        color: #333; /* Color de texto normal */

    }

    .table-custom tbody tr:hover {
        background-color: #e9ecef;
    }
</style>


<h2 class="m-3">Listado de Usuarios</h2>
<div class="text-end">
    <a href="editar_usuario.php" class="btn btn-success">Nuevo Usuario</a>
</div>

<table class="table table-custom">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Nombre</th>

        </tr>
    </thead>

    <tbody>

        <?php

        // Ruta al directorio de usuarios
        $rutaUsuarios = 'usuarios';

        // Verificar si el directorio de usuarios no existe
        if (!is_dir($rutaUsuarios)) {
            // Intentar crear el directorio de usuarios
            if (!mkdir($rutaUsuarios, 0777, true)) {
                // Si falla la creación, mostrar un mensaje de error y salir
                die("No se pudo crear el directorio '$rutaUsuarios'");
            }
        }

        // Escanear el directorio de usuarios para obtener los archivos
        $archivos = scandir($rutaUsuarios);

        // Recorrer los archivos
        foreach ($archivos as $archivo) {
            // Excluir los directorios "." y ".."
            if ($archivo != '.' && $archivo != '..') {
                // Construir la ruta completa al archivo
                $rutaArchivo = $rutaUsuarios . '/' . $archivo;

                // Leer el contenido del archivo
                $contenido = file_get_contents($rutaArchivo);

                // Deserializar el contenido para obtener el objeto original
                $user = unserialize($contenido);

                // Imprimir los datos en la tabla
                echo <<<FILA
                <tr>
                    <td>{$user->usuario}</td>
                    <td>{$user->nombre}</td>
                    <td>{$user->clave}</td>
                    <td >
                        <a href='editar_usuario.php?id={$user->usuario}' class='btn btn-warning'><i class='fa fa-edit'></i></a>
                        <a 
                        onclick="return confirm('¿Estás seguro que deseas eliminar este usuario?')"
                        href="usuario_delete.php?id= {$user->usuario}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
FILA;
            }
        }
        ?>

    </tbody>
</table>
