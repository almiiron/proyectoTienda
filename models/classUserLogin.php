<?php
class userLogin
{
    private $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function buscarUser($id, $user, $password)
    {
        if (!empty($id) && !empty($user) && !empty($password)) {
            $query = "SELECT * FROM usuarios WHERE id_usuario = '$id' AND nombre_usuario = '$user' AND password = '$password';";
        } else if (!empty($user) && !empty($password)) {
            $query = "SELECT * FROM usuarios WHERE nombre_usuario = '$user' AND password = '$password';";
        }
        $resultado = $this->conexion->ejecutarConsulta($query);
        if (mysqli_num_rows($resultado) > 0) {
            $estado = True;
        } else {
            $estado = False;
        }
        return $estado;
    }
}
?>