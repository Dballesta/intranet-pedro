<?php


class News
{

    public $id;
    public $dni;
    public $fecha;
    public $titulo;
    public $texto;
    public $archivo;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findAll()
    {
        $query = 'SELECT id, dni, fecha, titulo
                                FROM ' . strtolower(__CLASS__) . '
                                ORDER BY
                                  p.created_at DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function findOne()
    {
        $query = "SELECT nombre 
                                FROM " . strtolower(__CLASS__) . "
                                WHERE
                                      dni = :dni
                                      LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':dni', $this->dni, PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nombre = $row['nombre'];
    }

    public function exists()
    {
        $query = "SELECT nombre 
                                FROM " . strtolower(__CLASS__) . "
                                WHERE
                                      dni = :dni
                                      LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':dni', $this->dni, PDO::PARAM_INT);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function login()
    {
        $query = "SELECT dni, nombre, apellidos, privilegios
                FROM
                    " . strtolower(__CLASS__) . " 
                WHERE
                    dni= :dni and password = :password";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':dni', $this->dni);
        $stmt->bindParam(':password', $this->password);

        $stmt->execute();
        return $stmt;
    }

    public function insert()
    {
        $query = 'INSERT INTO ' . strtolower(__CLASS__) .
            'SET nombre = :nombre';

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));

        $stmt->bindParam(':nombre', $this->nombre);


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
                                                nombre = :nombre, 
                                                apellidos = :apellidos,
                                                password = :password,
                                                privilegios = :privilegios
                                            WHERE dni = :dni';

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->nombre));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':privilegios', $this->privilegios);
        $stmt->bindParam(':dni', $this->dni);

        if ($stmt->execute()) {
            return true;
        }

        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }

    public function delete()
    {
        $query = 'DELETE FROM ' . strtolower(__CLASS__) . ' WHERE dni = :dni';

        $stmt = $this->conn->prepare($query);

        $this->dni = htmlspecialchars(strip_tags($this->dni));

        $stmt->bindParam(':dni', $this->dni);

        if ($stmt->execute()) {
            return true;
        }

        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }
}