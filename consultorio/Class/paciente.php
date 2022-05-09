<?php
//Codificar los métodos y las clases necesarios para gestión y control de un consulturio odontológico tenga en cuenta que existen pacientes que se deben
// reprogramar, cancelar, cambio de médico; es necesario contar con la posible actualización constante de los datos por parte de los pacientes.
// El modelo debe permitir imprimir la información de los medicos, de los pacientes, como también el detalle de una cita odontologica.
//Extraer los atributos necesarios para cada clase junto con sus métodos que cumplan con los requerimientos anteriormente mencionados. 

require 'Database.php';

class paciente
{
    private  $identificacion;
    private  $nombre;
    private  $edad;
    private  $fecha;

    public function __construct( $identificacion=0,  $nombre='', $edad=0 ,$fecha='')
    {
        $this->identificacion=$identificacion;
        $this->nombre=$nombre;
        $this->edad=$edad;
        $this->fecha=$fecha;

        $database= new Database();
        $this->conexionBaseDatos=$database->conexion;
    }
        public function setIdentificacion( $identificacion)
        {
            $this->identificacion=$identificacion;
        }
        public function getidentificacion()
        {
            return $this->identificacion;
        }
        public function setNombre( $nombre)
        {
            $this->nombre=$nombre;
        }
        public function getNombre()
        {
            return $this->nombre;
        }
        public function setEdad( $edad)
        {
            $this->edad=$edad;
        }
        public function getEdad()
        {
            return $this->edad;
        }
        public function setFecha($fecha)
        {
            $this->fecha=$fecha;
        }
        public function getfecha()
        {
            return $this->fecha;
        }

        public function Detalle()
        {
            echo "Identificación del paciente: ".$this->identificacion. "<br>";
            echo "Nombre completo: ".$this->nombre. "<br>";
            echo "Edad:  ".$this->edad. "<br>";
            echo "Fecha:  ".$this->fecha. "<br>", "<br>";
        }
        public function save()
        {
            try {
                $query="INSERT INTO pacientes (identificacion,nombre,edad,fecha) VALUES (:identificacion, :nombre, :edad,:fecha)";
                $values=[
                    ":identificacion"=> $this->identificacion,
                    ":nombre"=> $this->nombre,
                    ":edad"=> $this->edad,
                    ":fecha"=> $this->fecha,
                ];
                
                $consulta=$this->conexionBaseDatos->prepare($query);
                $consulta->execute($values);
                echo "Guardado de forma exitosa <br>";

            } catch (PDOException $error) {
             die("Error al guardar".$error);
            }
        }
        public function buscar($id)
        {
            try {
                $query="SELECT * FROM pacientes where identificacion=$id";
                $pacientes=[];
                $sql=$this->conexionBaseDatos->query($query, PDO:: FETCH_ASSOC);
                foreach($sql as $pacientes){
                    $paciente =new paciente();
                    echo $paciente->identificacion=$pacientes['identificacion']."<br>";
                    echo $paciente->nombre=$pacientes['nombre']."<br>";
                    echo $paciente->edad=$pacientes['edad']."<br>";
                    echo $paciente->fecha=$pacientes['fecha']."<br>";

                    array_push($pacientes,$paciente);
    
                }
                return $pacientes;
            } catch (PDOException $error) {
                echo "Error al buscar pacientes: ";
            }
        }
        public function listar()
        {
            try {
                $query="SELECT * FROM pacientes ";
                $pacientes=[];
                $sql=$this->conexionBaseDatos->query($query, PDO:: FETCH_ASSOC);
                foreach($sql as $pacientes){
                    $paciente =new paciente();
                    echo $paciente->identificacion=$pacientes['identificacion']."<br>";
                    echo $paciente->nombre=$pacientes['nombre']."<br>";
                    echo $paciente->edad=$pacientes['edad']."<br>";
                    echo $paciente->fecha=$pacientes['fecha']."<br>";

                    array_push($pacientes,$paciente);
    
                }
                return $pacientes;
            } catch (PDOException $error) {
                echo "Error al listar pacientes ";
            } 
        }
        public function eliminar($id)
        {
            try {
                $query="DELETE  FROM pacientes where identificacion=$id";

                $consulta=$this->conexionBaseDatos->prepare($query);
                $consulta->execute();
                echo "Eliminado de manera exitosa";

            } catch (PDOException $error) {
             die("Error al eliminar paciente".$error);
            }

        }
        public function modificar($id,$nombre,$edad,$fecha)
        {
            try {
                $query="UPDATE pacientes SET nombre='$nombre',edad='$edad',fecha='$fecha' where identificacion='$id'";
               
                $sql=$this->conexionBaseDatos->query($query);
               if ($sql){
                   echo "Se modificó correctamente";
               }
               else{
                   echo "Error al modificar";
               }
            } catch (PDOException $error) {
                echo "Error al modificar: ".$error->getMessage();
            } 
               
        }
    }