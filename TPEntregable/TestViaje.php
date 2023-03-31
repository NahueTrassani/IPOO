<?php

include "Viaje.php";
include "Persona.php";

$listaViajes = array();
$listaPasajeros = array();

$opcion = 99;
do{
    menu($opcion,$listaViajes,$listaPasajeros);
}while($opcion<>0);
//menú
function menu($opcion,$listaViajes,$listaPasajeros){
    echo "¡Bienvenido!"."\n";
    echo "Seleccione una opción para continuar: "."\n".
    "║ 1 ║ Cargar Viaje                        "."\n".
    "║ 2 ║ Buscar Viaje                        "."\n".
    "║ 3 ║ Cargar Pasajero                     "."\n".
    "║ 4 ║ Modificar Pasajero                  "."\n".
    "║ 5 ║ Buscar Pasajero                     "."\n".
    "║ 0 ║ Salir                               "."\n";
    $opcion = fgets(STDIN);

    
    switch($opcion){
        case 0:
            ////echo "eligió la opción SALIR";
            exit; //finalizar ejecución.
        case 1:
            echo "eligió la opción 'Cargar Viaje'"."\n";
            //cargar viaje
            $listaViajes=agregarViaje($listaViajes);
            menu($opcion,$listaViajes,$listaPasajeros);
            break;
        case 2:
            echo "eligió la opción 'Buscar Viaje'"."\n";
            //buscar viaje en la coleccion de viajes.
            echo "Ingrese el 'Nro de Vuelo' que desea buscar: ";
            $x=trim(fgets(STDIN));
            $viaje = buscarViaje($listaViajes, $x);
           
            if (gettype($viaje) === 'object' && get_class($viaje) === 'Viaje'){
                //si encontró el vuelo lo muestra junto con sus pasajeros.
                // Verificar que $viaje->getPasajeros() no sea void
                 //validar que si el vuelo no tiene pasajeros que no intente mostrarlos.
                if (!empty($viaje->getPasajeros())) {
                    $personas = $viaje->getPasajeros();
                    for($i = 0; $i < count($personas); $i++){
                        $pers = $personas[$i];
                        $str = $pers->getNombre();
                        //el vuelo tiene pasajeros, muestra datos del vuelo y pasajeros.
                        echo "Datos viaje: "  ."\n". "Destino: " . $viaje->getDestino() ."\n". "Cantidad máxima de pasajeros: " . $viaje->getCantMaxPasajeros()."\n". "Cantidad total de pasajeros: " .$viaje->getCantPasajeros()."\n". "Pasajeros: " . $pers->getApellido() . ", " .$str . "\n";
                    }
                }else{
                    //el vuelo no tiene pasajeros, solo muestra datos del vuelo
                    echo "Datos viaje: "  ."\n". "Destino: " . $viaje->getDestino() ."\n". "Cantidad máxima de pasajeros: " . $viaje->getCantMaxPasajeros()."\n". "Cantidad total de pasajeros: " .$viaje->getCantPasajeros()."\n";
                }   
            }else{
                echo "No se encontro el vuelo"."\n";
            } 
            menu($opcion,$listaViajes,$listaPasajeros);
            break;
        case 3:
            echo "Para cargar una persona, antes debe indicar a continuación el vuelo donde desea ubicarlo: "."\n"; 
            $nroVuelo=trim(fgets(STDIN));
            $vuelo = buscarViaje($listaViajes, $nroVuelo);
            if (gettype($vuelo) === 'object' && get_class($vuelo) === 'Viaje'){
                //si encontró el vuelo carga al pasajero
                $pasajero=agregarPasajero($listaViajes,$nroVuelo);
                //agrega el pasajero a la coleccion de pasajeros 
                array_push($listaPasajeros,$pasajero);
                //y a la coleccion de pasajeros en un vuelo.
                $vuelo->cargarPasajeroVuelo($pasajero);
            }else{
                echo "No se encontro el vuelo"."\n";
            } 
            menu($opcion,$listaViajes,$listaPasajeros); //vuelve a llamar al menu con las colecciones.
            break;
        case 4:
            echo "eligió la opción 'Modificar Pasajero'"."\n";
            //MODIFICAR PERSONA.
            echo "Ingrese el dni del pasajero que desea buscar";
            $n = trim(fgets(STDIN));
            modificarPasajero($listaPasajeros, $n);
            menu($opcion,$listaViajes,$listaPasajeros);
            break;
        case 5:
            echo "eligió la opción 'Buscar Pasajero'"."\n";
            echo "Ingrese el dni del pasajero que desea buscar";
            $n = trim(fgets(STDIN));
            buscarPasajero($listaPasajeros, $n);
            menu($opcion,$listaViajes,$listaPasajeros);
            break;
        default:
            echo "Debe elegir una opción valida";
    }
}


/**
***************************SECCION viajes*************************************.
 */

/**
 * Summary of agregarViaje
 * @param array $listaViajes
 * @return array
 */
