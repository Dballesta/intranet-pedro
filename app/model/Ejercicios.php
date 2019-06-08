<?php


class Ejercicios
{

    public $id;
    public $idTema;
    public $titulo;
    public $texto;
    public $tipo;
    public $archivo;
    public $fechaIni;
    public $fechaFin;

    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findAll()
    {
        $query = 'SELECT id, idTEma, titulo, texto, tipo, archivo, fechaIni, fecha
                                FROM ' . strtolower(__CLASS__) . '
                                ORDER BY
                                fecha  ASC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function getLasts($limit)
    {
        $query = 'SELECT id, dni, titulo, fecha, imagen
                                FROM ' . strtolower(__CLASS__) . '
                                ORDER BY
                                fecha  ASC
                                LIMIT 0,:limit';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':limit', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    public function getLastsWithOffset($offset, $limit)
    {
        $query = 'SELECT id, dni, titulo, fecha, imagen
                                FROM ' . strtolower(__CLASS__) . '
                                ORDER BY
                                fecha  ASC
                                LIMIT :offset,:limit';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':offset', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $this->id, PDO::PARAM_INT);

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
            '(dni, titulo, fecha, texto, archivo, imagen) 
                                                    VALUES 
                                                        (:dni, 
                                                        :titulo, 
                                                        :fecha, 
                                                        :texto, 
                                                        :archivo, 
                                                        :imagen)';

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