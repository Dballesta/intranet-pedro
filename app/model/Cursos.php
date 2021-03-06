<?php


class Cursos
{

    // Propiedades de la clase
    public $id;
    public $nombre;

    // Propiedad para la conexión a la BBDD
    private $conn;

    // Contructor generando la conexión a la BBDD

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Devolver Cursos
    public function findAll()
    {
        // Create query
        $query = 'SELECT id, nombre
                                FROM ' . strtolower(__CLASS__) . '
                                ORDER BY
                                nombre ASC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Ejecución de la query
        $stmt->execute();

        return $stmt;
    }

    // Devolver Curso
    public function findOne()
    {
        // Creación de la consulta
        // Devolución de la primera coincidencia en la tabla
        $query = "SELECT nombre 
                                FROM " . strtolower(__CLASS__) . "
                                WHERE
                                      id = :id
                                      LIMIT 0,1";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Asignación de valores
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Seteo de las propiedades
        $this->nombre = $row['nombre'];
    }

    // Insertar Curso
    public function insert()
    {
        // Creación de la consulta
        $query = 'INSERT INTO ' . strtolower(__CLASS__) .
                                                    '(nombre) 
                                                    VALUES 
                                                        (:nombre)';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // strip_tags -> Eliminamos etiquetas introducidas
        // htmlspecialchars -> Escapamos los caracteres especiales
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));

        // Asignación de valores
        $stmt->bindParam(':nombre', $this->nombre);


        // Ejecución de la query
        if ($stmt->execute()) {
            return true;
        }

        // En el caso de Error devolvemos el código de error y false
        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }

    // Actualizar Curso
    public function update()
    {
        // Generación de la query
        $query = 'UPDATE ' . strtolower(__CLASS__) . '
                                            SET nombre = :nombre 
                                            WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // strip_tags -> Eliminamos etiquetas introducidas
        // htmlspecialchars -> Escapamos los caracteres especiales
        $this->title = htmlspecialchars(strip_tags($this->nombre));

        // Asignación de valores
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':id', $this->id);

        // Ejecución de la query
        if ($stmt->execute()) {
            return true;
        }

        // En el caso de Error devolvemos el código de error y false
        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }

    // Borrar Curso
    public function delete()
    {
        // Generación de la query
        $query = 'DELETE FROM ' . strtolower(__CLASS__) . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // strip_tags -> Eliminamos etiquetas introducidas
        //// htmlspecialchars -> Escapamos los caracteres especiales
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Asignación de valores
        $stmt->bindParam(':id', $this->id);

        // Ejecución de la query
        if ($stmt->execute()) {
            return true;
        }

        // En el caso de Error devolvemos el código de error y false
        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }

    public function exists()
    {
        $query = "SELECT id 
                                FROM " . strtolower(__CLASS__) . "
                                WHERE
                                      nombre = :nombre
                                      LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
}