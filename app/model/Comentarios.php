<?php


class Comentarios
{

    public $id;
    public $fecha;
    public $idTema;
    public $dni;
    public $texto;

    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findAll()
    {
        $query = 'SELECT id, fecha, idTema, dni, texto
                                FROM ' . strtolower(__CLASS__) . '
                                ORDER BY
                                fecha  ASC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function findOne()
    {
        $query = "SELECT id, fecha, idTema, dni, texto
                                FROM " . strtolower(__CLASS__) . "
                                WHERE
                                      id = :id
                                      LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->dni = $row['id'];
        $this->dni = $row['fecha'];
        $this->titulo = $row['idTema'];
        $this->fecha = $row['dni'];
        $this->texto = $row['texto'];
    }

    public function insert()
    {
        $query = 'INSERT INTO ' . strtolower(__CLASS__) .
            '(fecha, idTema, dni, texto) 
                                                    VALUES 
                                                        (
                                                        :fecha, 
                                                        :idTema, 
                                                        :dni, 
                                                        :texto
                                                        )';

        $stmt = $this->conn->prepare($query);

        $this->fecha = htmlspecialchars(strip_tags($this->fecha));
        $this->idTema = htmlspecialchars(strip_tags($this->idTema));
        $this->dni = htmlspecialchars(strip_tags($this->dni));
        $this->texto = htmlspecialchars(StringUtils::strip_html_script($this->texto));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':idTema', $this->idTema);
        $stmt->bindParam(':dni', $this->dni);
        $stmt->bindParam(':texto', $this->texto);

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
                                                id = :id, 
                                                fecha = :fecha, 
                                                idTema = :idTema, 
                                                dni = :dni, 
                                                texto = :texto
                                            WHERE 
                                                id = :id';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->fecha = htmlspecialchars(strip_tags($this->fecha));
        $this->idTema = htmlspecialchars(strip_tags($this->idTema));
        $this->dni = htmlspecialchars(strip_tags($this->dni));
        $this->texto = htmlspecialchars(StringUtils::strip_html_script($this->texto));


        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':idTema', $this->idTema);
        $stmt->bindParam(':dni', $this->dni);
        $stmt->bindParam(':texto', $this->texto);

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
}