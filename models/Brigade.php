<?php

class Brigade
{
    //DB connfig
    private $conn;
    private $table = 'brigades';

    //Brigade Properties
    public $id;
    public $shift;
    public $notes;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Brigades
    public function read()
    {
        try {
            $query = 'SELECT b.id, b.shift, b.notes
            FROM ' . $this->table . ' b';

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $brigade_arr = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $brigade_item = array(
                    'id' => $id,
                    'shift' => $shift,
                    'notes' => html_entity_decode($notes)
                );
                array_push($brigade_arr, $brigade_item);
            }
            return $brigade_arr;
        } catch (PDOException $ex) {
            echo 'Message: ' . $ex->getMessage();
        }
    }

    //Add Brigade
    public function add($shift, $notes)
    {
        try {
            $query = "INSERT INTO " . $this->table . " (shift, notes) 
            VALUES ('$shift', '$notes')";

            $stmt = $this->conn->prepare($query);
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $ex) {
            echo 'Message: ' . $ex->getMessage();
            return false;
        }
    }

    //Check Single Brigade
    public function check_single($id)
    {
        try {
            // Create query
            $query = 'SELECT COUNT(*)
            FROM ' . $this->table . ' b
        WHERE
            b.id = ?';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $id);

            if ($stmt->execute()) {
                if ($stmt->fetchColumn() >= 1) {
                    return true;
                }
            }
        } catch (PDOException $ex) {
            echo 'Message: ' . $ex->getMessage();
            return false;
        }
    }

    public function read_single($id)
    {
        try {
            $query = 'SELECT b.shift, b.notes 
                FROM ' . $this->table . ' b' .
                ' WHERE 
                    b.id = ?';

            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(1, $id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->shift = $row['shift'];
            $this->notes = $row['notes'];

        } catch (PDOException $ex) {
            echo 'Message: ' . $ex->getMessage();
        }
    }

    //Update Brigade
    public function edit($id, $shift, $notes)
    {
        try {
            // Create query
            $query = 'UPDATE ' . $this->table . '
            SET shift = :shift, notes = :notes
            WHERE id = :id';

            $stmt = $this->conn->prepare($query);
            // Clean data
            $this->shift = htmlspecialchars(strip_tags($shift));
            $this->notes = htmlspecialchars(strip_tags($notes));
            $this->id = htmlspecialchars(strip_tags($id));

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':shift', $this->shift);
            $stmt->bindParam(':notes', $this->notes);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $ex) {
            echo 'Message: ' . $ex->getMessage();
            return false;
        }
    }

    //Delete Brigade
    public function delete($id)
    {
        try {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($id));

            // Bind data
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $ex) {
            echo 'Message: ' . $ex->getMessage();
            return false;
        }
    }
}
