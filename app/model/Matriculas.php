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
                                                        (:idAsignatura, 
                                                        :dni, 
                                                        :estado)';

        $stmt = $this->conn->prepare($query);

        $this->dni = htmlspecialchars(strip_tags($this->dni));
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->fecha = htmlspecialchars(strip_tags($this->fecha));
        $this->texto = htmlspecialchars(StringUtils::strip_html_script($this->texto));
        $this->archivo = htmlspecialchars(strip_tags($this->archivo));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));


        $stmt->bindParam(':dni', $this->dni);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':texto', $this->texto);
        $stmt->bindParam(':archivo', $this->archivo);
        $stmt->bindParam(':imagen', $this->imagen);

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
                                                titulo = :titulo, 
                                                fecha = :fecha, 
                                                texto = :texto, 
                                                archivo = :archivo, 
                                                imagen = :imagen
                                            WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->dni = htmlspecialchars(strip_tags($this->dni));
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->fecha = htmlspecialchars(strip_tags($this->fecha));
        $this->texto = htmlspecialchars(StringUtils::strip_html_script($this->texto));
        $this->archivo = htmlspecialchars(strip_tags($this->archivo));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));


        $stmt->bindParam(':dni', $this->dni);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':texto', $this->texto);
        $stmt->bindParam(':archivo', $this->archivo);
        $stmt->bindParam(':imagen', $this->imagen);

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