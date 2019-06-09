<?php


class Entregas
{

    public $id;
    public $dni;
    public $idEjercicio;
    public $fecha;
    public $nota;
    public $comentarioProf;
    public $archivo;

    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findAll()
    {
        $query = 'SELECT id, dni, idEjercicio, fecha, nota, comentarioProf, archivo
                                FROM ' . strtolower(__CLASS__) . '
                                ORDER BY
                                fecha  ASC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function findOne()
    {
        $query = "SELECT id, dni, idEjercicio, fecha, nota, comentarioProf, archivo
                                FROM " . strtolower(__CLASS__) . "
                                WHERE
                                      id = :id
                                      LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->dni = $row['dni'];
        $this->titulo = $row['idEjercicio'];
        $this->titulo = $row['fecha'];
        $this->fecha = $row['nota'];
        $this->texto = $row['comentarioProf'];
        $this->archivo = $row['archivo'];
    }

    public function insert()
    {
        $query = 'INSERT INTO ' . strtolower(__CLASS__) .
            '(dni, titulo, fecha, texto, archivo, imagen) 
                                                    VALUES 
                                                        (:dni, 
                                                        :idEjercicio, 
                                                        :fecha, 
                                                        :nota, 
                                                        :comentarioProf, 
                                                        :archivo)';

        $stmt = $this->conn->prepare($query);

        $this->dni = $row['dni'];
        $this->titulo = $row['idEjercicio'];
        $this->titulo = $row['fecha'];
        $this->fecha = $row['nota'];
        $this->texto = $row['comentarioProf'];
        $this->archivo = $row['archivo'];



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
                                                dni = :dni, 
                                                idEjercicio = :idEjercicio, 
                                                fecha = :fecha, 
                                                nota = :nota, 
                                                comentarioProf = :comentarioProf, 
                                                archivo = :archivo, 
                                            WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->dni = htmlspecialchars(strip_tags($this->dni));
        $this->idEjercicio = htmlspecialchars(strip_tags($this->idEjercicio));
        $this->fecha = htmlspecialchars(strip_tags($this->fecha));
        $this->nota = htmlspecialchars(strip_tags($this->nota));
        $this->comentarioProf = htmlspecialchars(StringUtils::strip_html_script($this->comentarioProf));
        $this->archivo = htmlspecialchars(strip_tags($this->archivo));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':dni', $this->dni);
        $stmt->bindParam(':idEjercicio', $this->idEjercicio);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':nota', $this->nota);
        $stmt->bindParam(':comentarioProf', $this->comentarioProf);
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
                                      dni = :dni
                                      AND
                                      idEjercicio = :idEjercicio
                                      LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':dni', $this->dni);
        $stmt->bindParam(':idEjercicio', $this->idEjercicio);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
}