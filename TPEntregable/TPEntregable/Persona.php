<?php

class Persona{
    private $dni;
    private $nombre;
    private $apellido;
    private $telefono;
    private $nroVuelo;

    
    
    //
    //GETTERS
    // 


    
     //recupera dni
     public function __toString() {
      return "{$this->dni}{$this->nombre}{$this->apellido}";
     }
     public function getVuelo(){
      return $this->nroVuelo;
  }
    public function getDni(){
      return $this->dni;
  }

   // recupera nombre
  
  public function getNombre(){
      return $this->nombre;
  }

 
   // recupera apellido
  
  public function getApellido(){
      return $this->apellido;
  }

  
  // recupera telefono
  
  public function getTelefono(){
      return $this->telefono;
  }



  //
  //SETTERS
  // 

    //Establece el valor de documento

    public function setDni($dni){
      $this->dni = $dni;
  }

  public function setVuelo($nroVuelo){
    $this->nroVuelo = $nroVuelo;
}
  // Establece el valor de nombre

  public function setNombre($nombre){
      $this->nombre = $nombre;
  }

// Establece el valor de apellido
 
public function setApellido($apellido){
  $this->apellido = $apellido;
}

   // Establece el valor de telefono

  public function setTelefono($telefono){
      $this->telefono = $telefono;
  }

  public function __construct(){
    $this->dni = "";
    $this->nombre = "";
    $this->apellido = "";
    $this->telefono = "";
    $this->nroVuelo = "";
  }
   // declara variables tipo parametro-.
	 // @param string $nombre
 	 // @param string $apellido
	 // @param int $documento
	 // @param int $telefono

  //cargar persona
  public function cargarPersona($dni, $nombre, $apellido, $telefono, $nroVuelo){		
		$this->setDni($dni);
		$this->setNombre($nombre);
		$this->setApellido($apellido);
		$this->setTelefono($telefono);
		$this->setVuelo($nroVuelo);
  }

}

?>