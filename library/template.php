<?php

/*Aplicando el patrón de diseño singleton para crear una única instancia de esta clase */
class Template
{

    public static $instancia = null;

    public static function aplicar($titulo = 'Listado Estudiante')
    {
        if (self::$instancia == null) {
            self::$instancia = new Template($titulo);
        }
        return self::$instancia;
    }

    /* Aplicando un método mágico encargado de dispararse cuando suceda un evento 
        pero en este caso se llamará cuando se cree la instancia de esta clase.
    */

    function __construct($titulo)
    {


?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" href="css/Main.css">
            <!-- Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <title><?= $titulo; ?></title>
        </head>

        <body>

            <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Mi Sitio</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">
                                    <i class="fa-solid fa-house"></i>
                                    Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="panel.php">Panel</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="datos.php">Datos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="list_usuario.php">Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="acercade.php">Acerca de</a>
                            </li>

                        </ul>

                        <form class="d-flex" role="search" action="buscar.php">
                            <input class="form-control me-2" type="search" placeholder="Buscar entrenador" aria-label="Buscar">
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
                    </div>
                </div>
            </nav>

            <div class="div_central">
            <?php
        }

        /*El objetivo de este método destructor es mostrar al final de la página el copysr */

        function __destruct()
        {

            ?>

            </div>

            <hr />

            <footer class="mb-5">
                Derechos Reservados <?= date('Y'); ?> &copy;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            </footer>
        </body>

        </html>

<?php

    }
}
?>
