<?php
require('library/main.php');
template::aplicar('Inicio');

$id = $_GET['id'];

$maestro = getMaestroByid($id);

if ($_POST) {
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];

    $maestro->pokemons = [];

    foreach ($nombre as $k => $i) {
        $p = new Pokemon();
        $p->nombre = $i;
        $p->tipo = $tipo[$k];
        $p->valor = $valor[$k];

        $maestro->pokemons[] = $p;
    }

    if (!is_dir('datos')) {
        mkdir('datos');
    }

    // Ruta completa al archivo dentro de la carpeta "datos"
    $rutaArchivo = 'datos/' . $maestro->id . '.dat';

    // Serializa el objeto y guarda los datos en el archivo
    $data = serialize($maestro);
    file_put_contents($rutaArchivo, $data);

    irA('datos.php');
}

if (!$maestro) {
    irA('datos.php');
}
?>

<h3 class="m-3">Registro de Pokemones</h3>
<div class="text-end">
    <button type='button' onclick='nuevopkm()' class="btn btn-success mt2">Nuevo Pokemones</button>
</div>

<div>
    <h4>Pokemons de: <?= $maestro->nombre; ?></h4>
</div>

<form method="post" action="" class="ins-text formulario">
    <table class="table table-custom">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Valor</th>
                <td></td>
            </tr>
        </thead>
        <tbody id="pkBody">
            <!-- Aquí se agregan las filas dinámicamente -->
        </tbody>
    </table>

    <div>
        <button class="btn btn-primary">
            <i class="fa fa-save"></i>
            Guardar
        </button>
    </div>
</form>

<script>
    function nuevopkm() {
        const npokemons = {
            'nombre': '',
            'tipo': '',
            'valor': ''
        };
        editarpkmpkm(npokemons);
    }

    function editarpkmpkm(op) {
        const fila = `
            <tr>
                <td><input type="text" value="${op.nombre}" required name="nombre[]" class="form-control"/></td>
                <td><input type="text" value="${op.tipo}" required name="tipo[]" class="form-control"/></td>
                <td><input type="text" value="${op.valor}" required name="valor[]" class="form-control"/></td>
                <td><button onclick="deleterow(this);" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
            </tr>
        `;
        document.getElementById('pkBody').insertAdjacentHTML('beforeend', fila);
    }

    function deleterow(btn) {
        if (confirm("¿Desea eliminar este Pokémon?")) {
            const fila = btn.parentNode.parentNode;
            fila.parentNode.removeChild(fila);
        }
    }

    // Cargar Pokémons existentes al cargar la página
    const pokemones = <?= json_encode($maestro->pokemons); ?>;
    pokemones.forEach(pokemon => editarpkmpkm(pokemon));
</script>
