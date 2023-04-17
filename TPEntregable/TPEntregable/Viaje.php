<?php

class Viaje{
    /**
     * Variables instancia de la clase Viaje
     * int $id
     * string $destino
     * int $cantMaxPasajeros
   
     */
    private $id;
    private $destino;
    private $cantMax;
    private $cantPasajeros;
    private $pasajeros = array();
    private $responsable;
    
    //...
    
    public function setResponsable($responsable) {
        $this->responsable = $responsable;
    }
    
    public function getResponsable() {
        return $this->responsable;
    }
    
    //
    //GETTERS
    // 

    public function __toString() {
        return "{$this->id}{$this->destino}{$this->cantMax}";
    }
    // Obtiene el valor de cantMaxPasajeros
      
    public function getCantMaxPasajeros(){
        return $this->cantMax;
    }
    public function getCantPasajeros(){
        return $this->cantPasajeros;
    }
    //Obtiene el valor de destino
    public function getDestino(){
        return $this->destino;
    }

     //Obtiene el valor de idViaje
    public function getIdViaje() {
        return $this->id;
    }


    public function cuentaCantPasajeros($cantPasajeros){
        $this->cantPasajeros += $cantPasajeros;
    }

    public function getPasajeros() {
        return $this->pasajeros;
    }

    //
    //SETTERS
    //


    //Establece el valor de id
   
    public function setIdViaje($id){
        $this->id = $id;
    }

    //Establece el destino
    public function setDestino($destino){
        $this->destino = $destino;
    }

     //Establece el valor de cantMaxPasajeros
    public function setCantMaxPasajeros($cantMax){
        $this->cantMax = $cantMax;
    }

    //inicializar Instancia de clase.-
    // @param int $id
 	// @param string $destino
	// @param int $cantMax
    
    public function __construct(){
        $this->id = "";
        $this->destino = "";
        $this->cantMax = "";
        $this->cantPasajeros = 0;
        $this->responsable = "";
    }

	 // declara variables tipo parametro-.
	 // @param int $id
 	 // @param string $destino
	 // @param int $cantMax
	
    public function cargarViaje($id, $destino, $cantMax) {
            $this->setIdViaje($id);
            $this->setDestino($destino);
            $this->setCantMaxPasajeros($cantMax);
          
    }
    public function cargarPasajeroVuelo($persona) {
        array_push($this->pasajeros, $persona);
      }
}
?>