<?php
// models/Alumno.php
class Alumno
{
    private $conn;
    private $table_name = "alumnos";

    public $numAlumno;
    public $nombre;
    public $apellidos;
    public $fechaNacimiento;
    public $repite;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para leer todos los alumnos
    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY numAlumno ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para crear un alumno
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, apellidos=:apellidos, fechaNacimiento=:fechaNacimiento, repite=:repite";
        $stmt = $this->conn->prepare($query);

        // Limpiar y enlazar parámetros
        $this->nombre = $this->nombre;
        $this->apellidos = $this->apellidos;
        // ... validaciones si fueran necesarias

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellidos", $this->apellidos);
        $stmt->bindParam(":fechaNacimiento", $this->fechaNacimiento);
        $stmt->bindParam(":repite", $this->repite, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para leer un solo alumno (para editar)
    public function readOne()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE numAlumno = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->numAlumno);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nombre = $row['nombre'];
            $this->apellidos = $row['apellidos'];
            $this->fechaNacimiento = $row['fechaNacimiento'];
            $this->repite = $row['repite'];
        }
    }

    // Método para actualizar un alumno
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET nombre=:nombre, apellidos=:apellidos, fechaNacimiento=:fechaNacimiento, repite=:repite WHERE numAlumno=:numAlumno";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':fechaNacimiento', $this->fechaNacimiento);
        $stmt->bindParam(':repite', $this->repite, PDO::PARAM_INT);
        $stmt->bindParam(':numAlumno', $this->numAlumno, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar un alumno
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE numAlumno = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->numAlumno, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}