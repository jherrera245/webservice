<?php

require_once 'request.php';
require_once 'model.php';

//Definimos la codificación de caracteres en la cabecera.
header('Content-Type: text/html; charset=utf-8');

//configuracion de tabla
$table = "contactos"; //nombre tabla

//columnas
$columnas = [
    'id' => 'NULL',
    'nombre' => 'NULL',
    'telefono' => 'NULL'
];

//filtro para validaciones validaciones
$filter = [
    "id" => FILTER_SANITIZE_ENCODED,
    "nombre" => [
        'filter' => FILTER_SANITIZE_STRING,
        'flags'  => FILTER_FLAG_STRIP_LOW,
    ],
    "telefono" => [
        'filter' => FILTER_SANITIZE_STRING,
        'flags'  => FILTER_FLAG_STRIP_LOW,
    ]
]; 

//cargar datos
if (isGet() and getParam("action") == "all") {
    $json = array();

    foreach (selectAll($table) as $contacto) {
        $json["id"] = $contacto["id"];
        $json["nombre"] = $contacto["nombre"];
        $json["telefono"] = $contacto["telefono"];
    }
    
    echo json_encode($json);
}

//consultar un registro
if (isGet() and getParam("action") == "get") {
    $json = array();

    foreach (find($table, getParam("id")) as $contacto) {
        $json["id"] = $contacto["id"];
        $json["nombre"] = $contacto["nombre"];
        $json["telefono"] = $contacto["telefono"];
    }
    
    echo json_encode($json);
}

//guardar datos
if (isPost() and getParam("action") == "save") {
    //cargado datos a modelo
    $columnas["nombre"] = getParam('nombre');
    $columnas["telefono"] = getParam('telefono');

    //creamos un nuevo array con las entradas filtradas
    $data = filter_var_array($columnas, $filter);

    if (insert($table, $data) > 0) {
        echo json_encode(array('token_save'=>true));
    }else {
        echo json_encode(array('token_save'=>false));
    }
}

//Actualizar datos
if (isPost() and getParam("action") == "update") {
    //cargado datos a modelo
    $columnas["id"] = getParam("id");
    $columnas["nombre"] = getParam('nombre');
    $columnas["telefono"] = getParam('telefono');

    //creamos un nuevo array con las entradas filtradas
    $data = filter_var_array($columnas, $filter);

    if (update($table, $data) > 0) {
        echo json_encode(array('token_update'=>true));
    }else {
        echo json_encode(array('token_update'=>false));
    }
}

//Eliminar datos
if (isGet() && getParam("action") == "delete") {   
    if (delete($table, getParam("id")) > 0) {
        echo json_encode(array('token_delete'=>true));
    }else {
        echo json_encode(array('token_delete'=>false));
    }
}