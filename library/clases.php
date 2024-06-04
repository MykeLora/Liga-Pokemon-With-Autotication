<?php


class Maestro{
    public function __construct($id = null) {
        if($id == null){
            $id = getGUID();
        }
        $this->id = $id;
    }

    public $id = null;
    public $cedula = "";
    public $nombre = "";
    public $apellido = "";
    public $fnacimiento = "";

    public $pokemons = [];

     // Método para calcular la edad del maestro
    public function calcularEdad() {
        // Calcular la diferencia entre la fecha actual y la fecha de nacimiento
        $fecha_nacimiento = new DateTime($this->fnacimiento);
        $fecha_actual = new DateTime();
        $diferencia = $fecha_actual->diff($fecha_nacimiento);

        // Devolver la edad en años como un entero
        return $diferencia->y;
    }
}


class Pokemon{
    
    public $nombre = "";
    public $tipo = "";
    public $valor = "";
}

class Usuario{
    public $id = null;
    public $usuario = '';
    public $clave = '';
    public $nombre = '';

}
