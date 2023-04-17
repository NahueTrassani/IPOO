<?php
class ResponsableV {
    private $numEmpleado;
    private $numLicencia;
    private $nombre;
    private $apellido;
    
    public function __construct(){
        $this->numEmpleado = "";
        $this->numLicencia = "";
        $this->nombre = "";
        $this->apellido = "";
    }

    public function __toString() {
        return "\n"."Responsable: " . $this->apellido . ", " . $this->nombre ."\n"."Numero de empleado: " . $this->numEmpleado."Numero de licencia: " . $this->numLicencia."\n";
    }
    
    public function cargarResponsable($nombre, $apellido, $numEmpleado, $numLicencia){		
		$this->setNombre($nombre);
		$this->setApellido($apellido);
        $this->setNumEmpleado($numEmpleado);
		$this->setNumLicencia($numLicencia);
    }
    public function getNumEmpleado() {
        return $this->numEmpleado;
    }
    
    public function getNumLicencia() {
        return $this->numLicencia;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getApellido() {
        return $this->apellido;
    }
    
    public function setNumEmpleado($numEmpleado) {
        $this->numEmpleado = $numEmpleado;
    }
    
    public function setNumLicencia($numLicencia) {
        $this->numLicencia = $numLicencia;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }
}

?>