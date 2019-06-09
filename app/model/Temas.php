<?php


class Temas
{

    public $id;
    public $idAsignatura;
    public $nombre;
    public $texto;
    public $archivo;

    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findAll()
    {
        $query = 'SELECT id, idAsignatura, nombre, texto, archivo
                                FROM ' . strtolower(__CLASS__) . '
                                ORDER BY
                                nombre  ASC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function findOne()
    {
        $query = "SELECT idAsignatura, nombre, texto, archivo
                                FROM " . strtolower(__CLASS__) . "
                                WHERE
                                      id = :id
                                      LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->idAsignatura = $row['idAsignatura'];
        $this->nombre = $row['nombre'];
        $this->texto = $row['texto'];
        $this->archivo = $row['archivo'];
    }

    public function insert()
    {
        $query = 'INSERT INTO ' . strtolower(__CLASS__) .
            '(idAsignatura, nombre, texto, archivo) 
                                                    VALUES 
                                                        (
                                                        :idAsignatura, 
                                                        :nombre, 
                                                        :texto, 
                                                        :archivo, 
                                                        )';

        $stmt = $this->conn->prepare($query);

        $this->idAsignatura = htmlspecialchars(strip_tags($this->idAsignatura));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->texto = htmlspecialchars(StringUtils::strip_html_script($this->texto));
        $this->archivo = htmlspecialchars(strip_tags($this->archivo));

        $stmt->bindParam(':idAsignatura', $this->idAsignatura);
        $stmt->bindParam(':nombre', $this->nombre);
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
                                                dni = :idAsignatura, 
                                                titulo = :nombre, 
                                                fecha = :texto, 
                                                texto = :archivo, 
                                            WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->idAsignatura = htmlspecialchars(strip_tags($this->idAsignatura));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->texto = htmlspecialchars(StringUtils::strip_html_script($this->texto));
        $this->archivo = htmlspecialchars(strip_tags($this->archivo));


        $stmt->bindParam(':idAsignatura', $this->idAsignatura);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':texto', $this->texto);
        $stmt->bindParam(':archivo', $this->archivo);;

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