function agregarViaje($listaViajes){
    //crea instancia de clase viaje
    $viaje = new Viaje();
    //setea los datos del vuelo
    echo "Indique el número del vuelo (numérico): "."\n". "¡ADVERTENCIA!: Si el valor ingresado no es numérico, el vuelo no podrá ser encontrado (validación pendiente de implementación):"."\n";
    $id = fgets(STDIN);

    echo "Indique el destino del viaje: ";
    $destino = trim(fgets(STDIN));

    echo "Indique la capacidad máxima de personas que tiene el viaje: ";
    $cantMax = fgets(STDIN);

    //invoca al metodo insert de la clase viaje con los parametros indicados anteriormente.
    $viaje->cargarViaje($id,$destino,$cantMax);

    //echo "Viaje cargado en array con éxito ";
   
    $listaViajes[] = $viaje;
    
    return $listaViajes;
}



/**
 * Summary of buscarViaje
 * @param array $listaViajes
 * @param int $n
 * @return mixed
 */
function buscarViaje($listaViajes, $nroVuelo){
    for ($i = 0; $i < count($listaViajes); $i++){
        $encontro = recuperarViaje($listaViajes[$i],$nroVuelo);
        if ($encontro){
            return $listaViajes[$i];
        }
   }
}


/**
 * Summary of mostrarViaje
 * @param Viaje $viaje
 * @return boolean
 */
function recuperarViaje($viaje, $nroVuelo){
    $id = $viaje->getIdViaje();
    if ($viaje->getIdViaje() == $nroVuelo){
        //echo "encontró!!";
       return true;
    }else{
        //echo "NOOOO encontró";
        return false;
    }
    
    //$des = $viaje->getDestino();
    //echo "Destino: " . $des;
}



/**
 * Summary of listarViajes
 * @param array $listaViajes
 * @return void
 */
function listarViajes($listaViajes){
    for ($i = 0; $i < count($listaViajes); $i++){
        $viaje=$listaViajes[$i];
        echo "Datos viaje: "  ."\n". "Destino: " . $viaje->getDestino() ."\n". "Cantidad máxima de pasajeros: " . $viaje->getCantMaxPasajeros()."\n";
    }
}



/**
***************************SECCION PASAJEROS*************************************.
 */

/**
 * Summary of agregarPasajero
 * @param array $colPasajeros
 * @return Persona 
 */
function agregarPasajero($listaViajes, $nroVuelo){
    //crea instancia de clase viaje
    $persona1 = new Persona();
    //setea los datos del vuelo
    echo "Indique el Dni del pasajero (numérico): ";
    $dni = fgets(STDIN);

    echo "Indique el nombre del pasajero: ";
    $nombre = trim(fgets(STDIN));

    echo "Indique el apellido del pasajero: ";
    $apellido = trim(fgets(STDIN));

    echo "Indique el teléfono del pasajero: ";
    $telefono = fgets(STDIN);

    //invoca al metodo insert de la clase viaje con los parametros indicados anteriormente.
    $persona1->cargarPersona($dni, $nombre, $apellido, $telefono, $nroVuelo);
    $viaje = buscarViaje($listaViajes, $nroVuelo);
    $viaje->cuentaCantPasajeros(1);
    //$colPasajeros[]= $persona1;
    return $persona1;

}

/**
 * Summary of buscarPasajero
 * @param array $listaPasajeros
 * @param int $n
 * @return void
 */
function buscarPasajero($listaPasajeros, $n){
    for ($i = 0; $i < count($listaPasajeros); $i++){
        
        $persona=$listaPasajeros[$i];
        if (trim($persona->getDni()) === $n){
            echo "Se encontro al pasajero con " . "\n". "Nombre: " . $persona->getNombre() . "\n". " Apellido: " . $persona->getApellido() ."\n". "Nro de vuelo: ".$persona->getVuelo()."\n";
        }
        
    }
}

/**
 * Summary of modificarPasajero
 * @param array $listaPasajeros
 * @param int $n
 * @return void
 */
function modificarPasajero($listaPasajeros, $n){

    for ($i = 0; $i < count($listaPasajeros); $i++){
        
        $persona=$listaPasajeros[$i];
        if (trim($persona->getDni()) === $n){
          
            echo "Indique el nombre del pasajero: ";
            $nombre = trim(fgets(STDIN));
            $persona->setNombre($nombre);

            echo "Indique el apellido del pasajero: ";
            $apellido = trim(fgets(STDIN));
            $persona->setApellido($apellido);

            echo "Indique el teléfono del pasajero: ";
            $telefono = fgets(STDIN);
            $persona->setTelefono($telefono);  
        }
        
    }
}

/**
 * Summary of listarPasajeros
 * @param array $colPasajeros
 * @return void
 */
function listarPasajeros($colPasajeros){
    for ($i = 0; $i < count($colPasajeros); $i++){
        $persona=$colPasajeros[$i];
        echo "Datos Pasajero: " ."\n". "Nombre: " . $persona->getNombre() . "\n"." Apellido: " . $persona->getApellido()."\n";
    }
   
}

?>