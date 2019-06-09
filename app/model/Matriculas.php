<?php


class Matriculas
{

    public $id;
    public $idAsignatura;
    public $dni;
    public $estado;

    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findAll()
    {
        $query = 'SELECT id, idAsignatura, dni, estado
                                FROM ' . strtolower(__CLASS__) . '
                                ORDER BY
                                dni  ASC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function findByDni()
    {
        $query = 'SELECT id, idAsignatura, dni, estado
                                FROM ' . strtolower(__CLASS__) . '
                                WHERE 
                                    estado > 1
                                    dni = :dni
                                ORDER BY
                                dni  ASC';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':dni', $this->dni);

        $stmt->execute();

        return $stmt;
    }

    public function findAllActive()
    {
        $query = 'SELECT id, idAsignatura, dni, estado
                                FROM ' . strtolower(__CLASS__) . '
                                WHERE estado > 1
                                ORDER BY
                                dni  ASC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function findOne()
    {
        $query = "SELECT id, idAsignatura, dni, estado
                                FROM " . strtolower(__CLASS__) . "
                                WHERE
                                      id = :id
                                      LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->dni = $row['id'];
        $this->titulo = $row['idAsignatura'];
        $this->fecha = $row['dni'];
        $this->texto = $row['estado'];
    }

    public function insert()
    {
        $query = 'INSERT INTO ' . strtolower(__CLASS__) .
            '(idAsignatura, dni, estado) 
                                                    VALUES 
                                                        (
                                                        :idAsignatura, 
                                                        :dni, 
                                                        :estado
                                                        )';

        $stmt = $this->conn->prepare($query);

        $this->idAsignatura = htmlspecialchars(strip_tags($this->idAsignatura));
        $this->dni = htmlspecialchars(strip_tags($this->dni));
        $this->estado = htmlspecialchars(strip_tags($this->estado));


        $stmt->bindParam(':idAsignatura', $this->idAsignatura);
        $stmt->bindParam(':dni', $this->dni);
        $stmt->bindParam(':estado', $this->estado);

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
                                                idAsignatura = :idAsignatura, 
                                                dni = :dni, 
                                                estado = :estado
                                            WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->idAsignatura = htmlspecialchars(strip_tags($this->idAsignatura));
        $this->dni = htmlspecialchars(strip_tags($this->dni));
        $this->estado = htmlspecialchars(strip_tags($this->estado));


        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':idAsignatura', $this->idAsignatura);
        $stmt->bindParam(':dni', $this->dni);
        $stmt->bindParam(':estado', $this->estado);

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
                                      nombre = :nombre
                                      AND
                                      idAsignatura = :idAsignatura
                                      LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':idAsignatura', $this->idAsignatura);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
}