<?php

#funcion para la conexion a base de datos
function conectar() {
    $server = "localhost";
    $database = "mi_agenda";
    $user = "root";
    $password = "";
    // Create connection
    $conexion = mysqli_connect($server, $user, $password, $database);
    $conexion->set_charset("utf8mb4");

    // Check connection
    if (!$conexion) {
       $conexion = mysqli_error($conexion);
    }

    return $conexion;
}

# Funcion para deconectar
function desconectar($conexion) {
    try {
        mysqli_close($conexion);
        $estado = true;
    } catch (Exception $e) {
        $estado = false;
    }
    return $estado;
}

# funcion para insertar datos a la base de datos
function insertar($nombre, $telefono) {
    $conexion = conectar();
    $query = "INSERT INTO contactos (id, nombre,telefono) VALUES(NULL, '$nombre', '$telefono')";   
    
    if (mysqli_query($conexion, $query)) {
        $estado = true; 
    }else {
        $estado = false;
    }

    desconectar($conexion);
    return $estado;
}

# funcion para actualizar datos a la base de datos
function actualizar($id, $nombre, $telefono) {
    $conexion = conectar();
    $query = "UPDATE contactos  SET nombre = '$nombre', telefono = '$telefono' WHERE id = '$id'";   
    
    if (mysqli_query($conexion, $query)) {
        $estado = true; 
    }else {
        $estado = false;
    }

    desconectar($conexion);
    return $estado;
}

# funcion para actualizar datos a la base de datos
function eliminar($id) {
    $conexion = conectar();
    $query = "DELETE FROM contactos WHERE id = '$id'";   
    
    if (mysqli_query($conexion, $query)) {
        $estado = true; 
    }else {
        $estado = false;
    }

    desconectar($conexion);
    return $estado;
}

# funcion para listar contactos
function listar($filtro) {
    $conexion = conectar();
    $json = array();
    
    $query = "SELECT id, nombre, telefono FROM contactos WHERE nombre LIKE '%$filtro%' OR telefono LIKE '%$filtro%'";
    
    $result = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($contacto = mysqli_fetch_array($result)) {
            $row = array();
            $row['id'] = $contacto['id'];
            $row['nombre'] = $contacto['nombre'];
            $row['telefono'] = $contacto['telefono'];
            $json[] = $row;
        }
    }
    
    desconectar($conexion);
    return array_values($json);
}