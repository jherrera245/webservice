<?php
    require_once "config.php";

    $datos = array();
    $accion = "";

    if (isset($_POST["accion"])) {
        $accion = $_POST["accion"];
    }

    if ($accion == "insertar") {
        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];

        if (insertar($nombre, $telefono) == true) {
            $datos["estado"] = true;
            $datos["resultado"] = "Registro realizado correctamente";
        }else {
            $datos["estado"] = false;
            $datos["resultado"] = "No se pudo almacenar el contacto";
        }
    }else if ($accion == "listar") {
        $filtro = (isset($_POST["filtro"])) ? $_POST["filtro"] : "";
        $datos["estado"] = true;
        $datos["resultado"] = listar($filtro);
    }else if ($accion == "actualizar") {
        $id = $_POST["id_contacto"];
        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];

        if (actualizar($id, $nombre, $telefono) == true) {
            $datos["estado"] = true;
            $datos["resultado"] = "Registro actualizado correctamente";
        }else {
            $datos["estado"] = false;
            $datos["resultado"] = "No se pudo actualizar el contacto";
        }
    }else if ($accion == "eliminar") {
        $id = $_POST["id_contacto"];

        if (eliminar($id) == true) {
            $datos["estado"] = true;
            $datos["resultado"] = "Registro eliminado correctamente";
        }else {
            $datos["estado"] = false;
            $datos["resultado"] = "No se pudo eliminar el contacto";
        }
    } 

    echo json_encode($datos);
?> 