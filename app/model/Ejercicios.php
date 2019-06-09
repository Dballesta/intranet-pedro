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
        $query = 'SELECT id, idTema, titulo, texto, tipo, archivo, fechaIni, fechaFin
                                FROM ' . strtolower(__CLASS__) . '
                                ORDER BY
                                fecha  ASC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function findOne()
    {
        $query = "SELECT id, idTema, titulo, texto, tipo, archivo, fechaIni, fechaFin
                                FROM " . strtolower(__CLASS__) . "
                                WHERE
                                      id = :id
                                      LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->dni = $row['id'];
        $this->titulo = $row['idTema'];
        $this->fecha = $row['titulo'];
        $this->texto = $row['texto'];
        $this->archivo = $row['tipo'];
        $this->archivo = $row['archivo'];
        $this->archivo = $row['fechaIni'];
        $this->archivo = $row['fechaFin'];
    }

    public function findByIdTema()
    {
        $query = "SELECT id, idTema, titulo, texto, tipo, archivo, fechaIni, fechaFin
                                FROM " . strtolower(__CLASS__) . "
                                WHERE
                                    idTema = :idTema
                                ORDER BY
                                    fechaFin";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':idTema', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;

    }

    public function insert()
    {
        $query = 'INSERT INTO ' . strtolower(__CLASS__) .
            '(idTema, titulo, texto, tipo, archivo, fechaIni, fechaFin) 
                                                    VALUES 
                                                        (
                                                        :idTema, 
                                                        :titulo, 
                                                        :texto, 
                                                        :tipo, 
                                                        :archivo,
                                                        :fechaIni,
                                                        :fechaFin
                                                        )';

        $stmt = $this->conn->prepare($query);

        $this->idTema = htmlspecialchars(strip_tags($this->idTema));
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->texto = htmlspecialchars(StringUtils::strip_html_script($this->texto));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        $this->archivo = htmlspecialchars(strip_tags($this->archivo));
        $this->fechaIni = htmlspecialchars(strip_tags($this->fechaIni));
        $this->fechaFin = htmlspecialchars(strip_tags($this->fechaFin));


        $stmt->bindParam(':idTema', $this->idTema);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':texto', $this->texto);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':archivo', $this->archivo);
        $stmt->bindParam(':fechaIni', $this->fechaIni);
        $stmt->bindParam(':fechaFin', $this->fechaFin);

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
                                                idTema = :idTema, 
                                                titulo = :titulo, 
                                                texto = :texto, 
                                                tipo = :tipo, 
                                                archivo = :archivo,
                                                fechaIni = :fechaIni,
                                                fechaFin = :fechaFin
                                            WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->idTema = htmlspecialchars(strip_tags($this->idTema));
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->texto = htmlspecialchars(StringUtils::strip_html_script($this->texto));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        $this->archivo = htmlspecialchars(strip_tags($this->archivo));
        $this->fechaIni = htmlspecialchars(strip_tags($this->fechaIni));
        $this->fechaFin = htmlspecialchars(strip_tags($this->fechaFin));


        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':idTema', $this->idTema);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':texto', $this->texto);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':archivo', $this->archivo);
        $stmt->bindParam(':fechaIni', $this->fechaIni);
        $stmt->bindParam(':fechaFin', $this->fechaFin);

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
                                      idTema = :idTema
                                      AND
                                      titulo = :titulo
                                      LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':idTema', $this->idTema);
        $stmt->bindParam(':titulo', $this->titulo);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
}