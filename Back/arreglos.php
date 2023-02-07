<!-- C:\xampp\htdocs\arreglos -->
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost"; $usuario = "root"; $contrasenia = ""; $nombreBaseDatos = "arreglos";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);

// Esquema: Arreglos:      "ID": 1,
                //         "Nombre": "Juan",
                //         "Telefono": "555-5555",
                //         "Arreglo": "Reparación de computadora",
                //         "Precio": 500,
                //         "Abono": 250,
                //         "Estado": "Pendiente"
// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultar"])){
    $sqlarreeglos = mysqli_query($conexionBD,"SELECT * FROM arreglos WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlarreeglos) > 0){
        $arreeglos = mysqli_fetch_all($sqlarreeglos,MYSQLI_ASSOC);
        echo json_encode($arreeglos);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["borrar"])){
    $sqlarreeglos = mysqli_query($conexionBD,"DELETE FROM arreglos WHERE id=".$_GET["borrar"]);
    if($sqlarreeglos){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//Inserta un nuevo registro y recepciona en método post los datos de nombre, telefono, arreglo, precio, abono y estado
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $nombre=$data->nombre;
    $telefono=$data->telefono;
    $arreglo=$data->arreglo;
    $precio=$data->precio;
    $abono=$data->abono;
    $estado=$data->estado;
    if($nombre != "" && $telefono != "" && $arreglo != "" && $precio != "" && $abono != "" && $estado != ""){
            $sqlarreeglos = mysqli_query($conexionBD,"INSERT INTO arreglos(nombre,telefono,arreglo,precio,abono,estado) VALUES('$nombre','$telefono','$arreglo','$precio','$abono','$estado')");
            echo json_encode(["success"=>1]);
        }
    exit();

    // Ejemplo de peticion en postman
    // {
    //     "nombre": "Juan",
    //     "telefono": "555-5555",
    //     "arreglo": "Reparación de computadora",
    //     "precio": 500,
    //     "abono": 250,
    //     "estado": "Pendiente"
    // }
    // URL: http://localhost/Back/arreglos.php?insertar=1
    // Método: POST

}
// Actualiza datos pero recepciona datos de nombre, telefono, arreglo, precio, abono y estado y una clave para actualizar
if(isset($_GET["actualizar"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $nombre=$data->nombre;
    $telefono=$data->telefono;
    $arreglo=$data->arreglo;
    $precio=$data->precio;
    $abono=$data->abono;
    $estado=$data->estado;
    $sqlarreeglos = mysqli_query($conexionBD,"UPDATE arreglos SET nombre='$nombre',telefono='$telefono',arreglo='$arreglo',precio='$precio',abono='$abono',estado='$estado' WHERE id='$id'");
    
    echo json_encode(["success"=>1]);
    exit();
}
// Consulta todos los registros de la tabla arreglos
$sqlarreeglos = mysqli_query($conexionBD,"SELECT * FROM arreglos ");
if(mysqli_num_rows($sqlarreeglos) > 0){
    $arreeglos = mysqli_fetch_all($sqlarreeglos,MYSQLI_ASSOC);
    echo json_encode($arreeglos);
}
else{ echo json_encode([["success"=>0]]); }

?>
<!-- 
REST API: Conjunto de reglas que definen como se debe de comunicar un cliente con un servidor para realizar una petición y recibir una respuesta.

API: Conjunto de funciones y procedimientos que permiten la creación de aplicaciones que interactúan entre sí.

* GET: Método de petición HTTP que se utiliza para solicitar datos de un recurso específico.

CRUD: Create, Read, Update, Delete. Es un conjunto de operaciones básicas que se pueden realizar en una base de datos.

POST
Create: Crear un nuevo registro. http://localhost/arreglos/arreglos.php?insertar=1 // Es necesario enviar los datos en formato JSON en el cuerpo de la petición: 
    {
        "nombre": "Uzi",
        "telefono": "444-4444",
        "arreglo": "Reparación de Codig",
        "precio": "1500.00",
        "abono": "1250.00",
        "estado": "Pendiente"
    }
    ID no es necesario enviarlo, ya que es autoincrementable.
    
GET
Read: Crear un nuevo registro. http://localhost/arreglos/arreglos.php // NOS MUESTRA TODOS LOS REGISTROS, NO ES NECESARIO ENVIAR NADA

PUT
Update: Actualizar un registro. http://localhost/arreglos/arreglos.php?actualizar=1 // Es necesario enviar los datos en formato JSON en el cuerpo de la petición: 
    {
        "id": "1",
        "nombre": "Uzi",
        "telefono": "444-4444",
        "arreglo": "Reparación de Codig",
        "precio": "1500.00",
        "abono": "1250.00",
        "estado": "Pendiente"
    }
    ID es necesario enviarlo, ya que es el que se va a actualizar.

DELETE
Delete: Eliminar un registro. http://localhost/arreglos/arreglos.php?borrar=1 // Es necesario enviar el ID del registro que se va a eliminar.


JSON: Formato de texto ligero para el intercambio de datos. Un texto que describe un objeto. -->