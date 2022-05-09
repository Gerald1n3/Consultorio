<?php
//Codificar los métodos y las clases necesarios para gestión y control de un consulturio odontológico tenga en cuenta que existen citas que se deben
// reprogramar, cancelar, cambio de médico; es necesario contar con la posible actualización constante de los datos por parte de los pacientes.
// El modelo debe permitir imprimir la información de los medicos, de los pacientes, como también el detalle de una cita odontologica.
//Extraer los atributos necesarios para cada clase junto con sus métodos que cumplan con los requerimientos anteriormente mencionados. 

require 'Database.php';

class Consultorio
{
    private  $codigoCita;
    private  $nombrePaciente;
    private  $nombreOdonto;
    private  $fecha;
    private $conexionBaseDatos;

    public function __construct( $codigoCita=0,  $nombrePaciente='', $nombreOdonto='',$fecha='')
    {
        $this->codigoCita=$codigoCita;
        $this->nombrePaciente=$nombrePaciente;
        $this->nombreOdonto=$nombreOdonto;
        $this->fecha=$fecha;

        $database= new Database();
        $this->conexionBaseDatos=$database->conexion;
    }
        public function setCodigoCita( $codigoCita)
        {
            $this->codigoCita=$codigoCita;
        }
        public function getCodigoCita()
        {
            return $this->codigoCita;
        }
        public function setNombrePaciente( $nombrePaciente)
        {
            $this->nombrePaciente=$nombrePaciente;
        }
        public function getNombrePaciente()
        {
            return $this->nombrePaciente;
        }
        public function setNombreOdonto( $nombreOdonto)
        {
            $this->nombreOdonto=$nombreOdonto;
        }
        public function getNombreOdonto()
        {
            return $this->nombreOdonto;
        }
        public function setFecha( $fecha)
        {
            $this->fecha=$fecha;
        }
        public function getFecha()
        {
            return $this->Fecha;
        }

        public function Detalle()
        {
            echo "Nro. Cita: ".$this->codigoCita. "<br>";
            echo "Nombre completo del paciente: ".$this->nombrePaciente. "<br>";
            echo "Nombre completo del odontologo:  ".$this->nombreOdonto. "<br>";
            echo "Fecha asignada:  ".$this->fecha. "<br>", "<br>";
        }
        public function save()
        {
            try {
                $query="INSERT INTO citas (codigoCita,nombrePaciente,nombreOdonto,fecha) VALUES (:codigoCita, :nombrePaciente, :nombreOdonto,:fecha)";
                $values=[
                    ":codigoCita"=> $this->codigoCita,
                    ":nombrePaciente"=> $this->nombrePaciente,
                    ":nombreOdonto"=> $this->nombreOdonto,
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
                $query="SELECT * FROM citas where codigoCita=$id";
                $citas=[];
                $sql=$this->conexionBaseDatos->query($query, PDO:: FETCH_ASSOC);
                foreach($sql as $citas){
                    $consultorio =new Consultorio();
                    echo $consultorio->codigoCita=$citas['codigoCita']."<br>";
                    echo $consultorio->nombrePaciente=$citas['nombrePaciente']."<br>";
                    echo $consultorio->nombreOdonto=$citas['nombreOdonto']."<br>";
                    echo $consultorio->fecha=$citas['fecha']."<br>";

                    array_push($citas,$consultorio);
    
                }
                return $citas;
            } catch (PDOException $error) {
                echo "Error al buscar productos: ";
            }
        }
        public function listar()
        {
            try {
                $query="SELECT * FROM citas ";
                $citas=[];
                $sql=$this->conexionBaseDatos->query($query, PDO:: FETCH_ASSOC);
                foreach($sql as $citas){
                    $consultorio =new Consultorio();
                    echo $consultorio->codigoCita=$citas['codigoCita']."<br>";
                    echo $consultorio->nombrePaciente=$citas['nombrePaciente']."<br>";
                    echo $consultorio->nombreOdonto=$citas['nombreOdonto']."<br>";
                    echo $consultorio->fecha=$citas['fecha']."<br>";

                    array_push($citas,$consultorio);
    
                }
                return $citas;
            } catch (PDOException $error) {
                echo "Error al listar citas ";
            } 
        }
        public function cancelar($id)
        {
            try {
                $query="DELETE  FROM citas where codigoCita=$id";

                $consulta=$this->conexionBaseDatos->prepare($query);
                $consulta->execute();
                echo "Cita cancelada de manera exitosa <br>";

            } catch (PDOException $error) {
             die("Error al cancelar cita".$error);
            }

        }
        public function modificar($id,$nombrePaciente,$nombreOdonto,$fecha)
        {
            try {
                $query="UPDATE citas SET nombrePaciente='$nombrePaciente',nombreOdonto='$nombreOdonto',fecha='$fecha' where codigoCita='$id'";
               
                $sql=$this->conexionBaseDatos->query($query);
               if ($sql){
                   echo "Se reprogramó correctamente";
               }
               else{
                   echo "Error al reprogramarrrr";
               }
            } catch (PDOException $error) {
                echo "Error al reprogamar: ".$error->getMessage();
            } 
               
        }
    }