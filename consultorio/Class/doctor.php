<?php
//Codificar los métodos y las clases necesarios para gestión y control de un consulturio odontológico tenga en cuenta que existen doctores que se deben
// reprogramar, cancelar, cambio de médico; es necesario contar con la posible actualización constante de los datos por parte de los pacientes.
// El modelo debe permitir imprimir la información de los medicos, de los pacientes, como también el detalle de una cita odontologica.
//Extraer los atributos necesarios para cada clase junto con sus métodos que cumplan con los requerimientos anteriormente mencionados. 

require 'Database.php';

class Doctor
{
    private  $identificacion;
    private  $nombre;
    private  $horas;
    private  $especializacion;

    public function __construct( $identificacion=0,  $nombre='', $horas=0 ,$especializacion='')
    {
        $this->identificacion=$identificacion;
        $this->nombre=$nombre;
        $this->horas=$horas;
        $this->especializacion=$especializacion;

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
        public function setHoras( $horas)
        {
            $this->horas=$horas;
        }
        public function gethoras()
        {
            return $this->horas;
        }
        public function setEspecializacion( $especializacion)
        {
            $this->especializacion=$especializacion;
        }
        public function getEspecializacion()
        {
            return $this->especializacion;
        }

        public function Detalle()
        {
            echo "Identificación profesional: ".$this->identificacion. "<br>";
            echo "Nombre completo: ".$this->nombre. "<br>";
            echo "Horas laboradas:  ".$this->horas. "<br>";
            echo "Especialista en:  ".$this->especializacion. "<br>", "<br>";
        }
        public function save()
        {
            try {
                $query="INSERT INTO doctores (identificacion,nombre,horas,especializacion) VALUES (:identificacion, :nombre, :horas,:especializacion)";
                $values=[
                    ":identificacion"=> $this->identificacion,
                    ":nombre"=> $this->nombre,
                    ":horas"=> $this->horas,
                    ":especializacion"=> $this->especializacion,
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
                $query="SELECT * FROM doctores where identificacion=$id";
                $doctores=[];
                $sql=$this->conexionBaseDatos->query($query, PDO:: FETCH_ASSOC);
                foreach($sql as $doctores){
                    $doctor =new Doctor();
                    echo $doctor->identificacion=$doctores['identificacion']."<br>";
                    echo $doctor->nombre=$doctores['nombre']."<br>";
                    echo $doctor->horas=$doctores['horas']."<br>";
                    echo $doctor->especializacion=$doctores['especializacion']."<br>";

                    array_push($doctores,$doctor);
    
                }
                return $doctores;
            } catch (PDOException $error) {
                echo "Error al buscar doctores: ";
            }
        }
        public function listar()
        {
            try {
                $query="SELECT * FROM doctores ";
                $doctores=[];
                $sql=$this->conexionBaseDatos->query($query, PDO:: FETCH_ASSOC);
                foreach($sql as $doctores){
                    $doctor =new Doctor();
                    echo $doctor->identificacion=$doctores['identificacion']."<br>";
                    echo $doctor->nombre=$doctores['nombre']."<br>";
                    echo $doctor->horas=$doctores['horas']."<br>";
                    echo $doctor->especializacion=$doctores['especializacion']."<br>";

                    array_push($doctores,$doctor);
    
                }
                return $doctores;
            } catch (PDOException $error) {
                echo "Error al listar doctores ";
            } 
        }
        public function eliminar($id)
        {
            try {
                $query="DELETE  FROM doctores where identificacion=$id";

                $consulta=$this->conexionBaseDatos->prepare($query);
                $consulta->execute();
                echo "Eliminado de manera exitosa";

            } catch (PDOException $error) {
             die("Error al eliminar doctor".$error);
            }

        }
        public function modificar($id,$nombre,$horas,$especializacion)
        {
            try {
                $query="UPDATE doctores SET nombre='$nombre',horas='$horas',especializacion='$especializacion' where identificacion='$id'";
               
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