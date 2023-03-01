<?php

class Detail
{
    //DB connfig
    private $conn;
    private $table = 'details';

    //Detail Properties
    public $id;
    public $title;
    public $date;
    public $quality;
    public $brigade_id;
    public $notes;
    public $worker_id;
    public $worker_name;
    public $worker_surname;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Details
    public function read()
    {
        try {
            $query = 'SELECT b.shift as brigade_shift, w.surname as worker_surname, w.name as worker_name, d.id, d.title, d.date, d.quality, d.notes, d.brigade_id, d.worker_id
            FROM ' . $this->table . ' d
            LEFT JOIN
                brigades b ON d.brigade_id = b.id 
            LEFT JOIN
                workers w ON d.worker_id = w.id';

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $details_arr = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $detail_item = array(
                    'id' => $id,
                    'title' => $title,
                    'date' => $date,
                    'quality' => $quality,
                    'notes' => $notes,
                    'brigade_id' => $brigade_id,
                    'worker_id' => $worker_id,
                    'brigade_shift' => $brigade_shift,
                    'worker_surname' => $worker_surname,
                    'worker_name' => $worker_name
                );
                array_push($details_arr, $detail_item);
            }
            return $details_arr;
        } catch (PDOException $ex) {
            echo 'Message: ' . $ex->getMessage();
        }
    }

    //Add Detail
    public function add($title, $quality, $notes, $brigade_id, $worker_id)
    {
        try {
            $query = "INSERT INTO " . $this->table . " (title, quality, brigade_id, notes, worker_id) 
            VALUES ('$title', '$quality', '$brigade_id', '$notes', '$worker_id')";

            $stmt = $this->conn->prepare($query);
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $ex) {
            echo 'Message: ' . $ex->getMessage();
            return false;
        }
    }

    //Check Single Detail
    public function check_single($id)
    {
        try {
            // Create query
            $query = 'SELECT COUNT(*)
            FROM ' . $this->table . ' d
        WHERE
            d.id = ?';

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

    //Read Single Detail
    public function read_single($id)
    {
        try {
            $query = 'SELECT d.title, d.date, d.quality, d.brigade_id, d.notes, d.worker_id  
            FROM ' . $this->table . ' d' .
                ' WHERE 
                    d.id = ?';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->title = $row['title'];
            $this->date = $row['date'];
            $this->quality = $row['quality'];
            $this->brigade_id = $row['brigade_id'];
            $this->notes = $row['notes'];
            $this->worker_id = $row['worker_id'];
        } catch (PDOException $ex) {
            echo 'Message: ' . $ex->getMessage();
        }
    }

    //Update Detail
    public function edit($id, $title, $date, $quality, $notes, $brigade_id, $worker_id){
        try {
            // Create query
            $query = 'UPDATE ' . $this->table . '
            SET title = :title, date = :date, quality = :quality, notes = :notes, brigade_id = :brigade_id, worker_id = :worker_id 
            WHERE id = :id';

            $stmt = $this->conn->prepare($query);
            // Clean data
            $this->title = htmlspecialchars(strip_tags($title));
            $this->date = htmlspecialchars(strip_tags($date));
            $this->quality = htmlspecialchars(strip_tags($quality));
            $this->notes = htmlspecialchars(strip_tags($notes));
            $this->brigade_id = htmlspecialchars(strip_tags($brigade_id));
            $this->worker_id = htmlspecialchars(strip_tags($worker_id));
            $this->id = htmlspecialchars(strip_tags($id));

            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':date', $this->date);
            $stmt->bindParam(':quality', $this->quality);
            $stmt->bindParam(':notes', $this->notes);
            $stmt->bindParam(':brigade_id', $this->brigade_id);
            $stmt->bindParam(':worker_id', $this->worker_id);
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

    //Delete Detail
    public function delete($id) {
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
