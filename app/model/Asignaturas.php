<?php


class Asignaturas
{

    public $id;
    public $idCurso;
    public $nombre;
    public $dniProfesor;
    public $texto;
    public $archivo;


    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findAll()
    {
        $query = 'SELECT id, idCurso, nombre, dniProfesor, texto, archivo
                                FROM ' . strtolower(__CLASS__) . '
                                ORDER BY
                                nombre  ASC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function findByIdCurso()
    {
        $query = 'SELECT id, idCurso, nombre, dniProfesor, texto, archivo
                                FROM ' . strtolower(__CLASS__) . '
                                WHERE
                                idCurso = :idCurso
                                ORDER BY
                                nombre  ASC';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':idCurso', $this->idCurso, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    public function findOne()
    {
        $query = "SELECT id, dni, titulo, fecha, texto, archivo, imagen
                                FROM " . strtolower(__CLASS__) . "
                                WHERE
                                      id = :id
                                      LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->dni = $row['dni'];
        $this->titulo = $row['titulo'];
        $this->fecha = $row['fecha'];
        $this->texto = $row['texto'];
        $this->archivo = $row['archivo'];
        $this->archivo = $row['imagen'];
    }

    public function insert()
    {
        $query = 'INSERT INTO ' . strtolower(__CLASS__) .
            '(idCurso, nombre, dniProfesor, texto, archivo) 
                                                    VALUES 
                                                        (
                                                        :idCurso, 
                                                        :nombre, 
                                                        :dniProfesor, 
                                                        :texto, 
                                                        :archivo
                                                        )';

        $stmt = $this->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($this->idCurso));
        $this->fecha = htmlspecialchars(strip_tags($this->nombre));
        $this->fecha = htmlspecialchars(strip_tags($this->dniProfesor));
        $this->texto = htmlspecialchars(StringUtils::strip_html_script($this->texto));
        $this->archivo = htmlspecialchars(strip_tags($this->archivo));

        $stmt->bindParam(':idCurso', $this->idCurso);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':dniProfesor', $this->dniProfesor);
        $stmt->bindParam(':texto', $this->texto);
        $stmt->bindParam(':archivo', $this->archivo);

        if ($stmt->execute()) {
            return true;
        }

        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' . strtolower(__CLASS__) . '
                                            SET
                                                idCurso = :idCurso, 
                                                nombre = :nombre, 
                                                dniProfesor = :dniProfesor, 
                                                texto = :texto, 
                                                archivo = :archivo
                                            WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':idCurso', $this->idCurso);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':dniProfesor', $this->dniProfesor);
        $stmt->bindParam(':texto', $this->texto);
        $stmt->bindParam(':archivo', $this->archivo);

        if ($stmt->execute()) {
            return true;
        }

        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }

    public function delete()
    {
        $query = 'DELETE FROM ' . strtolower(__CLASS__) . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }

    public function exists()
    {
        $query = "SELECT id 
                                FROM " . strtolower(__CLASS__) . "
                                WHERE
                                    idCurso = :idCurso
                                    AND 
                                    nombre = :nombre
                                    LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':idCurso', $this->idCurso);
        $stmt->bindParam(':nombre', $this->nombre);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
}