<?php

class Worker
{
    //DB connfig
    private $conn;
    private $table = 'workers';

    //Worker Properties
    public $id;
    public $surname;
    public $name;
    public $lastname;
    public $position;
    public $salary;
    public $brigade_id = NULL;
    public $brigade_shift = NULL;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Workers
    public function read() {
        try {
            $query = 'SELECT b.shift as brigade_shift, w.id, w.surname, w.name, w.lastname, w.position, w.salary, w.brigade_id
            FROM ' . $this->table . ' w
            LEFT JOIN
                brigades b ON w.brigade_id = b.id';

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $workers_arr = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $worker_item = array(
                    'id' => $id,
                    'surname' => $surname,
                    'name' => $name,
                    'lastname' => $lastname,
                    'position' => $position,
                    'salary' => $salary,
                    'brigade_id' => $brigade_id,
                    'brigade_shift' => $brigade_shift
                );
                array_push($workers_arr, $worker_item);
            }
            return $workers_arr;
        } catch (PDOException $ex) {
            echo 'Message: ' . $ex->getMessage();
        }
    }

    //Add Worker
    public function add($surname, $name, $lastname, $salary, $position, $brigade_id) {
        try{
            $query = "INSERT INTO " . $this->table . " (surname, name, lastname, position, salary, brigade_id) 
            VALUES ('$surname', '$name', '$lastname', '$position', '$salary', '$brigade_id')";
            
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute()) {
                return true;
            }
        }catch (PDOException $ex) {
            echo 'Message: ' . $ex->getMessage();
            return false;
        }
    }

    //Read Single Worker
    public function read_single($id) {
        try {
            $query = 'SELECT w.surname, w.name, w.lastname, w.position, w.salary, w.brigade_id 
            FROM ' . $this->table . ' w' .
                ' WHERE 
                    w.id = ?';

            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(1, $id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->surname = $row['surname'];
            $this->name = $row['name'];
            $this->lastname = $row['lastname'];
            $this->position = $row['position'];
            $this->salary = $row['salary'];
            $this->brigade_id = $row['brigade_id'];
        } catch (PDOException $ex) {
            echo 'Message: ' . $ex->getMessage();
        }
    }

    //Check Single Worker
    public function check_single($id)
    {
        try {
            // Create query
            $query = 'SELECT COUNT(*)
            FROM ' . $this->table . ' w
        WHERE
            w.id = ?';

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

    //Update Worker
    public function edit($id, $surname, $name, $lastname, $position, $salary, $brigade_id){
        try {
            // Create query
            $query = 'UPDATE ' . $this->table . '
            SET surname = :surname, name = :name, lastname = :lastname, position = :position, salary = :salary, brigade_id = :brigade_id
            WHERE id = :id';

            $stmt = $this->conn->prepare($query);
            // Clean data
            $this->surname = htmlspecialchars(strip_tags($surname));
            $this->name = htmlspecialchars(strip_tags($name));
            $this->lastname = htmlspecialchars(strip_tags($lastname));
            $this->position = htmlspecialchars(strip_tags($position));
            $this->salary = htmlspecialchars(strip_tags($salary));
            $this->brigade_id = htmlspecialchars(strip_tags($brigade_id));
            $this->id = htmlspecialchars(strip_tags($id));

            $stmt->bindParam(':surname', $this->surname);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':lastname', $this->lastname);
            $stmt->bindParam(':position', $this->position);
            $stmt->bindParam(':salary', $this->salary);
            $stmt->bindParam(':brigade_id', $this->brigade_id);
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

    //Delete Worker
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
