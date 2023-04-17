<?php

include "Viaje.php";
include "Persona.php";
include "ResponsableV.php";

$listaViajes = array();
$listaPasajeros = array();

$opcion = 0;
//do{
    menu($opcion,$listaViajes,$listaPasajeros);
//}while($opcion<>0);
//menú
function menu($opcion,$listaViajes,$listaPasajeros){
    echo "¡Bienvenido/a!"."\n";
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
                    echo "Datos del viaje: "  ."\n". "Destino--> " . $viaje->getDestino() ."\n". "Cantidad máxima de pasajeros--> " . $viaje->getCantMaxPasajeros(). "Cantidad total de pasajeros--> " .$viaje->getCantPasajeros()."\n"."-----------"."\n"."Responsable del vuelo--> ".$viaje->getResponsable()."\n";
                    $personas = $viaje->getPasajeros();
                    for($i = 0; $i < count($personas); $i++){
                        $pers = $personas[$i];
                        //el vuelo tiene pasajeros, muestra datos del vuelo y pasajeros.
                        echo "Datos de pasajeros: "  ."\n". "Apellido y nombre--> " . $pers->getApellido() . ", " .$pers->getNombre() . "\n" . "Nro de Tel--> " . $pers->getTelefono() . "\n";
                    }
                }else{
                    //el vuelo no tiene pasajeros, solo muestra datos del vuelo
                    echo "Datos viaje: "  ."\n". "Destino--> " . $viaje->getDestino() ."\n". "Cantidad máxima de pasajeros--> " . $viaje->getCantMaxPasajeros(). "Cantidad total de pasajeros--> ".$viaje->getCantPasajeros()."\n"."-----------"."\n"."Responsable del vuelo--> ".$viaje->getResponsable()."\n";
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
                 //si encontro el vuelo debe revisar que el pasajero no exista aun-.
                 $pasajerosVuelo = $vuelo->getPasajeros();
                 if (!empty($pasajerosVuelo)) {
                    //si encontró pasajeros busca el indicado
                    echo "Ingrese el dni del pasajero que desea cargar: "."\n";
                    $n = trim(fgets(STDIN));
                    $condicion = validarPasajeroEnViaje($pasajerosVuelo, $n);
                    //si lo encuentra no lo puede volver a cargar
                    if ($condicion){
                        echo "El pasajero ya se encuentra cargado en el vuelo"."\n";
                    }else{
                        //si encontró el vuelo y el pasajero no se encuentra en el, lo carga
                        $pasajero=agregarPasajero($n,$listaViajes,$nroVuelo);
                        //agrega el pasajero a la coleccion de pasajeros 
                        array_push($listaPasajeros,$pasajero);
                        //y a la coleccion de pasajeros en un vuelo.
                        $vuelo->cargarPasajeroVuelo($pasajero);
                        $vuelo->cuentaCantPasajeros(1);
                    }
                 }else{
                    //si encontró el vuelo y aun no tiene pasajeros, carga
                    $pasajero=agregarPasajero(0,$listaViajes,$nroVuelo);
                    //agrega el pasajero a la coleccion de pasajeros 
                    array_push($listaPasajeros,$pasajero);
                    //y a la coleccion de pasajeros en un vuelo.
                    $vuelo->cargarPasajeroVuelo($pasajero);
                    $vuelo->cuentaCantPasajeros(1);
                 }
            
            }else{
                echo "No se encontro el vuelo"."\n";
            } 
            menu($opcion,$listaViajes,$listaPasajeros);
             //vuelve a llamar al menu con las colecciones.
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

    echo "Ingrese los datos del responsable del vuelo: "."\n";

    echo "Nombre"."\n";
    $nombre = trim(fgets(STDIN));

    echo "Apellido: "."\n";
    $apellido = trim(fgets(STDIN));

    echo "numEmpleado: "."\n";
    $numEmpleado = fgets(STDIN);

    echo "numLicencia"."\n";
    $numLicencia = fgets(STDIN);
    
    $responsable = new ResponsableV();
    $responsable->cargarResponsable($nombre, $apellido, $numEmpleado, $numLicencia);
    
    //invoca al metodo insert de la clase viaje con los parametros indicados anteriormente.
    $viaje->cargarViaje($id,$destino,$cantMax);
    $viaje->setResponsable($responsable);

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
function agregarPasajero($n,$listaViajes, $nroVuelo){
    //crea instancia de clase viaje
    $persona1 = new Persona();
    //setea los datos del vuelo
    if(empty($n)){
        echo "Indique el Dni del pasajero (numérico): ";
        $dni = fgets(STDIN);
    }else{
        $dni = $n;
    }
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
 * Summary of validarPasajeroEnViaje
 * @param array $listaPasajeros
 * @param int $n
 * @return boolean
 */
function validarPasajeroEnViaje($listaPasajeros, $n){
    $condicion = false;
    for ($i = 0; $i < count($listaPasajeros); $i++){
        
        $persona=$listaPasajeros[$i];
        if (trim($persona->getDni()) === $n){
            //echo "Se encontro al pasajero con " . "\n". "Nombre: " . $persona->getNombre() . "\n". " Apellido: " . $persona->getApellido() ."\n". "Nro de vuelo: ".$persona->getVuelo()."\n";
            $condicion = true;
        }
        
    }
    return $condicion;
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