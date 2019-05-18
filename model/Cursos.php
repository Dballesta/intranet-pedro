<?php


class Cursos
{
    // Propiedad para la conexión a la BBDD
    private $conn;

    // Propiedades de la clase
    public $id;
    public $nombre;

    // Contructor generando la connexión a la BBDD
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get Posts
    public function findAll() {
        // Create query
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                ORDER BY
                                  p.created_at DESC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Ejecución de la query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Post
    public function findOne() {
        // Creación de la consulta
        // Devolución de la primera coincidencia en la tabla
        $query = 'SELECT nombre 
                                FROM ' . __CLASS__ . '
                                WHERE
                                      id = :id
                                      LIMIT 0,1';

        // Prepare tatement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    // Create Post
    public function insert() {
        // Create query
        $query = 'INSERT INTO ' . __CLASS__ . ' SET nombre = :nombre';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));

        // Bind data
        $stmt->bindParam(':title', $this->title);


        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Update Post
    public function update() {
        // Generación de la query
        $query = 'UPDATE ' . __CLASS__ . '
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
        if($stmt->execute()) {
            return true;
        }

        // En el caso de Error devolvemos el código de error y falses
        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }

    // Borrar Curso
    public function delete() {
        // Generación de la query
        $query = 'DELETE FROM ' . __CLASS__ . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // strip_tags -> Eliminamos etiquetas introducidas
        //// htmlspecialchars -> Escapamos los caracteres especiales
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Asignación de valores
        $stmt->bindParam(':id', $this->id);

        // Ejecución de la query
        if($stmt->execute()) {
            return true;
        }

        // En el caso de Error devolvemos el código de error y falses
        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }
}