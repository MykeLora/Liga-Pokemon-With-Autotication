<?php
require('library/main.php');
template::aplicar('Panel Estadístico');

$archivos = scandir('datos/');
$datos = [];
$cantidad_pokemons = 0; // Inicializar la cantidad total de Pokémon
$edad_total = 0; // Inicializar la suma total de edades
$valor_total = 0; // Inicializar la suma total de valores de Pokémon
$pokemon_mas_caro = 0; // Inicializar el nombre del Pokémon más caro
$pokemon_mas_caro_valor = 0; // Inicializar el valor del Pokémon más caro
$pokemon_menos_valioso = 0; // Inicializar el nombre del Pokémon menos valioso
$pokemon_menos_valioso_valor = PHP_INT_MAX; // Inicializar el valor del Pokémon menos valioso

foreach ($archivos as $archivo) {
    // Excluir los directorios "." y ".."
    if ($archivo != '.' && $archivo != '..') {
        // Construir la ruta completa al archivo
        $rutaArchivo = 'datos/' . $archivo;
            
        // Leer el contenido del archivo
        $contenido = file_get_contents($rutaArchivo);
            
        // Deserializar el contenido para obtener el objeto original
        $maestro = unserialize($contenido);
        
        $datos[] = $maestro;

        // Contar la cantidad de Pokémon del maestro actual y sumarla a la cantidad total
        $cantidad_pokemons += count($maestro->pokemons);

        // Sumar la edad del maestro actual a la suma total de edades
        $edad_total += intval($maestro->calcularEdad());

       // Convertir la variable $valor_total a entero antes de utilizarla en operaciones aritméticas
        $valor_total = intval($valor_total);

        foreach ($maestro->pokemons as $p) {
            if (property_exists($p, 'valor')) {
                // Convertir $p->valor a entero antes de sumarlo a $valor_total
                $valor_total += intval($p->valor);

                if ($p->valor > $pokemon_mas_caro_valor) {
                    $pokemon_mas_caro_valor = $p->valor;
                    $pokemon_mas_caro = $p->nombre;
                }

                if ($p->valor < $pokemon_menos_valioso_valor) {
                    $pokemon_menos_valioso_valor = $p->valor;
                    $pokemon_menos_valioso = $p->nombre;
                }
            }
        }

        
    }
}

$cantidad_maestro = count($datos);
$promedio_pokemones_por_entrenador = $cantidad_pokemons / $cantidad_maestro;
$edad_promedio = $edad_total / $cantidad_maestro;
$valor_promedio_pokemones = $valor_total / $cantidad_pokemons;
?>


<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Tarjeta para la cantidad total de entrenadores registrados -->
            <div class="card bg-primary text-white mb-3 fit-content">
                <div class="card-header">
                    <span class="emoji">👥</span> Cantidad total de entrenadores registrados
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $cantidad_maestro; ?></h5>
                </div>
            </div>
            
            <!-- Tarjeta para el promedio de Pokémon por entrenador -->
            <div class="card bg-success text-white mb-3 fit-content">
                <div class="card-header">
                    <span class="emoji">🐾</span> Promedio de Pokémon por entrenador
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= number_format($promedio_pokemones_por_entrenador, 2); ?></h5>
                </div>
            </div>
            
            <!-- Tarjeta para la edad promedio de los entrenadores -->
            <div class="card bg-info text-white mb-3 fit-content">
                <div class="card-header">
                    <span class="emoji">🎂</span> Edad promedio de los entrenadores
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= number_format($edad_promedio, 2); ?> años</h5>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- Tarjeta para la cantidad total de Pokémon registrados -->
            <div class="card bg-warning text-white mb-3 fit-content">
                <div class="card-header">
                    <span class="emoji">🐉</span> Cantidad total de Pokémon registrados
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $cantidad_pokemons; ?></h5>
                </div>
            </div>
            
            <!-- Tarjeta para el valor promedio de los Pokémon -->
            <div class="card bg-danger text-white mb-3 fit-content">
                <div class="card-header">
                    <span class="emoji">💰</span> Valor promedio de los Pokémon
                </div>
                <div class="card-body">
                    <h5 class="card-title">$<?= number_format($valor_promedio_pokemones, 2); ?></h5>
                </div>
            </div>
            
            <!-- Tarjeta para el Pokémon más caro -->
            <div class="card bg-secondary text-white mb-3 fit-content">
                <div class="card-header">
                    <span class="emoji">💎</span> Pokémon más caro
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $pokemon_mas_caro; ?></h5>
                </div>
            </div>
          
            <!-- Tarjeta para el Pokémon menos valioso -->
            <div class="card bg-dark text-white mb-2 fit-content">
                <div class="card-header">
                    <span class="emoji">💩</span> Pokémon menos valioso
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $pokemon_menos_valioso; ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

