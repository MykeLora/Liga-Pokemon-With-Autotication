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

    .table-custom th, .table-custom td {
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


<h2 class="m-3">Listado de maestros</h2>
<div class="text-end">
    <a href="editar.php" class="btn btn-success">Nuevo Maestro</a>
</div>

<table class="table table-custom">
    <thead>
        <tr>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Pokemones</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>


    <?php

        $archivos = scandir('datos');

        foreach ($archivos as $archivo) {
            // Excluir los directorios "." y ".."
            if ($archivo != '.' && $archivo != '..') {
                // Construir la ruta completa al archivo
                $rutaArchivo = 'datos/' . $archivo;
                
                // Leer el contenido del archivo
                $contenido = file_get_contents($rutaArchivo);
                
                // Deserializar el contenido para obtener el objeto original
                $maestro = unserialize($contenido);
               
                    
                // Verificar si la propiedad "pokemones" está definida y es un array
                if (isset($maestro->pokemons) && is_array($maestro->pokemons)) {
                    // Obtener la cantidad de pokemones
                    $cpokemones = count($maestro->pokemons);
                } else {
                    // Si la propiedad "pokemones" no está definida o no es un array, establecer la cantidad de pokemones en 0
                    $cpokemones = 0;
                }
                // Imprimir los datos en la tabla
                echo <<<FILA
                <tr>
                    <td>{$maestro->cedula}</td>
                    <td>{$maestro->nombre}</td>
                    <td>{$maestro->apellido}</td>
                    <td>{$cpokemones}</td>
                    <td class='pokemones-cell'>
                        <a href='pokemones.php?id={$maestro->id}' class='btn btn-warning m-1'> pokemones</a>
                        <a href='editar.php?id={$maestro->id}' class='btn btn-warning'><i class='fa fa-edit'></i></a>
                    </td>
                </tr>
FILA;
            }
        }    
    ?>

    </tbody>
</table>